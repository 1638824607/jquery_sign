@extends('layouts.web.common')

@section('title', '入香阁-全本小说网')

@section('content')
    <link rel="stylesheet" type="text/css" href="/web/css/common.css" />
<!--导航  end-->
<!--登录提示-->
<!--登录提示 end-->
<!--通用头部 end-->
<!--第一屏-->
<div class="new_model1 clearfix">
    <div class="container clearfix">
        <!--左边-->
        <div class="fl new_left bbox">
            <div class="ngirl">
                <a href="javascript:void(0)"><h1><b>热门分类</b></h1></a>
                <div class="boycat scats clearfix" style="margin-top:30px;margin-left:10px">
                    @foreach($bookTypeList as $bookType)
                        <a href="{{url('book_list/0/'.$bookType['id'])}}" title="{{$bookType['name']}}">{{$bookType['name']}}<b></b></a>
                    @endforeach
                </div>
            </div>

        </div>
        <!--左边 end-->
        <!--中间-->
        <div class="fl new_center bbox">
            <div id="box" class="newbox">
                <pre class="prev">prev</pre>
                <pre class="next">next</pre>
                <ul>
                    @foreach($rankData['bookCarouselList'] as $bookRow)
                        <li>
                            <a href="{{url("book_detail/" . $bookRow['id'])}}" target="_blank">
                                <img src="{{$bookRow['cover']}}" />
                                <h2>
                                    {{$bookRow['author_name']}}&nbsp;
                                    <img src="/web/img/pen.png" style="width: 13px;display: none;"/>
                                </h2>
                                <h1>{{$bookRow['name']}}</h1>
                                <h3>
                                    <b>{{$bookTypeList[$bookRow['type']]['name']}}</b>
                                </h3>
                                <p>{{str_replace('<br>', '', $bookRow['description'])}}</p>
                                <em class="bookend"></em>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <!--中间 end-->
        <!--右边-->
        <div class="fl new_right bbox">
            <h1 title=""><em>&nbsp;</em><span class="fr hotpic"><b class="active">日</b><b>月</b><b>总</b></span></h1>
            <ul class="rightul block">
                @foreach($rankData['bookReadDayRankList'] as $bookRow)
                    <li class="r{{$loop->iteration}}"><a href="{{url('book_detail/'.$bookRow['id'])}}" title="{{$bookRow['name']}}"><b>{{$loop->iteration}}</b>{{$bookRow['name']}}</a></li>
                @endforeach
            </ul>
            <ul class="rightul">
                @foreach($rankData['bookReadWeekRankList'] as $bookRow)
                    <li class="r{{$loop->iteration}}"><a href="{{url('book_detail/'.$bookRow['id'])}}" title="{{$bookRow['name']}}"><b>{{$loop->iteration}}</b>{{$bookRow['name']}}</a></li>
                @endforeach
            </ul>
            <ul class="rightul ">
                @foreach($rankData['bookReadMonthRankList'] as $bookRow)
                    <li class="r{{$loop->iteration}}"><a href="{{url('book_detail/'.$bookRow['id'])}}" title="{{$bookRow['name']}}"><b>{{$loop->iteration}}</b>{{$bookRow['name']}}</a></li>
                @endforeach
            </ul>
        </div>
        <!--右边 end-->
    </div>
</div>
<!--第一屏 end-->

