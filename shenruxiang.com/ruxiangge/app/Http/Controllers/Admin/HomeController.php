<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

class HomeController extends BaseController
{

    /**
     * 后台首页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author shenruxiang
     * @date 2018/8/9 09:37
     */
    public function index()
    {
        return view('');
    }

    /**
     * 服务器监控
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author shenruxiang
     * @date 2018/9/28 11:21
     */
    public function system()
    {
        return view('');
    }
}
