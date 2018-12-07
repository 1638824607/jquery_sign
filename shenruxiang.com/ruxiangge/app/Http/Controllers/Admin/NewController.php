<?php

namespace App\Http\Controllers\Admin;

use App\Admin\News;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class NewController extends BaseController
{
    /**
     * 前台友情链接
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     * @author shenruxiang
     * @date 2018/8/27 16:46
     */
    public function new_list(Request $request)
    {
        if($request->isMethod('post'))
        {
            $newList = News::all();

            return $this->retJsonTableData($newList);
        }else
        {
            return view('');
        }
    }

    /**
     * 添加和修改友情链接
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author shenruxiang
     * @date 2018/8/27 16:46
     */
    public function new_save(Request $request)
    {
        $newRow = $request->input();

        if(! empty($newRow['id'])) {
            News::where('id', $newRow['id'])->update($newRow);
        }else {
            News::create($newRow);
        }


        Cache::forever('new_list', News::where('status', 1)->orderBy('sort', 'DESC')->get()->keyBy('id')->toArray());

        return $this->retJson(3, '操作成功');
    }

    /**
     * 删除友情链接
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author shenruxiang
     * @date 2018/8/27 20:42
     */
    public function new_del(Request $request)
    {
        $newRow = $request->input();

        if(empty($newRow['id'])) {
            return $this->retJson(2, '删除失败');
        }

        News::where('id', $newRow)->delete();

        Cache::forever('new_list', News::where('status', 1)->orderBy('sort', 'DESC')->get()->keyBy('id')->toArray());

        return $this->retJson(3, '删除成功');
    }
}
