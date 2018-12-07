<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>权限管理-权限列表</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="/admin/lib/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="/admin/css/admin.css" media="all">
    <link rel="stylesheet" href="/admin/lib/font-awesome/css/font-awesome.min.css">
    <style>
        .i-style{
            float:right;
            margin-top: 5px;
        }
    </style>
</head>
<body>

<div class="layui-fluid">
    <div class="layui-card">
        <div class="layui-card-body">
            <div style="padding-bottom: 10px;">
                <button class="layui-btn layuiadmin-btn-list permission-add">添加</button>
            </div>
            <div>
                <table id="permission_table" lay-filter="permission_table"></table>
            </div>
        </div>
    </div>
</div>

<div class="none" id="permission-form">
    <div class="layui-form" id="permission-form-reset" lay-filter="permission-form" style="padding: 20px 30px 0 0;">
        <div class="layui-form-item">
            <label class="layui-form-label">权限标示</label>
            <div class="layui-input-block">
                <input type="text" name="name" lay-verify="required" placeholder="请输入权限标示" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">权限名</label>
            <div class="layui-input-block">
                <input type="text" name="display_name" lay-verify="required" placeholder="请输入权限名" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">权限描述</label>
            <div class="layui-input-block">
                <input type="text" name="description" lay-verify="required" placeholder="请输入权限描述" autocomplete="off" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">菜单icon</label>
            <div class="layui-input-block">
                <input type="text" name="menu_icon" lay-verify="required" placeholder="请输入菜单icon" autocomplete="off" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">权限状态</label>
            <div class="layui-input-block">
                <input type="radio" name="is_show" value="1" title="显示" checked>
                <input type="radio" name="is_show" value="2" title="屏蔽">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">排序</label>
            <div class="layui-input-block">
                <input type="number" name="sort" placeholder="排序" autocomplete="off" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">父级菜单</label>
            <div class="layui-input-block">
                <select name="parent" class="permission-list-select" lay-verify="required">

                </select>
            </div>
        </div>

        <input type="hidden" name="id">

        <div class="layui-form-item layui-hide">
            <input type="button" lay-submit lay-filter="permission-form-submit" id="permission-form-submit" value="确认">
            <button type="reset" id="form-reset" class="layui-btn layui-btn-primary">重置</button>
        </div>
    </div>
</div>


<script type="text/html" id="table-content-list">
    <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="edit"><i class="layui-icon  layui-icon-edit"></i>编辑</a>
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del"><i class="layui-icon layui-icon-delete"></i>删除</a>
</script>