<!--第二频-->
<br>
<div class="new_model2 clearfix">
    <div class="container clearfix">
        <h1 class="clearfix"><em></em><span class="fr">
            </span></h1>
        <!--new2_push-->
        <div class="new2_push bbox clearfix">
            <div class="shadows"></div>
            <!--左-->
            @foreach($rankData['bookRecommendList'] as $bookRow)
                <div class="fl new2_list bbox">


                        <div class="clearfix new264">
                            <div class="new2img fl">
                                <a href="{{url('book_detail/'.$bookRow['id'])}}" target="_blank"><img src="{{$bookRow['cover']}}" /></a>
                            </div>
                            <div class="new2cont fl">
                                <h2 class="clearfix"><a href="{{url('book_detail/'.$bookRow['id'])}}" title="{{$bookRow['name']}}" target="_blank">{{$bookRow['name']}}</a></h2>
                                <h3><b>{{$bookRow['type']}}</b><em class="fr">{{$bookRow['author_name']}}</em></h3>
                                <p style="text-overflow:ellipsis;overflow:hidden;display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;">{!! $bookRow['description'] !!}</p>
                                <h4><a href="{{url('book_detail/'.$bookRow['id'])}}" title="{{$bookRow['name']}}" target="_blank">阅读</a></h4>
                            </div>
                        </div>

                        <div class=" clearfix new236">
                            <ul>
                                @foreach($bookRow['child'] as $book)
                                    <li>
                                        <a style="text-overflow:ellipsis;overflow:hidden;display:-webkit-box;-webkit-line-clamp:1;-webkit-box-orient:vertical;white-space:pre;line-height: 30px" href="{{url('book_detail/'.$book['id'])}}" target="_blank"><b>[{{$book['type']}}]</b>{!! $book['description'] !!}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                </div>
            @endforeach

            <!--左 end-->
            <!--左-->

            <!--左 end-->
        </div>
        <!--new2_push end-->
        <!--广告-->
        <br />
        <!--广告 end-->
        <!--分类-->
        <div class="newincat clearfix">
            @foreach($rankData['bookCategoryList'] as $bookType => $bookList)
                @if($loop->iteration < 6)
                    <div class="newcats bbox cat">
                        <a href="{{url('book_list/0/'.$bookType)}}"><h2>{{$bookTypeList[$bookType]['name']}}<em>小说</em><b></b></h2></a>
                        <ul>
                            @foreach($bookList as $key => $bookRow)
                                @if($key == 0)
                                <li class="catone"><a href="{{url('book_detail/'.$bookRow['id'])}}" title="" target="_blank"><span class="fl cleft"><img src="{{$bookRow['cover']}}" alt="" /></span><span class="fl cright"><h3>{{$bookRow['name']}}</h3><p><em>{{$bookRow['author_name']}}</em></p></span></a></li>
                                @else
                                <li><a href="{{url('book_detail/'.$bookRow['id'])}}" title="" target="_blank"><b></b>{{$bookRow['name']}}</a></li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                @endif
            @endforeach

        </div>
        <!--分类 end-->
    </div>
</div>
<!--第二频 end-->
<!--广告-->
<br>
<br>
<br>
<br>

{{--<div class="newads">--}}
    {{--<div class="container">--}}
        {{--<a href="https://www.9kus.com/Book/detail/book_id/42744" title="" target="_blank"><img src="https://img.9kus.com/Images/42/5b7d295ad1ae2.jpg" alt="" data-recommendid="162003" /></a>--}}
    {{--</div>--}}
{{--</div>--}}


<!--广告 end-->
<!--第三屏-->
<div class="new_model3 clearfix">
    <div class="container clearfix">
        <!--左边-->
        <div class="fl new3_left bbox">
            <h1><b>HOT</b>当红文 <em></em></h1>
            <ul>
                @foreach($rankData['bookHotList'] as $bookRow)
                    <li><a href="{{url('book_detail/'.$bookRow['id'])}}"><span class="fl mleft">{{$bookRow['name']}}</span><span class="fl mright">{{$bookRow['author_name']}}</span></a>
                    </li>
                @endforeach
            </ul>
        </div>
        <!--左边 end-->
        <!--中间-->
        <div class="fl new3_center bbox">
            <h1><em></em>网友热搜<b></b></h1>
            <div class="cbanber">
                <div id="boxs">
                    <div id="list">
                        <ul>
                            @foreach($rankData['bookHotSearchList'] as $bookRow)
                                <li>
                                    <a href="{{url('book_detail/'.$bookRow['id'])}}" title="{{$bookRow['name']}}" target="_blank">
                                        <img src="{{$bookRow['cover']}}" />
                                        <div class="opa"></div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                        <a href="javascript:;" class="prev"></a>
                        <a href="javascript:;" class="next"></a>
                    </div>
                </div>
                <div id="top">
                    <div class="small">
                        <ul>

                            @foreach($rankData['bookHotSearchList'] as $key => $bookRow)
                                <li class="@if($key == 0) hove @endif">
                                    <div class="cont">
                                        <a href="{{url('book_detail/'.$bookRow['id'])}}" target="_blank">继续阅读</a>
                                        <span class="fl contleft"><h4>{{$bookRow['name']}}</h4><p style="text-overflow:ellipsis;overflow:hidden;display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;">
                                                {!! $bookRow['description'] !!}
                                            </p></span>
                                        <span class="fl contright"><h2><span class="fl ping"><b></b></span><span class="fl newload" data-rel="95"><em></em></span></h2><h3><span class="fl hots"><b></b></span><span class="fl newloadb" data-rel="95"><em></em></span></h3></span>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!--中间 end-->
        <!--右边-->
        <div class="fl new3_left bbox">
            <h1><b>NEW</b>今日推荐<em></em></h1>
            <ul>
                @foreach($rankData['bookTodayRecommendList'] as $bookRow)
                    <li><a href="{{url('book_detail/'.$bookRow['id'])}}"><span class="fl mleft">{{$bookRow['name']}}</span><span class="fl mright">{{$bookRow['author_name']}}</span></a></li>
                @endforeach
            </ul>
        </div>
        <!--右边 end-->
    </div>
