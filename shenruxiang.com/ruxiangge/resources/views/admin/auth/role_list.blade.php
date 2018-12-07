<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>权限管理-角色列表</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="/admin/lib/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="/admin/css/admin.css" media="all">
    <style>
        .user-btn-style{
            float:right;
            margin-top: 2px;
        }

        .permission-list{
            text-align: left;
            margin-left: 3em;
        }
        .layui-form-checkbox{
            margin-right: 0px;
        }
    </style>
</head>
<body>

<div class="layui-fluid">
    <div class="layui-card">
        <div class="layui-card-body">
            <div style="padding-bottom: 10px;">
                <button class="layui-btn layuiadmin-btn-list role-add">添加</button>
            </div>
            <div>
                <table id="role_table" lay-filter="role_table"></table>
            </div>
        </div>
    </div>
</div>


<div style="display: none" id="user-form">
    <table class="layui-table">
        <colgroup>
            <col width="150">
            <col width="200">
            <col>
        </colgroup>
        <thead>
        <tr>
            <th>角色</th>
            <th>用户</th>
        </tr>
        </thead>
        <tbody class="user-list">

        </tbody>
    </table>
</div>

<div style="display: none;"  id="permission-list">
    <div class="layui-form" style="padding-top: 30px; text-align: center;">
        <div class="layui-form-item">
            <label class="layui-form-label">权限列表</label>
            <div class="layui-input-inline permission-list">

            </div>
        </div>
    </div>
</div>


<div style="display:none;" id="role-form">
    <div class="layui-form" lay-filter="role-form"  style="padding: 20px 30px 0 0;">
        <div class="layui-form-item">
            <label class="layui-form-label">角色标示</label>
            <div class="layui-input-block">
                <input type="text" name="name" lay-verify="required" placeholder="请输入角色标示" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">角色名</label>
            <div class="layui-input-block">
                <input type="text" name="display_name" lay-verify="required" placeholder="请输入角色名" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">角色描述</label>
            <div class="layui-input-block">
                <input type="text" name="description" lay-verify="required" placeholder="请输入描述" autocomplete="off" class="layui-input">
            </div>
        </div>

        <input type="hidden" name="id">

        <div class="layui-form-item layui-hide">
            <input type="button" lay-submit lay-filter="role-form-submit" id="role-form-submit" value="确认">
        </div>
    </div>
</div>


<script type="text/html" id="table-content-list">
    <a class="layui-btn layui-btn-xs" lay-event="permission"><i class="layui-icon  layui-icon-senior"></i>权限</a>
    <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="edit"><i class="layui-icon  layui-icon-edit"></i>编辑</a>
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del"><i class="layui-icon layui-icon-delete"></i>删除</a>
</script>

