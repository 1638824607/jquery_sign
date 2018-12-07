@extends('layouts.web.common')

@section('title', '入香阁-全本小说网-'.$bookRow['author_name'])

@section('content')
    <link rel="stylesheet" type="text/css" href="/web/css/bookauthor.css" />

    <div class="setCenter">
        <div class="nMC_informationWrap">
            <div class="nMC_information">
                <div class="nMC_userImg"><img src="/web/img/author_logo1.png" alt=""></div>
                <div class="nMC_userName">
                    {{$bookRow['author_name']}}
                </div>
            </div>
        </div>
        <div class="nMC_work clearfix">
            <div class="nMC_workLeft">
                <a href="{{url('book_detail/'.$bookRow['id'])}}"><img src="{{$bookRow['cover']}}" class="nMC_bookBig" alt="" /></a>
            </div>
            <div class="nMC_workRight">
                <div class="nMC_workFrame clearfix">
                    <a href="javascript:void 0" class="nMC_frame nMC_frameActive">TA的书架</a>
                </div>
                <div class="nMC_myCenter">
                    @if(! empty($bookList))
                        @foreach($bookList as $bookRow)
                            <div class="nMC_row clearfix">
                                @foreach($bookRow as $book)
                                    <div class="nMC_myBookList">
                                        <img src="{{$book['cover']}}" style="height: 193px;" class="nMC_bookImg" alt="" />
                                        <a href="{{url('book_detail/'. $book['id'])}}">
                                            <img src="/web/img/user11.png" class="bookShadow" alt="" />
                                        </a>
                                        <p>
                                            <a href="{{url('book_detail/'. $book['id'])}}">
                                                {{$book['name']}}
                                            </a>
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection