<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>入香阁后台管理系统</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="/admin/lib/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="/admin/css/admin.css" media="all">
    <link rel="stylesheet" href="/admin/css/login.css" media="all">
    <link rel="stylesheet" href="/admin/lib/nprogress/nprogress.css" media="all">
    <style>
        #nprogress .bar{
            background:#000000;
        }
        #nprogress .spinner-icon{
            border-top-color:#000000;
            border-left-color:#000000;
        }
    </style>
</head>
<body>
<div class="layadmin-user-login layadmin-user-display-show" id="LAY-user-login" style="display: none;">

    <div class="layadmin-user-login-main" style="margin-top: 5%">
        <div class="layadmin-user-login-box layadmin-user-login-header">
            <h2>ShenRuXiang</h2>
            <p>入香阁后台管理系统</p>
        </div>
        <div class="layadmin-user-login-box layadmin-user-login-body layui-form">
            <div class="layui-form-item">
                <label class="layadmin-user-login-icon layui-icon layui-icon-username" for="LAY-user-login-username"></label>
                <input type="text" name="name" id="login-name" lay-vertype="tips" lay-verify="required"  autocomplete="off" placeholder="用户名" class="layui-input">
            </div>
            <div class="layui-form-item">
                <label class="layadmin-user-login-icon layui-icon layui-icon-password" for="LAY-user-login-password"></label>
                <input type="password" name="password" id="login-password" lay-vertype="tips" lay-verify="required" placeholder="密码" class="layui-input">
            </div>
            <div class="layui-form-item">
                <div class="layui-row">
                    {{--<div class="layui-col-xs7">--}}
                        {{--<label class="layadmin-user-login-icon layui-icon layui-icon-vercode" for="LAY-user-login-vercode"></label>--}}
                        {{--<input type="text" name="code" id="login-code" lay-vertype="tips" lay-verify="required" placeholder="图形验证码" class="layui-input">--}}
                    {{--</div>--}}
                    {{--<div class="layui-col-xs5">--}}
                        {{--<div style="margin-left: 10px;">--}}
                            {{--<img src="https://www.oschina.net/action/user/captcha" class="layadmin-user-login-codeimg" id="LAY-user-get-vercode">--}}
                        {{--</div>--}}
                    {{--</div>--}}
                </div>
            </div>

            <div class="layui-form-item">
                <button class="layui-btn layui-btn-fluid layui-bg-black" lay-submit lay-filter="user-login-submit">登 入</button>
            </div>

        </div>
    </div>

    <div class="layui-trans layadmin-user-login-footer">

        <p>© 2018 <a href="http://www.shenruxiang.com" target="_blank">www.shenruxiang.com</a></p>
        <p>
            {{--<span><a href="http://www.shenruxiang.com" target="_blank">ICP备案号:京ICP备16037841号</a></span>--}}
        </p>
    </div>
</div>
</body>
<script src="/admin/lib/layui/layui.js"></script>
<script src="/admin/lib/nprogress/nprogress.js"></script>
<script>
    layui.use(['jquery','form'], function() {
        var $ = layui.$;
        var form = layui.form;
        var layer = layui.layer;

        var ajax_login_url = '{{url("admin/ajax_login")}}';
        var redirect_index_url = '{{url("admin/index")}}';
        var login_url = '{{url("admin/login")}}';

        NProgress.start();

        $(window).load(function() {
            if(self != top) {
                top.location.href = login_url;
                return false;
            }

            NProgress.done();
        });



        form.on('submit(user-login-submit)', function(data)
        {
            $.post(
                ajax_login_url,
                data.field,
                function(res){
                    if(res.status == 1){
                        $.each(res.msg, function(k, v){
                            layer.tips(v[0], $('#login-' + k),{tipsMore:true,time:1000});
                        });
                    }else if(res.status == 2){
                        layer.msg(res.msg,{icon:5,shade:0.1,time:1000});
                    }else{
                        layer.msg(res.msg, {icon:6,shade:0.1,time:1000}, function(){
                            window.location.href = redirect_index_url;
                        });
                    }
            },'json');
        });
    });
</script>
</html>