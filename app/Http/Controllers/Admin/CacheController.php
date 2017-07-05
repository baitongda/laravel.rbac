<?php
// +----------------------------------------------------------------------
// | Description:
// +----------------------------------------------------------------------
// | Author: [apple] <3279867796@qq.com>
// +----------------------------------------------------------------------

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\AdminController;
use libraries\org\io\Dir;

class CacheController extends AdminController
{
    // 删除全部核心缓存
    public function delCore(){
        $dir = new Dir();
        if(is_dir(base_path('storage') . '/framework/views')){$dir->del(base_path('storage') . '/framework/views');}
        if(is_dir(base_path('storage') . '/framework/sessions')){$dir->del(base_path('storage') . '/framework/sessions');}
        if(is_dir(base_path('storage') . '/debugbar')){$dir->del(base_path('storage') . '/debugbar');}
        if(is_dir(base_path('storage') . '/logs')){$dir->del(base_path('storage') . '/logs');}
        echo('[清除成功]');
    }
}