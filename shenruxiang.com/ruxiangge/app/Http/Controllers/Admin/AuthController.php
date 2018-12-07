<?php

namespace App\Http\Controllers\Admin;

use App\Admin\Permission;
use App\Admin\PermissionRole;
use App\Admin\Role;
use App\Admin\RoleUser;
use App\Admin\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends BaseController
{
    /**
     * 管理员列表页面
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     * @author shenruxiang
     * @date 2018/8/7 16:01
     */
    public function user_list(Request $request)
    {
        if($request->isMethod('post'))
        {
            $userList = User::all();

            return $this->retJsonTableData($userList);
        }else
        {
            return view('');
        }
    }

    /**
     * 管理员添加修改页面
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     * @author shenruxiang
     * @date 2018/8/7 18:19
     */
    public function user_save(Request $request)
    {
        $userRow = $request->input();

        if(! empty($userRow['id'])) {
            unset($userRow['password']);
            unset($userRow['file']);
            User::where('id', $userRow['id'])->update($userRow);
        }else {
            $userRow['password'] = bcrypt($userRow['password']);

            User::create($userRow);
        }

        return $this->retJson(3, '操作成功');
    }

    /**
     * 管理员删除
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author shenruxiang
     * @date 2018/8/7 18:20
     */
    public function user_del(Request $request)
    {
        $userId = intval($request->input('id'));

        if(empty($userId)) {
            return $this->retJson(2, '删除失败');
        }

        # 删除用户
        User::where('id', $userId)->delete();

        # 删除用户角色关联
        RoleUser::where('user_id', $userId)->delete();

        return $this->retJson(3, '删除成功');
    }

    /**
     * 获取角色列表及用户角色
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author shenruxiang
     * @date 2018/8/8 10:58
     */
    public function ajax_user_role_list(Request $request)
    {
        # 获取角色列表
        $roleList = Role::all()->toArray();

        $userId = intval($request->input('user_id'));

        if(empty($userId)) {
            return $this->retJson(2, '获取角色失败');
        }

        # 获取用户角色
        $userRole = RoleUser::where('user_id', $userId)->get()->toArray();

        $userRole = arrayColumns($userRole, 'role_id');

        return $this->retJson(3, '角色列表', ['roleList' => $roleList, 'userRole' => $userRole]);
    }

    /**
     * 修改用户角色
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author shenruxiang
     * @date 2018/8/8 18:55
     */
    public function ajax_user_role_save(Request $request)
    {
        $userId  = intval($request->input('user_id'));
        $roleIds = $request->input('role_ids');

        if(empty($userId)) {
            return $this->retJson(2, '修改角色失败');
        }

        RoleUser::where('user_id', $userId)->delete();

        if(! empty($roleIds))
        {
            $roleIdArr = explode(',', $roleIds);

            $roleUserData = array_map(function($roleId) use($userId){
                return ['role_id' => $roleId, 'user_id' => $userId];
            }, $roleIdArr);

            RoleUser::insert($roleUserData);
        }

        return $this->retJson(3, '修改角色成功');
    }

    /**
     * 角色列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     * @author shenruxiang
     * @date 2018/8/7 20:54
     */
    public function role_list(Request $request)
    {
        if($request->isMethod('post'))
        {
            $roleList = Role::all();

            return $this->retJsonTableData($roleList);
        }else {
            return view('');
        }
    }

    /**
     * 添加修改角色表单
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     * @author shenruxiang
     * @date 2018/8/7 21:04
     */
    public function role_save(Request $request)
    {
        $roleRow = $request->input();

        if(! empty($roleRow['id'])) {

            Role::where('id',$roleRow['id'])->update($roleRow);
        }else {
            Role::create($roleRow);
        }

        return $this->retJson(3, '操作成功');
    }

    /**
     * 获取角色用户列表
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author shenruxiang
     * @date 2018/8/8 18:59
     */
    public function ajax_role_user_list(Request $request)
    {
        $roleId = intval($request->input('role_id'));

        if(empty($roleId)) {
            return $this->retJson(2, '数据有误');
        }

        $roleUserList = RoleUser::where('role_id', $roleId)->get()->toArray();

        if(empty($roleUserList)) {
            return $this->retJson(3, '无数据');
        }

        $userIdArr = arrayColumns($roleUserList, 'user_id');

        $userList = User::whereIn('id', $userIdArr)->get()->toArray();

        return $this->retJson(3, '获取成功', $userList);
    }

    /**
     * 获取权限及用户权限列表
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author shenruxiang
     * @date 2018/8/8 21:37
     */
    public function ajax_role_permission_list(Request $request)
    {
        $roleId = intval($request->input('role_id'));

        $permissionList = Permission::orderBy('parent', 'asc')->orderBy('sort','desc')->get()->toArray();

        # 权限列表
        $permissionList = $this->tree($permissionList);

        $permissionIdList = PermissionRole::where('role_id', $roleId)->get()->toArray();

        $rolePermisssion = [];

        if(! empty($permissionIdList)) {
            $rolePermisssion = arrayColumns($permissionIdList, 'permission_id');
        }

        return $this->retJson(3, '获取成功', ['permissionList' => $permissionList, 'rolePermission' => $rolePermisssion]);
    }

    /**
     * 修改角色权限
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author shenruxiang
     * @date 2018/8/8 23:08
     */
    public function ajax_role_permission_save(Request $request)
    {
        $roleId = intval($request->input('role_id'));

        $permissionIds = trim($request->input('permission_ids'));

        if(empty($roleId)) {
            return $this->retJson(2, '删除失败');
        }

        # 删除角色权限关联
        PermissionRole::where('role_id', $roleId)->delete();

        # 增加角色权限关联
        if(! empty($permissionIds))
        {
            $permissionIdArr = explode(',', $permissionIds);

            $rolePermissionData = array_map(function($permissionId) use($roleId){
                return ['role_id' => $roleId, 'permission_id' => $permissionId];
            }, $permissionIdArr);

            PermissionRole::insert($rolePermissionData);
        }

        return $this->retJson(3, '修改成功');
    }

    /**
     * 删除角色
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author shenruxiang
     * @date 2018/8/7 21:28
     */
    public function role_del(Request $request)
    {
        $roleId = intval($request->input('id'));

        if(empty($roleId)) {
            return $this->retJson(2, '删除失败');
        }

        # 删除角色
        Role::where('id', $roleId)->delete();

        # 删除用户角色关联
        RoleUser::where('role_id', $roleId)->delete();

        # 删除角色权限关联
        PermissionRole::where('role_id', $roleId)->delete();

        return $this->retJson(3, '删除成功');
    }

    /**
     * 权限列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     * @author shenruxiang
     * @date 2018/8/7 21:46
     */
    public function permission_list(Request $request)
    {
        if($request->isMethod('post'))
        {
            $permissionList = Permission::orderBy('parent', 'asc')->orderBy('sort','desc')->get()->toArray();

            $permissionList = $this->tree($permissionList);

            return $this->retJsonTableData($permissionList);
        }else {
            return view('');
        }
    }

    /**
     * 根据权限生成树状结构
     * @param        $list
     * @param int    $pid
     * @param int    $level
     * @param string $html
     * @return array
     * @author shenruxiang
     * @date 2018/8/9 15:40
     */
    public function tree(&$list,$pid=0,$level=0,$html='|——')
    {
        static $tree = array();

        foreach($list as $v){
            if($v['parent'] == $pid)
            {
                $v['sort_num'] = $level;
                $v['html']     = str_repeat($html,$level);

                $tree[] = $v;

                $this->tree($list,$v['id'],$level+1);
            }
        }
        return $tree;
    }

    /**
     * 添加修改权限表单
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     * @author shenruxiang
     * @date 2018/8/7 21:47
     */
    public function permission_save(Request $request)
    {
        $permissionRow = $request->input();

        if(! empty($permissionRow['id'])) {

            Permission::where('id',$permissionRow['id'])->update($permissionRow);
        }else {

            $permissionExist = Permission::where('name', $permissionRow['name'])->first();

            if(! empty($permissionExist)) {
                return $this->retJson(2, '权限已存在');
            }

            Permission::create($permissionRow);
        }

        return $this->retJson(3, '操作成功');
    }

    /**
     * 权限删除
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author shenruxiang
     * @date 2018/8/7 21:48
     */
    public function permission_del(Request $request)
    {
        $permissionId = intval($request->input('id'));

        if(empty($permissionId)) {
            return $this->retJson(2, '删除失败');
        }

        $parentPermissionList = Permission::where('parent', $permissionId)->get()->toArray();

        if(! empty($parentPermissionList)) {
            return $this->retJson(2, '存在子级菜单,不可删除');
        }

        # 删除权限
        Permission::where('id', $permissionId)->delete();

        # 删除角色权限关联
        PermissionRole::where('permission_id', $permissionId)->delete();

        return $this->retJson(3, '删除成功');
    }

    /**
     * 登陆用户个人信息
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author shenruxiang
     * @date 2018/9/20 18:57
     */
    public function user_info()
    {
        $userRow = Auth::guard($this->app_guard)->user();

        return view('', ['userRow' => $userRow]);
    }

    /**
     * 用户头像上传
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author shenruxiang
     * @date 2018/9/20 21:11
     */
    public function user_avatar_upload(Request $request)
    {
        $avatarPath = $request->file('file')->store('avatar');

        return response()->json([
            'code' => 0,
            'msg'  => '上传成功',
            'data' => '/storage/' . $avatarPath
        ]);
    }

    /**
     * 修改密码
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     * @author shenruxiang
     * @date 2018/9/20 21:46
     */
    public function pass_edit(Request $request)
    {
        $userRow = Auth::guard($this->app_guard)->user();

        if($request->isMethod('post'))
        {
            $oldPassword = $request->input('old_password');
            $password    = $request->input('password');
            $rePassword  = $request->input('repassword');

            if(! Hash::check($oldPassword, $userRow['password'])){
                return $this->retJson(3, '密码错误');
            }

            if($password != $rePassword) {
                return $this->retJson(3, '密码不一致');
            }

            User::where('id', $userRow['id'])->update(['password' => bcrypt($password)]);

            return $this->retJson(3, '修改密码成功');
        }else {
            return view('', ['userRow' => $userRow]);
        }
    }
}
