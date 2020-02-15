<?php
/**
 * Created by PhpStorm.
 * User: youth
 * Date: 2020-02-12
 * Time: 14:31
 */
namespace app\index\controller;
use app\index\model\User;
use think\Controller;
use think\Request;
use think\Session;

class Base extends Controller
{
    public function _initialize()
    {
        $user = User::get(Session::get('user_id'));
        Request::instance()->bind('user',$user);
    }
}