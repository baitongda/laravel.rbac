<?php
// +----------------------------------------------------------------------
// | Description: RBAC后台公用模型类
// +----------------------------------------------------------------------
// | Author: [apple] <3279867796@qq.com>
// +----------------------------------------------------------------------

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Admin extends Cms
{
    //关闭添加 或者 修改 自动生成 时间字段
    public $timestamps = false;

    protected $validate = [
        'rules' => [],
        'messages' => []
    ];

    /**
     * 获取验证规则
     * @param int $id
     * @return mixed
     */
    public function getRules($id=0) {
        return $this->validate['rules'];
    }

    /**返回验证信息
     * @param int $id
     * @return mixed
     */
    public function getMessages($id=0) {
        return $this->validate['messages'];
    }

}