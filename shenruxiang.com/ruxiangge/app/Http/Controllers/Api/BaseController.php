<?php

namespace App\Http\Controllers\Api;

use GuzzleHttp\Client;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class BaseController extends Controller
{
    protected $app_guard = 'api';

    public function __call($method, $parameters)
    {
        if(substr($method, -9) == 'WithCache')
        {
            $method = str_replace('WithCache', '', $method);

            if(method_exists($this, $method))
            {
                $className = get_class($this);

                $memcachedKey = "{$className}:{$method}:".json_encode($parameters, true);

                $cacheData = Cache::remember($memcachedKey, 60 * 24 * 5, function () use($className,$method,$parameters) {
                    return call_user_func_array(array($this, $method), $parameters);
                });

                return $cacheData;
            }
        }

        return call_user_func_array(array($this, $method), $parameters);
    }

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
     * guzzle对象
     * @return Client
     * @author shenruxiang
     * @date 2018/11/17 21:18
     */
    protected function guzzleClient()
    {
        return  new Client();
    }
}
