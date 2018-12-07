@extends('layouts.wap.common')

@section('title', $bookRow['name'].'最新章节目录-入香阁')

@section('content')
    <!--目录 -->
    <div class="catlogxx bg clearfix">
        <div class="container">
            <h1>共{{$lastChapterSort}}章 <span class="fr"><a href="{{url('book_detail/'.$bookRow['id'])}}">简介</a><a href="{{url('book_dir/'.$bookRow['id'].'/asc')}}" class="@if($sort == 'asc') active @endif">正序</a><a href="{{url('book_dir/'.$bookRow['id'].'/desc')}}" class="@if($sort == 'desc') active @endif">倒序</a></span></h1>
            <ul>
                @foreach($chapterList['data'] as $chapterRow)
                    <li><a href="{{url('book_chapter_detail/'.$chapterRow['id'].'/'.$chapterRow['book_id'])}}"><span><i>{{$chapterRow['name']}}</i></span></a></li>
                @endforeach
            </ul>
            <!--分页-->
            <div class="upnextss">
                <em>
                    @isset($chapterList['prev_page_url'])
                        <a href="{{$chapterList['prev_page_url']}}"><b>&lt;</b> 上一页 </a>
                    @endisset
                </em>
                <em><a class=" newpage"><b>{{$chapterList['current_page']}}/{{$chapterList['last_page']}}</b></a></em>
                <em>
                    @isset($chapterList['next_page_url'])
                        <a href="{{$chapterList['next_page_url']}}" class="fr"> 下一页 <b>&gt;</b></a>
                    @endisset
                </em>
            </div>
            <!--分页 end-->
        </div>
    </div>
</div>
</body>
</html>
    <script>
        $('#metakeywords').attr('content', "{{$bookRow['name']}},{{$bookRow['name']}}最新章节免费阅读");
        $('#metadescription').attr('content', "{{$bookRow['name']}}最新章节由网友提供,《{{$bookRow['name']}}》情节跌宕起伏、扣人心弦,是一本情节与文笔俱佳的{{$bookTypeList[$bookRow['type']]['name']}},入香阁免费提供{{$bookRow['name']}}最新清爽干净的文字章节在线免费阅读。");
    </script>
@endsection