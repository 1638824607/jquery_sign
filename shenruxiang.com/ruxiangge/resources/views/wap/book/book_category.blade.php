@extends('layouts.wap.common')

@section('title', '入香阁-全本小说网-分类')

@section('content')
    <link rel="stylesheet" type="text/css" href="/wap/css/channel.css">

<section id="channles">
    <dl class="fenlei_tab">
        @foreach($bookTypeList as $bookType)
            <dt>
                <a href="{{url('book_list/0/'.$bookType['id'])}}">
                    <span>{{$bookType['name']}}</span>
                </a>
            </dt>
        @endforeach
    </dl>
</section>

</body>
</html>

@endsection