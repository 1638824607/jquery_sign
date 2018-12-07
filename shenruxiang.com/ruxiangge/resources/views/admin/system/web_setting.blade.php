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
</head>
<body>
<div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
    <ul class="layui-tab-title">
        <li class="layui-this">网站基本信息</li>
        <li>网站控制</li>
    </ul>
    <div class="layui-tab-content">
        <div class="layui-tab-item layui-show">
            <div class="layui-fluid">
                <div class="layui-row">
                    <div class="layui-col-md12">
                        <div class="layui-card">
                            <div class="layui-card-header">网站基本信息</div>
                            <div class="layui-card-body layui-row layui-form" lay-filter="web-info-form">
                                <div class="layui-form-item">
                                    <label class="layui-form-label">网站名称</label>
                                    <div class="layui-input-block">
                                        <input type="text" name="site_name" autocomplete="off" placeholder="请输入网站名称" class="layui-input" value="{{! empty($webInfoSettingRow->site_name) ? $webInfoSettingRow->site_name : ''}}">
                                    </div>
                                </div>

                                <input type="hidden" name="type" value="1">

                                <div class="layui-form-item">
                                    <label class="layui-form-label">网站地址</label>
                                    <div class="layui-input-block">
                                        <input type="text" name="site_url" autocomplete="off" placeholder="请输入网站地址" class="layui-input" value="{{! empty($webInfoSettingRow->site_url) ? $webInfoSettingRow->site_url : ''}}">
                                    </div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label">网站关键字</label>
                                    <div class="layui-input-block">
                                        <input type="text" name="site_keyword"  autocomplete="off" placeholder="请输入网站关键字" class="layui-input" value="{{! empty($webInfoSettingRow->site_keyword) ? $webInfoSettingRow->site_keyword : ''}}">
                                    </div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label">网站描述</label>
                                    <div class="layui-input-block">
                                        <input type="text" name="site_desc" autocomplete="off" placeholder="请输入网站描述" class="layui-input" value="{{! empty($webInfoSettingRow->site_desc) ? $webInfoSettingRow->site_desc : ''}}">
                                    </div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label">ICP备案号</label>
                                    <div class="layui-input-block">
                                        <input type="text" name="site_icp" autocomplete="off" placeholder="请输入备案号" class="layui-input" value="{{! empty($webInfoSettingRow->site_icp) ? $webInfoSettingRow->site_icp : ''}}">
                                    </div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label">联系电话</label>
                                    <div class="layui-input-block">
                                        <input type="number" name="site_tel" autocomplete="off" placeholder="请输入联系电话" class="layui-input" value="{{! empty($webInfoSettingRow->site_tel) ? $webInfoSettingRow->site_tel : ''}}">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">联系QQ</label>
                                    <div class="layui-input-block">
                                        <input type="number" name="site_qq" autocomplete="off" placeholder="请输入联系QQ" class="layui-input" value="{{! empty($webInfoSettingRow->site_qq) ? $webInfoSettingRow->site_qq : ''}}">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">联系邮箱</label>
                                    <div class="layui-input-block">
                                        <input type="text" name="site_email" autocomplete="off" placeholder="请输入联系邮箱" class="layui-input" value="{{! empty($webInfoSettingRow->site_email) ? $webInfoSettingRow->site_email : ''}}">
                                    </div>
                                </div>

                                <div class="layui-form-item layui-layout-admin">
                                    <div class="layui-input-block">
                                        <div class="layui-footer" style="left: 0;">
                                            <button class="layui-btn" lay-submit lay-filter="web_info_setting">立即提交</button>
                                            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-tab-item">
            <div class="layui-fluid">
                <div class="layui-row">
                    <div class="layui-col-md12">
                        <div class="layui-card">
                            <div class="layui-card-header">网站控制</div>
                            <div class="layui-card-body layui-row layui-form">
                                <div class="layui-form-item">
                                    <label class="layui-form-label">网站状态</label>
                                    <div class="layui-input-block">
                                        @if(! empty($webControllerSettingRow))
                                            <input type="radio" name="site_status" value="1" @if($webControllerSettingRow->site_status == 1) checked  @endif title="开启">
                                            <input type="radio" name="site_status" value="2" @if($webControllerSettingRow->site_status == 2) checked  @endif title="关闭">
                                        @else
                                            <input type="radio" name="site_status" value="1" title="开启">
                                            <input type="radio" name="site_status" value="2" title="关闭" checked>
                                        @endif
                                    </div>
                                </div>

                                <input type="hidden" name="type" value="2">

                                <div class="layui-form-item">
                                    <label class="layui-form-label">闭站提示</label>
                                    <div class="layui-input-block">
                                        <input type="text" name="site_close_msg"  autocomplete="off" placeholder="请输入闭站提示" class="layui-input" value="{{! empty($webControllerSettingRow->site_close_msg) ? $webControllerSettingRow->site_close_msg : ''}}">
                                    </div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label">注册状态</label>
                                    <div class="layui-input-block">
                                        @if(! empty($webControllerSettingRow))
                                            <input type="radio" name="site_reg" value="1" title="开启" @if($webControllerSettingRow->site_reg == 1) checked  @endif>
                                            <input type="radio" name="site_reg" value="2" title="关闭" @if($webControllerSettingRow->site_reg == 2) checked  @endif>
                                        @else
                                            <input type="radio" name="site_reg" value="1" title="开启">
                                            <input type="radio" name="site_reg" value="2" title="关闭" checked>
                                        @endif
                                    </div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label">验证码状态</label>
                                    <div class="layui-input-block">
                                        @if(! empty($webControllerSettingRow))
                                            <input type="radio" name="site_code" value="1" title="开启" @if($webControllerSettingRow->site_code == 1) checked  @endif>
                                            <input type="radio" name="site_code" value="2" title="关闭" @if($webControllerSettingRow->site_code == 2) checked  @endif>
                                        @else
                                            <input type="radio" name="site_code" value="1" title="开启">
                                            <input type="radio" name="site_code" value="2" title="关闭" checked>
                                        @endif
                                    </div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label">第三方登陆</label>
                                    <div class="layui-input-block">
                                        <input type="checkbox" name="site_oauth[]" value="qq" title="QQ" @if(! empty($webControllerSettingRow->site_oauth) && strstr($webControllerSettingRow->site_oauth, 'qq')) checked  @endif>
                                        <input type="checkbox" name="site_oauth[]" value="wb" title="微博" @if(! empty($webControllerSettingRow->site_oauth) && strstr($webControllerSettingRow->site_oauth, 'wb')) checked  @endif>
                                        <input type="checkbox" name="site_oauth[]" value="wx" title="微信" @if(! empty($webControllerSettingRow->site_oauth) && strstr($webControllerSettingRow->site_oauth, 'wx')) checked  @endif>
                                    </div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label">缓存状态</label>
                                    <div class="layui-input-block">
                                        @if(! empty($webControllerSettingRow))
                                            <input type="radio" name="site_cache" value="1" title="开启" @if($webControllerSettingRow->site_cache == 1) checked  @endif>
                                            <input type="radio" name="site_cache" value="2" title="关闭" @if($webControllerSettingRow->site_cache == 2) checked  @endif>
                                        @else
                                            <input type="radio" name="site_cache" value="1" title="开启">
                                            <input type="radio" name="site_cache" value="2" title="关闭" checked>
                                        @endif
                                    </div>
                                </div>

                                <div class="layui-form-item">
                                    <label class="layui-form-label">缓存时间</label>
                                    <div class="layui-input-block">
                                        <input type="number" name="site_cache_time" autocomplete="off" placeholder="请输入缓存时间" class="layui-input" value="{{! empty($webControllerSettingRow->site_cache_time) ? $webControllerSettingRow->site_cache_time : ''}}">
                                    </div>
                                </div>

                                <div class="layui-form-item layui-layout-admin">
                                    <div class="layui-input-block">
                                        <div class="layui-footer" style="left: 0;">
                                            <button class="layui-btn" lay-submit lay-filter="web_controller_setting">立即提交</button>
                                            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
<script src="/admin/lib/layui/layui.js"></script>
<script>
    layui.use(['jquery','element','layer','form'], function() {
        var $ = layui.$;
        var layer = layui.layer;
        var form = layui.form;

        var ajax_site_setting_save_url = '{{url("admin/system/setting_save")}}';

        form.on('submit(web_controller_setting)', function(data)
        {
            $.post(
                ajax_site_setting_save_url,
                data.field,
                function(res){
                    if(res.status == 2){
                        layer.msg(res.msg,{icon:5,shade:0.1,time:1000});
                    }else{
                        layer.msg(res.msg, {icon:6,shade:0.1,time:1000}, function(){
                            layer.closeAll();
                            window.location.reload();
                        });
                    }
                },'json'
            );
        });

        form.on('submit(web_info_setting)', function(data)
        {
            $.post(
                ajax_site_setting_save_url,
                data.field,
                function(res){
                    if(res.status == 2){
                        layer.msg(res.msg,{icon:5,shade:0.1,time:1000});
                    }else{
                        layer.msg(res.msg, {icon:6,shade:0.1,time:1000}, function(){
                        layer.closeAll();
                        window.location.reload();
                        });
                    }
                },'json'
            );
        });
    });
</script>