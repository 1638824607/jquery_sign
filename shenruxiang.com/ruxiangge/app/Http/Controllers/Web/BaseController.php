<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    protected $app_guard = 'web';

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
}