</div>
<!--第三屏 end-->
<!--广告-->

<br>
<br>

{{--<div class="newads">--}}
    {{--<div class="container">--}}
        {{--<a href="https://www.9kus.com/Activity/zhengdun" title="" target="_blank"><img src="https://img.9kus.com/Images/03/5b237c2b76a64.jpg" alt="" data-recommendid="154112" /></a>--}}
    {{--</div>--}}
{{--</div>--}}


<!--广告 end-->
<!--第四屏-->
<div class="new_model4">
    <div class="container clearfix">
        <div class="boys girls clearfix">
            <!--左边-->
            <div class="new4_left bbox fl">
                <h1 class="clearfix"><em></em><span class="fr">
                    </span></h1>
                <div class="new_row clearfix">
                    <!--块-->
                    @foreach($rankData['bookWomanRecommendList'] as $bookRow)
                        <div class="fl row_left">
                                <div class="clearfix">
                                    <span class="fl spleft"><a href="{{url('book_detail/'.$bookRow['id'])}}" title="" target="_blank"><img height="213px" src="{{$bookRow['cover']}}" alt="" /></a></span>
                                    <span class="fl spright"><h2 class="clearfix"><a href="{{url('book_detail/'.$bookRow['id'])}}" title="" target="_blank">{{$bookRow['name']}}</a></h2><h3><b>{{$bookTypeList[$bookRow['type']]['name']}}</b><em class="fr">{{$bookRow['author_name']}}</em></h3><p style="text-overflow:ellipsis;overflow:hidden;display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;">{!! $bookRow['description'] !!}</p><h4><a href="{{url('book_detail/'.$bookRow['id'])}}" title="" target="_blank">阅读</a></h4></span>
                                </div>
                                <!--子列表-->
                                <div class="childlist">
                                    <ul>
                                        @foreach($bookRow['child'] as $bookChildRow)
                                            <li><a style="overflow: hidden;white-space: nowrap;text-overflow: ellipsis;" href="{{url('book_detail/'.$bookChildRow['id'])}}" title="" target="_blank" data-recommendid="161255"><b>[{{$bookTypeList[$bookChildRow['type']]['name']}}]</b>{{$bookChildRow['name']}}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            <!--子列表 end-->
                        </div>
                    @endforeach
                    <!--块 end-->
                </div>
            </div>
            <!--左边 end-->
            <!--右边-->
            <div class="new4_right bbox fl">
                <div class="new_right">
                    <h1 title="连载热文榜"><em style="margin-left: -15px;">&nbsp;</em><span class="fr hotpic"><b class="active">日</b><b>月</b><b>总</b></span></h1>
                    <ul class="rightul block">
                        @foreach($rankData['bookWomanReadDayRankList'] as $bookRow)
                            <li class="r{{$loop->iteration}}"><a href="{{url('book_detail/'.$bookRow['id'])}}" title="{{$bookRow['name']}}"><b>{{$loop->iteration}}</b>{{$bookRow['name']}}</a></li>
                        @endforeach
                    </ul>
                    <ul class="rightul ">
                        @foreach($rankData['bookWomanReadWeekRankList'] as $bookRow)
                            <li class="r{{$loop->iteration}}"><a href="{{url('book_detail/'.$bookRow['id'])}}" title="{{$bookRow['name']}}"><b>{{$loop->iteration}}</b>{{$bookRow['name']}}</a></li>
                        @endforeach
                    </ul>
                    <ul class="rightul ">
                        @foreach($rankData['bookWomanReadMonthRankList'] as $bookRow)
                            <li class="r{{$loop->iteration}}"><a href="{{url('book_detail/'.$bookRow['id'])}}" title="{{$bookRow['name']}}"><b>{{$loop->iteration}}</b>{{$bookRow['name']}}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <!--右边 end-->
        </div>
        <br>
        <div class="boys clearfix">
            <!--左边-->
            <div class="new4_left bbox fl">
                <h1 class="clearfix"><em></em><span class="fr">
                    </span></h1>
                <div class="new_row clearfix">
                    <!--块-->
                    @foreach($rankData['bookManRecommendList'] as $bookRow)
                        <div class="fl row_left">
                            <div class="clearfix">
                                <span class="fl spleft"><a href="{{url('book_detail/'.$bookRow['id'])}}" title="" target="_blank"><img height="213px" src="{{$bookRow['cover']}}" alt="" /></a></span>
                                <span class="fl spright"><h2 class="clearfix"><a href="{{url('book_detail/'.$bookRow['id'])}}" title="" target="_blank">{{$bookRow['name']}}</a></h2><h3><b>{{$bookTypeList[$bookRow['type']]['name']}}</b><em class="fr">{{$bookRow['author_name']}}</em></h3><p style="text-overflow:ellipsis;overflow:hidden;display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;">{!! $bookRow['description'] !!}</p><h4><a href="{{url('book_detail/'.$bookRow['id'])}}" title="" target="_blank">阅读</a></h4></span>
                            </div>
                            <!--子列表-->
                            <div class="childlist">
                                <ul>
                                    @foreach($bookRow['child'] as $bookChildRow)
                                        <li><a style="overflow: hidden;white-space: nowrap;text-overflow: ellipsis;" href="{{url('book_detail/'.$bookChildRow['id'])}}" title="" target="_blank" data-recommendid="161255"><b>[{{$bookTypeList[$bookChildRow['type']]['name']}}]</b>{{$bookChildRow['name']}}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                            <!--子列表 end-->
                        </div>
                    @endforeach
                    <!--块 end-->
                </div>
            </div>
            <!--左边 end-->
            <!--右边-->
            <div class="new4_right bbox fl">
                <div class="new_right">
                    <h1 title="连载热文榜"><em style="margin-left: -15px;">&nbsp;</em><span class="fr hotpic"><b class="active">日</b><b>月</b><b>总</b></span></h1>
                    <ul class="rightul block">
                        @foreach($rankData['bookManReadDayRankList'] as $bookRow)
                            <li class="r{{$loop->iteration}}"><a href="{{url('book_detail/'.$bookRow['id'])}}" title="{{$bookRow['name']}}"><b>{{$loop->iteration}}</b>{{$bookRow['name']}}</a></li>
                        @endforeach
                    </ul>
                    <ul class="rightul ">
                        @foreach($rankData['bookManReadWeekRankList'] as $bookRow)
                            <li class="r{{$loop->iteration}}"><a href="{{url('book_detail/'.$bookRow['id'])}}" title="{{$bookRow['name']}}"><b>{{$loop->iteration}}</b>{{$bookRow['name']}}</a></li>
                        @endforeach
                    </ul>
                    <ul class="rightul ">
                        @foreach($rankData['bookManReadMonthRankList'] as $bookRow)
                            <li class="r{{$loop->iteration}}"><a href="{{url('book_detail/'.$bookRow['id'])}}" title="{{$bookRow['name']}}"><b>{{$loop->iteration}}</b>{{$bookRow['name']}}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <!--右边 end-->
        </div>
        <!--公共版权-->
        <br>
        {{--<div class="boys public clearfix">--}}
            {{--<!--左边-->--}}
            {{--<div class="new4_left bbox fl">--}}
                {{--<h1 class="clearfix"><em></em><span class="fr"></span></h1>--}}
                {{--<div class="new_row clearfix">--}}
                    {{--<!--块-->--}}
                    {{--<div class="fl row_left">--}}
                        {{--<div class="clearfix">--}}
                            {{--<span class="fl spleft"><a href="http://www.shenruxiang.com/Book/detail/bookid/10183.html" title="" target="_blank"><img src="https://img.9kus.com/bookImages/83/10183_300_400.jpg" alt="" /></a></span>--}}
                            {{--<span class="fl spright"><h2 class="clearfix"><a href="http://www.shenruxiang.com/Book/detail/bookid/10183.html" title="" target="_blank">史记</a></h2><h3><b>传统文学</b><em class="fr">by 司马迁</em></h3><p>《史记》是由司马迁撰写的中国第一部纪传体通史，是二十四史的第一部，全书分12本纪，10表，8书，30......</p><h4><a href="http://www.shenruxiang.com/Book/content/bookid/10183.html" title="" target="_blank">阅读</a></h4></span>--}}
                        {{--</div>--}}
                        {{--<!--子列表-->--}}
                        {{--<div class="childlist">--}}
                            {{--<ul>--}}
                                {{--<li><a href="http://www.shenruxiang.com/Book/detail/bookid/24016.html" title="" target="_blank"><b>[经典图书]</b>悲惨世界</a></li>--}}
                                {{--<li><a href="http://www.shenruxiang.com/Book/detail/bookid/14634.html" title="" target="_blank"><b>[两性情感]</b>私海深秋</a></li>--}}
                                {{--<li><a href="http://www.shenruxiang.com/Book/detail/bookid/24576.html" title="" target="_blank"><b>[经典图书]</b>官场现形记</a></li>--}}
                                {{--<li><a href="http://www.shenruxiang.com/Book/detail/bookid/24898.html" title="" target="_blank"><b>[经典图书]</b>安娜&middot;卡列宁娜</a></li>--}}
                                {{--<li><a href="http://www.shenruxiang.com/Book/detail/bookid/24848.html" title="" target="_blank"><b>[传统文学]</b>旧唐书</a></li>--}}
                                {{--<li><a href="http://www.shenruxiang.com/Book/detail/bookid/25314.html" title="" target="_blank"><b>[经典图书]</b>约翰&middot;克里斯朵夫</a></li>--}}
                                {{--<li><a href="http://www.shenruxiang.com/Book/detail/bookid/24690.html" title="" target="_blank"><b>[经典图书]</b>曾国藩家书</a></li>--}}
                                {{--<li><a href="http://www.shenruxiang.com/Book/detail/bookid/13834.html" title="" target="_blank"><b>[两性情感]</b>心间</a></li>--}}
                            {{--</ul>--}}
                        {{--</div>--}}
                        {{--<!--子列表 end-->--}}
                    {{--</div>--}}
                    {{--<!--块 end-->--}}
                    {{--<!--块-->--}}
                    {{--<div class="fl row_left">--}}
                        {{--<div class="clearfix">--}}
                            {{--<span class="fl spleft"><a href="http://www.shenruxiang.com/Book/detail/bookid/10137.html" title="" target="_blank"><img src="https://img.9kus.com/bookImages/37/10137_300_400.jpg" alt="" /></a></span>--}}
                            {{--<span class="fl spright"><h2 class="clearfix"><a href="http://www.shenruxiang.com/Book/detail/bookid/10137.html" title="" target="_blank">红楼梦</a></h2><h3><b>传统文学</b><em class="fr">by 曹雪芹</em></h3><p>《红楼梦》，中国古典四大名著之首，清代作家曹雪芹创作的章回体长篇小说。早期仅有前八十回抄本流传，原名......</p><h4><a href="http://www.shenruxiang.com/Book/content/bookid/10137.html" title="" target="_blank">阅读</a></h4></span>--}}
                        {{--</div>--}}
                        {{--<!--子列表-->--}}
                        {{--<div class="childlist">--}}
                            {{--<ul>--}}
                                {{--<li><a href="http://www.shenruxiang.com/Book/detail/bookid/14597.html" title="" target="_blank"><b>[两性情感]</b>繁花</a></li>--}}
                                {{--<li><a href="http://www.shenruxiang.com/Book/detail/bookid/14129.html" title="" target="_blank"><b>[两性情感]</b>十几岁</a></li>--}}
                                {{--<li><a href="http://www.shenruxiang.com/Book/detail/bookid/14240.html" title="" target="_blank"><b>[传统文学]</b>妮莎斯卡比尔</a></li>--}}
                                {{--<li><a href="http://www.shenruxiang.com/Book/detail/bookid/10147.html" title="" target="_blank"><b>[传统文学]</b>初刻拍案惊奇</a></li>--}}
                                {{--<li><a href="http://www.shenruxiang.com/Book/detail/bookid/25272.html" title="" target="_blank"><b>[传统文学]</b>续西游记</a></li>--}}
                                {{--<li><a href="http://www.shenruxiang.com/Book/detail/bookid/18266.html" title="" target="_blank"><b>[传统文学]</b>纳兰泪</a></li>--}}
                                {{--<li><a href="http://www.shenruxiang.com/Book/detail/bookid/24256.html" title="" target="_blank"><b>[历史传记]</b>巨人传</a></li>--}}
                                {{--<li><a href="http://www.shenruxiang.com/Book/detail/bookid/24712.html" title="" target="_blank"><b>[历史传记]</b>说岳全传</a></li>--}}
                            {{--</ul>--}}
                        {{--</div>--}}
                        {{--<!--子列表 end-->--}}
                    {{--</div>--}}
                    {{--<!--块 end-->--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<!--左边 end-->--}}
            {{--<!--右边-->--}}
            {{--<div class="new4_right bbox fl">--}}
                {{--<div class="new_right">--}}
                    {{--<h1 title="连载热文榜"><a href="http://www.shenruxiang.com/Rank/rankList/attr/1/type/1.html"><em style="margin-left: -15px;">&nbsp;</em></a><span class="fr hotpic"><b class="active">日</b><b>月</b><b>总</b></span></h1>--}}
                    {{--<ul class="rightul block">--}}
                        {{--<li class="r1"><a href="http://www.shenruxiang.com/Book/detail/bookid/26070.html" title=""><b>1</b>崇祯长编</a></li>--}}
                        {{--<li class="r2"><a href="http://www.shenruxiang.com/Book/detail/bookid/24014.html" title=""><b>2</b>经济学原理</a></li>--}}
                        {{--<li class="r3"><a href="http://www.shenruxiang.com/Book/detail/bookid/10137.html" title=""><b>3</b>红楼梦</a></li>--}}
                        {{--<li class="r4"><a href="http://www.shenruxiang.com/Book/detail/bookid/25030.html" title=""><b>4</b>交际花盛衰记</a></li>--}}
                        {{--<li class="r5"><a href="http://www.shenruxiang.com/Book/detail/bookid/25976.html" title=""><b>5</b>续资治通鉴</a></li>--}}
                        {{--<li class="r6"><a href="http://www.shenruxiang.com/Book/detail/bookid/24256.html" title=""><b>6</b>巨人传</a></li>--}}
                        {{--<li class="r7"><a href="http://www.shenruxiang.com/Book/detail/bookid/10143.html" title=""><b>7</b>镜花缘</a></li>--}}
                        {{--<li class="r8"><a href="http://www.shenruxiang.com/Book/detail/bookid/25974.html" title=""><b>8</b>资治通鉴</a></li>--}}
                        {{--<li class="r9"><a href="http://www.shenruxiang.com/Book/detail/bookid/25950.html" title=""><b>9</b>文献通考</a></li>--}}
                        {{--<li class="r10"><a href="http://www.shenruxiang.com/Book/detail/bookid/24866.html" title=""><b>10</b>清史稿</a></li>--}}
                    {{--</ul>--}}
                    {{--<ul class="rightul ">--}}
                        {{--<li class="r1"><a href="http://www.shenruxiang.com/Book/detail/bookid/10143.html" title=""><b>1</b>镜花缘</a></li>--}}
                        {{--<li class="r2"><a href="http://www.shenruxiang.com/Book/detail/bookid/25950.html" title=""><b>2</b>文献通考</a></li>--}}
                        {{--<li class="r3"><a href="http://www.shenruxiang.com/Book/detail/bookid/10137.html" title=""><b>3</b>红楼梦</a></li>--}}
                        {{--<li class="r4"><a href="http://www.shenruxiang.com/Book/detail/bookid/25974.html" title=""><b>4</b>资治通鉴</a></li>--}}
                        {{--<li class="r5"><a href="http://www.shenruxiang.com/Book/detail/bookid/24852.html" title=""><b>5</b>宋史</a></li>--}}
                        {{--<li class="r6"><a href="http://www.shenruxiang.com/Book/detail/bookid/25976.html" title=""><b>6</b>续资治通鉴</a></li>--}}
                        {{--<li class="r7"><a href="http://www.shenruxiang.com/Book/detail/bookid/25868.html" title=""><b>7</b>通典</a></li>--}}
                        {{--<li class="r8"><a href="http://www.shenruxiang.com/Book/detail/bookid/13712.html" title=""><b>8</b>国防生续集</a></li>--}}
                        {{--<li class="r9"><a href="http://www.shenruxiang.com/Book/detail/bookid/24848.html" title=""><b>9</b>旧唐书</a></li>--}}
                        {{--<li class="r10"><a href="http://www.shenruxiang.com/Book/detail/bookid/25314.html" title=""><b>10</b>约翰&middot;克里斯朵夫</a></li>--}}
                    {{--</ul>--}}
                    {{--<ul class="rightul ">--}}
                        {{--<li class="r1"><a href="http://www.shenruxiang.com/Book/detail/bookid/10137.html" title=""><b>1</b>红楼梦</a></li>--}}
                        {{--<li class="r2"><a href="http://www.shenruxiang.com/Book/detail/bookid/24852.html" title=""><b>2</b>宋史</a></li>--}}
                        {{--<li class="r3"><a href="http://www.shenruxiang.com/Book/detail/bookid/25950.html" title=""><b>3</b>文献通考</a></li>--}}
                        {{--<li class="r4"><a href="http://www.shenruxiang.com/Book/detail/bookid/10183.html" title=""><b>4</b>史记</a></li>--}}
                        {{--<li class="r5"><a href="http://www.shenruxiang.com/Book/detail/bookid/14634.html" title=""><b>5</b>私海深秋</a></li>--}}
                        {{--<li class="r6"><a href="http://www.shenruxiang.com/Book/detail/bookid/24694.html" title=""><b>6</b>子不语</a></li>--}}
                        {{--<li class="r7"><a href="http://www.shenruxiang.com/Book/detail/bookid/24016.html" title=""><b>7</b>悲惨世界</a></li>--}}
                        {{--<li class="r8"><a href="http://www.shenruxiang.com/Book/detail/bookid/24848.html" title=""><b>8</b>旧唐书</a></li>--}}
                        {{--<li class="r9"><a href="http://www.shenruxiang.com/Book/detail/bookid/25976.html" title=""><b>9</b>续资治通鉴</a></li>--}}
                        {{--<li class="r10"><a href="http://www.shenruxiang.com/Book/detail/bookid/10135.html" title=""><b>10</b>水浒全传</a></li>--}}
                    {{--</ul>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<!--右边 end-->--}}
        {{--</div>--}}
    </div>
