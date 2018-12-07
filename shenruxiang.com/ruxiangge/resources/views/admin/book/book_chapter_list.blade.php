<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>小说管理-小说章节列表</title>
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
    <div class="layui-card">
        <div class="layui-form layui-card-header layuiadmin-card-header-auto">
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label">小说ID</label>
                    <div class="layui-input-inline">
                        <input type="number" name="book_id" value="{{$book_id}}" placeholder="请输入小说ID" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">章节ID</label>
                    <div class="layui-input-inline">
                        <input type="text" name="id" placeholder="请输入章节ID" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">章节标题</label>
                    <div class="layui-input-inline">
                        <input type="text" name="title" placeholder="请输入章节标题" autocomplete="off" class="layui-input">
                    </div>
                </div>

                <div class="layui-inline">
                    <label class="layui-form-label">章节状态</label>
                    <div class="layui-input-inline">
                        <select name="status">
                            <option value="">请选择状态</option>
                            <option value="1">正常</option>
                            <option value="2">屏蔽</option>
                        </select>
                    </div>
                </div>

                <div class="layui-inline">
                    <button class="layui-btn layuiadmin-btn-list" lay-submit lay-filter="book-chapter-search-form-submit">
                        <i class="layui-icon layui-icon-search layuiadmin-button-btn"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="layui-card-body">
            <div style="padding-bottom: 10px;">
                <button class="layui-btn layuiadmin-btn-list book-chapter-add">添加</button>
                @isset($book_id)
                    <button class="layui-btn layuiadmin-btn-list layui-btn-danger book-chapter-check" data-book-id="{{$book_id}}">章节修正</button>
                @endisset
            </div>
            <div>
                <table id="book_chapter_table" lay-filter="book_chapter_table"></table>
            </div>
        </div>
    </div>
</div>

<div style="display: none" id="book-chapter-form">
    <div class="layui-form" lay-filter="book-chapter-form" style="padding: 20px 30px 0 0;">

        <input type="hidden" name="id">

        <div class="layui-form-item">
            <label class="layui-form-label">小说ID</label>
            <div class="layui-input-block">
                <input type="number" name="book_id" lay-verify="required" placeholder="请输入小说ID" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">数据库ID</label>
            <div class="layui-input-block">
                <input type="text" name="db_id" lay-verify="required" placeholder="请输入数据库ID" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">章节名</label>
            <div class="layui-input-block">
                <input type="text" name="name" lay-verify="required" placeholder="请输入章节名" autocomplete="off" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">字数</label>
            <div class="layui-input-block">
                <input type="number" name="word_count" lay-verify="required" placeholder="请输入字数" autocomplete="off" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">排序</label>
            <div class="layui-input-block">
                <input type="number" name="sort" lay-verify="required" placeholder="请输入排序" autocomplete="off" class="layui-input">
            </div>
        </div>

        <div class="layui-inline">
            <label class="layui-form-label">章节状态</label>
            <div class="layui-input-inline">
                <select name="status" lay-verify="required">
                    <option value="">请选择状态</option>
                    <option value="1">正常</option>
                    <option value="2">屏蔽</option>
                </select>
            </div>
        </div>

        <div class="layui-form-item layui-hide">
            <input type="button" lay-submit lay-filter="book-chapter-form-submit" id="book-chapter-form-submit" value="确认">
        </div>
    </div>
</div>

