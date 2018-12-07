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
        legend{
            text-align: center
        }
        fieldset{
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="layui-fluid">
    <div class="layui-card">
        <div class="layui-card-body">
            <fieldset class="layui-elem-field layui-field-title">
                <legend><span>{{$chapterRow['name']}}</span></legend>
            </fieldset>

            <script id="container" name="content" type="text/plain"></script>
            <!-- 配置文件 -->
        </div>
    </div>
</div>
{{--<script src="/admin/lib/layui/layui.js"></script>--}}
{{--<script>--}}
    {{--layui.use(['layedit','jquery'], function(){--}}
        {{--var layedit = layui.layedit;--}}
        {{--var $      = layui.$;--}}

    {{--});--}}
{{--</script>--}}
<script src="http://www.jq22.com/jquery/jquery-2.1.1.js"></script>
<script type="text/javascript" src="/admin/lib/ueditor/ueditor.config.js"></script>
<!-- 编辑器源码文件 -->
<script type="text/javascript" src="/admin/lib/ueditor/ueditor.all.js"></script>

<script type="text/javascript">
    var chapterContent = "{!! $chapterContent !!}";

    var ue = UE.getEditor('container',{
        toolbars:[
            [
                'undo',
                'redo',
                'indent',
                'pasteplain',
                'selectall',
                'fontfamily',
                'fontsize',
                'justifyleft',
                'justifyright',
                'justifycenter',
                'autotypeset',
                'drafts'
            ]
        ],
        elementPathEnabled:false,
        tabSize:2,
        tabNode:'&emsp;',
        initialFrameHeight:400
    });

    $(document).ready(function () {

        ue.ready(function () {
            ue.setContent(chapterContent);  //赋值给UEditor
        });

    });
</script>
</body>
</html>
