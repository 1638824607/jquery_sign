@extends('layouts.wap.common')

@section('title', "入香阁-全本小说网-".$authorName)

@section('content')
    <style>
        .btn-group{
            display: table;
            width: 100%;
            margin-right: auto;
            margin-left: auto;
            table-layout: fixed;
            margin-top: 0px;
            font-size: 1.1rem;
        }
        .btn-group-cell{
            font-size: 100%;
            font-weight: 400;
            display: table-cell;
        }

        .god-data-t{
            text-align: center;
            font-size: .75rem;
            transform: scale(.83333);
            color: #969ba3;
        }

        .god-data-d{
            text-align: center;
            margin-top: 5px;
        }
    </style>
    <!--内容区-->
    <div class="newwap">

        <div class="meinfo bg clearfix">
            <div class="clearfix blurs">
                <div class="myblur">
                    <img src="/wap/img/40268_300_400.jpg" id="blur" class="blur" />
                </div>
                <div class="userx">
                    <img src="/wap/img/user22.jpg"/>
                    <h3 >{{empty($authorName) ? '' : $authorName}}</h3>
                    <div class="btn-group">
                        <dl class="btn-group-cell">
                            <dt class="god-data-t">作品数</dt>
                            <dd class="god-data-d">{{count($bookList)}}</dd>
                        </dl>
                        <dl class="btn-group-cell">
                            <dt class="god-data-t">收藏数</dt>
                            <dd class="god-data-d">{{empty($bookList) ? 0 : array_sum(arrayColumns($bookList, 'latelyFollower'))}}</dd>
                        </dl>

                    </div>
                </div>
            </div>
        </div>
        <div class="modelx inhot bg clearfix">
            <div class="container">
                <h2 style="padding: 0;font-size: 1.2rem">{{$authorName}}的全部作品（{{count($bookList)}}）</h2>
                @if(! empty($bookList))
                    @foreach($bookList as $bookRow)
                        @if($loop->iteration < 6)
                            <div class="rowone clearfix">
                                <a href="{{url('poly/detail/'.$bookRow['_id'])}}">
                                    <div class="fl rleft">
                                        <img src="{{config('app.static_url').$bookRow['cover']}}" />
                                    </div>
                                    <div  class="fl rright">
                                        <h3>{{$bookRow['title']}}</h3>
                                        <p class="twd">{{$bookRow['shortIntro']}}</p>
                                        <p>{{$bookRow['author']}}|<b>{{$bookRow['majorCate']}}</b><b class="fr">{{$bookRow['latelyFollower']}}人气</b></p>
                                    </div>
                                </a>
                            </div>
                    @endif
                @endforeach
                @endif
            <!--列表 end-->
            </div>
        </div>
    </div>
    </body>
    </html>
    <script>
        $('#metakeywords').attr('content', "{{$authorName}},"+$('#metakeywords').attr('content'));
    </script>
    <script type="text/javascript" src="/web/lib/layer/mobile/layer.js"></script>
@endsection