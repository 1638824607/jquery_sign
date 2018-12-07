<?php

namespace App\Http\Controllers\Admin;

use App\Admin\Link;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class LinkController extends BaseController
{
    /**
     * 前台友情链接
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     * @author shenruxiang
     * @date 2018/8/27 16:46
     */
    public function link_list(Request $request)
    {
        if($request->isMethod('post'))
        {
            $linkList = Link::all();

            return $this->retJsonTableData($linkList);
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
    public function link_save(Request $request)
    {
        $linkRow = $request->input();

        if(! empty($linkRow['id'])) {
            Link::where('id', $linkRow['id'])->update($linkRow);
        }else {
            Link::create($linkRow);
        }


        Cache::forever('link_list', Link::where('status', 1)->orderBy('sort', 'DESC')->get()->keyBy('id')->toArray());

        return $this->retJson(3, '操作成功');
    }

    /**
     * 删除友情链接
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author shenruxiang
     * @date 2018/8/27 20:42
     */
    public function link_del(Request $request)
    {
        $linkRow = $request->input();

        if(empty($linkRow['id'])) {
            return $this->retJson(2, '删除失败');
        }

        Link::where('id', $linkRow)->delete();

        Cache::forever('link_list', Link::where('status', 1)->orderBy('sort', 'DESC')->get()->keyBy('id')->toArray());

        return $this->retJson(3, '删除成功');
    }
}
