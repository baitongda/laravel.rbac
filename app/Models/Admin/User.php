<?php

namespace App\Models\Admin;

use App\Models\Admin;

class User extends Admin
{
    protected $table = 'User';

    protected $fillable = ['username','password','role','status','remark','last_login_time','last_login_ip','last_location'];//开启白名单字段

    protected $validate = [
        'rules' => [
            'username' => 'required|unique:user'
        ],
        'messages' =>
            [
                'username.required' => '用户名称必须！',
                'username.unique' => '用户名称已经存在！'
            ]
    ];

    /**
     * 重新验证规则 排除 当前 ID
     * @param int $id
     * @return mixed
     */
    public function getRules($id=0) {
        if($id) {
            $this->validate['rules']['username'] = $this->validate['rules']['username'] . ","  . 'username,' . $id;
        }
        return parent::getRules();
    }

    // 获取单个用户信息
    public function getUser($where = [],$field = ['*']) {
        return $this->where($where)->first($field);
    }

    // 删除用户
    public function delUser($where) {
        if($where){
            return $this->where($where)->delete();
        }else{
            return false;
        }
    }

    public function check_name($username,$user_id=0) {
        if($user_id) {   //编辑时查询
            $map[] = ['id','<>',$user_id];
            $map[]  = ['username','=',$username];
        } else {  // 新增是查询
            $map[]  = ['username','=',$username];
        }
        return $this->where($map)->first();
    }

//    protected function setPasswordAttribute($value)
//    {
//        return md5($value);
//    }
//
//    protected function setLastLoginTimeAttribute()
//    {
//        return time();
//    }
}
