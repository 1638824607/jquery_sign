<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>小说管理-小说爬虫列表</title>
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
                <button class="layui-btn layuiadmin-btn-list reptile-add">添加</button>
            </div>
            <div>
                <table id="reptile_table" lay-filter="reptile_table"></table>
            </div>
        </div>
    </div>
</div>

<div style="display: none" id="reptile-form">
    <div class="layui-form" lay-filter="reptile-form" style="padding: 20px 30px 0 0;">

        <input type="hidden" name="id">

        <div class="layui-form-item">
            <label class="layui-form-label">命令名称</label>
            <div class="layui-input-block">
                <input type="text" name="name" lay-verify="required" placeholder="请输入命令名称" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">语言类型</label>
            <div class="layui-input-block">
                <input type="text" name="lang" lay-verify="required" placeholder="请输入语言类型" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">命令</label>
            <div class="layui-input-block">
                <textarea name="cmd" required lay-verify="required" placeholder="请输入命令" class="layui-textarea"></textarea>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">目标地址</label>
            <div class="layui-input-block">
                <input type="text" name="target_url" lay-verify="required" placeholder="请输入目标地址" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">当前地址</label>
            <div class="layui-input-block">
                <input type="text" name="now_url" lay-verify="required" placeholder="请输入爬虫地址" autocomplete="off" class="layui-input">
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
        <div class="layui-form-item">
            <label class="layui-form-label">运行状态</label>
            <div class="layui-input-block">
                <select name="cmd_status" lay-verify="required">
                    <option value="">请选择运行状态</option>
                    <option value="1">未运行</option>
                    <option value="2">运行中</option>
                </select>
            </div>
        </div>
        <div class="layui-form-item layui-hide">
            <input type="button" lay-submit lay-filter="reptile-form-submit" id="reptile-form-submit" value="确认">
        </div>
    </div>
</div>


<script type="text/html" id="table-content-list">
    <a class="layui-btn layui-btn-warm layui-btn-xs" lay-event="run"><i class="layui-icon  layui-icon-edit"></i>运行</a>
    <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="edit"><i class="layui-icon  layui-icon-edit"></i>编辑</a>
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del"><i class="layui-icon layui-icon-delete"></i>删除</a>
</script>

<script src="/admin/lib/layui/layui.js"></script>
<script>
    layui.use(['jquery','table','form'], function() {
        var $ = layui.$;
        var table = layui.table;
        var form = layui.form;

        var reptile_table_ajax_url = '{{url("admin/reptile/reptile_list")}}';
        var reptile_del_url        = '{{url("admin/reptile/reptile_del")}}';
        var reptile_save_url       = '{{url("admin/reptile/reptile_save")}}';
        var reptile_run_url        = '{{url("admin/reptile/reptile_run")}}';

        // 数据表格渲染
        table.render({
            elem: '#reptile_table'
            ,url: reptile_table_ajax_url //数据接口
            ,method:'post'
            ,page: false //开启分页
            ,limit:20  //每页行数 默认10
            ,limits: [10, 20, 30]
            ,cols: [[ //表头
                {field : 'id',  title: 'ID',width:80, sort: true, fixed: 'left'}
                ,{field: 'name', title: '命令名称'}
                ,{field: 'lang', title: '语言类型'}
                ,{field: 'cmd', title: '命令'}
                ,{field: 'target_url', title: '目标地址'}
                ,{field: 'now_url', title: '当前地址'}
                ,{field: 'status',  title: '状态',templet:'<div>@{{d.status == 1 ? "正常": "屏蔽"}}</div>'}
                ,{field: 'cmd_status',  title: '运行状态',templet:function(d){
                    if(d.cmd_status == 2) {
                        return "<div><span class='layui-bg-red'>运行中</span><i class='layui-icon layui-anim layui-anim-rotate layui-anim-loop'>&#xe63d;</i></div>"
                    }else{
                        return "<div>未运行</div>"
                    }

                }}
                ,{title: "操作", width:200, align: "center", fixed: "right", toolbar: "#table-content-list"}
            ]]
        });
//
        // 管理员添加
        $('.reptile-add').on('click', function()
        {
            form.val('reptile-form',{
                'id' : '',
                'name' : '',
                'lang' : '',
                'cmd' : '',
                'target_url' : '',
                'now_url' : '',
                'status' : '',
                'cmd_status' : ''
            });

            layer.open({
                type: 1
                ,title: '添加命令'
                ,content: $('#reptile-form')
                ,maxmin: true
                ,area: ['650px', '650px']
                ,btn: ['确定', '取消']
                ,yes: function(index, layero){
                    //点击确认触发 iframe 内容中的按钮提交
                    $('#reptile-form-submit').click();
                }
            });
        });

        // 编辑和删除操作
        table.on('tool(reptile_table)', function(obj)
        {
            var data = obj.data;

            if(obj.event === 'del')
            {
                layer.confirm('真的删除么',{title:'删除命令'}, function(index){
                    $.post(
                        reptile_del_url,
                        {id:data.id},
                        function(res){
                            if(res.status == 2){
                                layer.msg(res.msg,{icon:5,shade:0.1,time:1000});
                            }else{
                               layer.msg(res.msg, {icon:6,shade:0.1,time:1000}, function(){
                                    table.reload('reptile_table');
                                    layer.closeAll();
                                });
                            }
                        },'json'
                    );

                });
            } else if(obj.event === 'edit')
            {
                form.val('reptile-form',{
                    'id' : data.id,
                    'name' : data.name,
                    'lang' : data.lang,
                    'cmd' : data.cmd,
                    'target_url' : data.target_url,
                    'now_url' : data.now_url,
                    'status' : data.status,
                    'cmd_status' : data.cmd_status
                });

                layer.open({
                    type: 1
                    ,title: '修改命令'
                    ,content: $('#reptile-form')
                    ,maxmin: true
                    ,area: ['650px', '650px']
                    ,btn: ['确定', '取消']
                    ,yes: function(index, layero){
                        $('#reptile-form-submit').click();
                    }
                });
            }else if(obj.event === 'run')
            {
                layer.confirm('确认要运行此命令吗？',{title:'运行命令'}, function(index){
                    $.post(
                        reptile_run_url,
                        {id:data.id},
                        function(res){
                            if(res.status == 2){
                                layer.msg(res.msg,{icon:5,shade:0.1,time:1000});
                            }else{
                                layer.msg(res.msg, {icon:6,shade:0.1,time:1000}, function(){
                                    table.reload('reptile_table');
                                    layer.closeAll();
                                });
                            }
                        },'json'
                    );

                });
            }
        });

        form.on('submit(reptile-form-submit)', function(data){

            $.post(
                reptile_save_url,
                data.field,
                function(res){
                    if(res.status == 2){
                        layer.msg(res.msg,{icon:5,shade:0.1,time:1000});
                    }else{
                        layer.msg(res.msg, {icon:6,shade:0.1,time:1000}, function(){
                            table.reload('reptile_table'); //重载表格
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
