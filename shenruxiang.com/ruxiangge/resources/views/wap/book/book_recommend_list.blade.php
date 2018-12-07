@extends('layouts.wap.common')

@section('title', '入香阁-全本小说网-往期精选推荐')

@section('content')
    <style>
        /*.p-text{*/
            /*text-overflow:ellipsis;overflow:hidden;display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;white-space:pre;line-height: 30px*/
        /*}*/
    </style>
    <link rel="stylesheet" type="text/css" href="/wap/css/newzt.css" />
    <div class="newztmore">
        <div class="container">
            <h2>每周小说精选</h2>
            <ul class="clearfix">
                @if(! empty($bookRecommendList))
                    @foreach($bookRecommendList as $bookRecommendRow)
                        <li>
                            <a href="{{url('book_recommend/'.$bookRecommendRow['start_day'].'/'.$bookRecommendRow['end_day'])}}" target="_blank"><img src="/wap/img/book_recommend_li_img.jpg" /><h3 class="clearfix"><span class="fl left">上周最火热推荐精选来袭！</span><span class="fl right">{{$bookRecommendRow['start_day']}}-{{$bookRecommendRow['end_day']}}</span></h3></a>

                        </li>
                    @endforeach
                @endif
                <div class="add_column"></div>
            </ul>
            {{--<div class="nmore">--}}
                {{--<a href="javascript:;" class="zjmore bd3 post_add">点击显示更多专题</a>--}}
            {{--</div>--}}
        </div>

    </div>
</body>
</html>
@endsection