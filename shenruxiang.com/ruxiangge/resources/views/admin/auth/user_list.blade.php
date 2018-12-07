<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>权限管理-用户列表</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="/admin/lib/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="/admin/css/admin.css" media="all">
</head>
<body>

<div class="layui-fluid">
    <div class="layui-card">
        <div class="layui-card-body">
            <div style="padding-bottom: 10px;">
                <button class="layui-btn layuiadmin-btn-list user-add">添加</button>
            </div>
            <div>
                <table id="user_table" lay-filter="user_table"></table>
            </div>
        </div>
    </div>
</div>

<div style="display: none" id="set-form">
    <div class="layui-form"  lay-filter="layuiadmin-form-tags" id="layuiadmin-app-form-tags" style="padding-top: 30px; text-align: center;">
        <div class="layui-form-item">
            <label class="layui-form-label">角色列表</label>
            <div class="layui-input-inline role-list">

            </div>
        </div>
    </div>
</div>

<div style="display: none" id="user-form">
    <div class="layui-form" lay-filter="user-form" style="padding: 20px 30px 0 0;">
        <div class="layui-form-item">
            <label class="layui-form-label">用户名</label>
            <div class="layui-input-block">
                <input type="text" name="name" lay-verify="required" placeholder="请输入用户名" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">邮箱</label>
            <div class="layui-input-block">
                <input type="text" name="email" lay-verify="required" placeholder="请输入邮箱" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">昵称</label>
            <div class="layui-input-block">
                <input type="text" name="nick_name" lay-verify="required" placeholder="请输入昵称" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item layui-form-item-password layui-hide">
            <label class="layui-form-label">密码</label>
            <div class="layui-input-block layui-input-password">
                <input type="password" name="password" maxlength="12" lay-verify="required" placeholder="请输入密码" autocomplete="off" class="layui-input layui-input-password">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">性别</label>
            <div class="layui-input-block">
                <input type="radio" name="sex" value="1" title="男">
                <input type="radio" name="sex" value="2" title="女">
                <input type="radio" name="sex" value="3" title="保密">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">状态</label>
            <div class="layui-input-block">
                <input type="radio" name="status" value="1" title="正常">
                <input type="radio" name="status" value="2" title="屏蔽">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">用户类型</label>
            <div class="layui-input-block">
                <select name="type" lay-verify="required">
                    <option value="">请选择用户类型</option>
                    <option value="1">注册用户</option>
                    <option value="2">管理员</option>
                </select>
            </div>
        </div>

        <input type="hidden" name="id">

        <div class="layui-form-item layui-hide">
            <input type="button" lay-submit lay-filter="user-form-submit" id="user-form-submit" value="确认">
        </div>
    </div>
</div>


<script type="text/html" id="table-content-list">
    <a class="layui-btn layui-btn-xs" lay-event="set"><i class="layui-icon  layui-icon-username"></i>角色</a>
    <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="edit"><i class="layui-icon  layui-icon-edit"></i>编辑</a>
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del"><i class="layui-icon layui-icon-delete"></i>删除</a>
</script>

