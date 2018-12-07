@extends('layouts.wap.common')

@section('title', $bookRow['title'].'最新章节目录-入香阁')

@section('content')
    <!--目录 -->
    <div class="catlogxx bg clearfix">
        <div class="container">
            <h1>共{{count($chapterList)}}章 <span class="fr">
                    <a href="{{url('poly/detail/'.$bookRow['_id'])}}">简介</a>
                </span>
            </h1>
            <ul>
                @foreach($chapterList as $chapterId => $chapterRow)
                    <li><a href="{{url('poly/content/'.$chapterId.'/'.$bookRow['_id'])}}"><span><i>{{$chapterRow['title']}}</i></span></a></li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
</body>
</html>
    <script>
        $('#metakeywords').attr('content', "{{$bookRow['title']}},{{$bookRow['title']}}最新章节免费阅读");
        $('#metadescription').attr('content', "{{$bookRow['title']}}最新章节由网友提供,《{{$bookRow['title']}}》情节跌宕起伏、扣人心弦,是一本情节与文笔俱佳的{{$bookRow['majorCate']}},入香阁免费提供{{$bookRow['title']}}最新清爽干净的文字章节在线免费阅读。");
    </script>
@endsection