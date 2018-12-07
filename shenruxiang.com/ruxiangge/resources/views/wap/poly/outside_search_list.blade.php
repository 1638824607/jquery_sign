@extends('layouts.wap.common')

@section('title', '入香阁-全本小说全网搜索')

@section('content')
    <style>
        em{
            color:red;
        }
    </style>
<div class="newwap">
    <div class="readhd bg  clearfix">
        <div class="indexmenu nomenu bg clearfix ">
            <div class="mnx clearfix">
                <ul class="clearfix">
                    <li style="width: 50%">
                        <a href="{{url('inside_search')}}">站内搜索</a>
                    </li>
                    <li style="width: 50%" class="active">
                        <a href="{{url('outside_search')}}">全网搜索</a>
                    </li>

                </ul>
            </div>
        </div>
        <div class="readhd bg  clearfix">
            <div class="clearfix top insearch">
                <div class="container  clearfix">
                    <div class="fl insleft">
                        <form id="searchForm" action="#" class="search-form">
                            <input id="keyword" type="search" name="key" class="stxt" autocomplete="off" value="{{$searchContent}}" />
                        </form>
                        <b class="insbtn"></b>
                    </div>
                    <div class="fl insright">
                        搜索
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--模块-->
    <div class="modelx  bookx bg clearfix">
        <div class="container">
            @if(!empty($searchList))
                @foreach($searchList as $searchRow)
                    <div class="rowone clearfix">
                        <a href="{{url('poly/detail/'.$searchRow['_id'])}}">
                            <div class="fl rleft">
                                <img src="{{config('app.static_url').$searchRow['cover']}}" />
                            </div>
                            <div class="fl rright">
                                <h3>{{$searchRow['title']}}<b class="fr">{{$searchRow['wordCount']}}</b></h3>
                                <p>{{$searchRow['author']}}</p>
                                <p class="twd">{{$searchRow['shortIntro']}}</p>
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