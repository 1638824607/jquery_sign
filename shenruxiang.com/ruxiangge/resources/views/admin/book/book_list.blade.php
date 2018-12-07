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
    <div class="layui-card">
        <div class="layui-form layui-card-header layuiadmin-card-header-auto">
            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label">小说ID</label>
                    <div class="layui-input-inline">
                        <input type="number" name="id" placeholder="请输入小说ID" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">作者名称</label>
                    <div class="layui-input-inline">
                        <input type="text" name="author_name" placeholder="请输入作者名称" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">小说名称</label>
                    <div class="layui-input-inline">
                        <input type="text" name="name" placeholder="请输入小说名称" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">阅读类型</label>
                    <div class="layui-input-inline">
                        <select name="reader_type">
                            <option value="">请选择阅读类型</option>
                            @foreach($bookReaderList as $val)
                                <option value="{{$val['id']}}">{{$val['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">小说类型</label>
                    <div class="layui-input-inline">
                            <select name="type">
                                <option value="">请选择小说类型</option>
                                @foreach($bookTypeList as $val)
                                    <option value="{{$val['id']}}">{{$val['name']}}</option>
                                @endforeach
                            </select>
                        </select>
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">状态</label>
                    <div class="layui-input-inline">
                        <select name="status">
                            <option value="">请选择状态</option>
                            <option value="1">未审核</option>
                            <option value="2">正常</option>
                            <option value="3">屏蔽</option>
                        </select>
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">轮播图状态</label>
                    <div class="layui-input-inline">
                        <select name="is_carousel">
                            <option value="">请选择轮播图状态</option>
                            <option value="2">显示</option>
                            <option value="1">屏蔽</option>
                        </select>
                    </div>
                </div>

                <div class="layui-inline">
                    <button class="layui-btn layuiadmin-btn-list" lay-submit lay-filter="book-search-form-submit">
                        <i class="layui-icon layui-icon-search layuiadmin-button-btn"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="layui-card-body">
            <div style="padding-bottom: 10px;">
                <button class="layui-btn layuiadmin-btn-list book-add">添加</button>
            </div>
            <div>
                <table id="book_table" lay-filter="book_table"></table>
            </div>
        </div>
    </div>
</div>

<div style="display: none" id="set-form">
    <div class="layui-form"  lay-filter="layuiadmin-form-tags" id="layuiadmin-app-form-tags" style="padding-top: 30px; text-align: center;">
        <div class="layui-form-item">
            <label class="layui-form-label">小说列表</label>
            <div class="layui-input-inline book-list">

            </div>
        </div>
    </div>
</div>

<div style="display: none" id="book-form">
    <div class="layui-form" lay-filter="book-form" style="padding: 20px 30px 0 0;">

        <input type="hidden" name="id">

        <div class="layui-form-item">
            <label class="layui-form-label">小说封面图</label>
            <div class="layui-upload">
                <button type="button" class="layui-btn" id="upload-book">上传封面图</button>
                <div class="layui-upload-list">
                    <img class="layui-upload-img" id="upload-book-img"  data-src="">
                    <input type="hidden" name="cover">
                    <p id="upload-book-text"></p>
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">作者名称</label>
            <div class="layui-input-block">
                <input type="text" name="author_name" lay-verify="required" placeholder="请输入作者名称" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">小说名称</label>
            <div class="layui-input-block">
                <input type="text" name="name" lay-verify="required" placeholder="请输入小说名称" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">小说描述</label>
            <div class="layui-input-block">
                <textarea name="description" required lay-verify="required" placeholder="请输入" class="layui-textarea"></textarea>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">小说评分</label>
            <div class="layui-input-block">
                <div id="book-rate"></div>
                <input type="hidden" name="rate">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">小说大小</label>
            <div class="layui-input-block">
                <input type="text" name="size" lay-verify="required" placeholder="请输入小说大小" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">小说字数</label>
            <div class="layui-input-block">
                <input type="text" name="word_count" lay-verify="required" placeholder="请输入小说字数" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">阅读类型</label>
            <div class="layui-input-block">
                <select name="reader_type" lay-verify="required">
                    <option value="">请选择阅读类型</option>
                    @foreach($bookReaderList as $val)
                        <option value="{{$val['id']}}">{{$val['name']}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">小说类型</label>
            <div class="layui-input-block">
                <select name="type" lay-verify="required">
                    <option value="">请选择小说类型</option>
                    @foreach($bookTypeList as $val)
                        <option value="{{$val['id']}}">{{$val['name']}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">小说状态</label>
            <div class="layui-input-block">
                <select name="status" lay-verify="required">
                    <option value="">请选择小说状态</option>
                    <option value="1">未审核</option>
                    <option value="2">正常</option>
                    <option value="3">屏蔽</option>
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">最新章节</label>
            <div class="layui-input-block">
                <input type="number" name="latest_chapter_id" lay-verify="required" placeholder="请输入最新章节" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">是否置顶</label>
            <div class="layui-input-block">
                <input type="radio" name="is_top" value="1" title="不置顶" checked>
                <input type="radio" name="is_top" value="2" title="置顶">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">是否推荐</label>
            <div class="layui-input-block">
                <input type="radio" name="is_recommend" value="1" title="不推荐" checked>
                <input type="radio" name="is_recommend" value="2" title="推荐">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">轮播图状态</label>
            <div class="layui-input-block">
                <input type="radio" name="is_carousel" value="1" title="屏蔽" checked>
                <input type="radio" name="is_carousel" value="2" title="显示">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">阅读次数</label>
            <div class="layui-input-block">
                <input type="number" name="read_num" lay-verify="required" placeholder="请输入阅读次数" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">收藏数</label>
            <div class="layui-input-block">
                <input type="number" name="collect_num" lay-verify="required" placeholder="请输入收藏数" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">排序</label>
            <div class="layui-input-block">
                <input type="number" name="sort" lay-verify="required" placeholder="请输入排序" autocomplete="off" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item layui-hide">
            <input type="button" lay-submit lay-filter="book-form-submit" id="book-form-submit" value="确认">
        </div>
    </div>
</div>

<script type="text/html" id="table-content-list">
    <a class="layui-btn layui-btn-warm layui-btn-xs" lay-event="chapter"><i class="layui-icon  layui-icon-read"></i>章节</a>
    <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="edit"><i class="layui-icon  layui-icon-edit"></i>编辑</a>
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del"><i class="layui-icon layui-icon-delete"></i>删除</a>
</script>

<script src="/admin/lib/layui/layui.js"></script>
<script>
    layui.use(['jquery','table','form', 'upload', 'rate', 'element'], function() {
        var $      = layui.$;
        var table  = layui.table;
        var form   = layui.form;
        var upload = layui.upload;
        var rate   = layui.rate;

        var book_table_ajax_url = '{{url("admin/book/book_list")}}';
        var book_cover_upload   = '{{url("admin/book/book_cover_upload")}}';
        var ajax_book_save_url  = '{{url("admin/book/book_save")}}';
        var ajax_book_del_url   = '{{url("admin/book/book_del")}}';

        var bookReaderList =  eval({!! json_encode($bookReaderList) !!});
        var bookTypeList   =  eval({!! json_encode($bookTypeList) !!});

        rate.render({
            elem: '#book-rate'
            ,length: 10
            ,value: 0
            ,text: true
            ,choose: function(value){
                $("input[name='rate']").val(value);
            }
        });

        var book_status = {
            1:'未审核',
            2:'正常',
            3:'屏蔽'
        };

        //监听搜索
        form.on('submit(book-search-form-submit)', function(data){
            var field = data.field;

            //执行重载
            table.reload('book_table', {
                where: field
            });
        });

        // 数据表格渲染
        table.render({
            elem: '#book_table'
            ,url: book_table_ajax_url //数据接口
            ,method:'post'
            ,height: 'full-220'
            ,page: true //开启分页
            ,limit:20  //每页行数 默认10
            ,limits: [10, 20, 30]
            ,cols: [[ //表头
                {field : 'id',  title: 'ID',width:80, sort: true, fixed: 'left'}
                ,{field: 'author_name', title: '作者名称'}
                ,{field: 'name',  title: '小说名称'}
//                ,{field: 'description',  title: '小说简介'}
//                ,{field: 'cover',  title: '缩略图'}
//                ,{field: 'latest_chapter_id',  title: '最新章节'}
                ,{field: 'word_count',  title: '小说大小',sort: true,templet:'<div>@{{d.word_count}}</div>'}
//                ,{field: 'word_count',  title: '小说字数'}
                ,{field: 'reader_type',  title: '阅读类型',templet:function(d){
                    return "<div>"+bookReaderList[d.reader_type]['name']+"</div>"
                }}
                ,{field: 'type',  title: '小说类型',templet:function(d){
                    return "<div>"+bookTypeList[d.type]['name']+"</div>"
                }}
                ,{field: 'read_num',  title: '阅读数',sort: true}
                ,{field: 'collect_num', width:80,  title: '收藏数',sort: true}
                ,{field: 'is_top',  title: '是否置顶',templet:'<div>@{{d.is_top == 1 ? "否" : "是"}}</div>'}
                ,{field: 'is_carousel',  title: '轮播图状态',templet:'<div>@{{d.is_carousel == 1 ? "屏蔽" : "显示"}}</div>'}
                ,{field: 'status', width:80,  title: '状态',templet:function(d){

                    return "<div>"+book_status[d.status]+"</div>"
                }}
//                ,{field: 'is_complate',  title: '是否完结'}
//                ,{field: 'is_recommend',  title: '是否推荐'}
//                ,{field: 'sort',  title: '排序'}
                ,{field: 'created_at', title: '创建时间'}
//                ,{field: 'updated_at', title: '更新时间'}
                ,{title: "操作",width:220, align: "center", fixed: "right", toolbar: "#table-content-list"}
            ]]
        });

        var uploadInst = upload.render({
            elem: '#upload-book'
            ,url: book_cover_upload
            ,before: function(obj){
                //预读本地文件示例，不支持ie8
                obj.preview(function(index, file, result){
                    $('#upload-book-img').attr('src', result); //图片链接（base64）
                });
            }
            ,done: function(res){
                $("input[name='cover']").val(res.data);

                return layer.msg(res.msg);
            }
            ,error: function(){
                var demoText = $('#upload-book-text');
                demoText.html('<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-mini upload-reload">重试</a>');
                demoText.find('.upload-reload').on('click', function(){
                    uploadInst.upload();
                });
            }
        });

        // 小说添加
        $('.book-add').on('click', function()
        {
            form.val('book-form',{
                'id' : '',
                'author_name' : '',
                'name' : '',
                'description' : '',
                'cover' : '',
                'latest_chapter_id' : '',
                'size' : '',
                'word_count' : '',
                'reader_type' : '',
                'type' : '',
                'read_num' : '',
                'collect_num' : '',
                'is_top' : '1',
                'is_carousel' : '1',
                'status' : '',
                'is_recommend' : '1',
                'sort' : ''
            });

            rate.render({
                elem: '#book-rate'
                ,length: 10
                ,value: 0
                ,text: true
                ,choose: function(value){
                    $("input[name='rate']").val(value);
                }
            });

            $('#upload-book-img').attr('src', ' ');

            layer.open({
                type: 1
                ,title: '添加小说'
                ,content: $('#book-form')
                ,maxmin: true
                ,area: ['100%', '100%']
                ,btn: ['确定', '取消']
                ,yes: function(index, layero){
                    //点击确认触发 iframe 内容中的按钮提交
                    $('#book-form-submit').click();
                }
            });
        });

        // 编辑和删除操作
        table.on('tool(book_table)', function(obj)
        {
            var data = obj.data;

            if(obj.event === 'del')
            {
                layer.confirm('真的删除么？', {
                    btn: ['确认','取消'], //按钮
                    title:'删除小说'
                }, function(){
                    layer.confirm('删除小说将导致章节全部删除！',{title:'删除小说'}, function(index){
                        $.post(
                            ajax_book_del_url,
                            {id:data.id},
                            function(res){
                                if(res.status == 2){
                                    layer.msg(res.msg,{icon:5,shade:0.1,time:1000});
                                }else{
                                    layer.msg(res.msg, {icon:6,shade:0.1,time:1000}, function(){
                                        table.reload('book_table');
                                        layer.closeAll();
                                    });
                                }
                            },'json'
                        );

                    });
                }, function(){

                });
            } else if(obj.event === 'edit')
            {
                form.val('book-form',{
                    'id' : data.id,
                    'author_name' : data.author_name,
                    'name' : data.name,
                    'description' : data.description,
                    'cover' : data.cover,
                    'latest_chapter_id' : data.latest_chapter_id,
                    'size' : data.size,
                    'word_count' : data.word_count,
                    'reader_type' : data.reader_type,
                    'type' : data.type,
                    'read_num' : data.read_num,
                    'collect_num' : data.collect_num,
                    'is_top' : data.is_top.toString(),
                    'is_carousel' : data.is_carousel.toString(),
                    'status' : data.status,
                    'is_recommend' :data.is_recommend.toString(),
                    'sort' : data.sort
                });

                rate.render({
                    elem: '#book-rate'
                    ,length: 10
                    ,value: data.rate
                    ,text: true
                    ,choose: function(value){
                        $("input[name='rate']").val(value);
                    }
                });

                $('#upload-book-img').attr('src', data.cover);

                layer.open({
                    type: 1
                    ,title: '修改小说信息'
                    ,content: $('#book-form')
                    ,maxmin: true
                    ,area: ['100%', '100%']
                    ,btn: ['确定', '取消']
                    ,yes: function(index, layero){
                        $('#book-form-submit').click();
                    }
                });
            }else if(obj.event === 'chapter')
            {
                var book_chapter_url = "{{url('admin/book/book_chapter_list')}}?book_id=" + data.id;

                layer.open({
                    type: 2,
                    title: '小说章节列表',
                    maxmin: true,
                    area: ['100%', '100%'],
                    content: book_chapter_url //iframe的url
                });
            }
        });

        form.on('submit(book-form-submit)', function(data)
        {
            delete(data.field['file']);

            data.field.rate = $('.layui-icon-rate-solid').length;

            $.post(
                ajax_book_save_url,
                data.field,
                function(res){
                    if(res.status == 2){
                        layer.msg(res.msg,{icon:5,shade:0.1,time:1000});
                    }else{
                        layer.msg(res.msg, {icon:6,shade:0.1,time:1000}, function(){
                            table.reload('book_table'); //重载表格
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
