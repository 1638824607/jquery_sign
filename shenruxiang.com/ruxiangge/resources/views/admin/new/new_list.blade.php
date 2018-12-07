<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>小说管理-小说资讯列表</title>
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
                <button class="layui-btn layuiadmin-btn-list new-add">添加</button>
            </div>
            <div>
                <table id="new_table" lay-filter="new_table"></table>
            </div>
        </div>
    </div>
</div>

<div style="display: none" id="new-form">
    <div class="layui-form" lay-filter="new-form" style="padding: 20px 30px 0 0;">

        <input type="hidden" name="id">

        <div class="layui-form-item">
            <label class="layui-form-label">资讯标题</label>
            <div class="layui-input-block">
                <input type="text" name="name" lay-verify="required" placeholder="请输入资讯标题" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">资讯地址</label>
            <div class="layui-input-block">
                <input type="text" name="url" lay-verify="required" placeholder="请输入资讯地址" autocomplete="off" class="layui-input">
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
            <input type="button" lay-submit lay-filter="new-form-submit" id="new-form-submit" value="确认">
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

        var new_table_ajax_url = '{{url("admin/index/new_list")}}';
        var new_del_url        = '{{url("admin/index/new_del")}}';
        var new_save_url       = '{{url("admin/index/new_save")}}';

        // 数据表格渲染
        table.render({
            elem: '#new_table'
            ,url: new_table_ajax_url //数据接口
            ,method:'post'
//            ,height: 'full-100'
            ,page: false //开启分页
            ,limit:20  //每页行数 默认10
            ,limits: [10, 20, 30]
            ,cols: [[ //表头
                {field : 'id',  title: 'ID',width:80, sort: true, fixed: 'left'}
                ,{field: 'name', title: '资讯标题'}
                ,{field: 'url', title: '资讯地址'}
                ,{field: 'sort', title: '排序'}
                ,{field: 'status',  title: '状态',templet:'<div>@{{d.status == 1 ? "正常": "屏蔽"}}</div>'}
                ,{field: 'created_at',  title: '创建时间'}
                ,{field: 'updated_at',  title: '更新时间'}
                ,{title: "操作", align: "center", fixed: "right", toolbar: "#table-content-list"}
            ]]
        });

        // 管理员添加
        $('.new-add').on('click', function()
        {
            form.val('new-form',{
                'id' : '',
                'name' : '',
                'url' : '',
                'sort' : '',
                'status' : ''
            });

            layer.open({
                type: 1
                ,title: '添加资讯'
                ,content: $('#new-form')
                ,maxmin: true
                ,area: ['550px', '550px']
                ,btn: ['确定', '取消']
                ,yes: function(index, layero){
                    //点击确认触发 iframe 内容中的按钮提交
                    $('#new-form-submit').click();
                }
            });
        });

        // 编辑和删除操作
        table.on('tool(new_table)', function(obj)
        {
            var data = obj.data;

            if(obj.event === 'del')
            {
                layer.confirm('真的删除么',{title:'删除资讯'}, function(index){
                    $.post(
                        new_del_url,
                        {id:data.id},
                        function(res){
                            if(res.status == 2){
                                layer.msg(res.msg,{icon:5,shade:0.1,time:1000});
                            }else{
                               layer.msg(res.msg, {icon:6,shade:0.1,time:1000}, function(){
                                    table.reload('new_table');
                                    layer.closeAll();
                                });
                            }
                        },'json'
                    );

                });
            } else if(obj.event === 'edit')
            {
                form.val('new-form',{
                    'id' : data.id,
                    'name' : data.name,
                    'url' : data.url,
                    'sort' : data.sort,
                    'status' : data.status
                });

                layer.open({
                    type: 1
                    ,title: '修改资讯'
                    ,content: $('#new-form')
                    ,maxmin: true
                    ,area: ['550px', '550px']
                    ,btn: ['确定', '取消']
                    ,yes: function(index, layero){
                        $('#new-form-submit').click();
                    }
                });
            }
        });

        form.on('submit(new-form-submit)', function(data){
            data.field.sort = data.field.sort == '' ? 0 : data.field.sort;
            $.post(
                new_save_url,
                data.field,
                function(res){
                    if(res.status == 2){
                        layer.msg(res.msg,{icon:5,shade:0.1,time:1000});
                    }else{
                        layer.msg(res.msg, {icon:6,shade:0.1,time:1000}, function(){
                            table.reload('new_table'); //重载表格
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
