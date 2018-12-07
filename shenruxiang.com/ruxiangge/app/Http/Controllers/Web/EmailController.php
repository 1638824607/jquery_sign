<?php

namespace App\Http\Controllers\Web;

use App\Admin\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class EmailController extends BaseController
{
    public function send_email(Request $request)
    {
        $user_email = $request->input('email');

        if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
            return $this->retJson(2, '发送失败');
        }

        $email_verify = mt_rand(100000, 999999);

        Mail::send('web/email/send_email',['email_verify'=>$email_verify],function($message) use($user_email){
            $to = $user_email;
            $message->to($to)->subject('入香阁用户注册验证码');
        });

        # 返回的一个错误数组，利用此可以判断是否发送成功

        if(! Mail::failures()) {
            $request->session()->put('email_verify', $email_verify . '_' . time());
            $request->session()->put('email_send', $user_email);
            return $this->retJson(3, '发送成功');
        }else {
            return $this->retJson(2, '发送失败');
        }
    }
}
