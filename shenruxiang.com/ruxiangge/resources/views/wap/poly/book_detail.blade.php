@extends('layouts.wap.common')

@section('title', '入香阁-全本小说全网书单')

@section('content')
    <style>
        em{
            color:red;
        }
    </style>
<div class="newwap">

    @if(!empty($bookDetailList))
        <div class="comment clearfix bg">
            <div class="container clearfix">
                <div class="entime clearfix girlx">
                    <h3 class="book-author">书单单主</h3>
                </div>
                <div class="rows">
                    <div class="utit">
                        <a href="javascript:void 0" style="display: block">
                            <img style="float: left;" src="{{config('app.static_url').$bookDetailList['author']['avatar']}}" />
                            <div class="book-detail-cell1">
                                <div class="book-title-x">
                                    <h4 class="book-detail-title">{{$bookDetailList['author']['nickname']}}</h4>
                                </div>
                                <p class="book-desc">收藏数：{{$bookDetailList['collectorCount']}}</p>
                            </div>
                            <div class="book-detail-cell1" style="margin-top: 15px">
                                    <p class="book-desc">{{$bookDetailList['title']}}</p>
                                    <div class="book-title-x" style="margin-bottom: -20px">
                                        <h4 class="book-detail-title" style="white-space: normal;line-height:2">{{$bookDetailList['desc']}}</h4>
                                    </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <!--模块-->
    <div class="modelx  bookx bg clearfix">
        <div class="container">
            <h2 style="padding: 0;font-size: 1.2rem">{{$bookDetailList['author']['nickname']}}的书单列表（{{count($bookDetailList['books'])}}）</h2>
            @if(!empty($bookDetailList))
                @foreach($bookDetailList['books'] as $bookDetailRow)
                    <div class="rowone clearfix">
                        <a href="{{url('poly/detail/'.$bookDetailRow['book']['_id'])}}">
                            <div class="fl rleft">
                                <img src="{{config('app.static_url').$bookDetailRow['book']['cover']}}" />
                            </div>
                            <div class="fl rright">
                                <h3>{{$bookDetailRow['book']['title']}}<b class="fr">{{ceil($bookDetailRow['book']['wordCount']/10000)}}万字</b></h3>
                                <p>{{$bookDetailRow['book']['author']}}|{{$bookDetailRow['book']['cat']}}|<span style="color: red">{{$bookDetailRow['book']['latelyFollower']}}人气</span></p>
                                <p class="twd">{{$bookDetailRow['comment']}}</p>
                            </div></a>
                    </div>
                @endforeach
            @endif
                <div class="nomore clearfix">已经到底啦~</div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var search_url = "{{url('outside_search')}}/";
    var search_list_url = "{{url('outside_search_list')}}/";

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
</body>
</html>
@endsection