</div>
<!--第四屏 end-->

<!--第七屏-->
<div class="new_model7 clearfix">
    <div class="container clearfix">
        <!--左-->
        <div class="new7_left bbox fl">
            <div class="new7_row time24 clearfix">
                <h1>24小时热搜<em></em></h1>
                <ul>
                    @foreach($rankData['bookHourSearchList'] as $key => $bookRow)
                        @if($key < 3)
                            <li class="ntop{{$key+1}}"><span class="fl new7_num"><b>{{$key+1}}</b></span><span class="fl new7_img"><a href="{{url('book_detail/'.$bookRow['id'])}}" title="" target="_blank">{{$bookTypeList[$bookRow['type']]['name']}}</a></span><span class="fl new7_l_info"><a href="{{url('book_detail/'.$bookRow['id'])}}" title="" target="_blank">{{$bookRow['name']}}</a></span></li>
                        @else
                            <li class="ntop{{$key+1}}"><span class="fl"><b>{{$key+1}}</b></span><span class="fl new7_img"><a href="{{url('book_detail/'.$bookRow['id'])}}" title="" target="_blank">{{$bookTypeList[$bookRow['type']]['name']}}</a></span><span class="fl new7_l_info"><a href="{{url('book_detail/'.$bookRow['id'])}}" title="" target="_blank">{{$bookRow['name']}}</a></span></li>
                        @endif
                    @endforeach
                </ul>
            </div>
            <div class="new7_row clearfix">
                <h1>收藏榜<em></em></h1>
                <ul>
                    @foreach($rankData['bookCollectList'] as $key => $bookRow)
                        @if($key < 3)
                        <li class="ntop{{$loop->iteration}}"><a href="{{url('book_detail/'.$bookRow['id'])}}" title="" target="_blank"><span class="fl new7_num"><b>{{$loop->iteration}}</b></span><span class="fl new7_img"><img src="{{$bookRow['cover']}}" alt="" /></span><span class="fl new7_l_info"><h2>{{$bookRow['name']}}</h2><h3>{{$bookRow['author_name']}}</h3></span></a></li>
                        @else
                            <li class="ntop{{$loop->iteration}}"><a href="{{url('book_detail/'.$bookRow['id'])}}" title="" target="_blank"><span class="fl new7_num"><b>{{$loop->iteration}}</b></span><span class="fl new7_tit">{{$bookRow['name']}}</span></a></li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
        <!--左 end-->
        <!--中-->
        <div class="new7_center bbox fl">
            <h1> 好看的小说 <em></em><span class="fr">
       <a href="{{url('book_list')}}" title="更多" target="_blank" class="mores">更多&gt;&gt;</a></span></h1>
            <ul>
                @foreach($rankData['bookUpdateList'] as $bookRow)
                    <li>
                        <span class="cats fl">
                            <a href="" target="_blank" title="">[{{$bookTypeList[$bookRow['type']]['name']}}] </a>
                        </span>
                        <span class="tits fl">
                            <a href="{{url('book_detail/'.$bookRow['id'])}}" target="_blank" title="">
                                <b class="title fl" style="color:gray;">{{$bookRow['name']}}</b>
                                <b class="title fl">{{$bookRow['last_chapter_name']}}</b>
                                <b class="aus fl">{{$bookRow['author_name']}}</b>
                                <b class="time fl">{{$bookRow['last_chapter_time']}}</b>
                            </a>
                        </span>
                    </li>
                @endforeach
            </ul>
        </div>
        <!--中 end-->
        <!--右-->
        <div class="new7_right bbox fl">
            <div class="new7_row new_money clearfix">
                <h1>实时收藏<em></em></h1>
                <div class="myscroll">
                    <ul>
                        @foreach($rankData['bookUpdateCollectList'] as $bookRow)
                            <li>
                                <h3>{{$bookRow['user_name']}}收藏了</h3><h2><a href="{{url('book_detail/'.$bookRow['id'])}}" title="" target="_blank">《{{$bookRow['name']}}》</a></h2>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            {{--<div class="new7_row ausays clearfix">--}}
                {{--<h1>作者专访<em></em><a href="http://www.shenruxiang.com/Index/author_special.html" style="color:#ad8b51;font-size:14px;margin-left:40px;">more&gt;&gt;</a></h1>--}}
                {{--<ul>--}}
                    {{--<li><a href="http://www.shenruxiang.com/Activity/sgwq" title="" target="_blank"><img src="https://img.9kus.com/Images/47/59f05067e5132.jpg" alt="" /></a></li>--}}
                    {{--<li><a href="http://www.shenruxiang.com/Activity/liusu" title="" target="_blank">九库大神醉流酥，携新作强势归来</a></li>--}}
                    {{--<li><a href="http://www.shenruxiang.com/Activity/dsll" title="" target="_blank">悬疑言情力作《大神出没请注意》</a></li>--}}
                    {{--<li><a href="http://www.shenruxiang.com/Activity/anqcyl" title="" target="_blank">缘来不曾后悔，爱你情出于蓝</a></li>--}}
                    {{--<li><a href="" title="" target="_blank"></a></li>--}}
                {{--</ul>--}}
            {{--</div>--}}
            <div class="new7_row new_news clearfix">
                <h1>网站资讯<em></em></h1>
                <ul>
                    @foreach($newList as $newRow)
                    <li><a href="{{$newRow['url']}}" title="" target="_blank">{{$newRow['name']}}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="new7_row app_down clearfix">
                <img src="/web/img/app_android.jpg" alt="安卓下载" />
            </div>
            <div class="new7_row app_down clearfix">
                <img src="/web/img/app_ios.jpg" alt="苹果下载" />
            </div>
        </div>
        <!--右 end-->
    </div>
