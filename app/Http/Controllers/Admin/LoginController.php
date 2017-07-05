<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: [apple] <3279867796@qq.com>
// +----------------------------------------------------------------------

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use libraries\org\util\RBAC;
use libraries\org\net\IpLocation;

class LoginController extends AdminController
{
    public function index() {
        return view('admin.login_index');
    }

    public function checkLogin(Request $request) {

        $username =  $request->input('username');
        $password =  $request->input('password');
        $verify   =  $request->input('verify');


        if (empty($username)) {
            return redirect()->back()->withErrors(trans('rbac.lan_input_user_name'))->withInput();
        }elseif(empty($password)) {
            return redirect()->back()->withErrors(trans('rbac.lan_input_password'))->withInput();
        }elseif(empty($verify)) {
            return redirect()->back()->withErrors(trans('rbac.lan_input_verify'))->withInput();
        }

        //生成认证条件
        $map            =   array();
//        // 支持使用绑定帐号登录
        $map['username'] = $username;
        $map['status']        = 1;

        if(session('verify') != md5($verify)) {
            return redirect()->back()->withErrors('验证码错误！')->withInput();
        }

        $authInfo = RBAC::authenticate($map);
        //使用用户名、密码和状态的方式进行认证
        if(false == $authInfo) {
            return redirect()->back()->withErrors('帐号不存在或已禁用！')->withInput();
        }else {
            if ($authInfo->password != md5($password)) {
                return redirect()->back()->withErrors('密码错误！')->withInput();
            }

            Session::put(config('admin.USER_AUTH_KEY'), $authInfo->id);
            Session::put('userid', $authInfo->id);  //用户ID
            Session::put('username', $authInfo->username);   //用户名
            Session::put('roleid', $authInfo->role);    //角色ID
            if ($authInfo->username == config('admin.SPECIAL_USER')) {
                Session::put(config('admin.ADMIN_AUTH_KEY'), true);
            }

            Session::save();

            //保存登录信息
            $User = DB::table(config('admin.USER_AUTH_MODEL'));

            $ip = $request->ip();
            $data = array();
            if ($ip) {    //如果获取到客户端IP，则获取其物理位置
                $Ip = new IpLocation(); // 实例化类
                $location = $Ip->getlocation($ip); // 获取某个IP地址所在的位置
                $data['last_location'] = '';
                if ($location['country'] && $location['country'] != 'CZ88.NET') $data['last_location'] .= $location['country'];
                if ($location['area'] && $location['area'] != 'CZ88.NET') $data['last_location'] .= ' ' . $location['area'];
            }

            $data['last_login_time'] = time();
            $data['last_login_ip'] = $request->ip();

            $User->where(['id' => $authInfo->id])->update($data);
            // 缓存访问权限
            RBAC::saveAccessList($authInfo->id);

            return redirect('/admin');
        }
    }

    // 用户登出
    public function logout()
    {
        if(Session::has(config('admin.USER_AUTH_KEY'))) {
            session([config('admin.USER_AUTH_KEY') => null]);
            session()->flush();
            session()->save();
            return redirect('admin/login/index');
        } else {
            return redirect()->back()->withErrors('已经登出！');
        }
    }
}