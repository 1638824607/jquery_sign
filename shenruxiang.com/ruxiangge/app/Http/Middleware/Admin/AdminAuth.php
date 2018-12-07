<?php

namespace App\Http\Middleware\Admin;

use App\Admin\Permission;
use App\Admin\PermissionRole;
use App\Admin\RoleUser;
use Closure;
use Illuminate\Support\Facades\Auth;

class AdminAuth
{
    private $whiteList = [
        'Login',
    ];
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
        $controller = mca()['controller'];

        # 判断用户是否登陆
        if(! in_array($controller, $this->whiteList))
        {
            if(! Auth::guard($guard)->check()) {
                return redirect($guard . '/login');
            }

            # 当前路由
            $currentUri = $request->route()->uri();

            # 获取用户id
            $userId = Auth::guard($guard)->id();

            if($userId != 2){
                return redirect($guard . '/login');
            }

            # 权限列表
            $authList = $this->accessControl($userId);

            if(empty($authList)) {

                return redirect($guard . '/login');
            }

            $adminAuthList = arrayColumns($authList, 'name');

//            if(! in_array($currentUri, $adminAuthList)) {
//                abort(404);
//            }

            $request->attributes->add(['authList' => $authList]);

        }

        return $next($request);
    }

    /**
     * 用户访问控制
     * @param $userId
     * @return array|bool
     * @author shenruxiang
     * @date 2018/8/7 11:19
     */
    public function accessControl($userId)
    {
        $roleUserModel       = new RoleUser;
        $permissionRoleModel = new PermissionRole;
        $permissionModel     = new Permission;

        # 获取用户角色列表
        $roleUserList = $roleUserModel->getRoleListByUid($userId);

        if(empty($roleUserList)) {
            return FALSE;
        }

        $roleIdArr = arrayColumns($roleUserList, 'role_id');

        # 获取用户权限列表
        $permissionList = $permissionRoleModel->getPermissListByRoleIdArr($roleIdArr);

        if(empty($permissionList)) {
            return FALSE;
        }

        $permissionIdArr = arrayColumns($permissionList, 'permission_id');

        # 获取用户权限
        $permissionList = $permissionModel->getPermissionListByIdArr($permissionIdArr);

        if(empty($permissionList)) {
            return FALSE;
        }

        return $permissionList;
    }
}
