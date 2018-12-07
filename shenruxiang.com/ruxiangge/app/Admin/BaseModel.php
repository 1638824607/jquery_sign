<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class BaseModel extends Model
{
    public static function __callStatic($method, $parameters)
    {
        if(substr($method, -9) == 'WithCache')
        {
            $method = str_replace('WithCache', '', $method);

            if(method_exists((new static), $method))
            {
                $className = get_class((new static));

                $memcachedKey = "{$className}:{$method}:".json_encode($parameters, true);

                $cacheData = Cache::remember($memcachedKey, 60 * 24, function () use($className,$method,$parameters) {
                    return call_user_func_array(array($className, $method), $parameters);
                });

                return $cacheData;
            }
        }

        return (new static)->$method(...$parameters);
    }
}