<script src="/admin/lib/layui/layui.js"></script>
<script>
    layui.use(['jquery','table', 'form'], function() {
        var $ = layui.$;
        var table = layui.table;
        var form = layui.form;

        var role_table_ajax_url = '{{url("admin/auth/role_list")}}';
        var role_del_url        = '{{url("admin/auth/role_del")}}';
        var ajax_role_save_url  = '{{url("admin/auth/role_save")}}';
        var ajax_role_user_list       = '{{url("admin/auth/ajax_role_user_list")}}';
        var ajax_role_permission_list = '{{url("admin/auth/ajax_role_permission_list")}}';
        var ajax_role_permission_save = '{{url("admin/auth/ajax_role_permission_save")}}';

        table.render({
            elem: '#role_table'
            ,url: role_table_ajax_url //数据接口
            ,method:'post'
            ,page: false //开启分页
            ,limit:20  //每页行数 默认10
            ,limits: [10, 20, 30]
            ,cols: [[ //表头
                {field : 'id', width:80,  title: 'ID', sort: true, fixed: 'left'}
                ,{field: 'name', title: '角色标示'}
                ,{field: 'display_name',  title: '角色名',templet: '<div>@{{d.display_name}}<a class="layui-btn layui-btn-warm layui-btn-xs user-btn-style" lay-event="user"><i class="layui-icon layui-icon-user"></i>用户</a></div>'}
                ,{field: 'description',  title: '描述'}
                ,{field: 'created_at', title: '创建时间'}
                ,{title: "操作", align: "center", fixed: "right", toolbar: "#table-content-list"}
            ]]
        });

        // 管理员添加
        $('.role-add').on('click', function()
        {
            form.val('role-form',{
                'id' : '',
                'name' : '',
                'display_name' : '',
                'description' : ''
            });

            layer.open({
                type: 1
                ,title: '添加角色'
                ,content: $('#role-form')
                ,maxmin: true
                ,area: ['550px', '550px']
                ,btn: ['确定', '取消']
                ,yes: function(index, layero){
                    //点击确认触发 iframe 内容中的按钮提交
                    $('#role-form-submit').click();
                }
                ,btn2:function(){
                    form.val('role-form',{
                        'id' : '',
                        'name' : '',
                        'display_name' : '',
                        'description' : ''
                    });
                }
            });
        });

        // 编辑和删除操作
        table.on('tool(role_table)', function(obj){
            var data = obj.data;

            if(obj.event === 'del'){
                layer.confirm('真的删除么',{title:'删除角色'}, function(index){
                    $.post(
                        role_del_url,
                        {id:data.id},
                        function(res){
                            if(res.status == 2){
                                layer.msg(res.msg,{icon:5,shade:0.1,time:1000});
                            }else{
                               layer.msg(res.msg, {icon:6,shade:0.1,time:1000}, function(){
                                    table.reload('role_table');
                                    layer.close(index);
                                });
                            }
                        },'json'
                    );

                });
            } else if(obj.event === 'edit')
            {
                form.val('role-form',{
                    'id' : data.id,
                    'name' : data.name,
                    'display_name' : data.display_name,
                    'description' : data.description
                });

                layer.open({
                    type: 1
                    ,title: '修改角色'
                    ,content: $('#role-form')
                    ,maxmin: true
                    ,area: ['550px', '550px']
                    ,btn: ['确定', '取消']
                    ,yes: function(){
                        $('#role-form-submit').click();
                    }
                });
            }else if(obj.event === 'user')
            {
                $('.user-list').html('');

                role_user_list(data.id,data.display_name);

                layer.open({
                    type: 1
                    ,title: '角色用户列表'
                    ,content: $('#user-form')
                    ,maxmin: true
                    ,area: ['550px', '550px']
                    ,btn: ['确定']
                    ,yes: function(index, layero){
                        layer.close(index);
                    }
                });
            }else if(obj.event === 'permission')
            {
                $('.permission-list').html('');

                permission_list(data.id);

                layer.open({
                    type: 1
                    ,title: '权限列表'
                    ,content: $('#permission-list')
                    ,maxmin: true
                    ,area: ['550px', '550px']
                    ,btn: ['确定', '取消']
                    ,yes: function(index, layero){
                        var permission_ids = $("input:checkbox[name='permission']:checked").map(function (index, elem) {
                            return $(elem).val();
                        }).get().join(',');

                        $.post(
                            ajax_role_permission_save,
                            {
                                role_id:data.id,
                                permission_ids:permission_ids
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

        // 角色用户列表
        function role_user_list(role_id,role_name)
        {
            $.post(
                ajax_role_user_list,
                {role_id:role_id},
                function(res){
                    if(res.status == 2){
                        layer.msg(res.msg,{icon:5,shade:0.1,time:1000});
                    }else{
                        var role_user_list_html = '';
                        if(!$.isEmptyObject(res.data))
                        {
                            $.each(res.data, function(k,v)
                            {
                                role_user_list_html += '<tr><td>'+role_name+'</td> <td>'+v.name+'</td></tr>';

                            });

                            $('.user-list').html(role_user_list_html);
                            form.render();
                        }
                    }
                },'json'
            );
        }


        function repeat(str , n){
            return new Array(n+1).join(str);
        }

        var space_str = "&emsp;&emsp;&emsp;&emsp;";

        function permission_list(role_id)
        {
            $.post(
                ajax_role_permission_list,
                {role_id:role_id},
                function(res){
                    if(res.status == 3)
                    {
                        var permission_list_html = '';
                        $.each(res.data.permissionList, function(k,v)
                        {
                            if($.inArray(v.id, res.data.rolePermission) < 0) {
                                permission_list_html += repeat(space_str, v.sort_num) + '<input type="checkbox" lay-filter="permission-checkbox" class="permission-pid-'+v.parent+'"  name="permission" value="'+v.id+'" title="'+v.display_name+'"><br>';
                            }else{
                                permission_list_html += repeat(space_str, v.sort_num) + '<input type="checkbox" lay-filter="permission-checkbox" class="permission-pid-'+v.parent+'" name="permission" value="'+v.id+'" title="'+v.display_name+'" checked><br>';
                            }
                        });

                        $('.permission-list').html(permission_list_html);
                        form.render();
                    }else{
                        layer.msg(res.msg);
                    }

                },'json'
            );
        }

        // 权限父级选中
        form.on('checkbox(permission-checkbox)', function(data)
        {
            var permission_id = data.value;

            $('.permission-pid-'+permission_id).prop('checked', data.elem.checked);
            form.render();

        });

        form.on('submit(role-form-submit)', function(data){

            $.post(
                ajax_role_save_url,
                data.field,
                function(res){
                    if(res.status == 2){
                        layer.msg(res.msg,{icon:5,shade:0.1,time:1000});
                    }else{
                        layer.msg(res.msg, {icon:6,shade:0.1,time:1000}, function(){
                            table.reload('role_table'); //重载表格
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
