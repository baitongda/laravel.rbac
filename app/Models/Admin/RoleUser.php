<?php
namespace App\Models\Admin;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Model;

class RoleUser extends Admin
{
    protected $table = 'Role_User';

    protected $fillable = ['user_id','role_id'];

    /**
     * 更新用户角色
     * @param $where
     * @param $data
     * @return bool
     */
    public function upRoleUser($where,$data) {
        if($where) {
            return $this->where($where)->update($data);
        } else {
            return false;
        }
    }

    /**
     * 添加用户角色
     * @param $data
     * @return bool
     */
    public function addRoleUser($data) {
        if($data) {
            return $this->fill($data)->save();
        } else {
            return false;
        }
    }
}
