<?php
// +----------------------------------------------------------------------
// | Description:
// +----------------------------------------------------------------------
// | Author: [apple] <3279867796@qq.com>
// +----------------------------------------------------------------------

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\AdminController;
use App\Models\Admin\Access;
use App\Models\Admin\Node;
use App\Models\Admin\Role;
use App\Models\Admin\RoleUser;
use App\Models\Admin\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use libraries\Tree;

class UserController extends AdminController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index() {
        $RoleDB = new Role();

        $role = $RoleDB->pluck('name','id');// 1 => "超级管理员"

        $map = array();
        $UserDB = new User();

        $list = $UserDB->where($map)->paginate(config('cms.web_admin_pagenum'));
        return view('admin.user_index',['role' => $role,'list' => $list]);
    }


    public function add(Request $request) {
        $UserDB = new User();
        $RoleDB =new Role();
        $RoleUser = new RoleUser();

        if(isset($_POST['dosubmit'])) {
            $this->validate($request, $UserDB->getRules(),$UserDB->getMessages());

            $form = $request->all();
            $password = $_POST['password'];
            $repassword = $_POST['repassword'];
            if(empty($password) || empty($repassword)){
                $this->error('密码必须！');
            }
            if($password != $repassword){
                $this->error('两次输入密码不一致！');
            }



            $form['password'] = md5($form['password']);
            $form['last_login_time'] = time();

            //根据表单提交的POST数据创建数据对象
            $userInfo = $UserDB->create($form);

            if(isset($userInfo->id)){
                $data['user_id'] = $userInfo->id;
                $data['role_id'] = $form['role'];

                if($RoleUser->addRoleUser($data)) {
                    $this->success('添加成功！',url('/admin/user/index'));
                } else {
                    $this->warn('用户添加成功,但角色对应关系添加失败!');
                }
            } else {
                $this->error('添加失败！');
            }
        } else{
            $role = $RoleDB ->getAllRole(array('status'=>1));
            return view('admin.user_add',['role' => $role,'tpltitle' => '添加']);
        }
    }

    public function edit(Request $request ,$id = 0) {
        $UserDB = new User();
        $RoleDB = new Role();
        $RoleUser = new RoleUser();

        if(isset($_POST['dosubmit'])) {
            $form = $request->all();

            $this->validate($request, $UserDB->getRules($form['id']) ,$UserDB->getMessages($form['id']));

            $password = $_POST['password'];
            $repassword = $_POST['repassword'];
            if(!empty($password) || !empty($repassword)){
                if($password != $repassword){
                    $this->error('两次输入密码不一致！');
                }
            }

            $UserInfo = $UserDB::find($form['id']);

            if(empty($password) && empty($repassword)) unset($form['password']);   //不填写密码不修改
            else $form['password'] = md5($form['password']);

            if($UserInfo) {
                if($UserInfo->update($form)) {
                    $where['user_id'] = $UserInfo->id;
                    $data['role_id'] = $form['role'];

                    $RoleUser->upRoleUser($where,$data);
                    $this->success( '修改成功！',url('/admin/user/index'));
                } else {
                    $this->error('修改失败！');
                }
            } else {
                $this->error("_404");
            }
        } else {
            if(!$id) $this->error('参数错误!');
            $role = $RoleDB->getAllRole(array('status' => 1));
            $info = $UserDB->getUser(array('id' => $id));
            return view('admin.user_add',['role' => $role,'info' => $info,'tpltitle' => '编辑']);
        }
    }

    public function del(Request $request,$id) {
        if(!$id) $this->error('参数错误!');
        $UserDB = new User();
        $info = $UserDB->getUser(array('id'=>$id));

        if($info) {
            if($info->username == config('admin.SPECIAL_USER')){     //无视系统权限的那个用户不能删除
                return redirect()->back()->withErrors('禁止删除此用户!');
            }
            if($UserDB->delUser(['id' => $id])) {
                if(DB::table('Role_User')->where(['user_id' => $id])->delete()) {
                    $this->success('删除成功！',url('/admin/user/index'));
                } else {
                    $this->warn('用户成功,但角色对应关系删除失败!');
                }
            } else {
                $this->error('删除失败!');
            }
        }
        else {
            $this->error("_404");
        }
    }

    //ajax 验证用户名
    public function check_username(Request $request,$userid=0){
        $UserDB = new User();
        $username =  $request->input('username');
        if($UserDB->check_name($username,$userid)){
            echo 1;
        }else{
            echo 0;
        }
    }

    /* ========角色部分======== */

    // 角色管理列表
    public function role(){
        $RoleDB = new Role();
        $list = $RoleDB->getAllRole();

        return view('admin.user_role',['list' => $list]);
    }

    // 添加角色
    public function role_add(Request $request){
        $RoleDB = new Role();
        if(isset($_POST['dosubmit'])) {
            $data = $request->all();//根据表单提交的POST数据创建数据对象
            $this->validate($request, $RoleDB->getRules(),$RoleDB->getMessages());            //控制器验证

            if($RoleDB->create($data)) {
                $this->success('添加成功！',url('/admin/user/role'));
            } else {
                $this->error('添加失败！');
            }
        }else{
            return view('admin.user_role_add',['tpltitle' => '添加']);
        }
    }

    public function role_edit(Request $request,$id=0) {
        $RoleDB = new Role();
        if(isset($_POST['dosubmit'])) {
            $data = $request->all();//根据表单提交的POST数据创建数据对象
            $this->validate($request, $RoleDB->getRules($data['id']),$RoleDB->getMessages($data['id']));            //控制器验证

            $info = $RoleDB::find($data['id']);
            if($info) {
                if($info->update($data)) {
                    $this->success('修改成功！',url('/admin/user/role'));
                } else {
                    $this->error('修改失败！');
                }
            } else {
                $this->error("_404");
            }
        }else{
            if(!$id)$this->error('参数错误!');
            $info = $RoleDB->getRole(array('id'=>$id));
            return view('admin.user_role_add',['tpltitle' => '编辑','info' => $info]);
        }
    }

    //删除角色
    public function role_del(Request $request,$id=0){
        if(!$id)$this->error('参数错误!');
        $RoleDB = new Role();
        if($RoleDB->delRole(['id' => $id])){
            $this->success('删除成功！',url('/admin/user/role'));
        }else{
            $this->error('删除失败!');
        }
    }

    // 排序权重更新
    public function role_sort(){
        $RoleDB = new Role();
        $sorts = $_POST['sort'];
        if(!is_array($sorts))$this->error('参数错误!');
        foreach ($sorts as $id => $sort) {
            $RoleDB->where(['id' =>$id])->update(['sort' => intval($sort)]);
        }

        $this->success('更新完成！',url('/admin/user/role'));
    }

    /* ========权限设置部分======== */

    //权限浏览
    public function access(Request $request,$roleid){
        if(!$roleid) $this->error('参数错误!');

        $Tree = new Tree();
        $Tree->icon = array('&nbsp;&nbsp;&nbsp;│ ','&nbsp;&nbsp;&nbsp;├─ ','&nbsp;&nbsp;&nbsp;└─ ');
        $Tree->nbsp = '&nbsp;&nbsp;&nbsp;';

        $NodeDB = new Node();
        $node = $NodeDB->getAllNode()->toArray();

        $AccessDB = new Access();

        $access = $AccessDB->getAllAccess([],['role_id','node_id','pid','level'])->toArray();

        foreach ($node as $n=>$t) {
            $node[$n]['checked'] = ($AccessDB->is_checked($t,$roleid,$access))? ' checked' : '';
            $node[$n]['depth'] = $AccessDB->get_level($t['id'],$node);
            $node[$n]['pid_node'] = ($t['pid'])? ' class="tr lt child-of-node-'.$t['pid'].'"' : '';
        }
        $str  = "<tr id='node-\$id' \$pid_node>
                    <td style='padding-left:30px;'>\$spacer<input type='checkbox' name='nodeid[]' value='\$id' class='radio' level='\$depth' \$checked onclick='javascript:checknode(this);' > \$title (\$name)</td>
                </tr>";

        $Tree->init($node);
        $html_tree = $Tree->get_tree(0, $str);


        return view('admin.user_access',['html_tree' => $html_tree,'roleid' => $roleid]);
    }

    //权限编辑
    public function access_edit(Request $request){
        $form = $request->all();
        $roleid = intval($form['roleid']);
        $nodeid = $form['nodeid'];
        if(!$roleid) $this->error('参数错误!');
        $AccessDB = new Access();

        if (is_array($nodeid) && count($nodeid) > 0) {  //提交得有数据，则修改原权限配置
            $AccessDB -> delAccess(array('role_id'=>$roleid));  //先删除原用户组的权限配置

            $NodeDB = new Node();
            $node = $NodeDB->getAllNode();

            foreach ($node as $_v) $node[$_v[id]] = $_v;
            foreach($nodeid as $k => $node_id){
                $data[$k] = $AccessDB -> get_nodeinfo($node_id,$node);
                $data[$k]['role_id'] = $roleid;
            };

            $AccessDB->insert($data); // 重新创建角色的权限配置
        } else {    //提交的数据为空，则删除权限配置
            $AccessDB->delAccess(array('role_id'=>$roleid));
        }
        $this->success('设置成功！',url('/admin/user/access/' . $roleid));
    }


}