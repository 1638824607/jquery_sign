@extends('layouts.wap.common')

@section('title', '入香阁-全本小说网榜单')

@section('content')
<div class="newwap">
    <!--模块-->
    <div class="modelx  bookx bg clearfix">
        <div class="container">
            @if(!empty($rankBookList))
                @foreach($rankBookList as $rankBookRow)
                    <div class="rowone clearfix">
                        <a href="{{url('poly/detail/'.$rankBookRow['_id'])}}">
                            <div class="fl rleft">
                                <img class="lazy" data-original="{{config('app.static_url').$rankBookRow['cover']}}" />
                            </div>
                            <div class="fl rright">
                                <h3>{{$rankBookRow['title']}}<b class="fr">{{$rankBookRow['majorCate']}}</b></h3>
                                <p>{{$rankBookRow['author']}}</p>
                                <p class="twd">{{$rankBookRow['shortIntro']}}</p>
                            </div>
                        </a>
                    </div>
                @endforeach
            @endif
                <div class="nomore clearfix">已经到底啦~</div>
        </div>
    </div>
</div>
</body>
</html>
@endsection