<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

# 用户后台登陆验证
class LoginRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'     =>'required',
            'password' =>'required',
//            'code'     =>'required',
        ];
    }

    public function messages() {
        return [
            'name.required'     =>'用户名不能为空',
            'password.required' =>'密码不能为空',
//            'code.required'     =>'验证码不能为空',
        ];
    }

    public function failedValidation( \Illuminate\Contracts\Validation\Validator $validator ) {
        exit(json_encode(array(
            'status' => 1,
            'msg' => $validator->getMessageBag()->toArray(),
        )));
    }
}
