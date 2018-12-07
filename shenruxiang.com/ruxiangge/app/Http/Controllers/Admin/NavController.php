<?php

namespace App\Http\Controllers\Admin;

use App\Admin\Nav;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class NavController extends BaseController
{
    /**
     * 前台首页导航设置
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     * @author shenruxiang
     * @date 2018/8/27 16:46
     */
    public function nav_list(Request $request)
    {
        if($request->isMethod('post'))
        {
            $navList = Nav::all();

            return $this->retJsonTableData($navList);
        }else
        {
            return view('');
        }
    }

    /**
     * 添加和修改导航
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author shenruxiang
     * @date 2018/8/27 16:46
     */
    public function nav_save(Request $request)
    {
        $navRow = $request->input();

        if(! empty($navRow['id'])) {
            Nav::where('id', $navRow['id'])->update($navRow);
        }else {
            Nav::create($navRow);
        }


        Cache::forever('nav_list', Nav::where('status', 1)->orderBy('sort', 'DESC')->get()->keyBy('id')->toArray());

        return $this->retJson(3, '操作成功');
    }

    /**
     * 删除导航
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author shenruxiang
     * @date 2018/8/27 20:42
     */
    public function nav_del(Request $request)
    {
        $navRow = $request->input();

        if(empty($navRow['id'])) {
            return $this->retJson(2, '删除失败');
        }

        Nav::where('id', $navRow)->delete();

        Cache::forever('nav_list', Nav::where('status', 1)->orderBy('sort', 'DESC')->get()->keyBy('id')->toArray());

        return $this->retJson(3, '删除成功');
    }
}