<script src="/admin/lib/layui/layui.js"></script>
<script>
    layui.use(['jquery','table','form'], function() {
        var $ = layui.$;
        var table = layui.table;
        var form = layui.form;

        var user_table_ajax_url = '{{url("admin/auth/user_list")}}';
        var user_del_url        = '{{url("admin/auth/user_del")}}';
        var ajax_user_save_url  = '{{url("admin/auth/user_save")}}';
        var ajax_user_role_list      = '{{url("admin/auth/ajax_user_role_list")}}';
        var ajax_user_role_save      = '{{url("admin/auth/ajax_user_role_save")}}';


        // 数据表格渲染
        table.render({
            elem: '#user_table'
            ,url: user_table_ajax_url //数据接口
            ,method:'post'
//            ,height: 'full-100'
            ,page: false //开启分页
            ,limit:20  //每页行数 默认10
            ,limits: [10, 20, 30]
            ,cols: [[ //表头
                {field : 'id',  title: 'ID',width:80, sort: true, fixed: 'left'}
                ,{field: 'name', title: '账号'}
                ,{field: 'email',  title: '邮箱'}
                ,{field: 'nick_name', title: '昵称'}
                ,{field: 'sex',  title: '性别',templet:'<div>@{{#if(d.sex == 1){}}男@{{# } else if(d.sex == 2) { }}女@{{#} else{}}保密@{{# } }}</div>'}
                ,{field: 'avatar',  title: '头像',templet:'<div><img style="height:100%" src="@{{d.avatar}}" alt=""></div>'}
                ,{field: 'duration',  title: '在线时长'}
                ,{field: 'read_num',  title: '阅读量'}
                ,{field: 'day_num',  title: '活跃天数'}
                ,{field: 'status',  title: '状态',templet:'<div>@{{d.status == 1 ? "正常" : "屏蔽"}}</div>'}
                ,{field: 'type',  title: '类型', templet:'<div>@{{d.type == 1 ? "注册用户" : "管理员"}}</div>'}
                ,{field: 'created_at', title: '创建时间'}
                ,{field: 'updated_at', title: '更新时间'}
                ,{title: "操作",width:200, align: "center", fixed: "right", toolbar: "#table-content-list"}
            ]]
        });

        // 管理员添加
        $('.user-add').on('click', function()
        {
            $('.layui-form-item-password').removeClass('layui-hide');

            form.val('user-form',{
                'id' : '',
                'name' : '',
                'nick_name':'',
                'sex':'',
                'avatar':'',
                'status':'',
                'type':'',
                'email' : '',
                'password' : ''
            });

            layer.open({
                type: 1
                ,title: '添加用户'
                ,content: $('#user-form')
                ,maxmin: true
                ,area: ['550px', '550px']
                ,btn: ['确定', '取消']
                ,yes: function(index, layero){
                    //点击确认触发 iframe 内容中的按钮提交
                    $('#user-form-submit').click();
                }
                ,btn2:function(){
                    form.val('user-form',{
                        'id' : '',
                        'name' : '',
                        'nick_name':'',
                        'sex':'',
                        'avatar':'',
                        'status':'',
                        'type':'',
                        'email' : '',
                        'password' : ''
                    });
                }
            });
        });

        //  初始化用户角色列表
        function init_role(user_id)
        {
            $.post(
                ajax_user_role_list,
                {user_id:user_id},
                function(res){
                    if(res.status == 3)
                    {
                        var role_list_html = '';
                        $.each(res.data.roleList, function(k,v)
                        {
                            if($.inArray(v.id, res.data.userRole) < 0) {
                                role_list_html += '<input type="checkbox" name="role" value="'+v.id+'" title="'+v.display_name+'"><br>';
                            }else{
                                role_list_html += '<input type="checkbox" name="role" value="'+v.id+'" title="'+v.display_name+'" checked><br>';
                            }
                        });

                        $('.role-list').html(role_list_html);
                        form.render();
                    }else{
                        layer.msg(res.msg);
                    }

                },'json'
            );
        }

        // 编辑和删除操作
        table.on('tool(user_table)', function(obj)
        {
            var data = obj.data;

            if(obj.event === 'del')
            {
                layer.confirm('真的删除么',{title:'删除用户'}, function(index){
                    $.post(
                        user_del_url,
                        {id:data.id},
                        function(res){
                            if(res.status == 2){
                                layer.msg(res.msg,{icon:5,shade:0.1,time:1000});
                            }else{
                               layer.msg(res.msg, {icon:6,shade:0.1,time:1000}, function(){
                                    table.reload('user_table');
                                    layer.close(index);
                                });
                            }
                        },'json'
                    );

                });
            } else if(obj.event === 'edit')
            {
                form.val('user-form',{
                    'id' : data.id,
                    'name' : data.name,
                    'nick_name' : data.nick_name,
                    'email' : data.email,
                    'sex':data.sex.toString(),
                    'avatar':data.avatar,
                    'status':data.status.toString(),
                    'type':data.type
                });

                $('.layui-form-item-password').addClass('layui-hide');

                $('.layui-input-password').attr('lay-verify', '');

                layer.open({
                    type: 1
                    ,title: '修改用户'
                    ,content: $('#user-form')
                    ,maxmin: true
                    ,area: ['550px', '550px']
                    ,btn: ['确定', '取消']
                    ,yes: function(index, layero){
                        $('#user-form-submit').click();
                    }
                });
            }else if(obj.event === 'set')
            {
                var user_id = data.id;

                init_role(user_id);

                layer.open({
                    type: 1
                    ,title: '修改角色'
                    ,content: $('#set-form')
                    ,maxmin: true
                    ,area: ['550px', '550px']
                    ,btn: ['确定', '取消']
                    ,yes: function(index, layero){
                        //点击确认触发 iframe 内容中的按钮提交
                        var role_ids = $("input:checkbox[name='role']:checked").map(function (index, elem) {
                            return $(elem).val();
                        }).get().join(',');

                        $.post(
                            ajax_user_role_save,
                            {
                                user_id:user_id,
                                role_ids:role_ids
                            },
                            function(res){
                                layer.msg(res.msg, {icon:6,shade:0.1,time:1000}, function(){
                                    layer.close(index);
                                });
                            },'json'
                        );

                    }
                });
            }
        });

        form.on('submit(user-form-submit)', function(data){

            $.post(
                ajax_user_save_url,
                data.field,
                function(res){
                    if(res.status == 2){
                        layer.msg(res.msg,{icon:5,shade:0.1,time:1000});
                    }else{
                        layer.msg(res.msg, {icon:6,shade:0.1,time:1000}, function(){
                            table.reload('user_table'); //重载表格
                            layer.closeAll();
                        });
                    }
                },'json'
            );
        });
    });
</script>
</body>
</html>
