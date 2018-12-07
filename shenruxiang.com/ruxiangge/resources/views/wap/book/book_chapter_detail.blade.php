<!DOCTYPE html>
<html lang="zh-cmn-Hans">
<head>
    <title>{{$chapterRow['name']}}-{{$bookRow['name']}}-入香阁</title>
    <meta charset="utf-8" />
    <meta http-equiv="Cache-Control" content="no-transform" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <meta name="Baiduspider" content="noarchive" />
    <meta name="keywords" content="{{$chapterRow['name']}},{{$bookRow['name']}}" />
    <meta name="description" content="{{$bookRow['name']}}最新章节{{$chapterRow['name']}}免费阅读" />
    <meta name="renderer" content="webkit" />
    <meta name="viewport" content="initial-scale=1, maximum-scale=3, minimum-scale=1, user-scalable=no" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
    <meta name="format-detection" content="telephone=no" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <link rel="shortcut icon" href="/web_favicon.ico" type="image/x-icon">
    <meta name="wap-font-scale" content="no" />
    <link type="text/css" rel="stylesheet" href="/wap/css/base.css" />
    <script src="/wap/js/jquery-1.11.1.min.js" type="text/javascript"></script>

    <!--头部推荐-->
    <!--头部推荐end-->
    <link type="text/css" rel="stylesheet" href="/wap/css/style.css" />
    <!--引导提示-->
    <script type="text/javascript" src="/wap/js/newwap.js"></script>
    <script type="text/javascript" src="/wap/js/jquery.cookie.js"></script>
    <script type="text/javascript">
        var readClx =  $.cookie('readColor');
        var FontSX =  $.cookie('fontsize');
        var FontABC,H1Font = 16
        if(FontSX == null || FontSX== undefined ){
            FontSX = 20;
        }else{

            if(FontSX == '30'){
                FontABC = 0;
                H1Font = 20;
            }else if(FontSX == '20'){
                FontABC = 1;
                H1Font = 16;
            }else if(FontSX == '16'){
                FontABC = 2;
                H1Font = 14;
            }
            FontSX = $.cookie('fontsize');
        }
    </script>
</head>
<body class="readbg">
<!--内容区-->
<div class="newwap read ">
    <div class="readhd clearfix">
        <div class="clearfix top">
            <div class="container clearfix">
                <span class="fl left"><a href="{{url('book_detail/'.$chapterRow['book_id'])}}" class="backgo" title="入香阁">入香阁</a></span>
                <span class="fl wh center"></span>
                <span class="fr right"><a class="home">更多</a><a class="editmb">设置</a>
                    <!--工具栏 -->
       <div class="moremenu">
        <div class="container">
         <a href="{{url('/')}}" class="m01">首页</a>
         <a href="{{url('book_category')}}" class="m02">分类</a>
         <a href="{{url('book_rank')}}" class="m03">排行</a>
         <a href="{{url('book_collect_list')}}" class="m04">书架</a>
        </div>
       </div>
                    <!--工具栏 end--></span>
            </div>
        </div>
    </div>
    <div class="readcont clearfix ">
        <div class="container clearfix">
            <div class="bigfontx" data-rel="{{$chapterRow['id']}}">
                <div class="model0">
                    <div class="mdxx">
                        <h1 class="mdxx-title">{{$chapterRow['name']}}</h1>
                    </div>
                    <div class="con_tent">
                        <?php echo empty($chapterContent) ? '' : $chapterContent ?>
                    </div>
                </div>
            </div>
            <div class="addload">
                <div class="sayword">正在加载下一章</div>
            </div>
        </div>
    </div>
    <script>
        $('.readcont ').css({'font-size':FontSX+'px'});
        $('.mdxx ').css({ 'font-size':H1Font+'px' });
    </script>
    <!--工具栏-->
    <div class="readtool updown">
        <div class="container">
            <div class="first">
                <div class="moretool">
                    <a href="{{url('book_chapter_detail/'.$chapterFirstId.'/'.$chapterRow['book_id'])}}" class="m1 fl">上一章</a>
                    <a href="{{url('book_dir/'.$chapterRow['book_id'])}}" class="m2 fl">目录</a>
                    <a href="{{url('book_chapter_detail/'.$chapterLastId.'/'.$bookRow['id'])}}" class="m3 fl">下一章</a>
                </div>
            </div>
        </div>
    </div>
    <div class="readtool settingx ">
        <div class="container">
            <div class="moret">
                <div class=" left clearfix">
                    <span class="fl xl ">字体大小</span>
                    <span class="fl xr"><b class="fonts fl">大</b><b class="fontn fl active">中</b><b class="fontb fl">小</b></span>
                </div>
                <div class=" right clearfix">
                    <span class="fl xl ">背景颜色</span>
                    <span class="fl xr"><b class="fl active"><em class="cl0"></em>白天</b><b class="fl "><em class="cl1"></em>夜晚</b><b class="fl"><em class="cl2"></em>护眼</b></span>
                </div>
            </div>
        </div>
    </div>
    <!--添加收藏-->
    @if($collectStatus)
        <a class="addfav addfavok">撤出书架</a>
    @else
        <a class="addfav">加入书架</a>
    @endif
    <!--添加收藏 end-->
