@extends('layouts.wap.common')

@section('title', '入香阁-全本小说网')

@section('content')
<!--内容区-->
<link rel="stylesheet" href="/wap/css/upload_avatar.css">
<div class="newwap">
    <style>
        .upload-img{
            background: url(/wap/img/upload_img.png) no-repeat 10px center;
            background-size: auto 80%;
            font-size: 1.2rem;
            color: #363636;
            position: absolute;
            -webkit-border-radius: 50px;
            border-radius: 50px;
            padding: 20px 8px 4px 25px;
            text-align: center;
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
            top:50%;
        }
    </style>
    <div class="meinfo bg clearfix">
        <div class="clearfix blurs">
            <div class="myblur">
                <img src="/wap/img/40268_300_400.jpg" id="blur" class="blur" />
            </div>
            <div class="userx">
                <img  id='user-avatar' src="{{empty(Auth::guard('wap')->user()->avatar)? '/storage/user_avatar/default.png' : Auth::guard('wap')->user()->avatar}}" />
                <i class="upload-img"></i>
                <h3><i class="@if(!empty(Auth::guard('wap')->user()->sex) && Auth::guard('wap')->user()->sex == 1)  sex-man @elseif(!empty(Auth::guard('wap')->user()->sex) && Auth::guard('wap')->user()->sex == 2) sex-woman  @endif"></i>{{empty(Auth::guard('wap')->user()->nick_name) ? '' : Auth::guard('wap')->user()->nick_name}}</h3>
            </div>
        </div>

    </div>
    <div class="aboutme bg clearfix">
        <div class="container">
            <ul>
                <li class="user"><a href="javascript:void 0" title="">修改昵称</a></li>
                <li class="sex"><a href="javascript:void 0" title="">性别选择</a></li>
                <li class="email"><a href="javascript:void 0" title="">电子邮箱</a></li>
                <li class="history"><a href="{{url((mca()['controller'] == 'Poly' ? 'poly/' : '1').'book_history')}}" title="">阅读历史</a></li>
                <li class="book"><a href="{{url((mca()['controller'] == 'Poly' ? 'poly/' : '1').'book_collect_list')}}" title="">我的书架</a></li>
                <li class="suggest"><a href="javascript:void 0" title="">意见反馈</a></li>
            </ul>
        </div>
    </div>
    <div class="loginout bg clearfix">
        <a href="javascript:void 0">退出登录</a>
    </div>
    <div class="edit-name none">
        <div style="width: 300px">
            <div class="pushtel"><input type="text" maxlength="16" class="nick_name" placeholder="请输入昵称" style="border-bottom: 1px solid #ededed;"></div>
            <div class="sendok edit-name-sure">确认</div>
        </div>
    </div>

    <div class="edit-sex none">
        <div style="width: 300px">
            <div class="pushtel" style="text-align: center">
                <input type="radio" value="1" name="sex" class="sex" style="margin:10px;display: inline!important;width:auto;border-bottom: 1px solid #ededed;">男
                <input type="radio" value="2" name="sex" class="sex" style="margin:10px;display: inline!important;width:auto;border-bottom: 1px solid #ededed;">女
                <input type="radio" value="3" name="sex" class="sex" style="margin:10px;display: inline!important;width:auto;border-bottom: 1px solid #ededed;">保密
            </div>
            <div class="sendok edit-sex-sure">确认</div>
        </div>
    </div>

    <div class="edit-email none">
        <div style="width: 350px">
            <div class="pushtel">
                <input type="email" maxlength="32" class="email" placeholder="请输入邮箱" style="border-bottom: 1px solid #ededed;">
                <input type="text" maxlength="6" class="email_code" placeholder="请输入邮箱验证码" style="border-bottom: 1px solid #ededed;width: 50%;float: left">
                <div class="sendok send-email-code" style="float: left;width: 35%;margin: 7px;padding: 3px;">发送</div>
            </div>
            <div class="sendok edit-email-sure">更改邮箱</div>
        </div>
    </div>

    <div class="edit-suggest none">
        <div style="width: 300px">
            <div class="pushtel"><textarea name="" placeholder="在此反馈意见内容" id="" rows="8"  style="border: 1px solid #ededed;width: 100%;overflow: auto;word-break: break-all;"></textarea></div>
            <div class="sendok edit-suggest-sure">确认</div>
        </div>
    </div>
</div>

<input type="file" id="file" style="opacity: 0;position: fixed;"/>
<div class="clip_box" id="clip_box">
    <div class="loading_center" id="loading_center"><img src="/wap/img/loader.png"/></div>
    <div id="clip_main" style="width:100%;height:100%;display: none">
        <h4 style="color:#4eaf7a;">双指旋转和双指缩放</h4>
        <div id="clipArea"></div>
        <div style="text-align: center">
            <button id="clip_btn">裁剪保存</button>
            <button id="btn_close" onclick="hideClipBox()">关闭</button>
        </div>
        <input type="file" id="file" style="opacity: 0;position: fixed;"/>
    </div>