</div>
<!--第七屏 end-->
<!--尾部-->
<!--尾部 end-->

<script type="text/javascript" src="/web/js/newbanner.js"></script>
<script type="text/javascript" src="/web/js/marquee.js"></script>
<script type="text/javascript">
    //首页左导航切换
    $('.new_model1 .grilcat a').on({
        'mouseenter':function(){
            $('.new_model1 .grilcat a').find('b').removeClass('active')
            $(this).find('b').addClass('active')
            $(this).parents('a').siblings().find('b').removeClass('active')
        }
    })

    //首页左导航切换
    $('.new_model1 .boycat a').on({
        'mouseenter':function(){
            $('.new_model1 .boycat a').find('b').removeClass('active')
            $(this).find('b').addClass('active')
            $(this).parents('a').siblings().find('b').removeClass('active')
        },
    });

    //第一屏右边切换
    $('.new_right .hotpic b').on('mouseenter',function(){
        var Idx = $(this).index();
        $(this).addClass('active').siblings().removeClass('active');
        $(this).parents('h1').siblings('.rightul').hide();
        $(this).parents('h1').siblings('.rightul').eq(Idx).show();
    })

    //滚动
    $('.myscroll').marquee({
        auto: true,
        interval: 4000,
        showNum: 5,
        stepLen: 1,
        type: 'vertical'
    });
</script>

@endsection