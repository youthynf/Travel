<?php
/**
 * Created by PhpStorm.
 * User: youth
 * Date: 2020-02-11
 * Time: 21:49
 */
namespace app\index\controller;

use think\Request;
use think\Controller;
use app\index\model\Order;
use app\admin\model\Place as PlaceModel;
use app\admin\model\Item as ItemModel;

class Orders extends Controller
{
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
        if(!empty($postData['room_type']) && !empty($postData['amount'])) {
            $remark[] = "{$postData['amount']}个{$postData['room_type']}";
            $item = ItemModel::get(array('id' => $postData['room_type']));
            $remark[] = "总额：" . $postData['amount'] * $item->price . "元";
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