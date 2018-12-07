@extends('layouts.web.common')

@section('title', '入香阁-全本小说网')

@section('content')
    <style>
        .NameColor em{
            color: red;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="/web/css/search.css" />
    <div class="search_frameWrap">
        <form id="search_form" action="{{url('inside_search')}}" method="get">
            <div class="search_frame">
                <input type="text" name="content" class="search_Input" value="{{$searchContent}}" placeholder="搜索小说名称">
                <a class="search_frameBtn" href="javascript:search()"></a>
            </div>
        </form>
        <p class="search_notice">
            {{--搜索小说--}}
            @foreach($bookSearchList as $bookRow)
                <a href="{{url('book_detail/'.$bookRow['id'])}}" class="ResumeColor">{{$bookRow['name']}}</a>
            @endforeach
        </p>
    </div>
    <div class="boardSetCenter search_result ajaxSearchList">
        @if(! empty($searchContent))
        <div class="search_resultTop">搜索到与“
            <a href="###" class="BlueColor">{{$searchContent}}</a>
            ”有关的作品{{empty($searchList['hits']['total']) ? 0 : $searchList['hits']['total']}}条
        </div>
        @endif
        @if(!empty($searchList['hits']['total']) && $searchList['hits']['total'] > 0)
            @foreach($searchList['hits']['hits'] as $searchRow)
                <div class="searchContent">
                    <a href="{{url('book_detail/'.$searchRow['_source']['book_id'])}}">
                        <img src="{{$searchRow['_source']['book_cover']}}" alt="" class="searchBookImg">
                    </a
                    ><p>
                        <a href="{{url('book_detail/'.$searchRow['_source']['book_id'])}}" class="NameColor">
                            {!! $searchRow['highlight']['book_name'][0] !!}
                        </a>
                    </p>
                    <p class="searchBookInf">				作者:
                        <a href="{{url('book_author/'. $searchRow['_source']['book_id']. '/' .$searchRow['_source']['author_name'])}}" class="AuthorColor">{{$searchRow['_source']['author_name']}}</a>
                        分类 :
                        <a href="{{url('book_list/0/'.$searchRow['_source']['cate_name'])}}" class="AuthorColor">{{$bookTypeList[$searchRow['_source']['cate_name']]['name']}}</a>
                        <span>写作进程: 完结</span><span>字数:{{$searchRow['_source']['book_word_count']}}万字</span><span>更新时间:{{$searchRow['_source']['update_time']}}</span>
                    </p>
                    <div class="search_resultResume">
                        {!! $searchRow['_source']['book_desc'] !!}
                    </div>
                </div>
            @endforeach
        @endif
    </div>
    <script>
        function search(){
            var search_content = $('.search_Input').val();

            window.location.href = "{{url('inside_search')}}/" + search_content;
        }

    </script>
@endsection