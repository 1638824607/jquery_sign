@extends('layouts.wap.common')

@section('title', '入香阁-全本小说网-精选推荐')

@section('content')
    <style>
        /*.p-text{*/
            /*text-overflow:ellipsis;overflow:hidden;display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;white-space:pre;line-height: 30px*/
        /*}*/
    </style>
    <link rel="stylesheet" type="text/css" href="/wap/css/newzt.css" />
<div class="newzt">
    <div class="topban">
        <img src="/wap/img/topban.png" />
    </div>
    <div class="container">
        <div class="clearfix">
            <ul class="newbklist">
                @if(!empty($bookList))
                    @foreach($bookList as $bookRow)
                        <li>
                            <div class="lis">
                                <span class="cont"><a class="recommend-img-a" href="{{url('book_detail/'. $bookRow['id'])}}" target="_blank"><img class="bookimg" src="{{$bookRow['cover']}}" /></a><p>{{mb_substr(str_replace('<br>', '', $bookRow['description']),0,20)}}...</p><h6><b>小说作者</b></h6><h5><img class="users" src="{{$bookRow['cover']}}" />{{$bookRow['author_name']}}</h5><h4><a href="{{url('book_detail/'. $bookRow['id'])}}" target="_blank">立即阅读</a></h4></span>
                            </div>
                        </li>
                    @endforeach
                @endif
            </ul>
        </div>
        <div class="clearfix btban">
            <a href="{{url('book_recommend_list')}}"><img src="/wap/img/otmore.png" /></a>
        </div>
    </div>
</div>

<script type="text/javascript">


    // //微信配置
//    var jsUrl = window.location.href;
//    jsUrl = encodeURIComponent(jsUrl);

//    //获取签名
//    $.ajax({
//        url: "https://m.9kus.com/WechatPlatform/getSign/op/10116",
//        type: "POST",
//        async: false,
//        cache: false,
//        data: 'jsUrl=' + jsUrl+'&AppID=wxe81efe9e982386b2',
//        success: function (data) {
//
//            data = eval('(' + data + ')');
//            if (data.status == '1') {
//                var sign = data.sign;
//                var timeStamp = data.timeStamp;
//                var randStr = data.randStr;
//
//                //验证接口
//                wx.config({
//                    debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
//                    appId: 'wxe81efe9e982386b2', // 必填，公众号的唯一标识
//                    timestamp: timeStamp, // 必填，生成签名的时间戳
//                    nonceStr: randStr, // 必填，生成签名的随机串
//                    signature: sign,// 必填，签名，见附录1
//                    jsApiList: [
//                        'onMenuShareTimeline',
//                        'onMenuShareAppMessage',
//                        'onMenuShareQQ',
//                    ] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
//                });
//            }
//        }
//    });
//
//
//    wx.ready(function () {
//        //分享朋友圈接口
//        wx.onMenuShareTimeline({
//            title: '九库文学 | 短言情一周精选！', // 分享标题
//            desc: '精选最新最热门的金牌短篇小说，每周更新，好书看不完', // 分享描述
//            link: "https://m.9kus.com/shortWeek/index/id/181003/op/10116", // 分享链接
//            imgUrl: 'https://img2.9kus.com/wap_9kus/new_wap/newzt/300.jpg?v=1234', // 分享图标
//            success: function () {
//                // 用户确认分享后执行的回调函数
//            },
//            cancel: function () {
//                // 用户取消分享后执行的回调函数
//            }
//        });
//        //分享给微信好友
//        wx.onMenuShareAppMessage({
//            title: '九库文学 | 短言情一周精选！', // 分享标题
//            desc: '精选最新最热门的金牌短篇小说，每周更新，好书看不完', // 分享描述
//            link: "https://m.9kus.com/shortWeek/index/id/181003/op/10116", // 分享链接
//            imgUrl: 'https://img2.9kus.com/wap_9kus/new_wap/newzt/300.jpg?v=1234', // 分享图标
//            success: function () {
//                // 用户确认分享后执行的回调函数
//            },
//            cancel: function () {
//                // 用户取消分享后执行的回调函数
//            }
//        });
//        //分享到QQ
//        wx.onMenuShareQQ({
//            title: '九库文学 | 短言情一周精选！', // 分享标题
//            desc: '精选最新最热门的金牌短篇小说，每周更新，好书看不完', // 分享描述
//            link: "https://m.9kus.com/shortWeek/index/id/181003/op/10116", // 分享链接
//            imgUrl: 'https://img2.9kus.com/wap_9kus/new_wap/newzt/300.jpg?v=1234', // 分享图标
//            success: function () {
//                // 用户确认分享后执行的回调函数
//            },
//            cancel: function () {
//                // 用户取消分享后执行的回调函数
//            }
//        });
//    });
</script>
</body>
</html>
@endsection