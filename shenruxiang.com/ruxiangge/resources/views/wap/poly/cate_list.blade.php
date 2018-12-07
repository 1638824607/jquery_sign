@extends('layouts.wap.common')

@section('title', '入香阁-全本小说网-全网')

@section('content')
    @if(!empty($cateList))
        @php
            unset($cateList['ok']);
            unset($cateList['picture'])
        @endphp
        @foreach($cateList as $cateType => $cateTypeList)
            <div class="catsall bg clearfix">
                <div class="container">
                    <h2>
                        @switch($cateType)
                            @case('male')
                                男生
                            @break
                            @case('female')
                                女生
                            @break
                            @case('press')
                                出版
                            @break
                            @default
                                {{$cateType}}
                        @endswitch
                    </h2>
                    @if(! empty($cateTypeList))
                        <div class="cata">
                            @foreach($cateTypeList as $cateRow)
                                <a href="{{route('poly/cate', ['gender' => $cateType, 'major' => $cateRow['name']])}}"><b>{{$cateRow['name']}}<br><span>{{$cateRow['bookCount']}}本</span></b></a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    @endif
</body>
</html>
@endsection