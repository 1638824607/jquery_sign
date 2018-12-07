<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <title>@yield('title')</title>
    <meta charset="utf-8" />
    <meta name="keywords" id="metakeywords" content="{{! empty($systemInfo->site_keyword) ? $systemInfo->site_keyword : ''}}" />
    <meta name="description" id="metadescription" content="{{! empty($systemInfo->site_desc) ? $systemInfo->site_desc : ''}}" />
    <meta http-equiv="X-UA-Compatible" content="IE=8,IE=9,IE=10,IE=11,chrome=1" />
    <meta name="renderer" content="webkit" />
    <meta http-equiv="Cache-Control" content="no-transform" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <meta name="baidu-site-verification" content="nfZnnp6kHz" />
    <link rel="shortcut icon" href="/web_favicon.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="/web/css/base.css" />
    <link rel="stylesheet" type="text/css" href="/web/css/animate.css" />
    <script type="text/javascript" src="/web/js/jquery-3.1.1.min.js"></script>
    <script type="text/javascript" src="/web/js/jquery.lazyload.min.js"></script>
    <script type="text/javascript" src="/web/js/cookie.js"></script>
    <script type="text/javascript" src="/web/lib/layer/layer.js"></script>
    <script src="/web/js/lyz.calendar.min.js" type="text/javascript"></script>
    <script>
        var _hmt = _hmt || [];
        (function() {
            var hm = document.createElement("script");
            hm.src = "https://hm.baidu.com/hm.js?9b58dc8c4217bdc3a881044c60540a11";
            var s = document.getElementsByTagName("script")[0];
            s.parentNode.insertBefore(hm, s);
        })();
    </script>
    <script>
        (function(){
            var bp = document.createElement('script');
            var curProtocol = window.location.protocol.split(':')[0];
            if (curProtocol === 'https') {
                bp.src = 'https://zz.bdstatic.com/linksubmit/push.js';
            }
            else {
                bp.src = 'http://push.zhanzhang.baidu.com/push.js';
            }
            var s = document.getElementsByTagName("script")[0];
            s.parentNode.insertBefore(bp, s);
        })();
    </script>
</head>
<body>
<!--通用头部-->
<div class="gray"></div>
<div class="new_heder">
    <div class="container clearfix">
        <div class="fl new_left">
            <a href="{{url('/')}}" title="入香阁"><h1 class="newlogo"></h1></a>
        </div>
        <div class="fl new_right clearfix">
            <div class="fl myreads">
                <b class="new_his">阅读记录</b>
                @auth('web')
                    @if($bookRedisHistoryList = \Illuminate\Support\Facades\Redis::zrevrange('zset_book_history_'.Auth::guard('web')->id(), 0, 2))

                        <p class="new_history ">
                            @foreach($bookRedisHistoryList as $redisHistoryBookId)
                                @php
                                    $redisHistoryBookRow = \Illuminate\Support\Facades\Redis::hget('hash_book_history_'.Auth::guard('web')->id(), $redisHistoryBookId);

                                    $redisHistoryBookRow = explode('|', $redisHistoryBookRow);
                                @endphp
                                <a href="{{url('book_chapter_detail/'.$redisHistoryBookRow[1].'/'.$redisHistoryBookRow[0])}}" target="_blank" title="{{$redisHistoryBookRow[2]}} {{$redisHistoryBookRow[5]}}">上次看到：{{$redisHistoryBookRow[2]}} {{$redisHistoryBookRow[5]}}</a>
                            @endforeach
                        </p>
                    @endif
                @endauth
            </div>
            @guest('web')
                <div class="fl newlogin">
                    <b class="new_login">登录</b>
                    <ul class="new_nologin">
                        <li class="logingo"><a href="javascript:void 0" title="账号登录">账号登录</a></li>
                        <li class="reggo"><a href="javascript:void 0" title="注册新账号">注册新账号</a></li>
                        {{--<li class="@if(empty($systemSet->site_oauth) || !strstr($systemSet->site_oauth, 'wx')) none  @endif"><a href="http://www.shenruxiang.com/User/wechatLogin.html" title="微信登录" class="ncon nwechat">微信登录</a></li>--}}
                        {{--<li class="@if(empty($systemSet->site_oauth) || !strstr($systemSet->site_oauth, 'wb')) none  @endif"><a href="http://www.shenruxiang.com/User/wbLogin.html" title="微博登录" class="ncon nweibo">微博登录</a></li>--}}
                        {{--<li class="@if(empty($systemSet->site_oauth) || !strstr($systemSet->site_oauth, 'qq')) none  @endif"><a href="http://www.shenruxiang.com/User/qqLogin.html" title="QQ登录" class="ncon nqq">QQ登录</a></li>--}}
                    </ul>
                </div>
            @else
                <div class="fl newlogin user_login">
                    <a href="" class="userimg">
                        <img class="bd-radius50" src="{{ Auth::guard('web')->user()->avatar }}"></a>
                    <ul class="new_nologin"><!--已登录-->
                        <li class="active">
                            <a href="{{url('user')}}" class="first">{{ ! empty(Auth::guard('web')->user()->nick_name) ? Auth::guard('web')->user()->nick_name : Auth::guard('web')->user()->name }}</a>
                        </li>
                        <li>
                            <a href="{{url('user')}}">用户中心</a>
                        </li>
                        <li class="user-logout">
                            <a href="javascript:void 0">注销帐号</a>
                        </li><!--已登录 end-->
                    </ul>
                </div>
            @endguest
        </div>
    </div>
