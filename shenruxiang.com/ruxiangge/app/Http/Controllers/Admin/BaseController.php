<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    protected $app_guard = 'admin';

    /**
     * 返回json数据
     * @param int    $status
     * @param string $msg
     * @param array  $data
     * @return \Illuminate\Http\JsonResponse
     * @author shenruxiang
     * @date 2018/8/7 00:33
     */
    protected function retJson($status = 2 , $msg = '', $data = [])
    {
        return response()->json([
            'status' => $status,
            'msg'    => $msg,
            'data'   => $data
        ]);
    }

    /**
     * 返回json data
     * @param array $data
     * @param int   $count
     * @return \Illuminate\Http\JsonResponse
     * @author shenruxiang
     * @date 2018/8/10 11:30
     */
    protected function retJsonTableData($data = [], $count = 0)
    {
        return response()->json([
            'code'  => 0,
            'count' => $count,
            'data'  => $data,
            'msg'   => 'success'
        ]);
    }
}