</div>
<!--引导提示-->
<div class="tipsalert">
    <div class="tipxx tipxx01"></div>
    <div class="tipxx tipxx02"></div>
    <div class="tipxx tipxx03"></div>
    <div class="tipxx tipxx04"></div>
</div>
<!--百度站长统计-->
<div style="display:none;">

</div>
<script type="text/javascript">    //判断是否同时登录
    var bookCollectUrl = "{{url('book_collect')}}";
    var bookId = "{{$bookRow['id']}}";
    var clickStatus = true;

    //收藏
    $('.addfav').on('click',function(){
        var obj = $(this);
        if(clickStatus)
        {
            clickStatus = false;

            $.ajax({
                type: "POST",
                url: bookCollectUrl,
                async: false,
                cache:false,
                data: {
                    book_id:bookId
                },
                success: function(data){
                    clickStatus = true;

                    if(data.status === 3){
                        obj.addClass('addfavok').html('<i></i>撤出书架');
                    }else if(data.status === 4){
                        obj.removeClass('addfavok').html('<i></i>加入书架');
                    }else{
                        window.location.href=signinUrl;
                    }
                }
            });
        }
    })

    // 屏蔽右键
    $(document).bind("contextmenu",function(e){return false;});
    $(document).bind("selectstart",function(){return false;});
    $(document).keydown(function(e){
        if(e.keyCode==116){
            return true;
        }else{
            return false;
        }
    });


    $('.read').addClass(readClx);
    var Bac = 0;
    if(readClx == 'readc0'){
        Bac = 0;
    }else if(readClx == 'readc1'){
        Bac = 1;
    }else if(readClx == 'readc2'){
        Bac = 2;
    }

    $('.readtool .left .xr b').eq(FontABC).addClass('active').siblings().removeClass('active');
    $('.readtool .right .xr b').eq(Bac).addClass('active').siblings().removeClass('active');

    //点击页面关闭
    $('.readcont').on('click',function(){
        $('.updown,.readhd,.read .addfav').toggle();
        $('.updown .first ').show();
        $('.settingx,.moremenu').hide();
        //  IsSc = true;
    });
    var IsSc = true;

    //更多设置
    $('.readhd .editmb').on('click',function(){
        IsSc = false;
        $('.settingx').show();
        $('.moremenu').hide();
    });
    //更多栏目
    $('.readhd .home').on('click',function(){
        IsSc = false;
        $('.moremenu').show();
        $('.settingx').hide();
    });
    //字体
    //var  fonts = 30,endFont;
    $('.readtool .left .xr b').on('click',function(){
        IsSc = false;
        var Index = $(this).index();
        if(Index ==0){
            FontSX = 30;
            H1Font = 20;
        }else if(Index ==1){
            FontSX = 20;
            H1Font = 16;
        }else{
            FontSX = 16;
            H1Font = 14;
        }
        $('.readcont ').css({
            'font-size':FontSX+'px',
        });
        $('.mdxx ').css({
            'font-size':H1Font+'px',
        });
        //  endFont = FontSX/22.5;
        // $('.readcont p').css({
        //     'font-size':endFont+'rem',
        //     'line-height':endFont*2+'rem',
        // });
        //    $('.readcont h1').css({
        //     'font-size':endFont*0.8+'rem',
        // });
        $(this).addClass('active').siblings().removeClass('active');
        $.cookie('fontsize',FontSX,{expires:30,path:'/'});
    });
    //加载后设置字体
    function setFont(){
        $('.readcont ').css({
            'font-size':FontSX+'px',
        });

        $('.mdxx ').css({
            'font-size':H1Font+'px',
        });
    }
    var appzj = Mornum = 0;
    var isGo = true;
    var STH,ContH,DocH,WinH;

    //滚动关闭  、无限加载
    $(window).scroll(function(){
        STH = $(window).scrollTop();
        ContH = $('.readcont .model0').height();
        DocH = $(document).height();
        WinH = $(window).height() ;
        if(IsSc){
            IsSc = true;
            if(STH<=0){
                $('.updown,.readhd,.read .addfav').show();
            }else{
                $('.readtool,.readhd,.read .addfav').hide();
            }
        }

        if(isGo){
            if(DocH -(STH+WinH) <= 3){
                isGo = false;
                $('.addload').show();
                var chapter_id = $('.bigfontx').attr('data-rel');
                if(chapter_id>0){
                    var book_id  ="{{$chapterRow['book_id']}}";
                    $.ajax({
                        type: "POST",
                        url: "{{url('book_chapter_detail_load')}}",
                        data: {id:chapter_id,bookid:book_id},
                        dataType:'json',
                        success: function(data){
                            var html = '';
                            if(data.status == 2)
                            {
                                setTimeout(function(){
                                    isGo = true;

                                    html = '<div class="model0"><div class="mdxx"><h1 class="mdxx-title">'+data.data.chapterNextRow.name+'</h1>' +
                                        '</div><div class="con_tent">'+data.data.chapterContent+'</div></div>';

                                    $('.bigfontx').append(html);
                                    $('.bigfontx').attr('data-rel',data.data.chapterNextRow.id);
                                    $('.addload').hide();
                                    setFont();
                                },600);
                            }else if(data.status == 3){
                                isGo = false;
                                setTimeout(function(){
                                    html = '<div class="model0"><div class="otbookx"><h3 class="writes"><b class="penxend"></b><br><span>本书已完结</span></h3></div></div>';

                                    $('.bigfontx').append(html);
                                    $('.addload').hide();
                                    setFont();
                                },600);
                            }


                        }
                    });
                }
            }
        }
    });

    //切换阅读背景
    $('.readtool .right .xr b').on('click',function(){
        var Indx = $(this).index();
        var Rels;
        $(this).addClass('active').siblings().removeClass('active');
        $('.read').removeClass('readc0 readc1 readc2');
        if(Indx == 0){
            Rels = 'readc0';
            $('.read').addClass(Rels);
        }else if(Indx == 1){
            Rels = 'readc1';
            $('.read').addClass(Rels);
        }else if(Indx == 2){
            Rels = 'readc2';
            $('.read').addClass(Rels);
        }

        $.cookie('readColor',Rels,{expires:30,path:'/'});
    });

    //引导提示
    $('.tipsalert .tipxx01').on('click',function(){
        $('.tipsalert .tipxx').hide();
        $('.tipsalert .tipxx02').show();
    });
    $('.tipsalert .tipxx02').on('click',function(){
        $('.tipsalert .tipxx').hide();
        $('.tipsalert .tipxx03').show();
    });
    $('.tipsalert .tipxx03').on('click',function(){
        $('.tipsalert .tipxx').hide();
        $('.tipsalert .tipxx04').show();
    });
    $('.tipsalert .tipxx04').on('click',function(){
        $.cookie('first_read_tips',1,{expires:1,path:'/'});
        $('.tipsalert ').hide();
    });

</script>
</body>
</html>