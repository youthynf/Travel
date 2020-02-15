<?php
/**
 * Created by PhpStorm.
 * User: youth
 * Date: 2020-02-13
 * Time: 16:33
 */
namespace app\admin\Controller;

use think\Controller;
use think\Request;
use app\admin\model\Place as PlaceModel;

class Hotel extends Controller
{
    public function index() {
        $request = Request::instance();
        $getData = $request->param();

        $where = "type = 1";
        if(!empty($getData['start'])) {
            $where .= ' and create_time >=' . strtotime($getData['start']);
        }
        if(!empty($getData['end'])) {
            $where .= ' and create_time <=' . strtotime($getData['end'] . " 23:59:59");
        }
        if(!empty($getData['title'])) {
            $where .= " and title like '%" . $getData['title'] . "%'";
        }

        $placeModel = new PlaceModel();
        $list = $placeModel->where($where)->select();
        $this->assign("place_list", $list);
        $this->assign("start", empty($getData['start']) ? '' : $getData['start']);
        $this->assign("end", empty($getData['end']) ? '' : $getData['end']);
        $this->assign("title", empty($getData['title']) ? '' : $getData['title']);
        return $this->fetch();
    }

    public function uploadImg() {
        $file = request()->file('file');
        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
        if($info){
            // 成功上传后 获取上传信息
            $path = '/uploads/' . $info->getSaveName();
            exit(json_encode(array('state' => 1, 'pic_path' => $path, 'msg' => 'success')));
        }else{
            // 上传失败获取错误信息
            exit(json_encode(array('state' => 1, 'msg' => $file->getError())));
        }
    }

    public function saveHotel() {
        $this->isAdmin();
        $request = Request::instance();
        $postData = $request->param();
        $id = $postData['id'];
        if(empty($id)) { //新增
            $placeModel = new PlaceModel();
            $placeModel->title = empty($postData['title']) ? '' : $postData['title'];;
            $placeModel->position = empty($postData['position']) ? '' : $postData['position'];
            $placeModel->outline = empty($postData['outline']) ? '' : $postData['outline'];
            $placeModel->price = empty($postData['price']) ? '' : $postData['price'];
            $placeModel->duration = empty($postData['duration']) ? '' : $postData['duration'];
            $placeModel->img = empty($postData['img']) ? '' : $postData['img'];
            $placeModel->content = empty($postData['content']) ? '' : $postData['content'];
            $placeModel->type = 1;
            $placeModel->create_time = time();
            if ($placeModel->save()) {
                exit(json_encode(array('state' => 1, 'msg' => 'success')));
            } else {
                exit(json_encode(array('state' => 0, 'msg' => $placeModel->getError())));
            }
        } else { //编辑
            $data['title'] = empty($postData['title']) ? '' : $postData['title'];;
            $data['position'] = empty($postData['position']) ? '' : $postData['position'];
            $data['outline'] = empty($postData['outline']) ? '' : $postData['outline'];
            $data['price'] = empty($postData['price']) ? '' : $postData['price'];
            $data['duration'] = empty($postData['duration']) ? '' : $postData['duration'];
            $data['img'] = empty($postData['img']) ? '' : $postData['img'];
            $data['content'] = empty($postData['content']) ? '' : $postData['content'];
            if (PlaceModel::update($data, array('id' => $id))) {
                exit(json_encode(array('state' => 1, 'msg' => 'success')));
            } else {
                exit(json_encode(array('state' => 0, 'msg' => '入库失败')));
            }
        }
    }

    private function isAdmin() {
        if(session('is_admin') != 1) {
            exit(json_encode(array('state' => 0, 'msg' => '权限不足')));
        }
    }

    public function delOne() {
        $this->isAdmin();
        $request = Request::instance();
        $postData = $request->param();
        $id = $postData['id'];
        if(PlaceModel::destroy(array("id" => $id))) {
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
        $model = new PlaceModel;
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
        if (PlaceModel::update(array('status' => $status), array('id' => $postData['id']))) {
            exit(json_encode(array('state' => 1, 'msg' => 'success')));
        } else {
            exit(json_encode(array('state' => 0, 'msg' => '更新失败')));
        }
    }
}
