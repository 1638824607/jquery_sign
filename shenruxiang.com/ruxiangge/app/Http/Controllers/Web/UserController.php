<?php

namespace App\Http\Controllers\Web;

use App\Admin\Book;
use App\Admin\User;
use App\Admin\UserCollect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class UserController extends BaseController
{
    protected $user;
    public function __construct(Request $request)
    {
        $this->middleware(function ($request, $next) {
            $user = Auth::guard($this->app_guard)->user();

            if(empty($user['id']) && (!$request->ajax())) {
                abort(404);
            }else {
                $this->user = $user;
            }

            return $next($request);
        });
    }

    /**
     * 用户注册
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author shenruxiang
     * @date 2018/8/26 18:07
     */
    public function register(Request $request)
    {
        $registerInfo =  $request->input();

        $regEmail       = trim($registerInfo['reg_user_email']);
//        $regEmailVerify = trim($registerInfo['reg_user_email_verify']);
        $regName        = trim($registerInfo['reg_user_name']);
        $regPass        = trim($registerInfo['reg_user_pass']);


        if (!filter_var($regEmail, FILTER_VALIDATE_EMAIL)) {
            return $this->retJson(2, '.reg_email_error span');
        }

        if(mb_strlen($regName) == '' || mb_strlen($regName) > 20) {
            return $this->retJson(2, '.reg_user_name_error span');
        }

        if(mb_strlen($regPass) == '' || mb_strlen($regPass) > 16) {
            return $this->retJson(2, '.reg_user_pass_error span');
        }

//        $email_verify = $request->session()->get('email_verify') ? explode('_', $request->session()->get('email_verify')) : '';
//
//        if(empty($email_verify)) {
//            return $this->retJson(2, '.reg_email_verify_error span');
//        }

//        $user_email_verify = $email_verify[0];
//        $user_email_verify_time = $email_verify[1];
//        $email_verify_exprie_time = 60*30*1000;
//
//        if($user_email_verify_time + $email_verify_exprie_time < time() || strtolower($user_email_verify) != strtolower($regEmailVerify)) {
//            return $this->retJson(2, '.reg_email_verify_error span');
//        }

        # 判断邮箱是否存在
        $userRow = User::where(['email' => $regEmail,'name' => $regEmail])->first();

        if(! empty($userRow)) {
            return $this->retJson(4, '邮箱已被注册');
        }

//        $request->session()->put('email_verify', NULL);

        $data = [
            'name'        => $regEmail,
            'email'       => $regEmail,
            'password'    => bcrypt($regPass),
            'nick_name'   => $regName,
            'app_type'    => 2,
            'oauth_type'  => 1,
            'avatar'      => '/storage/avatar/default.png',
            'register_ip' => $request->getClientIp()
        ];

        User::create($data);

        return $this->retJson(3, '注册成功，请登陆');
    }

    /**
     * 用户登陆
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author shenruxiang
     * @date 2018/8/26 17:15
     */
    public function login(Request $request)
    {
        if(Auth::guard($this->app_guard)->attempt(['name'=>$request->input('name'),'password'=>$request->input('password')], TRUE)) {
            $request->session()->forget('index_page');
            return $this->retJson(3, '登陆成功');
        }

        return $this->retJson(2, '登陆失败，请重试');
    }

    /**
     * 用户退出
     * @return \Illuminate\Http\JsonResponse
     * @author shenruxiang
     * @date 2018/8/26 22:21
     */
    public function logout(Request $request)
    {
        Auth::guard($this->app_guard)->logout();

        $request->session()->forget('index_page');

        return $this->retJson(3, '注销成功！');
    }

    /**
     * 用户中心
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author shenruxiang
     * @date 2018/9/3 12:22
     */
    public function index()
    {
        $userCollectList = UserCollect::where('user_id', $this->user['id'])->get()->toArray();

        $bookList = [];

        if(! empty($userCollectList)) {
            $bookIdArr = arrayColumns($userCollectList, 'book_id');

            $userBookList = Book::whereIn('id', $bookIdArr)->get()->toArray();

            if(! empty($userBookList)) {
                $bookListCount = count($userBookList);

                for($i = 0; $i < ceil($bookListCount); $i++)
                {
                    $bookList[] = array_slice($userBookList, $i * 4 ,4);
                }
            }
        }

        return view('', ['bookList' => $bookList, 'user' => $this->user]);
    }

    /**
     * 用户信息修改
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author shenruxiang
     * @date 2018/9/5 17:01
     */
    public function save(Request $request)
    {
        $userRow = $request->input();

        if($request->file('avatar')) {
            $avatarPath = $request->file('avatar')->store('user_avatar');
            $userRow['avatar'] = '/storage/' . $avatarPath;
        }else {
            unset($userRow['avatar']);
        }

        $email_verify = $request->session()->get('email_verify') ? explode('_', $request->session()->get('email_verify')) : '';

        if(! empty($email_verify) && ! empty($userRow['email_code']))
        {
            $user_email_verify = $email_verify[0];
            $user_email_verify_time = $email_verify[1];
            $email_verify_exprie_time = 60*30*1000;

            if($user_email_verify_time + $email_verify_exprie_time < time() || strtolower($user_email_verify) != strtolower($userRow['email_code'])) {
                return $this->retJson(2, '邮箱验证码错误');
            }

            if($userRow['email'] != $request->session()->get('email_send')) {
                return $this->retJson(2, '邮箱与验证邮箱不一致');
            }

        }else {
            $request->session()->put('email_verify', NULL);
            unset($userRow['email']);
        }

        unset($userRow['email_code']);

        $saveUserData = [];

        if(! empty($userRow['nick_name'])) {
            $saveUserData['nick_name'] = trim($userRow['nick_name']);
        }

        if(! empty($userRow['sex'])) {
            $saveUserData['sex'] = intval($userRow['sex']);
        }

        if(! empty($userRow['email'])) {
            $saveUserData['email'] = trim($userRow['email']);

            $existUserRow = User::where('id', '!=' ,Auth::guard($this->app_guard)->id())->where('email', $saveUserData['email'])->get()->toArray();

            if(! empty($existUserRow)) {
                return $this->retJson(2, '邮箱已存在');
            }
        }

        if(! empty($userRow['avatar'])) {
            $saveUserData['avatar'] = trim($userRow['avatar']);
        }

        User::where('id', Auth::guard($this->app_guard)->id())->update($saveUserData);

        return $this->retJson(3, '修改成功');
    }
}
