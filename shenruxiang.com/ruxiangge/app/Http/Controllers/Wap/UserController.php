<?php

namespace App\Http\Controllers\Wap;

use App\Admin\Book;
use App\Admin\Suggest;
use App\Admin\User;
use App\Admin\UserCollect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class UserController extends BaseController
{
    protected $user = 0;
    public function __construct(Request $request)
    {
        $this->middleware(function ($request, $next) {
            $user = Auth::guard($this->app_guard)->user();

            if(! empty($user['id'])) {
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
        if($request->isMethod('post'))
        {
            $registerInfo =  $request->input();

            $regEmail       = trim($registerInfo['reg_user_email']);
//            $regEmailVerify = trim($registerInfo['reg_user_email_verify']);
            $regName        = trim($registerInfo['reg_user_name']);
            $regPass        = trim($registerInfo['reg_user_pass']);


            if (!filter_var($regEmail, FILTER_VALIDATE_EMAIL)) {
                return $this->retJson(2, '邮箱格式不正确');
            }

            if(mb_strlen($regName) == '' || mb_strlen($regName) > 20) {
                return $this->retJson(2, '昵称格式不正确');
            }

            if(mb_strlen($regPass) == '' || mb_strlen($regPass) > 16) {
                return $this->retJson(2, '密码格式不正确');
            }

//            $email_verify = $request->session()->get('email_verify') ? explode('_', $request->session()->get('email_verify')) : '';
//
//            if(empty($email_verify)) {
//                return $this->retJson(2, '请输入邮箱验证码');
//            }

//            $user_email_verify = $email_verify[0];
//            $user_email_verify_time = $email_verify[1];
//            $email_verify_exprie_time = 60*30*1000;

//            if($user_email_verify_time + $email_verify_exprie_time < time() || strtolower($user_email_verify) != strtolower($regEmailVerify)) {
//                return $this->retJson(2, '邮箱验证码错误');
//            }

            # 判断邮箱是否存在
            $userRow = User::where(['email' => $regEmail,'name' => $regEmail])->first();

            if(! empty($userRow)) {
                return $this->retJson(4, '用户名或邮箱已被注册');
            }

            $request->session()->put('email_verify', NULL);

            $data = [
                'name'        => $regEmail,
                'email'       => $regEmail,
                'password'    => bcrypt($regPass),
                'nick_name'   => $regName,
                'app_type'    => 1,
                'oauth_type'  => 1,
                'avatar'      => '/storage/avatar/default.png',
                'register_ip' => $request->getClientIp()
            ];

            User::create($data);

            return $this->retJson(3, '注册成功，请登陆');
        }else {
            return view('');
        }
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
            $request->session()->forget('wap_index_page');
            return $this->retJson(3, '登陆成功,正在跳转···');
        }

        return $this->retJson(2, '登陆失败，请重试');
    }

    /**
     * 登录
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author shenruxiang
     * @date 2018/11/12 22:45
     */
    public function signin()
    {
        if(! empty($this->user)) {
            return redirect(url('user'));
        }

        return view('');
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
        $request->session()->forget('wap_index_page');
        return $this->retJson(3, '注销成功！');
    }

    public function forget_pass(Request $request)
    {
        if($request->isMethod('post'))
        {
            $registerInfo =  $request->input();

            $forgetEmail       = trim($registerInfo['forget_user_email']);
            $forgetEmailVerify = trim($registerInfo['forget_user_email_verify']);
            $forgetPass        = trim($registerInfo['forget_user_pass']);


            if (!filter_var($forgetEmail, FILTER_VALIDATE_EMAIL)) {
                return $this->retJson(2, '邮箱格式不正确');
            }

            if(mb_strlen($forgetPass) == '' || mb_strlen($forgetPass) > 16) {
                return $this->retJson(2, '密码格式不正确');
            }

            $email_verify = $request->session()->get('email_verify') ? explode('_', $request->session()->get('email_verify')) : '';

            if(empty($email_verify)) {
                return $this->retJson(2, '请输入邮箱验证码');
            }

            $user_email_verify = $email_verify[0];
            $user_email_verify_time = $email_verify[1];
            $email_verify_exprie_time = 60*30*1000;

            if($user_email_verify_time + $email_verify_exprie_time < time() || strtolower($user_email_verify) != strtolower($forgetEmailVerify)) {
                return $this->retJson(2, '邮箱验证码错误');
            }

            # 判断邮箱是否存在
            $userRow = User::where(['email' => $forgetEmailVerify,'name' => $forgetEmailVerify])->first();

            if(! empty($userRow)) {
                return $this->retJson(4, '用户名或邮箱已被注册');
            }

            $request->session()->put('email_verify', NULL);

            User::where('email', $forgetEmail)->update(['password' => bcrypt($forgetPass)]);

            return $this->retJson(3, '修改密码成功，请登陆');

        }else {
            return view('');
        }
    }

    /**
     * 用户中心
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author shenruxiang
     * @date 2018/9/3 12:22
     */
    public function index()
    {
        if(empty($this->user)) {
            return redirect(url('signin'));
        }
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
        if(empty($this->user)) {
            return redirect(url('signin'));
        }

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

        User::where('id', $this->user['id'])->update($userRow);

        return $this->retJson(3, '修改成功');
    }

    /**
     * 头像上传
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author shenruxiang
     * @date 2018/11/16 21:15
     */
    public function upload_avatar(Request $request)
    {
        $userId = Auth::guard($this->app_guard)->id();

        if(empty($userId)) {
            return $this->retJson(2, '上传失败');
        }

        $base64ImgData = $request->input('img_data');

        if(empty($base64ImgData)) {
            return $this->retJson(2, '上传失败');
        }

        $imgInfo = getHtml5Img($base64ImgData);

        if(empty($imgInfo)) {
            return $this->retJson(2, '上传失败');
        }

        $uploadAvatarName = sprintf("/avatar/%s/%s%s.%s", date('Y_m_d', time()), time(), rand(10000, 99999), $imgInfo['type']);

        $uploadAvatarPath = sprintf("%s%s", config('filesystems')['disks']['public']['root'], $uploadAvatarName);

        if(!is_dir(dirname($uploadAvatarPath))) {
            mkdir(dirname($uploadAvatarPath), 755, true);
        }

        $wirteRes = file_put_contents($uploadAvatarPath, $imgInfo['base64Img']);

        if(empty($wirteRes)) {
            return $this->retJson(2, '上传失败');
        }

        User::where('id', $userId)->update(['avatar' => '/storage/' . $uploadAvatarName]);

        $request->session()->forget('wap_index_page');

        return $this->retJson(1, '上传成功');
    }

    /**
     * 意见反馈
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author shenruxiang
     * @date 2018/11/14 11:48
     */
    public function suggest(Request $request)
    {
        $suggestContent = trim($request->input('content'));

        if(empty($suggestContent)) {
            return $this->retJson(2, '反馈内容不能为空');
        }

        $insertData = [
            'content' => $suggestContent,
            'user_id' => $this->user['id'],
        ];

        Suggest::create($insertData);

        return $this->retJson(3, '留言成功，感谢您的反馈');
    }
}
