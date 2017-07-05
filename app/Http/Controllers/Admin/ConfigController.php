<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;

class ConfigController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function config($id) {

        $config       = require  base_path('config'  . '/cms.php');	//网站配置
        if( file_exists( base_path('config') . '/admin.php') ) {
            $config_admin = require base_path('config') . '/admin.php';	//后台分组配置
        }
        if( file_exists( base_path('config') . '/home.php') ) {
            $config_home  =  require base_path('config') . '/home.php';	//前台分组配置
        }

        return view('admin.config_' . $id,['con' => $config,'con_admin' => $config_admin,'con_home' => $config_home]);
    }

    public function updateweb()
    {
        $con                      = $_POST["con"];
        if(isset($_POST["con_home"]))
            $con_home                 = $_POST["con_home"];
        if(isset($con['web_url']))
            $con['web_url']           = getaddxie($con['web_url']);
        if(isset($con['web_path']))
            $con['web_path']          = getaddxie($con['web_path']);
        if(isset($con['web_adsensepath']))
            $con['web_adsensepath']   = getrexie($con['web_adsensepath']);
        if(isset($con['web_copyright']))
            $con['web_copyright']     = stripslashes($con['web_copyright']);
        if(isset($con['web_tongji']))
            $con['web_tongji']        = stripslashes($con['web_tongji']);
        if(isset($con['web_admin_pagenum']))
            $con['web_admin_pagenum'] = abs(intval($con['web_admin_pagenum']));
        if(isset($con['web_home_pagenum']))
            $con['web_home_pagenum']  = abs(intval($con['web_home_pagenum']));
        if(isset($con['web_adsensepath'])){
            $dir                      =   base_path('public') . '/' .$con['web_adsensepath'];//广告保存目录
            if(!is_dir($dir)){
                mkdirss($dir);
            }
        }

        if(isset($con_home)){
            $config = array('con'=>$con,'con_home'=>$con_home);
        }else{
            $config = array('con'=>$con);
        }
        $this->updateconfig($config);
    }

    // 配置信息保存
    private function updateconfig($config)
    {
        foreach ($config as $k => $c) {
            $config_old = array();
            $config_new = array();
            switch ($k) {
                case 'con':
                    $config_old = require  base_path('config'  . '/cms.php');
                    if(is_array($c)) $config_new = array_merge($config_old,$c);
                    arr2file(base_path('config'  . '/cms.php'),$config_new);
                    break;

                case 'con_admin':
                    $config_old = require base_path('config') . '/admin.php';
                    if(is_array($c)) $config_new = array_merge($config_old,$c);
                    arr2file(require base_path('config') . '/admin.php',$config_new);
                    break;

                case 'con_home':
                    $config_old = base_path('config') . '/home.php';
                    if(is_array($c)) $config_new = array_merge($config_old,$c);
                    arr2file(base_path('config') . '/home.php',$config_new);
                    break;
            }

        }
        $this->success('更新成功！');
    }
}