@extends('layouts.wap.common')

@section('title', '入香阁-全本小说网-阅读记录')

@section('content')
<div class="newwap">
    <div class="readhistory bg clearfix">
        <div class="container">
            <div class="hita">
                <div class="hista">
                    <a href="{{url('book_history')}}" class="active">浏览历史</a>
                    <a href="{{url('book_collect_list')}}">我的书架</a>
                </div>
                @if(!empty($bookHistoryList))
                    <h2>共{{count($bookHistoryList)}}本</h2>
                    <ul class="clearfix">
                        @foreach($bookHistoryList as $bookRow)
                            <li>
                                <a href="@if(is_numeric($bookRow['book_id'])){{url('book_detail/'.$bookRow['book_id'])}}@else{{url('poly/detail/'.$bookRow['book_id'])}}@endif" title="{{$bookRow['book_name']}}">
                                    <span class="fl left"><img class="lazy" data-original="{{$bookRow['book_cover']}}" />
                                        <h4 style="position: relative;">{{$bookRow['chapter_name']}}</h4>
                                    </span>
                                    <span class="fl right">
                                        <h3>{{$bookRow['book_name']}}</h3>
                                        <h5>{{$bookRow['book_author_name']}}</h5>
                                        <h5>{{empty($bookRow['read_time']) ? 0 : date('m月d日', $bookRow['read_time'])}}看过</h5>
                                    </span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
    <!--尾部 end-->
</div>
</body>
</html>
@endsection