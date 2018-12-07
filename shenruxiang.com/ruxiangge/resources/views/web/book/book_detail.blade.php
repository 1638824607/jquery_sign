@extends('layouts.web.common')

@section('title', $bookRow['name'].'最新章节目录列表-入香阁-全本小说网')

@section('content')
    <link rel="stylesheet" type="text/css" href="/web/css/bookintro.css" />

    <div class="intro_content">
        <div class="container">

            <!--你所在的位置-->
            <a href="" name="book_info"></a>
            <div class="where">
                <a href="{{url('/')}}" title="首页">首页 </a>
                <b>&gt;</b>
                <a href="{{url('book_list/'.$bookReaderList[$bookRow['reader_type']]['id'])}}">{{$bookReaderList[$bookRow['reader_type']]['name']}}</a>
                <b>&gt;</b>
                <a href="{{url('book_list/0/'.$bookTypeList[$bookRow['type']]['id'])}}">{{$bookTypeList[$bookRow['type']]['name']}}</a>
                <b>&gt;</b>
                <a href="{{url('book_detail/'.$bookRow['id'])}}">{{$bookRow['name']}}</a>
            </div>
            <!--你所在的位置 end-->

            <div class="contents clearfix">
                <!--左边内容-->
                <div class="intro_left fl">
                    <div class="leftimg">
                        <a href="{{url('book_detail/'.$bookRow['id'])}}"><img style="width: 100%" src="{{$bookRow['cover']}}"/></a>
                    </div>
                    <!--评分-->
                    <div class="changeFixed">
                            <div class="bookInf_grade">
                                <div class="home_BPoint">
                                    <div class="home_BPointUp">
                                        {{$bookRow['rate']}}
                                    </div>
                                    <div class="home_BPointDown">
                                        评分
                                    </div>
                                </div>
                                <span class="gradeBlockWrap"><span class="gradeBlock" summary="0" indexnum="0"></span></span>
                                <span class="gradeBlockWrap"><span class="gradeBlock gradeBlockTwo" indexnum="0"></span></span>
                                <span class="gradeBlockWrap"><span class="gradeBlock gradeBlockTwo" indexnum="0"></span></span>
                                <span class="gradeBlockWrap"><span class="gradeBlock gradeBlockThree" indexnum="0"></span></span>
                                <span class="gradeBlockWrap"><span class="gradeBlock gradeBlockFour" indexnum="0"></span></span>
                            </div>
                        <!-- 阅读记录 -->
                        <div class="bookInfOperate_margin">
                            <a href="{{url('book_chapter_detail/0/'.$bookRow['id'])}}">
                                <div class="bookInfOperate worksInf">
                                    <div class="bookInfOperateLogo">
                                        <img src="/web/img/readGoon.png" alt="" class="readGoon" />
                                    </div> 开始阅读
                                </div></a>
                            <div class="bookInfOperate bookInfOperateBground2 addDetailCollect">


                                @empty($collectStatus)
                                    <div class="noIn collect-book no-add">
                                        <div class="bookInfOperateLogo bookInfOperateBground">
                                            <img src="/web/img/star.png" alt="" class="readGoon" />
                                        </div>
                                        <b>加入书架</b>
                                    </div>
                                    <div class="collect-book yes-add none" style="background:#ffdb6d none repeat scroll 0% 0%; color:#fff;">
                                        <div class="bookInfOperateLogo bookInfOperateBground">
                                            <img src="/web/img/starok.png" alt="" class="readGoon" />
                                        </div>
                                        <b>已入书架</b>
                                    </div>
                                @else
                                    <div class="noIn collect-book no-add none">
                                        <div class="bookInfOperateLogo bookInfOperateBground">
                                            <img src="/web/img/star.png" alt="" class="readGoon" />
                                        </div>
                                        <b>加入书架</b>
                                    </div>
                                    <div class="collect-book yes-add" style="background:#ffdb6d none repeat scroll 0% 0%; color:#fff;">
                                        <div class="bookInfOperateLogo bookInfOperateBground">
                                            <img src="/web/img/starok.png" alt="" class="readGoon" />
                                        </div>
                                        <b>已入书架</b>
                                    </div>
                                @endempty
                            </div>

                            <script>
                                var book_id = "{{$bookRow['id']}}";
                                var collectUrl = "{{url('book_collect')}}";

                                $('.collect-book').click(function(){
                                    $.ajax({
                                        type: "POST",
                                        url: collectUrl,
                                        data: {
                                            book_id:book_id
                                        },
                                        success: function (data) {
                                            if (data.status == 3) {
                                                $(".yes-add").removeClass('none');
                                                $(".no-add").addClass('none');
                                            }else if(data.status == 4){
                                                $(".no-add").removeClass('none');
                                                $(".yes-add").addClass('none');
                                            } else {
                                                $('.gray').show();
                                                $('.all_login').fadeIn(200);

                                            }
                                        }
                                    });
                                });
                            </script>
                        </div>
                        <!--作品信息-->
                        <div class="infos">
                            <a href="#book_info" class="bookInfNavWrap infos_one"> 作品信息 </a>
                            <a href="#book_dir" class="bookInfNavWrap infos_two "> 作品目录<span>{{count($chapterList)}}</span></a>
                        </div>
                    </div>
                    <!--评分 end-->
                </div>
                <div></div>
                <!--左边内容 end-->
                <!--中间内容区-->
                <div class="intro_center fl">
                    <h1><a href="" class="bookname_ch">{{$bookRow['name']}}</a><span>已完结</span></h1>
                    {{--<div class="shares fr clearfix">--}}
                        {{--<span class="share fr"><a href="javascript:;">分享</a></span>--}}
                        {{--<div class="shareot bdsharebuttonbox clearfix">--}}
                            {{--<a class="bds_qzone" href="#" data-cmd="qzone" title="分享到QQ空间"></a>--}}
                            {{--<a class="bds_weixin" href="#" data-cmd="weixin" title="分享到微信"></a>--}}
                            {{--<a class="bds_tsina" href="#" data-cmd="tsina" title="分享到新浪微博"></a>--}}
                            {{--<a class="bds_tieba" href="#" data-cmd="tieba" title="分享到百度贴吧"></a>--}}
                            {{--<a class="bds_sqq" href="#" data-cmd="sqq" title="分享到QQ好友"></a>--}}
                            {{--<a class="bds_douban" href="#" data-cmd="douban" title="分享到豆瓣网"></a>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    <div class="totals">
                        <a href="{{url('book_list/0/'.$bookTypeList[$bookRow['type']]['id'])}}" title="">{{$bookTypeList[$bookRow['type']]['name']}}</a>
                        <b>| </b>{{$bookRow['read_num']}}阅读
                        <b>| </b>{{$bookRow['word_count']}}万字
                        <b>| </b>{{$bookRow['updated_at']}}更新
                    </div>
                    <!--介绍内容-->
                    <div class="content">
                        <h2>作品简介</h2>
                        <p class="cons"><?php echo empty($bookRow['description']) ? '' : $bookRow['description'] ?></p>
                        <a href="" name="book_dir">&nbsp;</a>
                        {{--<a href="javascript:;" class="openall">[展开全部]</a>--}}
                    </div>
                    <!--推荐 end-->
                    <div class="book_catalogue" style="height:130px;">
                        <h2>最新章节</h2>
                        <ul>
                            @foreach($newChapterList as $newChapter)
                                <li><span class="sp1"></span><span class="sp2 word-wrap" style="text-align:left;width:220px;"><a title="{{$newChapter['name']}}" href="{{url('book_chapter_detail/'.$newChapter['id'].'/'.$bookRow['id'])}}">{{$newChapter['name']}}</a></span><span class="sp4 fr" style="width: 67px">{{date('Y-m-d', strtotime($newChapter['created_at']))}}</span></li>
                            @endforeach
                        </ul>
                    </div>
                    <!--最新章节-->
                    <div class="book_catalogue" style="height:130px;">
                        <h2>章节目录</h2>
                        <ul>
                            @foreach($chapterList as $chapter)
                                <li><span class="sp1"></span><span class="sp2 word-wrap" style="text-align:left;width:220px;"><a title="{{$chapter['name']}}" href="{{url('book_chapter_detail/'.$chapter['id'].'/'.$bookRow['id'])}}">{{$chapter['name']}}</a></span><span class="sp4 fr" style="width: 67px">{{date('Y-m-d', strtotime($chapter['created_at']))}}</span></li>
                            @endforeach

                        </ul>
                    </div>
                    <!--最新章节-->
                </div>
                <!--中间内容区 end-->
                <!--右边内容区-->
                <div class="intro_right fr">
                    <div class="users">
                        <div class="userbg">
                            <h2 class="clearfix grade1">
                                <span class="lefts fl">
                                    <a href="{{url('book_author/'. $bookRow['id']. '/' .$bookRow['author_name'])}}" target="_blank" class="grade">
                                        <img src="{{$bookRow['cover']}}" class="bd-radius50" alt="" />
                                    </a>
                                </span>
                                <span class="rights fl">
                                    <p>
                                        <b class="usauthor">小说作者</b>
                                        {{--<b class="augrade">小说作者</b>--}}
                                    </p>
                                    <a href="{{url('book_author/'. $bookRow['id']. '/' .$bookRow['author_name'])}}">
                                        {{$bookRow['author_name']}}
                                    </a>

                                </span>
                            </h2>
                        </div>
                    </div>
                    <br>
                    <br>
                    <!--用户信息 end-->
                    <div class="containers">
                        <!--其他作品-->
                        <!--其他作品 end-->
                        @if(! empty($authorBookList))
                            <div class="otherW clearfix">
                                <h2>
                                    作者其他作品
                                </h2>
                                @foreach($authorBookList as $authorBook)
                                    <div class="book clearfix">
                                        <span class="left fl">
                                            <a href="{{url('book_detail/'.$authorBook['id'])}}" target="_blank" title="{{$authorBook['name']}}">
                                                <img src="{{$authorBook['cover']}}" width="90" height="120">
                                            </a>
                                        </span>
                                        <span class="right fl">
                                            <h3 class="word-wrap">
                                                <a href="{{url('book_detail/'.$authorBook['id'])}}" target="_blank" class="bookname_ch">
                                                    {{$authorBook['name']}}
                                                </a>
                                            </h3>
                                            <p>
                                                <a href="{{url('book_detail/'.$authorBook['id'])}}" target="_blank" class="bookname_ch">
                                                    {{$authorBook['description']}}
                                                </a>
                                            </p>
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        <!--猜你喜欢-->
                        <div class="guess">
                            <h2>猜你喜欢</h2>
                            <ul>
                                @foreach($bookLikeList as $bookLikeRow)
                                    <li>
                                        <span class="left fl">
                                            <a href="{{url('book_detail/'.$bookLikeRow['id'])}}">
                                                <img src="{{$bookLikeRow['cover']}}" />
                                            </a>
                                        </span>
                                        <span class="right fl">
                                            <h3 class="word-wrap">
                                                <a href="{{url('book_detail/'.$bookLikeRow['id'])}}" class="bookname_ch">
                                                    {{$bookLikeRow['name']}}
                                                </a>
                                            </h3>
                                            <p>作者：
                                                <a class="author_ch" href="{{url('book_author/'. $bookLikeRow['id']. '/' .$bookLikeRow['author_name'])}}">
                                                    {{$bookLikeRow['author_name']}}
                                                </a>
                                            </p>
                                            <p class="word-wrap">{{$bookLikeRow['description']}}</p>
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <!--猜你喜欢 end-->
                    </div>
                </div>
                <!--右边内容区 end-->
            </div>
        </div>
        <!--内容区 end-->

        <script>
            $(function() {
                //左右高度
                var BHeight = $('body').height() + '100%';
                var LHeight = $('.intro_left').height();
                var CHeight = $('.intro_center').height();
                $('.intro_left,.intro_center,.intro_right').css('height', BHeight);


                //简介左边滚动
                $(window).scroll(function () {
                    height = $(window).scrollTop();
                    //滚动后导航固定//简介页面
                    if (height >= 400) {
                        $('.changeFixed').css({'position': 'fixed', 'top': '50px'}).addClass("animated fadeInDown");
                    } else {
                        $('.changeFixed').css({'position': 'relative', 'top': '0'}).removeClass("animated fadeInDown");
                    };

                    if (height >= 600) {
                        $('.hearten .hleft em').addClass("animated fadeInDown");
                    } else {
                        $('.hearten .hleft em').removeClass("animated fadeInDown");
                    };

                });

                //作品信息
                var bookInfNavWrap = $('.bookInfNavWrap');

                bookInfNavWrap.each(function (index, element) {
                    $(element).on({
                        mouseenter: function () {
                            if (index == 0) {
                                $(this).css({
                                    'background': 'url(/web/img/infIcon33.png) no-repeat center left',
                                    'color': '#fd7b48'
                                })
                            }
                            if (index == 1) {
                                bookInfNavWrap.eq(0).removeClass('infos_one_ac01');
                                $(this).css({
                                    'background': 'url(/web/img/infIcon11.png) no-repeat center left',
                                    'color': '#fd7b48'
                                })
                            }
                            if (index == 2) {
                                bookInfNavWrap.eq(0).removeClass('infos_one_ac01');
                                $(this).css({
                                    'background': 'url(/web/img/infIcon22.png) no-repeat center left',
                                    'color': '#fd7b48'
                                })
                            }
                        }, mouseleave: function () {
                            if (index == 0) {
                                $(this).css({
                                    'background': 'url(/web/img/infIcon3.png) no-repeat center left',
                                    'color': '#3c3c3c'
                                })
                                bookInfNavWrap.eq(0).addClass('infos_one_ac01');
                            }
                            if (index == 1) {
                                $(this).css({
                                    'background': 'url(/web/img/infIcon1.png) no-repeat center left',
                                    'color': '#3c3c3c'
                                });
                                bookInfNavWrap.eq(0).addClass('infos_one_ac01');

                            }
                            if (index == 2) {
                                $(this).css({
                                    'background': 'url(/web/img/infIcon2.png) no-repeat center left',
                                    'color': '#3c3c3c'
                                });
                                bookInfNavWrap.eq(0).addClass('infos_one_ac01');
                            }
                        }
                    });
                })

                // 分享按钮
                $('.intro_center .shares .share').on({
                    mouseenter: function () {
                        $('.intro_center .shareot').fadeIn(200);
                    }
                })

                //关闭分享
                $('.intro_center .shareot').on({
                    mouseleave: function () {
                        $(this).fadeOut(200);
                    }
                })

                //简介截取字数
                var contentP = $(".intro_center  .content .cons");
                var openall = $('.intro_center  .content .openall');

                if (contentP.height() > 162) {
                    openall.show();
                }
            });
        </script>
        <script>
            $('#metakeywords').attr('content', "{{$bookRow['name']}},{{$bookRow['name']}}最新章节免费阅读");
            $('#metadescription').attr('content', "{{$bookRow['name']}}最新章节由网友提供,《{{$bookRow['name']}}》情节跌宕起伏、扣人心弦,是一本情节与文笔俱佳的{{$bookTypeList[$bookRow['type']]['name']}},入香阁免费提供{{$bookRow['name']}}最新清爽干净的文字章节在线免费阅读。");
        </script>
    </div>
@endsection
