<?php

namespace App\Models\Admin;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Node extends Admin
{
    protected $table = 'node';

    protected $fillable = ['pid', 'title','display','level','name','data','status','remark'];//开启白名单字段

    protected $validate = [
        'rules' => [
            'title' => 'required',
            'name' => 'required'
        ],
        'messages' =>
            [
                'title.required' => '菜单名称必须！',
                'name.required' => '节点名称必须！'
            ]
    ];

    // 获取单个节点信息
    public function getNode($where = '',$field = ['*']) {
        return $this->where($where)->first($field);
    }

    // 获取所有节点信息
    public function getAllNode() {
        return $this->orderBy('sort','DESC')->select()->get();
    }

    // 删除节点
    public function delNode($where) {
        if($where){
            return $this->where($where)->delete();
        }else{
            return false;
        }
    }

    // 更新节点
    public function upNode($data) {
        if($data){
            return $this->save();
        }else{
            return false;
        }
    }

    // 子节点
    public function childNode($id){
        return $this->where(array('pid'=>$id))->select()->get();
    }
}
