<?php
/**
 * Created by PhpStorm.
 * User: youth
 * Date: 2020-02-12
 * Time: 17:56
 */
namespace app\admin\Controller;

use think\Controller;

class Index extends Controller
{
    function index() {
        $this->isLogin();
        return $this->fetch();
    }

    function login() {
        return $this->fetch();
    }

    function logout() {
        return $this->fetch();
    }

    function statistic() {
        return $this->fetch();
    }

    private function isLogin() {
        if(session('username') == '') {
            $this->redirect('/admin_login');
        }
    }
}