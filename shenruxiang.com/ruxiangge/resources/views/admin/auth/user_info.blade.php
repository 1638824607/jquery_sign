<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>小说管理-小说列表</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="/admin/lib/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="/admin/css/admin.css" media="all">
    <style>
        .layui-upload-img{width: 92px; height: 92px; margin: 0 0px 10px 110px;}
    </style>
</head>
<body>
    <div class="layui-fluid">
        <div class="layui-row layui-col-space15">
            <div class="layui-col-md12">
                <div class="layui-card">
                    <div class="layui-card-header">设置我的资料</div>
                    <div class="layui-card-body" pad15="">

                        <div class="layui-form" lay-filter="user-save">
                            <input type="hidden"  name="id" value="{{$userRow['id']}}">
                            <div class="layui-form-item">
                                <label class="layui-form-label">用户名</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="name" value="{{$userRow['name']}}" readonly="" class="layui-input">
                                </div>
                                <div class="layui-form-mid layui-word-aux">不可修改。一般用于登陆账号</div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">邮箱</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="email" value="{{$userRow['email']}}" autocomplete="off" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">昵称</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="nick_name" value="{{$userRow['nick_name']}}" autocomplete="off" placeholder="请输入昵称" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">性别</label>
                                <div class="layui-input-block">
                                    <input type="radio" name="sex" value="1" title="男" @if($userRow['sex'] == 1) checked @endif><div class="layui-unselect layui-form-radio"><i class="layui-anim layui-icon"></i><div>男</div></div>
                                    <input type="radio" name="sex" value="2" title="女" @if($userRow['sex'] == 2) checked @endif><div class="layui-unselect layui-form-radio layui-form-radioed"><i class="layui-anim layui-icon layui-anim-scaleSpring"></i><div>女</div></div>
                                    <input type="radio" name="sex" value="3" title="保密" @if($userRow['sex'] == 3) checked @endif><div class="layui-unselect layui-form-radio layui-form-radioed"><i class="layui-anim layui-icon layui-anim-scaleSpring"></i><div>保密</div></div>
                                </div>
                            </div>
                            <div class="layui-form-item">

                                <label class="layui-form-label">头像</label>
                                <div class="layui-upload">
                                    <button type="button" class="layui-btn layui-btn-primary" id="upload-avatar"><i class="layui-icon"></i>上传图片</button>
                                    <div class="layui-upload-list">
                                        <img class="layui-upload-img" id="upload-avatar-img"  src="{{empty($userRow['avatar']) ? '/storage/avatar/default.png' : $userRow['avatar']}}" >
                                        @if(empty($userRow['avatar']))<span>当前为默认头像</span>@endif
                                        <input type="hidden" name="avatar" value="{{empty($userRow['avatar']) ? '/storage/avatar/default.png' : $userRow['avatar']}}">
                                        <p id="upload-avatar-text"></p>
                                    </div>

                                </div>
                            </div>
                            <div class="layui-form-item">
                                <div class="layui-input-block">
                                    <button class="layui-btn" lay-submit="" lay-filter="user-save">确认修改</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<script src="/admin/lib/layui/layui.js"></script>
<script>
    layui.use(['jquery','element','layer','form', 'upload'], function() {
        var $ = layui.$;
        var layer = layui.layer;
        var form = layui.form;
        var upload = layui.upload;

        var ajax_user_save_url = '{{url("admin/auth/user_save")}}';
        var ajax_user_avatar_upload_url   = '{{url("admin/auth/user_avatar_upload")}}';

        form.on('submit(user-save)', function(data)
        {
            $.post(
                ajax_user_save_url,
                data.field,
                function(res){
                    if(res.status == 2){
                        layer.msg(res.msg,{icon:5,shade:0.1,time:1000});
                    }else{
                        layer.msg(res.msg, {icon:6,shade:0.1,time:1000}, function(){
                            layer.closeAll();
                            window.location.reload();
                        });
                    }
                },'json'
            );
        });

        var uploadInst = upload.render({
            elem: '#upload-avatar'
            ,url: ajax_user_avatar_upload_url
            ,before: function(obj){
                //预读本地文件示例，不支持ie8
                obj.preview(function(index, file, result){
                    $('#upload-avatar-img').attr('src', result); //图片链接（base64）
                });
            }
            ,done: function(res){
                $("input[name='avatar']").val(res.data);

                return layer.msg(res.msg);
            }
            ,error: function(){
                var demoText = $('#upload-avatar-text');
                demoText.html('<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-mini upload-reload">重试</a>');
                demoText.find('.upload-reload').on('click', function(){
                    uploadInst.upload();
                });
            }
        });
    });
</script>