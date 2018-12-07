@extends('layouts.wap.common')

@section('title', '入香阁-全本小说网')

@section('content')
<!--内容区-->
<div class="newwap">

    <div class="loginreg bg clearfix" style="top: -10%;">
        <div class="container">

            <div class="clearfix">
                <h2>账号登录</h2>
                <ul>
                    <li><input class="telx email"  placeholder="请输入邮箱" type="text" /></li>
                    <li><input class="passwdx" placeholder="请输入密码" type="password" /><a href="{{url('forget_pass')}}" class="yzm">忘记密码？</a></li>
                </ul>
                <div class="btnx">
                    <a href="javascript:;">登录</a>
                </div>
                <div class="logtip">
                    <a href="{{url('register')}}">注册账号</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="/web/lib/layer/mobile/layer.js"></script>
<script type="text/javascript">
    var mailReg = /^(\w-*\.*)+@(\w-?)+(\.\w{2,})+$/;
    $('.loginreg .btnx').on('click',function(){
        var email = $('.loginreg .email').val().trim();
        var passwdx = $('.loginreg .passwdx').val().trim();
        if(!email || !mailReg.test(email)){
            layer.open({
                content: '请输入正确的邮箱账号'
                ,skin: 'msg'
                ,time:2
            });
        } else if(!passwdx || passwdx.length < 8){
            layer.open({
                content: '请输入您的密码'
                ,skin: 'msg'
                ,time:2
            });
        }else{
            $.ajax({
                type: "POST",
                url: "{{url('login')}}",
                async: false,
                cache:false,
                data: {
                  name:email,
                  password:passwdx
                },
                dataType:'json',
                success: function(data){

                    if(data.status === 3){
                        layer.open({
                            content: data.msg
                            ,skin: 'msg'
                            ,time:2
                        });
                        window.location.href= "{{url('/')}}";
                    }else{
                        layer.open({
                            content: data.msg
                            ,skin: 'msg'
                            ,time:2
                        });
                    }
                }
            });
        }
    });
</script>
</body>
</html>
@endsection