<script type="text/html" id="table-content-list">
    <a class="layui-btn layui-btn-warm layui-btn-xs" lay-event="detail"><i class="layui-icon  layui-icon-read"></i>内容</a>
    <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="edit"><i class="layui-icon  layui-icon-edit"></i>编辑</a>
    {{--<a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del"><i class="layui-icon layui-icon-delete"></i>删除</a>--}}
</script>

<script src="/admin/lib/layui/layui.js"></script>
<script>
    layui.use(['jquery','table','form', 'upload', 'rate'], function() {
        var $      = layui.$;
        var table  = layui.table;
        var form   = layui.form;
        var upload = layui.upload;
        var rate   = layui.rate;

        var book_chapter_table_ajax_url = '{{url("admin/book/book_chapter_list")}}';
        var ajax_book_chapter_save_url  = '{{url("admin/book/book_chapter_save")}}';
        var ajax_book_chapter_del_url   = '{{url("admin/book/book_chapter_del")}}';

        var book_list =  eval({!! json_encode($book_list) !!});

        //监听搜索
        form.on('submit(book-chapter-search-form-submit)', function(data){
            var field = data.field;

            //执行重载
            table.reload('book_chapter_table', {
                where: field
            });
        });

        var get_book_id = "{{$book_id}}";

        // 数据表格渲染
        table.render({
            elem: '#book_chapter_table'
            ,url: book_chapter_table_ajax_url //数据接口
            ,method:'post'
            ,where:{book_id:get_book_id}
            ,height: 'full-220'
            ,page: true //开启分页
            ,limit:20  //每页行数 默认10
            ,limits: [10, 20, 30]
            ,cols: [[ //表头
                {field : 'id',  title: 'ID',width:150, sort: true, fixed: 'left'}
                ,{field: 'book_id',width:200, title: '小说ID/小说名称',templet:function(d){
                        return "<div>"+d.book_id + '/' + book_list[d.book_id]['name']+"</div>"
                    }}
                ,{field: 'db_id', title: '章节ID'}
                ,{field: 'name',width:250,  title: '名称'}
                ,{field: 'word_count',  title: '字数'}
                ,{field: 'sort',  title: '排序'}
                ,{field: 'status',  title: '状态',templet:'<div>@{{d.status == 1 ? "正常" : "屏蔽"}}</div>'}
                ,{field: 'created_at', title: '创建时间'}
                ,{title: "操作",width:200, align: "center", fixed: "right", toolbar: "#table-content-list"}
            ]]
        });

        // 章节添加
        $('.book-chapter-add').on('click', function()
        {
            form.val('book-chapter-form',{
                'id' : '',
                'book_id' : '',
                'db_id' : '',
                'name' : '',
                'word_count' : '',
                'sort' : '',
                'status' : ''
            });

            layer.open({
                type: 1
                ,title: '添加小说章节'
                ,content: $('#book-chapter-form')
                ,maxmin: true
                ,area: ['850px', '650px']
                ,btn: ['确定', '取消']
                ,yes: function(index, layero){
                    $('#book-chapter-form-submit').click();
                }
            });
        });

        // 章节修正
        $('.book-chapter-check').on('click', function()
        {
            var book_id = $(this).attr('data-book-id');

            if(book_id == '') {
                layer.msg('小说ID为空');
                return false;
            }

            var book_chapter_check_url = "{{url('admin/book/book_chapter_check')}}?book_id=" + book_id;

            layer.open({
                type: 2,
                title: '小说章节修正',
                maxmin: true,
                area: ['100%', '100%'],
                btn: ['确定', '取消'],
                content: book_chapter_check_url //iframe的url
            });
        });

        // 编辑和删除操作
        table.on('tool(book_chapter_table)', function(obj)
        {
            var data = obj.data;

            if(obj.event === 'del')
            {
                layer.confirm('真的删除么？', {
                    btn: ['确认','取消'], //按钮
                    title:'删除小说章节'
                }, function(){
                    $.post(
                        ajax_book_chapter_del_url,
                        {id:data.id},
                        function(res){
                            if(res.status == 2){
                                layer.msg(res.msg,{icon:5,shade:0.1,time:1000});
                            }else{
                                layer.msg(res.msg, {icon:6,shade:0.1,time:1000}, function(){
                                    table.reload('book_chapter_table');
                                    layer.closeAll();
                                });
                            }
                        },'json'
                    );
                });
            } else if(obj.event === 'edit')
            {
                form.val('book-chapter-form',{
                    'id' : data.id,
                    'book_id' : data.book_id,
                    'db_id' : data.db_id,
                    'name' : data.name,
                    'word_count' : data.word_count,
                    'sort' : data.sort,
                    'status' : data.status
                });

                layer.open({
                    type: 1
                    ,title: '修改小说章节信息'
                    ,content: $('#book-chapter-form')
                    ,maxmin: true
                    ,area: ['850px', '650px']
                    ,btn: ['确定', '取消']
                    ,yes: function(index, layero){
                        $('#book-chapter-form-submit').click();
                    }
                });
            }else if(obj.event === 'detail')
            {
                var book_chapter_content_url = "{{url('admin/book/book_chapter_content')}}?db_id=" + data.db_id;

                layer.open({
                    type: 2,
                    title: '小说章节内容',
                    maxmin: true,
                    area: ['100%', '100%'],
                    btn: ['确定', '取消'],
                    content: book_chapter_content_url //iframe的url
                });
            }
        });

        form.on('submit(book-chapter-form-submit)', function(data)
        {
            $.post(
                ajax_book_chapter_save_url,
                data.field,
                function(res){
                    if(res.status == 2){
                        layer.msg(res.msg,{icon:5,shade:0.1,time:1000});
                    }else{
                        layer.msg(res.msg, {icon:6,shade:0.1,time:1000}, function(){
                            table.reload('book_chapter_table'); //重载表格
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
