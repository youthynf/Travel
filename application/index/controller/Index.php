<?php
namespace app\index\controller;

use think\Controller;
use app\admin\model\Place as PlaceModel;

class Index extends Controller
{
    public function index()
    {
        $placeModel = new PlaceModel();
        $where = "type = 0";
        $placeList = $placeModel->where($where)->limit(4)->select();
        $where = "type = 1";
        $hotelList = $placeModel->where($where)->limit(4)->select();
        $where = "type = 2";
        $restaurantList = $placeModel->where($where)->limit(4)->select();
        $where = "type = 3";
        $articleList = $placeModel->where($where)->limit(3)->select();
        $this->assign('place_list', $placeList);
        $this->assign('hotel_list', $hotelList);
        $this->assign('restaurant_list', $restaurantList);
        $this->assign('article_list', $articleList);
        return $this->fetch();
    }

    public function hello($name = 'thinkphp') {
        $this->assign('name', $name);
        return $this->fetch();
    }
}
