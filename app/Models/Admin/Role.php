<?php

namespace App\Models\Admin;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Model;

class Role extends Admin
{
    protected $table = 'role';

    protected $validate = [
        'rules' => [
            'name' => 'required|unique:role',//,id
            'status' => 'required'
        ],
        'messages' =>
            [
                'name.required' => '角色名称必须！',
                'name.unique' => '角色名称已经存在！',
                'status.required' => '角色状态必须！',
            ]
    ];

    /**
     * 重新获取验证规则
     * @param int $id
     * @return mixed
     */
    public function getRules($id=0) {
        if($id) {
            $this->validate['rules']['name'] = $this->validate['rules']['name'] . ","  . 'name,' . $id;
        }
        return parent::getRules();
    }

    protected $fillable = ['name','pid','status','sort','remark'];

    // 获取所有角色信息
    public function getAllRole($where = [] , $field = ['*']) {
        return $this->where($where)->orderBy('sort','DESC')->select($field)->get();
    }

    // 获取单个角色信息
    public function getRole($where = [],$field = ['*']) {
        return $this->where($where)->first($field);
    }

    // 删除角色
    public function delRole($where) {
        if($where){
            return $this->where($where)->delete();
        }else{
            return false;
        }
    }

}
