<?php
/**
 * Created by PhpStorm.
 * User: youth
 * Date: 2020-02-12
 * Time: 17:56
 */
namespace app\admin\Controller;

use think\Request;
use think\Controller;
use app\index\model\User as UserModel;

class User extends Controller
{
    function index() {
        return $this->fetch();
    }

    function login() {
        return $this->fetch();
    }

    function checkLogin() {
        $request = Request::instance();
        $postData = $request->param();
        $user = UserModel::get(['username' => $postData['username']]);
        if(empty($user)) exit(json_encode(array('state' => 0, 'msg' => "找不到账号")));
        $userData = $user->getData();
        if($userData['password'] == $postData['password'] && $userData['admin'] == 1 && $userData['status'] != 1) {
            //将用户名和密码保存在session中
            session('is_admin', 1);
            session('user_id', $userData['id']);
            session('username', $postData['username']);
            session('upwd', $postData['password']);
            //跳转到用户中心
            exit(json_encode(array('state' => 1, 'msg' => 'success')));
        } else {
            exit(json_encode(array('state' => 0, 'msg' => "账号密码有误")));
        }
    }

    function logout() {
        session('is_admin', null);
        session('user_id', null);
        session('username', null);
        session('upwd', null);
        return $this->redirect('/admin_login');
    }

    private function isAdmin() {
        if(session('is_admin') != 1) {
            exit(json_encode(array('state' => 0, 'msg' => '权限不足')));
        }
    }

    public function user_list() {
        $request = Request::instance();
        $getData = $request->param();

        $where = "admin = 0";
        if(!empty($getData['start'])) {
            $where .= ' and create_time >=' . strtotime($getData['start']);
        }
        if(!empty($getData['end'])) {
            $where .= ' and create_time <=' . strtotime($getData['end'] . " 23:59:59");
        }
        if(!empty($getData['username'])) {
            $where .= " and username like '%" . $getData['username'] . "%'";
        }

        $userModel = new UserModel();
        $list = $userModel->where($where)->select();
        $this->assign("user_list", $list);
        $this->assign("start", empty($getData['start']) ? '' : $getData['start']);
        $this->assign("end", empty($getData['end']) ? '' : $getData['end']);
        $this->assign("username", empty($getData['username']) ? '' : $getData['username']);
        return $this->fetch();
    }

    public function admin_list() {
        $request = Request::instance();
        $getData = $request->param();

        $where = "admin = 1";
        if(!empty($getData['start'])) {
            $where .= ' and create_time >=' . strtotime($getData['start']);
        }
        if(!empty($getData['end'])) {
            $where .= ' and create_time <=' . strtotime($getData['end'] . " 23:59:59");
        }
        if(!empty($getData['username'])) {
            $where .= " and username like '%" . $getData['username'] . "%'";
        }

        $userModel = new UserModel();
        $list = $userModel->where($where)->select();
        $this->assign("user_list", $list);
        $this->assign("start", empty($getData['start']) ? '' : $getData['start']);
        $this->assign("end", empty($getData['end']) ? '' : $getData['end']);
        $this->assign("username", empty($getData['username']) ? '' : $getData['username']);
        return $this->fetch();
    }

    public function saveAdmin() {
        $this->isAdmin();
        $request = Request::instance();
        $postData = $request->param();
        $id = $postData['id'];
        if(empty($id)) { //新增
            $user = new UserModel;
            $user->username = $postData['username'];
            $user->password = $postData['password'];
            $user->email = $postData['email'];
            $user->phone = $postData['phone'];
            $user->admin = 1;
            if ($user->save()) {
                exit(json_encode(array('state' => 1, 'msg' => 'success')));
            } else {
                exit(json_encode(array('state' => 0, 'msg' => $user->getError())));
            }
        } else { //编辑
            $data['username'] = $postData['username'];
            $data['email'] = $postData['email'];
            $data['phone'] = $postData['phone'];
            if(!empty($postData['password']) && !empty($postData['repassword'])) {
                if($postData['password'] != $postData['repassword']) exit(json_encode(array('state' => 0, 'msg' => "密码设置不一致")));
                $data['password'] = $postData['password'];
                $data['repassword'] = $postData['repassword'];
            }
            if (UserModel::update($data, array('id' => $id))) {
                exit(json_encode(array('state' => 1, 'msg' => 'success')));
            } else {
                exit(json_encode(array('state' => 0, 'msg' => '入库失败')));
            }
        }
    }

    public function delOne() {
        $this->isAdmin();
        $request = Request::instance();
        $postData = $request->param();
        $id = $postData['id'];
        if(UserModel::destroy(array("id" => $id))) {
            exit(json_encode(array('state' => 1, 'msg' => 'success')));
        } else {
            exit(json_encode(array('state' => 0, 'msg' => '删除失败')));
        }
    }

    public function delAll() {
        $this->isAdmin();
        $request = Request::instance();
        $postData = $request->param();
        $ids = $postData['ids'];
        $model = new UserModel;
        if(is_array($ids)){
            $where = 'id in('.implode(',',$ids).')';
        }else{
            $where = 'id='.$ids;
        }
        $res = $model->where($where)->delete();
        if(res) {
            exit(json_encode(array('state' => 1, 'msg' => 'success')));
        } else {
            exit(json_encode(array('state' => 0, 'msg' => '删除失败')));
        }
    }

    public function editStatus() {
        $this->isAdmin();
        $request = Request::instance();
        $postData = $request->param();
        $status = $postData['status'] ?: 0;
        if (UserModel::update(array('status' => $status), array('id' => $postData['id']))) {
            exit(json_encode(array('state' => 1, 'msg' => 'success')));
        } else {
            exit(json_encode(array('state' => 0, 'msg' => '更新失败')));
        }
    }
}