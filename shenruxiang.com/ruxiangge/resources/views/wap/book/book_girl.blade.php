@extends('layouts.wap.common')

@section('title', '入香阁-全本小说网-女生')

@section('content')
    <div class="meinfo daypush bg clearfix">
        <div class="clearfix blurs swiper-container" style="padding: 0px" id="banner">
            <div class="swiper-wrapper">
                @foreach($bookCarouselList as $key => $bookRow)
                    <a class="swiper-slide" href="{{url('book_detail/'.$bookRow['id'])}}">
                        <div class="myblur">
                            <b class="dtip">每日金牌推荐</b>
                            <img src="{{$bookRow['cover']}}" id="blur" class="blur" />
                        </div>
                        <div class="dinfo clearfix">
                            <div class="fl dleft">
                                <img src="{{$bookRow['cover']}}" />
                            </div>
                            <div class="fl dright">
                                <h3>{{$bookRow['name']}}</h3>
                                <p class="twd">{!! $bookRow['description'] !!}</p>
                                <p><b>{{$bookTypeList[$bookRow['type']]['name']}}</b></p>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

        </div>

        <script type="text/javascript">
            var swiper = new Swiper('#banner',{
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                },
                speed:1000,
                autoplayDisableOnInteraction : false,
                loop:'loop',
                centeredSlides : true,
                slidesPerView:1,
                pagination : '.swiper-pagination',
                paginationClickable:true,
                prevButton:'.swiper-button-prev',
                nextButton:'.swiper-button-next',
                onInit:function(swiper){
                    swiper.slides[2].className="swiper-slide swiper-slide-active";//第一次打开不要动画
                },
                breakpoints: {
                    668: {
                        slidesPerView:1,
                    }
                },spaceBetween: 0
            });
        </script>
    </div>
    <div class="newbanner clearfix">
        <div class="insearch">
            <form id="searchForm" action="#" class="search-form">
                <input id="keyword" type="search" name="kw" class="stxt" autocomplete="off" placeholder="请输入关键词搜索" />
            </form>
            <b class="insbtn"></b>

            <!--模块-->
            <div class="modelx bg clearfix">
                <div class="container">
                    <h2 class="boy0">女生佳作</h2>
                    @foreach($bookWomanRow as $bookRow)
                            @if($loop->iteration < 4)
                                <div class="rowone clearfix">
                                    <a href="{{url('book_detail/'.$bookRow['id'])}}">
                                        <div class="fl rleft">
                                            <img src="{{$bookRow['cover']}}" />
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
                    @endforeach
                    <!--列表 end-->
                </div>
            </div>
            <!--模块 end-->

            <!--模块-->
            <div class="modelx shuangwen bg clearfix">
                <div class="container">
                    <h2 class="boy1">精选热文</h2>
                    @foreach($bookWomanRow2 as $bookRow)
                        @if($loop->iteration < 4)
                            <div class="rowone clearfix">
                                <a href="{{url('book_detail/'.$bookRow['id'])}}">
                                    <div class="fl rleft">
                                        <img src="{{$bookRow['cover']}}" />
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
                @endforeach
                    <!--列表 end-->
                </div>
            </div>
            <!--模块 end-->
            <!--模块-->
            <div class="modelx boytop bg clearfix">
                <div class="container">
                    <h2 class="boy2">今日点击榜</h2>
                    <!--列表-->
                    <div class="rowlist">
                        <div class="rowx">
                            @foreach($bookWomanReadDayRankList as $bookRow)
                                @if($loop->iteration < 6)
                                    <a href="{{url('book_detail/'.$bookRow['id'])}}" class="section"><h3>{{$bookRow['name']}}<i class="fr">{{$bookRow['author_name']}}</i></h3></a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <!--列表 end-->
                </div>
            </div>
            <script type="text/javascript">    //导航
                var search_url = "{{url('inside_search')}}/";
                var search_list_url = "{{url('inside_search_list')}}/";

                $('.insearch .insright').on('click',function(){
                    var keyword = $("#keyword").val();
                    var url = !keyword ? search_url : search_list_url;

                    window.location.href = url + keyword;
                });


                $("#searchForm").submit(function(e){
                    e.preventDefault();
                    var keyword = $("#keyword").val();
                    var url = !keyword ? search_url : search_list_url;

                    window.location.href = url + keyword;
                });

                $('.insbtn').on('click',function(){
                    var keyword = $("#keyword").val();
                    var url = !keyword ? search_url : search_list_url;

                    window.location.href = url + keyword;
                })

            </script>
        </div>

    </div>
</div>
</body>
</html>
    <script>
        $('#metakeywords').attr('content', "女生,"+$('#metakeywords').attr('content'));
    </script>
@endsection