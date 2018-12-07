@extends('layouts.web.common')

@section('title', '入香阁-全本小说网-'.(empty($type) ? '书库' : $bookTypeList[$type]['name']))

@section('content')
    <link rel="stylesheet" type="text/css" href="/web/css/books.css" />

    <div class="new_books clearfix">
        <div class="container clearfix">
            <div class="new_book_cont clearfix">
                <!--左-->
                <div class="fl new_book_left">
                    <div class="lcont">
                        <h1><em></em><b></b>分类书库</h1>
                        <ul class="bookcat">
                            <li style="border-bottom: 1px solid #e6d6bb;"><a href="{{url('book_list')}}" class="active">全部</a></li>
                            <li style="border-bottom: 1px solid #e6d6bb;"><a></a></li>

                            @foreach($bookTypeList as $bookType)
                                <li><a class="@if($bookType['id'] == $type) active @endif" href="{{url('book_list/0/'.$bookType['id']).'/'.$word.'/'.$order}}" title="{{$bookType['name']}}">{{$bookType['name']}}</a></li>
                            @endforeach

                        </ul>
                    </div>
                </div>
                <!--左 end-->
                <!--右-->
                <div class="fl new_book_right">
                    <div class="booktops">
                        <h1>
                            <b></b
                            ><em></em>
                            小说书库
                            <span class="fr">
                                <a href="{{url('book_list/'.$reader_type.'/'.$type.'/'.$word.'/1')}}" class="@if($order == 1) active @endif">
                                    人气
                                </a>
                                <a href="{{url('book_list/'.$reader_type.'/'.$type.'/'.$word.'/2')}}" class="@if($order == 2) active @endif">
                                    字数
                                </a>
                                <a href="{{url('book_list/'.$reader_type.'/'.$type.'/'.$word.'/3')}}" class="@if($order == 3) active @endif">
                                    更新
                                </a>
                            </span>
                        </h1>
                        <p>
                            <span>
                                字数
                                <a href="{{url('book_list/'.$reader_type.'/'.$type.'/0/'.$order)}}" class="@if($word == 0) active @endif">
                                    全部
                                </a>
                                <a href="{{url('book_list/'.$reader_type.'/'.$type.'/1/'.$order)}}" class="@if($word == 1) active @endif">
                                    50万字以下
                                </a>
                                <a href="{{url('book_list/'.$reader_type.'/'.$type.'/2/'.$order)}}" class="@if($word == 2) active @endif">
                                    50-100万字
                                </a>
                                <a href="{{url('book_list/'.$reader_type.'/'.$type.'/3/'.$order)}}" class="@if($word == 3) active @endif">
                                    100万字以上
                                </a>
                            </span>
                        </p>
                    </div>
                    <div class="booklists clearfix">
                        <ul>
                            @if(!empty($bookList))
                                @foreach($bookList as $book)
                                    <li>
                                        <span class="fl bookimg">
                                            <a href="{{url('book_detail/'. $book['id'])}}" target="_blank" title="">
                                                <img src="{{$book['cover']}}" alt="" />
                                            </a>
                                        </span>
                                        <span class="fl booktitle">
                                            <h2>
                                                <a href="{{url('book_detail/'.$book['id'])}}" target="_blank" title="">
                                                    {{$book['name']}}
                                                </a>
                                                <b class="fr" style="font-size: 10px">
                                                    {{$book['word_count']}}万字
                                                </b>
                                            </h2>
                                            <h3>
                                                <a href="{{url('book_author/'.$book['id'].'/'.$book['author_name'])}}" target="_blank" title="">
                                                    {{$book['author_name']}}
                                                </a>
                                                <a href="{{url('book_list/0/'.$book['type'])}}" target="_blank" title="">
                                                    {{$bookTypeList[$book['type']]['name']}}
                                                </a>
                                                <a href="javascript:void 0" target="_blank" title="">
                                                    完结
                                                </a>
                                                <a href="javascript:void 0" target="_blank" title="">
                                                    {{$book['read_num']}}阅读
                                                </a>
                                            </h3>
                                            <p>
                                                <a href="{{url('book_detail/'. $book['id'])}}" target="_blank">
                                                    {!! $book['description'] !!}
                                                </a>
                                            </p>
                                        </span>
                                    </li>
                                @endforeach
                            @endif

                        </ul>
                    </div>
                    <!--分页-->
                    <div class="N_page">

                        @foreach ($elements as $element)
                            @if (is_string($element))
                                {{--<li class="disabled"><span>{{ $element }}</span></li>--}}
                                <a class="N_pageBtn" href="javascript:void 0">{{ $element }}</a>
                            @endif

                            @if (is_array($element))
                                @foreach ($element as $page => $url)
                                    @if ($page == $bookList->currentPage())

                                            <a class="N_pageBtn active" href="{{ $url }}">{{ $page }}</a>
                                    @else
                                            <a class="N_pageBtn" href="{{ $url }}">{{ $page }}</a>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach

                        @if ($bookList->hasMorePages())
                            <a href="{{ $bookList->nextPageUrl() }}" class="N_pageN">下一页</a>
                        @else
                            <a style="background: #ccc" href="javascript:void 0" class="N_pageN">下一页</a>
                        @endif

                        @if ($bookList->onFirstPage())
                            <a class="N_pageP" style="background: #ccc" href="javascript:void 0">上一页</a>
                        @else
                            <a class="N_pageP" href="{{ $bookList->previousPageUrl() }}">上一页</a>
                        @endif
                    </div>
                    <!--分页-->
                </div>
                <!--右 end-->
            </div>
        </div>
    </div>
@endsection