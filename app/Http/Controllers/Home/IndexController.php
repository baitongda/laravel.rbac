<?php

namespace App\Http\Controllers\Home;
use App\Http\Controllers\HomeController;

class IndexController extends HomeController
{
    /**
     * 前台控制器 web.php 定义路由
     */
    public function index() {
        return view('welcome');
    }
}