</div>

<!--导航-->
<div class="new_smhead">
    <div class="container">
        <div class="fl sm_left">
            <a href="" title="入香阁首页" class="sm_logos"><img src="/web/img/logo.png" alt="入香阁首页" /></a>

            @foreach($navList as $nav)
                <a href="{{url($nav['url'])}}"  title="{{$nav['name']}}">{{$nav['name']}}</a>
            @endforeach
        </div>
        <div class="fl sm_right">
            @guest('web')
                <div class="fr new_logins">
                    <a href="javascript:;" class="noic" target="_blank"></a>
                    <ul class="new_nologin">
                        <li class="logingo"><a href="javascript:void 0" title="账号登录">账号登录</a></li>
                        <li class="logingo"><a href="javascript:void 0" title="注册新账号">注册新账号</a></li>
                        {{--<li><a href="http://www.shenruxiang.com/User/wechatLogin.html" title="微信登录" class="ncon nwechat">微信登录</a></li>--}}
                        {{--<li><a href="http://www.shenruxiang.com/User/wbLogin.html" title="微博登录" class="ncon nweibo">微博登录</a></li>--}}
                        {{--<li><a href="http://www.shenruxiang.com/User/qqLogin.html" title="QQ登录" class="ncon nqq">QQ登录</a></li>--}}
                    </ul>
                </div>
             @else
                 <div class="fr new_logins">
                     <a href="javascript:;" style="background:url({{Auth::guard('web')->user()->avatar}}) no-repeat center; background-size:cover;border-radius:50%" class="noic" target="_blank"></a>
                     <ul class="new_nologin"><!--已登录-->
                         <li class="active">
                             <a href="{{url('user')}}" class="first">{{Auth::guard('web')->user()->nick_name}}</a>
                         </li>
                         <li>
                             <a href="{{url('user')}}">用户中心</a>
                         </li>
                         <li class="user-logout">
                             <a href="javascript:void 0">注销帐号</a>
                         </li><!--已登录 end--></ul>
                 </div>
             @endguest

                    <style>

                    </style>
            <div class="fr new_reads">
                <a href="##"></a>
                <p class="sm_new_history">

                    @auth('web')
                        @if($bookHistoryList = \Illuminate\Support\Facades\Redis::zrevrange('book_history_'.Auth::guard('web')->id(), 0, 2))
                            @foreach($bookHistoryList as $bookRow)
                                @php
                                    $bookRow = explode('|', $bookRow)
                                @endphp
                                <a href="{{url('book_chapter_detail/'.$bookRow[1].'/'.$bookRow[0])}}" target="_blank" title="{{$bookRow[2]}} {{$bookRow[3]}}">上次看到：{{$bookRow[2]}} {{$bookRow[3]}}</a>
                            @endforeach
                        @endif
                    @endauth

                </p>
            </div>
        </div>
        <!--二维码-->
        <div class="newewm">
            <div class="indexewm">
                <a class="jiuku"></a>
            </div>
        </div>
        <!--二维码 end-->
    </div>
</div>
<div class="new_hcats">
    <div class="container clearfix">
        <div class="fl new_c_left">
            @foreach($navList as $key => $nav)
                <a href="{{url($nav['url'])}}" title="{{$nav['name']}}" class="@if($nav['url'] == ltrim(str_replace(config('app')['url'], '', \Illuminate\Support\Facades\URL::current()), '/')) active @endif">{{$nav['name']}}</a>
            @endforeach
        </div>
        <div class="fl new_c_right">
            <input type="text" maxlength="10" class="newipt bbox SearchKey" placeholder="请输入关键词搜索" />
            <b class="newbtn postSearch"></b>
        </div>
    </div>
</div>

