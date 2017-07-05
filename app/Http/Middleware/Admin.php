<?php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Author: [apple] <3279867796@qq.com>
// +----------------------------------------------------------------------

namespace App\Http\Middleware;
use App\Http\Controllers\AdminController;
use Closure;
use libraries\org\util\RBAC;

class Admin extends AdminController
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        // 后台用户权限检查
        if (config('admin.USER_AUTH_ON') && !in_array(getCurrentControllerName(), explode(',', config('admin.NOT_AUTH_MODULE')))) {
            if (!RBAC::AccessDecision()) {
                //检查认证识别号
                if (!session(config('admin.USER_AUTH_KEY'))) {
                    //跳转到认证网关
                    return \Redirect::to(url(config('admin.USER_AUTH_GATEWAY')))->send();
                }

                // 没有权限 抛出错误
                if (config('admin.RBAC_ERROR_PAGE')) {
                    // 定义权限错误页面
                    return redirect(config('admin.RBAC_ERROR_PAGE'));
                } else {
                    if (config('admin.GUEST_AUTH_ON')) {
                        $this->error(trans('rbac._valid_access_'),url('admin.USER_AUTH_GATEWAY'));
                    }

                    // 提示错误信息
                    $this->error(trans('rbac._valid_access_'));
                }
            }

        }
        return $next($request);
    }
}