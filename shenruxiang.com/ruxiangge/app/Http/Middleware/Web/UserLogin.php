<?php

namespace App\Http\Middleware\Web;

use App\Admin\User;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class UserLogin
{
    public function handle($request, Closure $next)
    {
        $user = Auth::guard('web')->user();

        $currentTime = strtotime(date('Y-m-d',time()));

        if(! empty($user) && strtotime($user['updated_at']) < $currentTime) {
          $data = [
              'updated_at' => date('Y-m-d H:i:s', time()),
              'day_num' => $user['day_num'] + 1,
          ];

          User::where('id', $user['id'])->update($data);
        }

        return $next($request);
    }
}
