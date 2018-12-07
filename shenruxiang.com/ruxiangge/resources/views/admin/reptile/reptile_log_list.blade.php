<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>小说管理-小说爬虫日志列表</title>
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
            {{--<div style="padding-bottom: 10px;">--}}
                {{--<button class="layui-btn layuiadmin-btn-list reptile-add">添加</button>--}}
            {{--</div>--}}
            <div>
                <table id="reptile_table" lay-filter="reptile_table"></table>
            </div>
        </div>
    </div>
</div>

<script src="/admin/lib/layui/layui.js"></script>
<script>
    layui.use(['jquery','table','form'], function() {
        var $ = layui.$;
        var table = layui.table;
        var form = layui.form;

        var reptile_table_ajax_url = '{{url("admin/reptile/reptile_log_list")}}';

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
                ,{field: 'reptile_id', title: '爬虫ID'}
                ,{field: 'target_url', title: '爬虫地址'}
                ,{field: 'start_time', title: '开始时间'}
                ,{field: 'end_time', title: '结束时间'}
            ]]
        });
    });
</script>
</body>
</html>
