@extends('layouts.wap.common')

@section('title', '入香阁-全本小说网')

@section('content')
    <style>
        .style-a{
            /*width:20% !important;*/
            display: inline-block;
        }

        .rowx-a{
            border-bottom: 1px solid #ededed;
        }
    </style>
    <!--导航 end-->
    <!--滚图-->
    <div class="newbanner clearfix">
        <div class="swiper-container" id="banner">
            <div class="swiper-wrapper">
                @foreach($rankData['bookCarouselList'] as $bookRow)
                    <a class="style-a swiper-slide" href="{{url("book_detail/" . $bookRow['id'])}}">
                        <img style="width: 140px;height: 190px;"  src="{{$bookRow['cover']}}" />
                    </a>
                @endforeach
            </div>
        </div>
        <div class="insearch">
            <form id="searchForm" action="#" class="search-form">
                <input id="keyword" type="search" name="kw" class="stxt" autocomplete="off" placeholder="请输入小说名搜索" />
            </form>
            <b class="insbtn"></b>
        </div>
    </div>
    <script type="text/javascript">
        var swiper = new Swiper('#banner',{
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            speed:1000,
            autoplayDisableOnInteraction : false,
            loop:'loop',
            centeredSlides : true,
            slidesPerView:5,
            pagination : '.swiper-pagination',
            paginationClickable:true,
            prevButton:'.swiper-button-prev',
            nextButton:'.swiper-button-next',
            onInit:function(swiper){
                swiper.slides[2].className="swiper-slide swiper-slide-active";//第一次打开不要动画
            },
            breakpoints: {
                668: {
                    slidesPerView:5,
                }
            },spaceBetween: 0
        });
    </script>
    <!--滚图 end-->
    <!--模块-->
    <div class="modelx inhot bg clearfix">
        <div class="container">
            <h2 class="boy0">最热书单</h2>
            @foreach($rankData['bookReadDayRankList'] as $bookRow)
                @if($loop->iteration < 6)
                    <div class="rowone clearfix">
                        <a href="{{url('book_detail/'.$bookRow['id'])}}">
                            <div class="fl rleft">
                                <img class="lazy" data-original="{{$bookRow['cover']}}" />
                            </div>
                            <div class="fl rright">
                                <h3>{{$bookRow['name']}}</h3>
                                <p class="twd">{{str_replace('<br>', '', $bookRow['description'])}}</p>
                                <p>{{$bookRow['author_name']}}|<b>{{$bookTypeList[$bookRow['type']]['name']}}</b><b class="fr">完结</b></p>
                            </div>
                        </a>
                    </div>
                @endif
            @endforeach
        <!--列表 end-->
        </div>
    </div>

    <div class="modelx inhot bg clearfix">
        <div class="container">
            <h2 class="boy01">新书抢鲜</h2>
            @foreach($rankData['bookUpdateList'] as $bookRow)
                @if($loop->iteration < 9)
                    @if($loop->iteration < 4)
                        <div class="rowone clearfix">
                            <a href="{{url('book_detail/'.$bookRow['id'])}}">
                                <div class="fl rleft">
                                    <img class="lazy" data-original="{{$bookRow['cover']}}" />
                                </div>
                                <div class="fl rright">
                                    <h3>{{$bookRow['name']}}</h3>
                                    <p class="twd">{{str_replace('<br>', '', $bookRow['description'])}}</p>
                                    <p>{{$bookRow['author_name']}}|<b>{{$bookTypeList[$bookRow['type']]['name']}}</b><b class="fr">完结</b></p>
                                </div>
                            </a>
                        </div>
                    @else
                        <div class="rowlist">
                        <a href="{{url('book_detail/'.$bookRow['id'])}}"><h3><b>{{$bookTypeList[$bookRow['type']]['name']}}</b><i> | </i>{{$bookRow['name']}}</h3><p>{{str_replace('<br>', '', $bookRow['description'])}}</p></a>
                        </div>
                    @endif
                @endif
            @endforeach
            <!--列表-->
            {{--<div class="rowlist">--}}
                {{--<div class="rowx">--}}
                    {{--@foreach($rankData['bookUpdateList'] as $bookRow)--}}
                        {{--@if($loop->iteration < 9)--}}
                            {{--<a href="{{url('book_detail/'.$bookRow['id'])}}" style="border:none;"><h3><b>{{$bookTypeList[$bookRow['type']]['name']}}</b><i> | </i>{{$bookRow['name']}}</h3><p>{{str_replace('<br>', '', $bookRow['description'])}}</p></a>--}}
                        {{----}}
                        {{--@endif--}}
                    {{--@endforeach--}}
                {{--</div>--}}
            {{--</div>--}}
            <!--列表 end-->
        </div>
    </div>
    <!--模块 end-->
    <!--AD-->
    {{--<div class="kuads">--}}
        {{--<a href="" data-recommendid="167650"><img src="" /></a>--}}
    {{--</div>--}}
    <!--AD end-->
    <!--模块-->
    <div class="modelx bg clearfix">
        <div class="container">
            <h2 class="boy0">男生精品</h2>
            @foreach($rankData['bookManRecommendList'] as $bookRow)
                @if($loop->iteration < 2)
                    <div class="rowone clearfix">
                        <a href="{{url('book_detail/'.$bookRow['id'])}}">
                            <div class="fl rleft">
                                <img class="lazy" data-original="{{$bookRow['cover']}}" />
                            </div>
                            <div class="fl rright">
                                <h3>{{$bookRow['name']}}</h3>
                                <p class="twd">{{str_replace('<br>', '', $bookRow['description'])}}</p>
                                <p><b>{{$bookTypeList[$bookRow['type']]['name']}}</b><b class="fr">完结</b></p>
                            </div>
                        </a>
                    </div>
                    <!--列表-->
                    <div class="rowlist">
                        <div class="rowx">
                            @foreach($bookRow['child'] as $bookChildRow)
                                <a href="{{url('book_detail/'.$bookChildRow['id'])}}"><h3><b>{{$bookTypeList[$bookChildRow['type']]['name']}}</b><i> | </i>{{$bookChildRow['name']}}</h3><p>{{str_replace('<br>', '', $bookChildRow['description'])}}</p></a>
                            @endforeach
                        </div>
                        {{--<a href="{{url('book_list')}}" class="moreapp">查看更多<i></i></a>--}}
                    </div>
                @endif
            @endforeach
            <!--列表 end-->
        </div>
    </div>

    <div class="modelx modtj bg clearfix">
        <div class="container">
            <h2 class="boy0">女生最爱</h2>
            @foreach($rankData['bookWomanRecommendList'] as $bookRow)
                @if($loop->iteration < 2)
                    <div class="rowone clearfix">
                        <a href="{{url('book_detail/'.$bookRow['id'])}}">
                            <div class="fl rleft">
                                <img class="lazy" data-original="{{$bookRow['cover']}}" />
                            </div>
                            <div class="fl rright">
                                <h3>{{$bookRow['name']}}</h3>
                                <p class="twd">{{str_replace('<br>', '', $bookRow['description'])}}</p>
                                <p><b>{{$bookTypeList[$bookRow['type']]['name']}}</b><b class="fr">完结</b></p>
                            </div>
                        </a>
                    </div>
                    <!--列表-->
                    <div class="rowlist">
                        <div class="rowx">
                            @foreach($bookRow['child'] as $bookChildRow)
                                <a href="{{url('book_detail/'.$bookChildRow['id'])}}"><h3><b>{{$bookTypeList[$bookChildRow['type']]['name']}}</b><i> | </i>{{$bookChildRow['name']}}</h3><p>{{str_replace('<br>', '', $bookChildRow['description'])}}</p></a>
                            @endforeach
                        </div>
{{--                        <a href="{{url('book_list')}}" class="moreapp">查看更多<i></i></a>--}}
                    </div>
            @endif
        @endforeach
            <!--列表 end-->
        </div>
    </div>
    <!--模块 end-->
    <!--AD-->
    {{--<div class="kuads">--}}
        {{--<a href="" data-recommendid="166781"><img src="" /></a>--}}
    {{--</div>--}}
    <!--AD end-->

    <!--模块-->
    <div class="modelx modtj  modboy bg clearfix">
        <div class="container">
            <div class="smn clearfix">
                @foreach($rankData['bookCategoryList'] as $bookType => $bookList)
                    @if($loop->iteration < 4)
                        <a class="@if($loop->iteration == 1) active @endif" title="{{$bookTypeList[$bookType]['name']}}">{{$bookTypeList[$bookType]['name']}}</a>
                    @endif
                @endforeach
            </div>

            @foreach($rankData['bookCategoryList'] as $bookType => $bookList)
                @if($loop->iteration < 4)
                    <div class="modtjone">
                        @foreach($bookList as $key => $bookRow)
                            @if($loop->iteration == 1)
                                <div class="rowone clearfix">
                                    <a href="{{url('book_detail/'.$bookRow['id'])}}">
                                        <div class="fl rleft">
                                            <img  src="{{$bookRow['cover']}}" />
                                        </div>
                                        <div class="fl rright">
                                            <h3>{{$bookRow['name']}}</h3>
                                            <p>{{$bookRow['author_name']}}</p>
                                            <p class="twd">{{str_replace('<br>', '', $bookRow['description'])}}</p>
                                        </div>
                                    </a>
                                </div>
                            @else
                                <div class="rowlist">
                                    <div class="rowx rowx-a">
                                            <a href="{{url('book_detail/'.$bookRow['id'])}}"><h3>{{$bookRow['name']}}<i class="fr">{{$bookRow['author_name']}}</i></h3></a>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif
            @endforeach
        </div>
    </div>
    <!--模块 end-->
    <!--模块-->
    <div class="modelx boytop bg clearfix">
        <div class="container">
            <h2 class="boy2">近期飙升榜</h2>
            <!--列表-->
            <div class="rowlist">
                <div class="rowx">
                    @foreach($rankData['bookHourSearchList'] as $key => $bookRow)
                        @if($loop->iteration < 6)
                            <a href="{{url('book_detail/'.$bookRow['id'])}}" class="section"><h3>{{$bookRow['name']}}<i class="fr">{{$bookRow['author_name']}}</i></h3></a>
                        @endif
                    @endforeach
                </div>
            </div>
            <!--列表 end-->
        </div>
    </div>
    <!--模块 end-->

</div>
<script type="text/javascript">
    var search_url = "{{url('inside_search')}}/";
    var search_list_url = "{{url('inside_search_list')}}/";

    //分类切换
    $('.modboy .smn a').on('click',function(){
        $(this).addClass('active').siblings().removeClass('active');
        var idx = $(this).index();
        $('.modboy .modtjone').hide();
        $('.modboy .modtjone').eq(idx).show();
    });

    $("#searchForm").submit(function(e){
        e.preventDefault();
        var keyword = $("#keyword").val();
        url = !keyword ? search_url : search_list_url;

        window.location.href = url + keyword;
    });

    $('.insbtn').on('click',function(){
        var keyword = $("#keyword").val();
        url = !keyword ? search_url : search_list_url;

        window.location.href = url + keyword;
    })
</script>
</body>
</html>
@endsection