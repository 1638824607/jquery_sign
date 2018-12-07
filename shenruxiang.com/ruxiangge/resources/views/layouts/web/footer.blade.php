<div class="new_footer">
    <div class="container clearfix">
        <div class="clearfix">
            <div class="fl foot_left">
                <h1>
                    <b class="active">友情链接</b>
                </h1>
                <div class="ft_row clearfix">
                    @foreach($linkList as $linkRow)
                        <a href="{{$linkRow['url']}}" title="{{$linkRow['name']}}" target="_blank">{{$linkRow['name']}}</a>
                    @endforeach
                </div>
            </div>
            <div class="fl foot_right">
                <h1>入香阁</h1>
                <ul>
                    <li><a href="javascript:void 0" target="_blank"><b class="t1"></b>入香阁全本小说网</a></li>
                    <li><a href="javascript:void 0" target="_blank"><b class="t2"></b>入香阁客户端</a></li>
                    <li><a href="javascript:void 0" target="_blank"><b class="t3"></b>入香阁手机站</a></li>
                    <li><a href="javascript:void 0" target="_blank"><b class="t4"></b>入香阁官方微博</a></li>
                    <li><a href="javascript:void 0"  target="_blank"><b class="t5"></b>入香阁官方微信</a></li><li><a href="##"  target="_blank"><b ></b></a></li>
                </ul>
            </div>
        </div>
        <div class="new_copy">
            <h2><a href="javascript:void 0" title="关于我们" target="_blank">关于我们</a> |
                <a href="javascript:void 0" title="网站地图" target="_blank">网站地图</a> |
                <a href="{{url('privacy')}}" title="隐私声明" target="_blank">隐私声明</a> |
                <a href="javascript:;" onclick="index_goTop();">回到顶部↑</a></h2>
            <p>
            <p>
            <p>
            <p>
                客服邮箱：{{json_decode($systemInfo['content'],true)['site_email']}}
                电话：{{json_decode($systemInfo['content'],true)['site_tel']}}
                QQ：{{json_decode($systemInfo['content'],true)['site_qq']}}</p>
            {{--<p>网站备案/许可证号:<a href="https://www.miitbeian.gov.cn" target="_blank">粤ICP备14091483号-1</a>&nbsp;&nbsp; Copyright &copy; 2014 9kus.com All rights reserved.</p>--}}
            <p><a target="_blank" href="" style=""><img src="/web/img/rs.png" style="width:20px;height:20px;" />{{json_decode($systemInfo['content'],true)['site_icp']}}</a></p>
        </div>
    </div>
</div>
</body>
</html>