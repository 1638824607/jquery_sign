@extends('layouts.wap.common')

@section('title', '入香阁-全本小说搜索')

@section('content')
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
    </div>

    <div class="sesmodel bg clearfix">
        <div class="container">
            <h2>搜索热词 </h2>
            {{--word--}}
            <div class="clearfix alist">
                @if(!empty($searchHotwordList))
                    @foreach($searchHotwordList as $searchHotwordRow)
                        <a href="{{url('outside_search_list/'.$searchHotwordRow['word'])}}">{{$searchHotwordRow['word']}}</a>
                    @endforeach
                @endif
            </div>
        </div>
    </div>

    <div class="sesmodel bg clearfix">
        <div class="container">
            <h2>搜索历史 <b class="fr close"></b></h2>
            <div class="clearfix alist">
                @if(!empty($searchHistoryList))
                    @foreach($searchHistoryList as $searchHistoryRow)
                        <a  href="{{url('outside_search_list/'.$searchHistoryRow)}}">{{$searchHistoryRow}}</a>
                    @endforeach
                @endif
            </div>
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
    });

    $('.sesmodel .close').on('click',function(){
        var that = $(this);
        //删除cookie记录11
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