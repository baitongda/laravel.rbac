<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: [apple] <3279867796@qq.com>
// +----------------------------------------------------------------------

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\AdminController;
use libraries\org\util\Image;

class PublicController extends AdminController
{
    public function verify() {
        Image::buildImageVerify();
    }

}