<div class="all_login">
    <div class="logins">
        <a href="javascript:;" class="loginClose"></a>
        <h3>登录账号 </h3>
        <div class="homeLogin clearfix">
            <div class="homeLoginContent ">
                <div class="inpInf">
                    <span>账号</span>
                    <input type="text"  class="inpInf_content login_user_email" placeholder="请输入邮箱" />
                </div>
                <div class="LoginNotice login_email_error">
                    <p><span>*用户名不存在</span></p>
                </div>
                <div class="inpInf">
                    <span>密码</span>
                    <input type="password" maxlength="16" class="inpInf_content login_user_password" placeholder="请输入8-16位密码" />
                </div>
                <div class="LoginNotice login_password_error">
                    <p><span>*密码不正确</span></p>
                </div>
                <div class="Loginre">
                    <p><input type="checkbox" class="remember" checked />自动登录<a class="forgetpd" href="" target="_blank">忘记密码</a></p>
                </div>
                <div class="btns">
                    <p class="loginBtn submit-login"><a href="javascript:void 0">确认登录</a></p>
                    <p class="registerNew to-register"><a href="javascript:void 0" target="_blank">立即注册</a></p>
                </div>
            </div>
            <div class="third_party clearfix"></div>
            <div class="otherlogin clearfix">
                {{--<div class="@if(empty($systemSet->site_oauth) || !strstr($systemSet->site_oauth, 'wx')) none  @endif"><a class="wechat" title="微信登陆" href="http://www.shenruxiang.com/User/wechatLogin.html" target="_blank"></a></div>--}}
                {{--<div class="@if(empty($systemSet->site_oauth) || !strstr($systemSet->site_oauth, 'wb')) none  @endif"><a class="weibo" title="新浪微博" href="http://www.shenruxiang.com/User/wbLogin.html" target="_blank"></a></div>--}}
                {{--<div class="@if(empty($systemSet->site_oauth) || !strstr($systemSet->site_oauth, 'qq')) none  @endif"><a class="qq" title="QQ登陆" href="http://www.shenruxiang.com/User/qqLogin.html" target="_blank"></a></div>--}}
            </div>
        </div>
    </div>
</div>

