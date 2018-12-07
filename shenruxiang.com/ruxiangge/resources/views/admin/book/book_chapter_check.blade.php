<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>小说管理-章节修正</title>
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
                <button class="layui-btn layuiadmin-btn-list book_chapter_sort_create">小说章节排序初始化</button>
                <button class="layui-btn layuiadmin-btn-list book_chapter_sort_recreate">小说章节排序再生成</button>
                <button class="layui-btn layuiadmin-btn-list chapter_name_recreate">小说章节名称格式化</button>
                <button class="layui-btn layuiadmin-btn-list chapter_order_recreate">小说章节排序格式化</button>
                <button class="layui-btn layuiadmin-btn-list">小说章节名:{{$bookRow['name']}}</button>
                {{--<label class="layui-btn layuiadmin-btn-list layui-form-label">密码框</label>--}}
            </div>
            <div>
                <table id="chapter_check_table" lay-filter="chapter_check_table"></table>
            </div>
        </div>
    </div>
</div>

<script src="/admin/lib/layui/layui.js"></script>
<script>
    layui.use(['jquery','table', 'form'], function() {
        var $ = layui.$;
        var table = layui.table;
        var form = layui.form;

        var book_id = "{{$bookRow['id']}}";
        var chapter_check_table_ajax_url = '{{url("admin/book/book_chapter_check")}}';
        var book_chapter_sort_create_ajax_url = '{{url("admin/book/book_chapter_sort_create")}}';
        var book_chapter_sort_recreate_ajax_url = '{{url("admin/book/book_chapter_sort_recreate")}}';
        var book_chapter_edit_ajax_url = '{{url("admin/book/book_chapter_edit")}}';
        var chapter_name_recreate_ajax_url = '{{url("admin/book/chapter_name_recreate")}}';
        var chapter_order_recreate_ajax_url = '{{url("admin/book/chapter_order_recreate")}}';

        var start_load = layer.msg('加载中', {
            icon: 16
            ,shade: 0.01
        });

        table.render({
            elem: '#chapter_check_table'
            ,url: chapter_check_table_ajax_url //数据接口
            ,method:'post'
            ,where:{book_id:book_id}
            ,page: false //开启分页
            ,cols: [[ //表头
                {field : 'id', width:80,  title: 'ID', sort: true, fixed: 'left'}
                ,{field: 'name', title: '章节名称',edit: 'text'}
                ,{field: 'sort', title: '章节排序',edit: 'text'}
            ]]
            ,done: function(res, curr, count){
                layer.close(start_load);
            }
        });

        table.on('edit(chapter_check_table)', function(obj){
            var value = obj.value //得到修改后的值
                ,data = obj.data //得到所在行所有键值
                ,field = obj.field; //得到字段

            $.post(
                book_chapter_edit_ajax_url,
                {
                    field:field,
                    value:value,
                    id:data.id
                },
                function(res){
                    if(res.status == 2){
                        layer.msg(res.msg,{icon:5,time:500});
                    }else{
                        layer.msg(res.msg, {icon:6,time:500}, function(){
//                            table.reload('chapter_check_table');
                            layer.closeAll();
                        });
                    }
                },'json'
            );
        });

        $('.book_chapter_sort_create').click(function()
        {
            layer.confirm('确认要重新生成章节排序么？', {
                btn: ['确认','取消'], //按钮
                title:'生成小说章节排序'
            }, function(){
                layer.closeAll();

                layer.msg('加载中', {
                    icon: 16
                    ,shade: 0.01
                    ,time: 20000
                });

                $.post(
                    book_chapter_sort_create_ajax_url,
                    {book_id:book_id},
                    function(res){
                        if(res.status == 2){
                            layer.msg(res.msg,{icon:5,shade:0.1,time:1000});
                        }else{
                            layer.msg(res.msg, {icon:6,shade:0.1,time:1000}, function(){
                                table.reload('chapter_check_table');
                            });
                        }

                        layer.closeAll();
                    },'json'
                );
            });
        });

        $('.book_chapter_sort_recreate').click(function()
        {
            layer.confirm('确认要重新再生成章节排序么？', {
                btn: ['确认','取消'], //按钮
                title:'生成小说章节排序'
            }, function(){
                layer.closeAll();

                layer.msg('加载中', {
                    icon: 16
                    ,shade: 0.01
                    ,time: 20000
                });

                $.post(
                    book_chapter_sort_recreate_ajax_url,
                    {book_id:book_id},
                    function(res){
                        if(res.status == 2){
                            layer.msg(res.msg,{icon:5,shade:0.1,time:1000});
                        }else{
                            layer.msg(res.msg, {icon:6,shade:0.1,time:1000}, function(){
                                table.reload('chapter_check_table');
                            });
                        }

                        layer.closeAll();
                    },'json'
                );
            });
        });

        $('.chapter_name_recreate').click(function()
        {
            layer.confirm('确认要格式化章节名称么？', {
                btn: ['确认','取消'], //按钮
                title:'格式化章节名称'
            }, function(){
                layer.closeAll();

                layer.msg('加载中', {
                    icon: 16
                    ,shade: 0.01
                    ,time: 20000
                });

                $.post(
                    chapter_name_recreate_ajax_url,
                    {book_id:book_id},
                    function(res){
                        if(res.status == 2){
                            layer.msg(res.msg,{icon:5,shade:0.1,time:1000});
                        }else{
                            layer.msg(res.msg, {icon:6,shade:0.1,time:1000}, function(){
                                table.reload('chapter_check_table');
                            });
                        }
                        layer.closeAll();
                    },'json'
                );
            });
        });

        $('.chapter_order_recreate').click(function()
        {
            layer.confirm('确认要格式化章节排序么？', {
                btn: ['确认','取消'], //按钮
                title:'格式化章节排序'
            }, function(){
                layer.closeAll();

                layer.msg('加载中', {
                    icon: 16
                    ,shade: 0.01
                    ,time: 20000
                });

                $.post(
                    chapter_order_recreate_ajax_url,
                    {book_id:book_id},
                    function(res){
                        if(res.status == 2){
                            layer.msg(res.msg,{icon:5,shade:0.1,time:1000});
                        }else{
                            layer.msg(res.msg, {icon:6,shade:0.1,time:1000}, function(){
                                table.reload('chapter_check_table');
                            });
                        }
                        layer.closeAll();
                    },'json'
                );
            });
        });
    });
</script>
</body>
</html>
