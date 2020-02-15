<?php

namespace app\index\controller;

use think\Request;
use app\index\model\User as UserModel;

class User extends Base
{
    public function index()
    {
        if(session('user_id')) {
            $user = UserModel::get(session('user_id'));
            $this->assign('user', $user->getData());
        }
        return $this->fetch();
    }

    public function reg()
    {
        $request = Request::instance();
        $postData = $request->param();
        $user = new UserModel;
        $user->username = $postData['username'];
        $user->password = $postData['password'];
        $user->email = $postData['email'];
        $user->phone = $postData['phone'];
        if ($user->save()) {
            //将用户名和密码保存在session中
            session('user_id', $user->getLastInsID());
            session('username', $postData['username']);
            session('upwd', $postData['password']);
            //跳转到用户中心
            exit(json_encode(array('state' => 1, 'msg' => 'success')));
        } else {
            exit(json_encode(array('state' => 0, 'msg' => $user->getError())));
        }
    }

    public function login()
    {
        $request = Request::instance();
        $postData = $request->param();

        $user = UserModel::get(['username' => $postData['username']]);
        if(empty($user)) exit(json_encode(array('state' => 0, 'msg' => "找不到账号")));
        $userData = $user->getData();
        if($userData['password'] == $postData['password'] && $userData['status'] != 1) {
            //将用户名和密码保存在session中
            session('user_id', $userData['id']);
            session('username', $postData['username']);
            session('upwd', $postData['password']);
            //跳转到用户中心
            exit(json_encode(array('state' => 1, 'msg' => 'success')));
        } else {
            exit(json_encode(array('state' => 0, 'msg' => "账号密码有误")));
        }
    }

    public function update()
    {
        $request = Request::instance();
        $postData = $request->param();

        $user_id = session('user_id');
        $user = UserModel::get($user_id);
        $userData = $user->getData();
        if($userData['password'] == $postData['old_password']) {
            $data['username'] = $postData['username'];
            $data['password'] = $postData['new_password'];
            $data['email'] = $postData['email'];
            $data['phone'] = $postData['phone'];
            if (UserModel::update($data, array('id' => $user_id))) {
                //将用户名和密码保存在session中
                session('user_id', $user_id);
                session('username', $postData['username']);
                session('upwd', $postData['new_password']);
                //跳转到用户中心
                exit(json_encode(array('state' => 1, 'msg' => 'success')));
            } else {
                exit(json_encode(array('state' => 0, 'msg' => $user->getError())));
            }
        } else {
            exit(json_encode(array('state' => 0, 'msg' => "账号密码有误")));
        }

    }

    public function logout() {
        session('username', null);
        session('upwd', null);
        session('user_id', null);
        return $this->redirect('/');
    }
}