</div>

</body>
</html>
<script type="text/javascript" src="/web/lib/layer/mobile/layer.js"></script>

<script src="/wap/js/upload_avatar/hammer.js"></script>
<script src="/wap/js/upload_avatar/iscroll-zoom.js"></script>
<script src="/wap/js/upload_avatar/jquery.photoClip.js"></script>
<script>
    $(function() {
        $('.upload-img').click(function() {
            //图片上传按钮
            $('#file').click();
        });

    });

    $("#clipArea").photoClip({
        width: 160, //裁剪宽度
        height: 160, //裁剪高度
        file: "#file",
        view: "#hit",
        ok: "#clip_btn",
        loadStart: function() {
            $("#clip_box,#loading_center").show();
            $("#clip_main").hide();
        },
        loadComplete: function() {
            $("#clip_main").show();
            $('#loading_center').hide();
        },
        clipFinish: function(dataURL) {
            $("#clip_box").hide();
            $('#user-avatar').attr('src', dataURL);
            saveImageInfo();
            $("#clipArea img").remove();
        }
    });
    //图片上传结束
    $(function() {
        $('.upload_btn').click(function() {
            var upload_btn_id = $(this).attr("id");
            //图片上传按钮
            $('#file').click().attr("upload_btn_id", upload_btn_id);
        });

    });

    //图片上传
    function saveImageInfo() {
        var upload_pic = $("#user-avatar").attr("src");

        $.ajax({
            url:"{{url('upload_avatar')}}",
            type:"POST",
            data:{img_data:upload_pic},
            success: function(data){
                layer.open({
                    content: data.msg
                    ,skin: 'msg'
                    ,time:1
                });

//                window.setTimeout("window.location.reload()",1000);
            }
        });
    }

    // 获取blob对象的兼容性写法
    function getBlob(buffer, format) {
        var Builder = window.WebKitBlobBuilder || window.MozBlobBuilder;
        if (Builder) {
            var builder = new Builder;
            builder.append(buffer);
            return builder.getBlob(format);
        } else {
            return new window.Blob([buffer], {type: format});
        }
    }


    // 渲染 Image 缩放尺寸
    function render(src, image) {
        var MAX_HEIGHT = 256;  //Image 缩放尺寸
        // 创建一个 Image 对象
        var image = new Image();

        // 绑定 load 事件处理器，加载完成后执行
        image.onload = function() {
            // 获取 canvas DOM 对象
            var canvas = document.createElement("canvas");
            // 如果高度超标
            if (image.height > MAX_HEIGHT) {
                // 宽度等比例缩放 *=
                image.width *= MAX_HEIGHT / image.height;
                image.height = MAX_HEIGHT;
            }
            // 获取 canvas的 2d 环境对象,
            // 可以理解Context是管理员，canvas是房子
            var ctx = canvas.getContext("2d");
            // canvas清屏
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            canvas.width = image.width;        // 重置canvas宽高
            canvas.height = image.height;
            // 将图像绘制到canvas上
            ctx.drawImage(image, 0, 0, image.width, image.height);
            // !!! 注意，image 没有加入到 dom之中

            var dataurl = canvas.toDataURL("image/jpeg");

        }
        // 设置src属性，浏览器会自动加载。
        // 记住必须先绑定render()事件，才能设置src属性，否则会出同步问题。
        image.src = src;
    }
    function hideClipBox() {
        $("#clip_box").hide();
    }
    function saveForm() {
        var upload_btn_pic = $("#upload_btn_pic").attr("src");
        var upload_btn2_pic = $("#upload_btn2_pic").attr("src");

        $.post("{{url('upload_avatar')}}", {upload_btn_pic: upload_btn_pic, upload_btn2_pic: upload_btn2_pic}, function(data) {
            alert("本地保存的图片：" + data.upload_btn_pic + "|" + data.upload_btn2_pic)
        }, "json")
    }







    var logoutUrl = "{{url('logout')}}";
    var userSaveUrl = "{{url('user_save')}}";
    var suggestUrl = "{{url('suggest')}}";
    var sendEmailUrl = "{{url('send_email')}}";

    $('.loginout').click(function(){
        $.ajax({
            url:logoutUrl,
            type:"POST",
            success: function(data){
                layer.open({
                    content: data.msg
                    ,skin: 'msg'
                    ,time:2
                });

                window.setTimeout("window.location.href='/'",1000);
            }
        });
    });

    $('.aboutme .user').click(function(){
        layer.open({
            type: 1
            ,content: $('.edit-name').html()
            ,anim: 'up'
            ,area: ['300px', '600px']
        });
    });

    $('.aboutme .sex').click(function(){
        layer.open({
            type: 1
            ,content: $('.edit-sex').html()
            ,anim: 'up'
            ,area: ['300px', '600px']
        });
    });

    $('.aboutme .email').click(function(){
        layer.open({
            type: 1
            ,content: $('.edit-email').html()
            ,anim: 'up'
            ,area: ['300px', '600px']
        });
    });

    $('.aboutme .suggest').click(function(){
        layer.open({
            type: 1
            ,content: $('.edit-suggest').html()
            ,anim: 'up'
            ,area: ['300px', '600px']
        });
    });

    $(document).on('click', '.edit-name-sure', function()
    {
        var nick_name = $(this).parent().find('input').val();

        if(!nick_name) {
            layer.open({
                content: '请输入昵称'
                ,skin: 'msg'
                ,time: 1 //2秒后自动关闭
            });

            return false;
        }

        $.ajax({
            url:userSaveUrl,
            type:"POST",
            data:{nick_name:nick_name},
            success: function(data){
                if(data.status === 3)
                {
                    layer.closeAll();

                    layer.open({
                        content: data.msg
                        ,skin: 'msg'
                        ,time:1
                    });

                    window.setTimeout("window.location.reload()",1000);
                }else{
                    layer.open({
                        content: data.msg
                        ,skin: 'msg'
                        ,time:1
                    });
                }
            }
        });
    });

    $(document).on('click', '.edit-sex-sure', function()
    {
        var sex = $(this).parent().find('input[name="sex"]:checked').val();

        if(!sex) {
            layer.open({
                content: '请选择性别'
                ,skin: 'msg'
                ,time: 1 //2秒后自动关闭
            });

            return false;
        }

        $.ajax({
            url:userSaveUrl,
            type:"POST",
            data:{sex:sex},
            success: function(data){
                if(data.status === 3)
                {
                    layer.closeAll();

                    layer.open({
                        content: data.msg
                        ,skin: 'msg'
                        ,time:1
                    });

                    window.setTimeout("window.location.reload()",1000);
                }else{
                    layer.open({
                        content: data.msg
                        ,skin: 'msg'
                        ,time:1
                    });
                }
            }
        });
    });

    $(document).on('click', '.edit-email-sure', function()
    {
        var email = $(this).parent().find('.email').val();
        var email_code = $(this).parent().find('.email_code').val();

        if(!email) {
            layer.open({
                content: '请输入邮箱'
                ,skin: 'msg'
                ,time: 1 //2秒后自动关闭
            });

            return false;
        }

        if(!email_code) {
            layer.open({
                content: '请输入邮箱验证码'
                ,skin: 'msg'
                ,time: 1 //2秒后自动关闭
            });

            return false;
        }

        $.ajax({
            url:userSaveUrl,
            type:"POST",
            data:{
                email_code:email_code,
                email:email
            },
            success: function(data){
                if(data.status === 3)
                {
                    layer.closeAll();

                    layer.open({
                        content: data.msg
                        ,skin: 'msg'
                        ,time:1
                    });

                    window.setTimeout("window.location.reload()",1000);
                }else{
                    layer.open({
                        content: data.msg
                        ,skin: 'msg'
                        ,time:1
                    });
                }
            }
        });
    });


    var mailBoolean = true;
    var mailTimer=null; //手机计时器
    var mailStart=60;
    $(document).on('click', '.send-email-code', function()
    {
        var email = $(this).parent().find('.email').val();

        var that = $(this);

        if(!email) {
            layer.open({
                content: '请输入邮箱'
                ,skin: 'msg'
                ,time: 1 //2秒后自动关闭
            });

            return false;
        }

        var mailTest=(/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(email));

        if(mailTest){  //正则验证邮箱号
            if(mailBoolean){
                $.ajax({
                    type:"POST",
                    url:sendEmailUrl,
                    data:{email:email},
                    success:function(data){
                        layer.open({
                            content: data.msg
                            ,skin: 'msg'
                            ,time: 1 //2秒后自动关闭
                        });
                    }
                });

                mailTimer=setInterval(function(){
                    mailStart--;
                    that.html( mailStart+"秒后重新获取");
                    if( mailStart <= 0){
                        mailStart = 60;
                        mailBoolean = true;
                        that.html( mailStart+"秒后重新获取");
                        clearInterval(mailTimer);
                    }
                },1000);
            }
            mailBoolean = false; //阻止重复触发计时器
        }else{
            layer.open({
                content: '邮箱格式不正确'
                ,skin: 'msg'
                ,time: 1 //2秒后自动关闭
            });
        }
    });

    $(document).on('click', '.edit-suggest-sure', function()
    {
        var suggest_content = $(this).parent().find('textarea').val();
        if(!suggest_content) {
            layer.open({
                content: '请输入内容'
                ,skin: 'msg'
                ,time: 1 //2秒后自动关闭
            });

            return false;
        }

        $.ajax({
            url:suggestUrl,
            type:"POST",
            data:{content:suggest_content},
            success: function(data){
                if(data.status ===3 ){
                    layer.closeAll();

                    layer.open({
                        content: data.msg
                        ,skin: 'msg'
                        ,time:1
                    });

                    window.setTimeout("window.location.reload()",1000);

                }else{
                    layer.open({
                        content: data.msg
                        ,skin: 'msg'
                        ,time:1
                    });
                }
            }
        });
    });
</script>
@endsection