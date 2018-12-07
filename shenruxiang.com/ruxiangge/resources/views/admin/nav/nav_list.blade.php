<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>小说管理-小说导航列表</title>
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
                <button class="layui-btn layuiadmin-btn-list nav-add">添加</button>
            </div>
            <div>
                <table id="nav_table" lay-filter="nav_table"></table>
            </div>
        </div>
    </div>
</div>

<div style="display: none" id="nav-form">
    <div class="layui-form" lay-filter="nav-form" style="padding: 20px 30px 0 0;">

        <input type="hidden" name="id">

        <div class="layui-form-item">
            <label class="layui-form-label">导航名称</label>
            <div class="layui-input-block">
                <input type="text" name="name" lay-verify="required" placeholder="请输入导航名称" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">导航url</label>
            <div class="layui-input-block">
                <input type="text" name="url" lay-verify="required" placeholder="请输入导航url" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">排序</label>
            <div class="layui-input-block">
                <input type="number" name="sort"  placeholder="请输入排序" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">状态</label>
            <div class="layui-input-block">
                <select name="status" lay-verify="required">
                    <option value="">请选择状态</option>
                    <option value="1">正常</option>
                    <option value="2">屏蔽</option>
                </select>
            </div>
        </div>

        <div class="layui-form-item layui-hide">
            <input type="button" lay-submit lay-filter="nav-form-submit" id="nav-form-submit" value="确认">
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

        var nav_table_ajax_url = '{{url("admin/index/nav_list")}}';
        var nav_del_url        = '{{url("admin/index/nav_del")}}';
        var nav_save_url       = '{{url("admin/index/nav_save")}}';

        // 数据表格渲染
        table.render({
            elem: '#nav_table'
            ,url: nav_table_ajax_url //数据接口
            ,method:'post'
//            ,height: 'full-100'
            ,page: false //开启分页
            ,limit:20  //每页行数 默认10
            ,limits: [10, 20, 30]
            ,cols: [[ //表头
                {field : 'id',  title: 'ID',width:80, sort: true, fixed: 'left'}
                ,{field: 'name', title: '导航名称'}
                ,{field: 'url', title: '导航url'}
                ,{field: 'sort', title: '排序'}
                ,{field: 'status',  title: '状态',templet:'<div>@{{d.status == 1 ? "正常": "屏蔽"}}</div>'}
                ,{field: 'created_at',  title: '创建时间'}
                ,{field: 'updated_at',  title: '更新时间'}
                ,{title: "操作", align: "center", fixed: "right", toolbar: "#table-content-list"}
            ]]
        });

        // 管理员添加
        $('.nav-add').on('click', function()
        {
            form.val('nav-form',{
                'id' : '',
                'name' : '',
                'url' : '',
                'sort' : '',
                'status' : ''
            });

            layer.open({
                type: 1
                ,title: '添加导航'
                ,content: $('#nav-form')
                ,maxmin: true
                ,area: ['550px', '550px']
                ,btn: ['确定', '取消']
                ,yes: function(index, layero){
                    //点击确认触发 iframe 内容中的按钮提交
                    $('#nav-form-submit').click();
                }
            });
        });

        // 编辑和删除操作
        table.on('tool(nav_table)', function(obj)
        {
            var data = obj.data;

            if(obj.event === 'del')
            {
                layer.confirm('真的删除么',{title:'删除导航'}, function(index){
                    $.post(
                        nav_del_url,
                        {id:data.id},
                        function(res){
                            if(res.status == 2){
                                layer.msg(res.msg,{icon:5,shade:0.1,time:1000});
                            }else{
                               layer.msg(res.msg, {icon:6,shade:0.1,time:1000}, function(){
                                    table.reload('nav_table');
                                    layer.closeAll();
                                });
                            }
                        },'json'
                    );

                });
            } else if(obj.event === 'edit')
            {
                form.val('nav-form',{
                    'id' : data.id,
                    'name' : data.name,
                    'url' : data.url,
                    'sort' : data.sort,
                    'status' : data.status
                });

                layer.open({
                    type: 1
                    ,title: '修改导航'
                    ,content: $('#nav-form')
                    ,maxmin: true
                    ,area: ['550px', '550px']
                    ,btn: ['确定', '取消']
                    ,yes: function(index, layero){
                        $('#nav-form-submit').click();
                    }
                });
            }
        });

        form.on('submit(nav-form-submit)', function(data){
            data.field.sort = data.field.sort == '' ? 0 : data.field.sort;
            $.post(
                nav_save_url,
                data.field,
                function(res){
                    if(res.status == 2){
                        layer.msg(res.msg,{icon:5,shade:0.1,time:1000});
                    }else{
                        layer.msg(res.msg, {icon:6,shade:0.1,time:1000}, function(){
                            table.reload('nav_table'); //重载表格
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