<script src="/admin/lib/layui/layui.js"></script>
<script>
    layui.use(['jquery','table','form'], function() {
        var $ = layui.$;
        var table = layui.table;
        var form = layui.form;

        var space_str = "|——";

        var permission_table_ajax_url = '{{url("admin/auth/permission_list")}}';
        var permission_del_url        = '{{url("admin/auth/permission_del")}}';
        var ajax_permission_save_url  = '{{url("admin/auth/permission_save")}}';

        table.render({
            elem: '#permission_table'
            ,url: permission_table_ajax_url //数据接口
            ,method:'post'
            ,page: false //开启分页
            ,limit:20  //每页行数 默认10
            ,limits: [10, 20, 30]
            ,cols: [[ //表头
                {field : 'id',  title: 'ID', width: 80, fixed: 'left'}
                ,{field: 'name', title: '权限标示'}
                ,{field: 'display_name',  title: '权限名',templet: '<div>@{{ d.html }}@{{d.display_name}}</div>'}
                ,{field: 'description',  title: '权限描述'}
                ,{field: 'menu_icon',title: '菜单icon',templet: '<div>@{{ d.menu_icon }}<i class="i-style fa fa-fw @{{ d.menu_icon }}"></i></div>'}
                ,{field: 'parent', width: 80, title: '父级ID'}
                ,{field: 'is_show',width: 80,  title: '状态',templet: '<div>@{{ d.is_show == 1 ? "显示" : "屏蔽" }}</div>'}
                ,{field: 'sort', width: 80, title: '排序'}
                ,{title: "操作", align: "center", fixed: "right", toolbar: "#table-content-list"}
            ]]
        });

        // 权限添加
        $('.permission-add').on('click', function()
        {
            form.val('permission-form',{
                'id' : '',
                'name' : '',
                'display_name' : '',
                'description' : '',
                'menu_icon' : '',
                'is_show' : '1',
                'sort': ''
            });

            ajax_load_permission_list();

            layer.open({
                type: 1
                ,title: '添加权限'
                ,content: $('#permission-form')
                ,maxmin: true
                ,area: ['550px', '550px']
                ,btn: ['确定', '取消']
                ,yes: function(index, layero){
                    //点击确认触发 iframe 内容中的按钮提交
                    $("#permission-form-submit").click();
                }
                ,btn2:function(){
                    form.val('permission-form',{
                        'id' : '',
                        'name' : '',
                        'display_name' : '',
                        'description' : '',
                        'menu_icon' : '',
                        'is_show' : '1',
                        'sort': ''
                    });
                }
            });
        });

        // 编辑和删除操作
        table.on('tool(permission_table)', function(obj){
            var data = obj.data;

            if(obj.event === 'del'){
                layer.confirm('真的删除么',{title:'删除权限'}, function(index){
                    $.post(
                        permission_del_url,
                        {id:data.id},
                        function(res){
                            if(res.status == 2){
                                layer.msg(res.msg,{icon:5,shade:0.1,time:1000});
                            }else{
                               layer.msg(res.msg, {icon:6,shade:0.1,time:1000}, function(){
                                    table.reload('permission_table');
                                    layer.close(index);
                                });
                            }
                        },'json'
                    );

                });
            } else if(obj.event === 'edit'){

                ajax_load_permission_list(data);

                layer.open({
                    type: 1
                    ,title: '修改权限'
                    ,content: $('#permission-form')
                    ,maxmin: true
                    ,area: ['550px', '550px']
                    ,btn: ['确定', '取消']
                    ,yes: function(index, layero){
                        $("#permission-form-submit").click();
                    }
                });
            }
        });


        // 权限修改和添加
        form.on('submit(permission-form-submit)', function(data){

            data.field.sort = data.field.sort == '' ? 0 : data.field.sort;

            $.post(
                ajax_permission_save_url,
                data.field,
                function(res){
                    if(res.status == 2){
                        parent.layer.msg(res.msg,{icon:5,shade:0.1,time:1000});
                    }else{
                        parent.layer.msg(res.msg, {icon:6,shade:0.1,time:1000}, function(){
                            layui.table.reload('permission_table'); //重载表格
                            layer.closeAll(); //再执行关闭s
                            form.render();
                        });
                    }
                },'json'
            );
        });


        function ajax_load_permission_list(data)
        {
            $.post(
                permission_table_ajax_url,
                function(res){
                    $('.permission-list-select').html('');

                    if(! $.isEmptyObject(res.data))
                    {
                        var option_html = '<option value="">请选择父级菜单</option><option value="0">———顶级菜单———</option>';

                        $.each(res.data, function(k,v){
                            option_html += '<option value="'+v.id+'">' + repeat(space_str, v.sort_num) + v.display_name+'</option>';
                        });

                        $('.permission-list-select').html(option_html);

                        if(data !== undefined) {
                            form.val('permission-form',{
                                'id' : data.id,
                                'name' : data.name,
                                'display_name' : data.display_name,
                                'description' : data.description,
                                'menu_icon' : data.menu_icon,
                                'is_show' : data.is_show.toString(),
                                'sort': data.sort,
                                'parent':data.parent
                            });
                        }

                        form.render();
                    }
                },'json'
            );

        }


        function repeat(str , n){
            return new Array(n+1).join(str);
        }
    });
</script>
</body>
</html>
