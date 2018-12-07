@extends('layouts.wap.common')

@section('title', '入香阁-全本小说搜索')

@section('content')
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
                        <input id="keyword" type="search" name="key" class="stxt" autocomplete="off" value="" />
                    </form>
                    <b class="insbtn"></b>
                </div>
                <div class="fl insright">
                    搜索
                </div>
            </div>
        </div>
    </div>
    <div class="sesmodel bg clearfix">
        <div class="container">
            <h2>热门推荐 </h2>
            <div class="clearfix alist">
                @foreach($bookSearchList as $bookSearchRow)
                    <a href="{{url('book_detail/'.$bookSearchRow['id'])}}">{{$bookSearchRow['name']}}</a>
                @endforeach
            </div>
        </div>
    </div>
    {{--<div class="sesmodel bg clearfix">--}}
        {{--<div class="container">--}}
            {{--<h2>搜索热词 </h2>--}}
            {{--<div class="clearfix alist">--}}
                {{--<a href="https://m.9kus.com/Search/searchList/key/%E8%85%B9%E9%BB%91/op/10116">腹黑</a>--}}
                {{--<a href="https://m.9kus.com/Search/searchList/key/%E7%9F%AD%E7%AF%87/op/10116">短篇</a>--}}
                {{--<a href="https://m.9kus.com/Search/searchList/key/%E6%80%BB%E8%A3%81/op/10116">总裁</a>--}}
                {{--<a href="https://m.9kus.com/Search/searchList/key/%E5%85%B5%E7%8E%8B/op/10116">兵王</a>--}}
                {{--<a href="https://m.9kus.com/Search/searchList/key/%E8%99%90%E7%88%B1/op/10116">虐爱</a>--}}
                {{--<a href="https://m.9kus.com/Search/searchList/key/%E7%BA%AF%E7%88%B1/op/10116">纯爱</a>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
    <div class="sesmodel bg clearfix">
        <div class="container">
            <h2>搜索历史 <b class="fr close"></b></h2>
            <div class="clearfix alist">
                @if(!empty($searchHistoryList))
                    @foreach($searchHistoryList as $searchHistoryRow)
                        <a href="{{url('inside_search_list/'.$searchHistoryRow)}}">{{$searchHistoryRow}}</a>
                    @endforeach
                @endif
            </div>
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
    });

    $('.sesmodel .close').on('click',function(){
        var that = $(this);
        //删除cookie记录1
        $.ajax({
            url:"{{url('del_search_history')}}",
            type:"POST",

            success:function(data){
                that.parent().siblings('.alist').empty();
            }
        });
    });
</script>
</body>
</html>
@endsection