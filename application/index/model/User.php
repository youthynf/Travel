<?php
/**
 * Created by PhpStorm.
 * User: youth
 * Date: 2020-02-12
 * Time: 14:32
 */
namespace app\index\model;

use think\Model;

class User extends Model
{
    // 设置完整的数据表（包含前缀）
    protected $table = 'think_user';
}