<div class="all_reg">
    <div class="regs">
        <a href="javascript:;" class="loginClose"></a>
        <h3>注册账号 </h3>
        <div class="homeLogin clearfix">
            <div class="homeLoginContent">
                <div class="inpInf">
                    <span>邮箱</span>
                    <input type="text"  class="inpInf_content reg_user_email" placeholder="请输入邮箱" />
                </div>
                <div class="LoginNotice reg_email_error">
                    <p><span style="float: inherit">*邮箱格式错误</span></p>
                </div>
                {{--<div class="inpInf">--}}
                    {{--<span>验证码</span>--}}
                    {{--<input type="text" maxlength="6" class="inpInf_content reg_user_email_verify" placeholder="请输入六位邮箱验证码" />--}}
                {{--</div>--}}
                {{--<div class="LoginNotice reg_email_verify_error">--}}
                    {{--<p><span style="float: inherit">*验证码不正确</span></p>--}}
                {{--</div>--}}
                <div class="inpInf">
                    <span>昵称</span>
                    <input type="text" maxlength="20"  class="inpInf_content reg_user_name" placeholder="请输入昵称" />
                </div>
                <div class="LoginNotice reg_user_name_error">
                    <p><span style="float: inherit">*昵称格式不正确</span></p>
                </div>
                <div class="inpInf">
                    <span>密码</span>
                    <input type="password" maxlength="16"  class="inpInf_content reg_user_pass"  placeholder="请输入8-16位密码" />
                </div>

                <div class="LoginNotice reg_user_pass_error">
                    <p><span style="float: inherit">*密码不正确</span></p>
                </div>

                <div class="btns">
                    <p class="registerNew submit-register"><a href="javascript:void 0" target="_blank">立即注册</a></p>
                    <p class="loginBtn to-login"><a href="javascript:void 0">返回登录</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // 注册
    $('.to-register').click(function(){
        $('.all_login').hide();
        $('.all_reg').show();
    });

    //登陆
    $('.to-login').click(function(){
        $('.all_reg').hide();
        $('.all_login').show();
    });
    // 图片懒加载
    $("img").lazyload(
        {placeholder : "http://img.9kus.com/Images/64/555d4c643d8e1.jpg",
            effect: "fadeIn"});

    var searchUrl = "{{url('inside_search')}}";

    // 头部搜索框 回车事件
    $('.SearchKey').keydown(function(event){
        if(event.keyCode == 13){ //绑定回车
            $(".postSearch").click();
        }
    });

    //头部切换
    $(window).scroll(function(){
        var ST = $(window).scrollTop();
        if(ST >= 100){
            $('.new_smhead').stop().show();
        }else{
            $('.new_smhead').stop().hide();
        }
    })

    // 回到顶部
    function index_goTop(){
        $('body,html').animate({scrollTop:0},1000);
        return false;
    }

    // 头部搜索框 点击事件
    $(".postSearch").click(function(){
        var search_content = '/' + $(".SearchKey").val();

        window.open(searchUrl + search_content);
    })

    //点击登陆
    $('.logingo').on('click',function(){
        $('.gray').show()
        $('.all_login').fadeIn(200);
    })
    //点击注册
    $('.reggo').on('click',function(){
        $('.gray').show()
        $('.all_reg').fadeIn(200);
    })

    //关闭登陆框
    $('.all_login .loginClose,.all_reg .loginClose').on('click',function(){
        $('.gray,.all_login').hide();
        $('.gray,.all_reg').hide();
    })

    //登陆
    var loginUrl = "{{url('login')}}";
    var loginBtnStatus = true;

    $('.submit-login').bind('click',function()
    {
        if(loginBtnStatus) {
            loginBtnStatus = false;
            $('.LoginNotice span').hide();

            var user_email =  $('.login_user_email').val();
            var user_pass =  $('.login_user_password').val();
            var remember = $('.remember').prop('checked');

            $.ajax({
                url:loginUrl,
                data:{
                    name:user_email,
                    password:user_pass,
                    remember:remember
                },
                type:"POST",
                success: function(data){
                    layer.msg(data.msg);
                    if(data.status =='3'){
                        window.setTimeout("window.location.reload()",2000);
                    }else {
                        loginBtnStatus = true;
                    }
                }
            });
        }

    })

    // 注册
    var regUrl = '{{url('register')}}';

    $('.submit-register').bind('click',function() {
        $('.LoginNotice span').hide();
        var reg_user_email =  $('.reg_user_email').val();
//        var reg_user_email_verify =  $('.reg_user_email_verify').val();
        var reg_user_name =  $('.reg_user_name').val();
        var reg_user_pass =  $('.reg_user_pass').val();

        if(! checkEmail(reg_user_email)) {
            $('.reg_email_error span').show();
            return false;
        }

//        if(reg_user_email_verify.length != 6){
//            $('.reg_email_verify_error span').show();
//            return false;
//        }

        if(reg_user_name.length <1 || reg_user_name.length > 20) {
            $('.reg_user_name_error span').show();
            return false;
        }

        if(reg_user_pass.length <8 || reg_user_pass.length > 16) {
            $('.reg_user_pass_error span').show();
            return false;
        }

        $.ajax({
            url:regUrl,
            data:{
                reg_user_email:reg_user_email,
//                reg_user_email_verify:reg_user_email_verify,
                reg_user_name:reg_user_name,
                reg_user_pass:reg_user_pass
            },
            type:"POST",
            success: function(data){
                if(data.status ==3){
                    layer.msg(data.msg);
                    window.setTimeout("window.location.reload()",2000);
                }else if(data.status == 4)
                {
                    layer.msg(data.msg);
                }else{
                    $(data.msg).show();
                }
            }
        });
    })

    //发送验证码倒计时
    var wait = 30;//倒计时30秒
    var intervalId;//定时
    var i = wait;//倒计时递减 1
    var sendEmailUrl = '{{url('send_email')}}';

    function code_exit() {
        $(".send-email").text(i + "秒后重新发送");
        i = i - 1;
        if (i <= -1) {
            $(".send-email").prop("disabled", false).text("获取验证码");
            clearInterval(intervalId);
            wait = i = 5;
        }
    }

    $('.send-email').click(function()
    {
        var user_email = $('.reg_user_email').val();

        if($(this).prop("disabled") == true){
            return false;
        }

        if(! checkEmail(user_email)) {
            $('.reg_email_error span').show();
            return false;
        }else {
            $('.reg_email_error span').hide();
        }

        var index = layer.load(1, {
            shade: [0.1,'#fff'] //0.1透明度的白色背景
        });

        $.ajax({
            url:sendEmailUrl,
            data:{
                'email':user_email
            },
            type:"POST",
            success: function(data){
                layer.closeAll();
                layer.msg(data.msg);
                if(data.status == 3) {
                    $(".send-email").prop("disabled", true);
                    intervalId = setInterval("code_exit()", 1000);
                }
            }
        });
    });

    // 验证邮箱
    function checkEmail(str){
        var
            re = /^(\w-*\.*)+@(\w-?)+(\.\w{2,})+$/;
        if(re.test(str)){
            return true;
        }else{
            return false;
        }
    }

    // 用户注销
    var logoutUrl = "{{url('logout')}}";
    $('.user-logout').click(function(){
        $.ajax({
            url:logoutUrl,
            type:"POST",
            success: function(data){
                layer.msg(data.msg);
                window.setTimeout("window.location.href='/'",2000);

            }
        });
    });

</script>