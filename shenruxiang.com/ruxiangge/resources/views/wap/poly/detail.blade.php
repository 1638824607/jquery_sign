@extends('layouts.wap.common_no_footer')

@section('title', $bookRow['title'].'最新章节列表-入香阁')

@section('content')
    <style>
        .book-read{
            background: url(/wap/img/boy_1.png) no-repeat left 6px;
            background-size: auto 80%;
            padding: 8px 0 5px 30px !important;
            margin-top:5px;
        }
        .book-collect{
            background: url(/wap/img/boy_3.png) no-repeat left 6px;
            background-size: auto 80%;
            padding: 8px 0 5px 30px !important;
        }

    </style>
    <div class="newwap">
        <div class="bookinfo bg clearfix">
            <div class="bookinfo bg clearfix">
                <div class="book_info clearfix">
                    <div class="clearfix blurs">
                        <div class="myblur">
                            {{--<img src="" id="blur" class="blur" />--}}
                        </div>
                        <div class="info_left fl">
                            <img src="{{config('app.static_url').$bookRow['cover']}}" alt="" />
                        </div>
                        <div class="info_right fl ">
                            <h2>{{$bookRow['title']}}</h2>
                            <p class="au">{{$bookRow['author']}}</p>
                            <p>{{$bookRow['majorCate']}} | {{ceil($bookRow['wordCount']/10000)}}万字 | {{empty($bookRow['isSerial']) ? '连载' : '完结'}}</p>
                            <p class="book-read"><span>{{$bookRow['latelyFollower']}}</span></p>
                            <p class="book-collect"><span>{{floor($bookRow['latelyFollower'] * $bookRow['retentionRatio']/100)}}</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bookinfo infob  bg clearfix">
            <div class="container clearfix">
                <div class="book_info clearfix">
                    <div class="intro  ">
                        <a href="{{empty($readChapterTitle) ? 'javascript:void 0' : url('poly/content/'.$readChapterId.'/'.$bookRow['_id'])}}" class="readhistry"><b>最近阅读</b>
                            {{empty($readChapterTitle) ? '暂无阅读记录' : $readChapterTitle}}
                        </a>
                        <h2 class="infoh2">简介</h2>
                        <div class="con ">
                            <div class="con_con">
                                {{$bookRow['longIntro']}}
                            </div>
                            <a href="javascript:;" class="downshow"></a>
                        </div>
                    </div>
                    <!--介绍 end-->
                    <!--目录-->
                    <div class="catalog ">
                        <h2 class="clearfix"><b>目录</b><a href="{{url('poly/dir/'.$bookRow['_id'])}}" title=" ">{{$bookRow['lastChapter']}}</a><em> {{date('m-d', strtotime($bookRow['updated']))}}更新</em></h2>
                    </div>
                    <!--目录 end-->
                </div>
            </div>
        </div>
        <style>
            .girlx .book-author {
                color: #0d0d0d;
                padding: 5px 0 4px 28px;
                font-weight: 600;
                background: url(/wap/img/boy_0.png) no-repeat left 6px;
                background-size: auto 80%;
            }

            .girlx .book-like {
                color: #0d0d0d;
                padding: 5px 0 4px 28px;
                font-weight: 600;
                background: url(/wap/img/boy_1.png) no-repeat left 6px;
                background-size: auto 80%;
            }
        </style>
    <!--模块-->
        <div class="comment clearfix bg">
            <div class="container clearfix">
                <div class="entime clearfix girlx">
                    <h3 class="book-author">本书作者</h3>
                </div>
                <div class="rows">
                    <div class="utit">
                        <a href="{{url('poly/author/' .$bookRow['author'])}}" style="display: block">
                            <img style="float: left;" src="{{config('app.static_url').$bookRow['cover']}}" />
                            <div class="book-detail-cell">
                                <div class="book-title-x">
                                    <h4 class="book-detail-title">{{$bookRow['author']}}</h4>
                                </div>
                                <p class="book-desc">作品数：{{$responseAuthorCount or 0}}</p>
                            </div>
                            <img class="book-detail-jiantou" style="float: right;width: 1rem;height:1.5rem;top:2.5rem" src="/wap/img/contmr.png" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="model aboutbk bg clearfix">
            <div class="container girlx">
                <h2 class="book-like">猜你喜欢</h2>
                <ul class="blist clearfix">
                    @foreach($likeBookList as $bookLikeRow)
                        <li><a style="text-align: center" href="{{url('poly/detail/'.$bookLikeRow['_id'])}}" title=""><img style="max-height: 133.63px" src="{{config('app.static_url').$bookLikeRow['cover']}}" alt="" /><h3>{{$bookLikeRow['title']}}</h3></a></li>
                    @endforeach
                </ul>
            </div>
        </div>
        <!--模块 end-->
        <div class="infobtns">
            <a href="{{url('book_history')}}" class="fl expedite"><i></i>阅读历史</a>
            <a href="{{url('poly/content/0'.'/'.$bookRow['_id'])}}" class="fl readgo">立即阅读</a>
            @if(! empty($collectStatus))
                <a class="fl addbook addfavok"><i></i>撤出书架</a>
            @else
                <a class="fl addbook"><i></i>加入书架</a>
            @endif
        </div>
</div>

<script type="text/javascript" src="/web/lib/layer/mobile/layer.js"></script>
<script type="text/javascript">
    var bookCollectUrl = "{{url('poly/collect')}}";
    var signinUrl = "{{url('signin')}}";
    var bookId = "{{$bookRow['_id']}}";
    var clickStatus = true;
    //简介展开
    $('.book_info .downshow').on('click',function(){
        $('.book_info .intro .con_con').toggleClass('show');
        $(' .book_info .downshow').toggleClass('downxs');
    });
    //加入书架
    $('.infobtns .addbook').on('click',function(){
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

    });
</script>
</body>
</html>
    <script>
        $('#metakeywords').attr('content', "{{$bookRow['title']}},{{$bookRow['title']}}最新章节免费阅读");
        $('#metadescription').attr('content', "{{$bookRow['title']}}最新章节由网友提供,《{{$bookRow['title']}}》情节跌宕起伏、扣人心弦,是一本情节与文笔俱佳的{{$bookRow['majorCate']}},入香阁免费提供{{$bookRow['title']}}最新清爽干净的文字章节在线免费阅读。");
    </script>
@endsection
