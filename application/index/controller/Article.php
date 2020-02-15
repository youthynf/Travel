<?php
/**
 * Created by PhpStorm.
 * User: youth
 * Date: 2020-02-11
 * Time: 21:49
 */
namespace app\index\controller;

use app\index\model\Order;
use think\Request;
use app\admin\model\Place as PlaceModel;
use app\index\model\Comment as CommentModel;
use think\Controller;

class Article extends Controller
{
    public function index()
    {
        return $this->fetch();
    }

    public function places() {
        $request = Request::instance();
        $getData = $request->param();
        $where = "type = 0";
        if(!empty($getData['position'])) {
            $where .= " and position like '%" . $getData['position'] . "%'";
        }
        if(!empty($getData['minPrice'])) {
            $where .= ' and price >=' . $getData['minPrice'];
        }
        if(!empty($getData['maxPrice'])) {
            $where .= " and price <= " . $getData['maxPrice'];
        }
        $placeModel = new PlaceModel();
        $placeList = $placeModel->where($where)->select();
        $this->assign('place_list', $placeList);
        $this->assign("position", empty($getData['position']) ? '' : $getData['position']);
        $this->assign("minPrice", empty($getData['minPrice']) ? '' : $getData['minPrice']);
        $this->assign("maxPrice", empty($getData['maxPrice']) ? '' : $getData['maxPrice']);
        return $this->fetch();
    }

    public function place($id = "") {
        $where = "type = 0 and id = " . intval($id);
        $placeModel = new PlaceModel();
        $place = $placeModel->where($where)->limit(1)->select();
        $this->assign('place', $place);
        return $this->fetch();
    }

    public function hotels() {
        $request = Request::instance();
        $getData = $request->param();
        $where = "type = 1";
        if(!empty($getData['position'])) {
            $where .= " and position like '%" . $getData['position'] . "%'";
        }
        if(!empty($getData['minPrice'])) {
            $where .= ' and price >=' . $getData['minPrice'];
        }
        if(!empty($getData['maxPrice'])) {
            $where .= " and price <= " . $getData['maxPrice'];
        }
        $placeModel = new PlaceModel();
        $hotelList = $placeModel->where($where)->select();
        $this->assign('hotel_list', $hotelList);
        $this->assign("position", empty($getData['position']) ? '' : $getData['position']);
        $this->assign("minPrice", empty($getData['minPrice']) ? '' : $getData['minPrice']);
        $this->assign("maxPrice", empty($getData['maxPrice']) ? '' : $getData['maxPrice']);
        return $this->fetch();
    }

    public function hotel($id = "") {
        $where = "type = 1 and id = " . intval($id);
        $placeModel = new PlaceModel();
        $place = $placeModel->where($where)->limit(1)->select();
        $this->assign('place', $place);
        return $this->fetch();
    }

    public function restaurants() {
        $request = Request::instance();
        $getData = $request->param();
        $where = "type = 2";
        if(!empty($getData['position'])) {
            $where .= " and position like '%" . $getData['position'] . "%'";
        }
        if(!empty($getData['minPrice'])) {
            $where .= ' and price >=' . $getData['minPrice'];
        }
        if(!empty($getData['maxPrice'])) {
            $where .= " and price <= " . $getData['maxPrice'];
        }
        $placeModel = new PlaceModel();
        $restaurantList = $placeModel->where($where)->select();
        $this->assign('restaurant_list', $restaurantList);
        $this->assign("position", empty($getData['position']) ? '' : $getData['position']);
        $this->assign("minPrice", empty($getData['minPrice']) ? '' : $getData['minPrice']);
        $this->assign("maxPrice", empty($getData['maxPrice']) ? '' : $getData['maxPrice']);
        return $this->fetch();
    }

    public function restaurant($id = '') {
        $where = "type = 2 and id = " . intval($id);
        $placeModel = new PlaceModel();
        $place = $placeModel->where($where)->limit(1)->select();
        $this->assign('place', $place);
        return $this->fetch();
    }

    public function blogs() {
        $placeModel = new PlaceModel();
        $where = "type = 3";
        $blogList = $placeModel->where($where)->select();
        $this->assign('blog_list', $blogList);
        return $this->fetch();
    }

    public function blog($id = "") {
        $where = "type = 3 and id = " . intval($id);
        $placeModel = new PlaceModel();
        //使用关联查询
        $place = $placeModel->where($where)->limit(1)->select();
        $this->assign('place', $place);
        return $this->fetch();
    }

    public function addComment() {
        if(session('username') == '') {
            exit(json_encode(array('state' => 0, 'msg' => '请先登录')));
        }

        $request = Request::instance();
        $postData = $request->param();
        $model = new CommentModel;
        $model->comment = $postData['comment'];
        $model->place_id = $postData['pid'];
        $model->uid = session('user_id');
        $model->username = session('username');
        $model->create_time = time();
        if ($model->save()) {
            exit(json_encode(array('state' => 1, 'msg' => 'success')));
        } else {
            exit(json_encode(array('state' => 0, 'msg' => 'fail')));
        }
    }

    public function addOrder() {
        if(session('username') == '') {
            exit(json_encode(array('state' => 0, 'msg' => '请先登录')));
        }

        $request = Request::instance();
        $postData = $request->param();

        $order = new Order();
        $order->item_id = empty($postData['item_id']) ? 0 : $postData['item_id'];
        $order->item_name = empty($postData['item_name']) ? 0 : $postData['item_name'];

        if(!empty($postData['amount'])) {
            $remark[] = "数量：{$postData['amount']}";
        }
        if(!empty($postData['book_time'])) {
            $remark[] = "预订时间：{$postData['book_time']}";
        }
        if(!empty($postData['item_price'])) {
            $remark[] = "总额：" . $postData['amount'] * $postData['item_price'];
        }
        $order->create_time = time();
        $order->remark = join(',', $remark);
        $order->status = 0;
        if ($order->save()) {
            exit(json_encode(array('state' => 1, 'msg' => 'success')));
        } else {
            exit(json_encode(array('state' => 0, 'msg' => 'fail')));
        }
    }
}