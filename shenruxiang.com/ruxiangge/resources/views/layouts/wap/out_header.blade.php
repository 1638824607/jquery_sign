<!DOCTYPE html>
<html lang="zh-cmn-Hans">
<head>
    <title>@yield('title')</title>
    <meta charset="utf-8" />
    <meta http-equiv="Cache-Control" content="no-transform" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <meta name="Baiduspider" content="noarchive" />
    <meta name="keywords" id="metakeywords" content="{{! empty($systemInfo->site_keyword) ? $systemInfo->site_keyword : ''}}" />
    <meta name="description" id="metadescription" content="{{! empty($systemInfo->site_desc) ? $systemInfo->site_desc : ''}}" />
    <meta name="renderer" content="webkit" />
    <meta name="viewport" content="initial-scale=1, maximum-scale=3, minimum-scale=1, user-scalable=no" />
    <meta name="apple-mobile-web-app-title" content="@yield('title')" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
    <meta name="format-detection" content="telephone=no" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="wap-font-scale" content="no" />
    <meta name="baidu-site-verification" content="nfZnnp6kHz" />
    <link type="text/css" rel="stylesheet" href="/wap/css/base.css" />
    <link rel="shortcut icon" href="/web_favicon.ico" type="image/x-icon">
    <script src="/wap/js/jquery-1.11.1.min.js" type="text/javascript"></script>
    <link type="text/css" rel="stylesheet" href="/wap/css/swiper.min.css" />
    <link type="text/css" rel="stylesheet" href="/wap/css/style.css" />
    <script type="text/javascript" src="/wap/js/swiper.min.js"></script>
    <script type="text/javascript" src="/wap/js/jquery.lazyload.js"></script>
    <script>
        var _hmt = _hmt || [];
        (function() {
            var hm = document.createElement("script");
            hm.src = "https://hm.baidu.com/hm.js?adf9ab711902bab54ace8ba275372637";
            var s = document.getElementsByTagName("script")[0];
            s.parentNode.insertBefore(hm, s);
        })();
    </script>
    <script>
        (function(){
            var bp = document.createElement('script');
            var curProtocol = window.location.protocol.split(':')[0];
            if (curProtocol === 'https') {
                bp.src = 'https://zz.bdstatic.com/linksubmit/push.js';
            }
            else {
                bp.src = 'http://push.zhanzhang.baidu.com/push.js';
            }
            var s = document.getElementsByTagName("script")[0];
            s.parentNode.insertBefore(bp, s);
        })();
    </script>
    <style>
        .footer-backtop-circle{
            position: fixed;
            z-index: 1;
            /*right:1 1rem;1*/
            bottom: 10rem;
            width: 2.75rem;
            height: 2.75rem;
            -webkit-transition: opacity .25s,visibility .25s;
            transition: opacity .25s,visibility .25s;
            color: #fff;
            border-radius: 99px;
            background-color: rgba(0,0,0,.6);
            opacity: 1;
            visibility: visible;
        }
        .btn-primary-circle {
            font-size: .8rem;
            line-height: 4;
            display: inline-block;
            box-sizing: border-box;
            width: 4.75rem;
            height: 4.75rem;
            padding: .5rem;
            text-align: center;
            color: #fff;
            border-radius: 99px;
            background-color: #ff5a4b;
        }
        .scroll-click{
            position: fixed;
            z-index: 1;
            right: 1rem;
            bottom: 1rem;
            width: 2.75rem;
            height: 2.75rem;
            -webkit-transition: opacity .25s,visibility .25s;
            transition: opacity .25s,visibility .25s;
            /*opacity: 0;*/
            color: #fff;
            border-radius: 99px;
            background-color: rgba(0,0,0,.6);
            opacity: 1;
            visibility: visible;
        }
    </style>

</head>
<body>
<!--内容区-->
<div class="newwap">
    <div class="readhd bg  clearfix">
        <div class="container index  clearfix">
            <span class="fl left">
                <a href="{{url('poly/book_list')}}" class="logo" title="入香阁">
                    <img src="/web/img/logo.png" /></a>
            </span>
            <span class="fl wh center"></span>
            <span class="fr right">
                @guest('wap')
                    <a href="{{url('signin')}}" class="xhome"><img src="/wap/img/nologin.png"></a>
                    <a href="{{url('poly/book_collect_list')}}" class="mbook">书架</a>
                    <a href="{{url('poly/outside_search')}}" class="msearch">搜索</a>
                @else
                    <a href="{{url('poly/user')}}" class="xhome">
                        <img src="{{empty(Auth::guard('wap')->user()->avatar) ? '/storage/user_avatar/default.png' : Auth::guard('wap')->user()->avatar}}" style="border-radius: 13px;" />
                    </a>
                    <a href="{{url('poly/book_collect_list')}}" class="mbook">书架</a>
                    <a href="{{url('poly/outside_search')}}" class="msearch">搜索</a>
                @endguest
            </span>
        </div>
    </div>
    <!--导航-->
    <b class="gray"></b>
    <div class="indexmenu bg clearfix ">
        <div class="mnx clearfix">
            <ul class="clearfix ">
                <li class="@if(mca()['action'] == 'book_list' || mca()['action'] == 'book_detail') active @endif"><a href="{{url('poly/book_list')}}">书单</a></li>
                <li class="@if(mca()['action'] == 'cate_list' || mca()['action'] == 'cate') active @endif"><a href="{{url('poly/cate_list')}}">分类</a></li>
                <li class="@if(in_array(mca()['action'], ['rank','rank_detail']) && (! empty($gender) && $gender == 'male')) active @endif"><a href="{{url('poly/rank/male')}}">男生榜</a></li>
                <li class="@if(in_array(mca()['action'], ['rank','rank_detail']) && (! empty($gender) && $gender == 'female')) active @endif"><a href="{{url('poly/rank/female')}}">女生榜</a></li>
            </ul>
        </div>
    </div>

    <a href="{{url('/')}}" class="footer-backtop-circle ">
        <span class="btn-primary-circle">本站</span>
    </a>

    <a href="javascript:void 0" class="scroll-click">
        <img class="scroll-img scroll-footer"  src="/wap/img/scroll_footer.png" alt="">
    </a>


    <script>
        $(window).scroll(function(){
            var before = $(window).scrollTop();
            $(window).scroll(function() {
                var after = $(window).scrollTop();
                if (before<after) {
                    $('.scroll-img').attr('src', '/wap/img/scroll_footer.png');
                    $('.scroll-img').removeClass('scroll-top').addClass('scroll-footer');
                    before = after;
                }
                if (before>after) {
                    $('.scroll-img').attr('src', '/wap/img/scroll_top.png');
                    $('.scroll-img').removeClass('scroll-footer').addClass('scroll-top');
                    before = after;
                }
            });
        });

        $(document).on('click', '.scroll-top', function()
        {
            $('html,body').animate({scrollTop: '0px'}, 800, function(){

                setTimeout(function () {
                    $('.scroll-img').attr('src', '/wap/img/scroll_footer.png');
                    $('.scroll-img').removeClass('scroll-top').addClass('scroll-footer');
                }, 200);

            });
        });

        $(document).on('click', '.scroll-footer', function()
        {
            $('html,body').animate({scrollTop:$('.footer').offset().top}, 800, function(){
                setTimeout(function () {
                    $('.scroll-img').attr('src', '/wap/img/scroll_top.png');
                    $('.scroll-img').removeClass('scroll-footer').addClass('scroll-top');
                }, 200);

            });
        });
    </script>