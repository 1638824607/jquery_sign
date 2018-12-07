@extends('layouts.wap.common')

@section('title', '入香阁-全本小说搜索')

@section('content')
    <style>
        em{
            color:red;
        }
    </style>
<div class="newwap">
    <div class="indexmenu nomenu bg clearfix ">
        <div class="mnx clearfix">
            <ul class="clearfix">
                <li style="width: 50%" class="active">
                    <a href="{{url('inside_search')}}">站内搜索</a>
                </li>
                <li style="width: 50%">
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
    <!--模块-->
    <div class="modelx  bookx bg clearfix">
        <div class="container">
            @if($searchList['hits']['total']>0)
                @foreach($searchList['hits']['hits'] as $searchRow)
                    <div class="rowone clearfix">
                        <a href="{{url('book_detail/'.$searchRow['_source']['book_id'])}}">
                            <div class="fl rleft">
                                <img src="{{$searchRow['_source']['book_cover']}}" />
                            </div>
                            <div class="fl rright">
                                <h3>{!! $searchRow['highlight']['book_name'][0] !!}<b class="fr">{{$searchRow['_source']['book_word_count']}}</b></h3>
                                <p>{{$searchRow['_source']['author_name']}}</p>
                                <p class="twd">{{mb_substr(str_replace('<br>', '', $searchRow['_source']['book_desc']),0,70)}}...</p>
                            </div></a>
                    </div>
                @endforeach
            @endif
                <div class="nomore clearfix">已经到底啦~</div>
        </div>
    </div>
</div>
<script type="text/javascript">
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
</body>
</html>
@endsection