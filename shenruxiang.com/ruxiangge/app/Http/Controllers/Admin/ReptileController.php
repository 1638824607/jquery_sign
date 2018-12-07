<?php

namespace App\Http\Controllers\Admin;

use App\Admin\Reptile;
use App\Admin\ReptileLog;
use App\Jobs\RunReptile;
use Illuminate\Http\Request;

class ReptileController extends BaseController
{
    /**
     * cmd列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     * @author shenruxiang
     * @date 2018/9/15 08:32
     */
    public function reptile_list(Request $request)
    {
        $reptileList = Reptile::all();

        if($request->isMethod('post'))
        {
            return $this->retJsonTableData($reptileList);
        }else
        {
            return view('');
        }
    }

    /**
     * 添加和修改cmd
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author shenruxiang
     * @date 2018/9/15 08:47
     */
    public function reptile_save(Request $request)
    {
        $reptileRow = $request->input();

        if(! empty($reptileRow['id'])) {
            Reptile::where('id', $reptileRow['id'])->update($reptileRow);
        }else {
            Reptile::create($reptileRow);
        }

        return $this->retJson(3, '操作成功');
    }

    /**
     * cmd删除
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author shenruxiang
     * @date 2018/9/15 08:58
     */
    public function reptile_del(Request $request)
    {
        $reptileId = intval($request->input('id'));

        if(empty($reptileId)) {
            return $this->retJson(2, '删除失败');
        }

        Reptile::where('id', $reptileId)->delete();

        return $this->retJson(3, '删除成功');
    }

    /**
     * 命令运行
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author shenruxiang
     * @date 2018/9/15 15:16
     */
    public function reptile_run(Request $request)
    {
        $reptileId = intval($request->input('id'));

        if(empty($reptileId)) {
            return $this->retJson(2, '运行失败');
        }

        $reptileRow = Reptile::where('id', $reptileId)->first();

        if(empty($reptileRow) || $reptileRow['cmd_status'] == 2 || $reptileRow['status'] == 2) {
            return $this->retJson(2, '该命令正在运行或数据异常');
        }

        if(empty($reptileRow['target_url']) || empty($reptileRow['now_url'])) {
            return $this->retJson(2, '地址为空');
        }

        $reptileLogRow = ReptileLog::where('reptile_id', $reptileId)->first();

        if(empty($reptileLogRow))
        {
            Reptile::where('id', $reptileId)->update(['cmd_status' => 2]);

            # 记录日志
            ReptileLog::create([
                'reptile_id' => $reptileId,
                'target_url' => $reptileRow['now_url'],
                'start_time' => date('Y-m-d H:i:s', time()),
            ]);

            RunReptile::dispatch($reptileRow);

            return $this->retJson(3, '运行成功');
        }else {
            return $this->retJson(2, '该爬虫已运行');
        }


    }

    /**
     * cmd日志列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     * @author shenruxiang
     * @date 2018/9/15 08:33
     */
    public function reptile_log_list(Request $request)
    {
        $reptileLogList = ReptileLog::all();

        if($request->isMethod('post'))
        {
            return $this->retJsonTableData($reptileLogList);
        }else
        {
            return view('');
        }
    }
}
