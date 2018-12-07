@extends('layouts.wap.common')

@section('title', '入香阁-全本小说网')

@section('content')
<!--内容区-->
<div class="newwap">
    <div class="loginreg bg clearfix" style="top: -10%;">
        <div class="container">
            <h2>忘记密码</h2>
            <ul>
                <li>
                    <input class="telx emails" maxlength="24" placeholder="请输入邮箱" type="text">
                </li>
                <li>
                    <input class="yzmx" maxlength="6" placeholder="请输入邮箱验证码" type="text">
                    <button class="yzm">获取验证码</button>
                </li>
                <li>
                    <input class="passwdx" placeholder="请输入8-16位新密码" type="password">
                </li>
            </ul>
            <div class="btnx">
                <a href="javascript:;">确认</a>
            </div>
            <div class="logtip">
                <a href="{{url('signin')}}">已有账号登陆</a>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="/web/lib/layer/mobile/layer.js"></script>
<script>
    var sendEmailUrl = "{{url('send_email')}}";
    var signinUrl = "{{url('signin')}}";
    var mailTest=(/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/);

    //获取验证码
    var time  = 60;
    var Isok = false;
    $('.loginreg .yzm').on('click',function(){
        var email = $('.loginreg .emails').val().trim();
        if(email == '' || mailTest.test(email) ==false){
            layer.open({
                content: '请输入正确的邮箱'
                ,skin: 'msg'
                ,time: 1
            });
        }else{
            Isok = true;
        }
        if(Isok){
            var $this = $(this);
            $.ajax({
                url:sendEmailUrl,
                type:'POST',
                async:false,
                cache:false,
                data:{email:email},
                success:function(data){
                    if(data.status === 3){
                        var timer =  setInterval(function(){
                            time-- ;
                            $this.html('剩余'+time+'秒').attr('disabled','disabled');
                            if(time<=0){
                                time = 60;
                                $this.html('获取验证码').removeAttr('disabled');
                                clearInterval(timer);
                            }
                        },1000)
                    }

                    layer.open({
                        content: data.msg
                        ,skin: 'msg'
                        ,time: 1
                    });
                }
            });
        }
    });


    //注册
    $('.loginreg .btnx').on('click',function(){
        var emails = $('.loginreg .emails').val().trim();
        var yzmx = $('.loginreg .yzmx').val().trim();
        var passwdx = $('.loginreg .passwdx').val().trim();
        if(emails == '' || mailTest.test(emails) ==false){
            layer.open({
                content: '请输入正确的邮箱'
                ,skin: 'msg'
                ,time: 1
            });

            return false;

        }

        if(yzmx == '' || yzmx.length < 6){
            layer.open({
                content: '请输入正确的验证码'
                ,skin: 'msg'
                ,time: 1
            });

            return false;
        }

        if(passwdx == '' || passwdx.length < 8 || passwdx.length > 16){

            layer.open({
                content: '请输入您的新密码'
                ,skin: 'msg'
                ,time: 1
            });

            return false;
        }

        $.ajax({
            url:"{{url('forget_pass')}}",
            type:"POST",
            async:false,
            cache:false,
            data:{
                forget_user_email:emails,
                forget_user_email_verify:yzmx,
                forget_user_pass:passwdx
            },
            success:function(data){
                layer.open({
                    content: data.msg
                    ,skin: 'msg'
                    ,time: 1
                });

                if(data.status === 3) {
                    window.setTimeout("window.location.href=signinUrl",2000);
                }
            }
        });

    });

</script>
</body>
</html>
@endsection