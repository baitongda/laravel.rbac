<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: [apple] <3279867796@qq.com>
// +----------------------------------------------------------------------

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;

/*
* Admin分组公共类
*/
class AdminController extends CmsController
{
    public function __construct()
    {
        parent::__construct();
        error_reporting(E_ERROR | E_WARNING | E_PARSE);
    }

    protected function success($msg = '', $url = null, $data = '', $wait = 3, array $header = []) {
        $code = 1;
        if (is_numeric($msg)) {
            $code = $msg;
            $msg  = '';
        }
        if (is_null($url) && isset($_SERVER["HTTP_REFERER"])) {
            $url = $_SERVER["HTTP_REFERER"];
        } elseif ('' !== $url) {
            $url = (strpos($url, '://') || 0 === strpos($url, '/')) ? $url : url($url);
        }
        $result = [
            'code' => $code,
            'msg'  => $msg,
            'data' => $data,
            'url'  => $url,
            'wait' => $wait,
        ];

        if(request()->ajax()) {
            header('Content-Type:application/json; charset=utf-8');
            exit(json_encode($result));
        } else {
            exit(view('public.dispatch_jump',$result));
        }
    }

    /**
     * 操作错误跳转的快捷方法
     * @access protected
     * @param mixed     $msg 提示信息
     * @param string    $url 跳转的URL地址
     * @param mixed     $data 返回的数据
     * @param integer   $wait 跳转等待时间
     * @param array     $header 发送的Header信息
     * @return void
     */
    protected function error($msg = '', $url = null, $data = '', $wait = 3, array $header = []) {
        $code = 0;
        if (is_numeric($msg)) {
            $code = $msg;
            $msg  = '';
        }
        if (is_null($url)) {
            $url = request()->ajax() ? '' : 'javascript:history.back(-1);';
        } elseif ('' !== $url) {
            $url = (strpos($url, '://') || 0 === strpos($url, '/')) ? $url : url($url);
        }
        $result = [
            'code' => $code,
            'msg'  => $msg,
            'data' => $data,
            'url'  => $url,
            'wait' => $wait,
        ];

        if(request()->ajax()) {
            header('Content-Type:application/json; charset=utf-8');
            exit(json_encode($result));
        } else {
            exit(view('public.dispatch_jump',$result));
        }
    }

    /**
     * 返回警告
     * @param string $message
     * @param string $jumpUrl
     */
    protected function warn($msg = '', $url = null, $data = '', $wait = 3, array $header = []) {
        $code = 2;
        if (is_numeric($msg)) {
            $code = $msg;
            $msg  = '';
        }
        if (is_null($url) && isset($_SERVER["HTTP_REFERER"])) {
            $url = $_SERVER["HTTP_REFERER"];
        } elseif ('' !== $url) {
            $url = (strpos($url, '://') || 0 === strpos($url, '/')) ? $url : url($url);
        }
        $result = [
            'code' => $code,
            'msg'  => $msg,
            'data' => $data,
            'url'  => $url,
            'wait' => $wait,
        ];

        if(request()->ajax()) {
            header('Content-Type:application/json; charset=utf-8');
            exit(json_encode($result));
        } else {
            exit(view('public.dispatch_jump',$result));
        }
    }
}