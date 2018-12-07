<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends BaseController
{
    /**
     * 后台登陆页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author shenruxiang
     * @date 2018/8/6 23:58
     */
    public function login()
    {
        $userId = Auth::guard($this->app_guard)->id();

        if(! empty($userId)) {
            return redirect(url('admin/index'));
        }

        return view('');
    }

    /**
     * 后台登陆接口
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @author shenruxiang
     * @date 2018/8/6 23:58
     */
    public function ajax_login(LoginRequest $request)
    {
        if(Auth::guard($this->app_guard)->attempt($request->input()))
        {
            $userId = Auth::guard($this->app_guard)->id();

            if($userId != 2){
                Auth::guard($this->app_guard)->logout();
                return $this->retJson(2, '登陆失败');
            }

            return $this->retJson(3, '登陆成功');
        }

        return $this->retJson(2, '登陆失败');
    }

    /**
     * 注销
     * @return \Illuminate\Http\JsonResponse
     * @author shenruxiang
     * @date 2018/8/7 19:00
     */
    public function logout()
    {
        $login_url = url('admin/login');

        Auth::guard($this->app_guard)->logout();

        echo "<script language=\"javascript\">top.window.location.href='".$login_url."';</script>";
    }
}
