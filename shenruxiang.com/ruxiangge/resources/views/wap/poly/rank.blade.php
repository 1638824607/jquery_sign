@extends('layouts.wap.common')

@section('title', '入香阁-全本小说网-全网')

@section('content')
    <style>
       .topsx li p{
           padding: 10px 0 5px;
       }

        .topsx h3{
            padding: 0 0 0 22px;
            margin-top: 15px;
            display: block;
            color: #333 !important;
            font-size: 14px;
            font-weight: 500;
            height: 100%;
            line-height: 1.6rem;
            margin-left: 1.46667rem;
        }

       .topsx img{
           float: left;
           width: 1.5rem;
           height: 1.5rem;
           margin: 0 0 0 .4rem;
       }
    </style>
    <div class="topsx bg clearfix">
        <div class="container">
            <ul>
                @if(! empty($rankList))
                    @foreach($rankList as $rankRow)
                        <li><a href="{{url('poly/rank_detail/'. $rankRow['_id'].'/'.$gender)}}"><img src="@if($rankRow['collapse'])
                                        /wap/img/default_rank_logo.png @else {{config('app.static_url').$rankRow['cover']}}
                                @endif" ><h3>{{str_replace('追书', '', $rankRow['title'])}}</h3><p></p></a></li>
                    @endforeach
                @endif
            </ul>
        </div>
    </div>
</body>
</html>
@endsection