@extends('layouts.wap.common')

@section('title', '入香阁-全本小说网-排行')

@section('content')
    <style>
        @font-face {
            font-family: "style_font_zhanku";
            src: url("/wap/style_font/style_font_zhanku.eot"); /* IE9 */
            src: url("/wap/style_font/style_font_zhanku.eot?#iefix") format("embedded-opentype"), /* IE6-IE8 */

            url("/wap/style_font/style_font_zhanku.woff") format("woff"), /* chrome、firefox */
            url("/wap/style_font/style_font_zhanku.ttf") format("truetype"), /* chrome、firefox、opera、Safari, Android, iOS 4.2+ */

            url("/wap/style_font/style_font_zhanku.svg#style_font_zhanku") format("svg"); /* iOS 4.1- */
            font-style: normal;
            font-weight: normal;
        }

        .book-toplist-title{
            font: bold 35px style_font_zhanku !important;
            color:#fff;
        }
        .book-title{
            overflow: hidden;white-space: nowrap;text-overflow: ellipsis;
            font-size: 1.2rem;
        }
    </style>
    <link rel="stylesheet" data-ignore="true" href="/wap/css/rank_font.css" />
    <div class="page page-toplist" id="page-toplist">
        <div class="content">
            <div data-l1="2">
                <div class="module module-toplist" data-l2="1">
                    <a href="javascript:void 0" class="book-toplist">
                        <img src="/wap/img/rank-bg-1.jpg" class="book-toplist-cover" alt="原创风云榜">
                        <h2 class="book-toplist-title">热文榜</h2>
                        <i class="icon icon-point-r"></i>
                    </a>
                    <ol class="book-ol book-ol-rank">
                        @foreach($rankData['bookReadDayRankList'] as $bookRow)
                            @if($loop->iteration < 6)
                                <li class="book-li">
                                    <a href="{{url('book_detail/'. $bookRow['id'])}}" class="book-layout">
                                        <h3 class="book-title">{{$bookRow['name']}}</h3>
                                        <span class="book-author">
                                <svg class="icon icon-arrow-r" aria-hidden="true"><use xlink:href="#icon-arrow-r"></use></svg>
                            </span>
                                    </a>
                                </li>
                            @endif
                        @endforeach

                    </ol>
                </div>
                <div class="module module-toplist" data-l2="2">
                    <a href="javascript:void 0" class="book-toplist" >
                        <img src="/wap/img/rank-bg-2.jpg" class="book-toplist-cover" alt="畅销榜">
                        <h2 class="book-toplist-title">畅销榜</h2>
                        <i class="icon icon-point-r"></i>
                    </a>
                    <ol class="book-ol book-ol-rank" data-l3="2">
                        @foreach($rankData['bookHotList'] as $bookRow)
                            @if($loop->iteration < 6)
                                <li class="book-li">
                                    <a href="{{url('book_detail/'. $bookRow['id'])}}" class="book-layout">
                                        <h3 class="book-title">{{$bookRow['name']}}</h3>
                                        <span class="book-author">
                                <svg class="icon icon-arrow-r" aria-hidden="true"><use xlink:href="#icon-arrow-r"></use></svg>
                            </span>
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ol>
                </div>
                <div class="module module-toplist" data-l2="3">
                    <a href="javascript:void 0" class="book-toplist">
                        <img src="/wap/img/rank-bg-3.jpg" class="book-toplist-cover" alt="点击榜">
                        <h2 class="book-toplist-title">点击榜</h2>
                        <i class="icon icon-point-r"></i>
                    </a>
                    <ol class="book-ol book-ol-rank" data-l3="2">
                        @foreach($rankData['bookReadMonthRankList'] as $bookRow)
                            @if($loop->iteration < 6)
                                <li class="book-li">
                                    <a href="{{url('book_detail/'. $bookRow['id'])}}" class="book-layout">
                                        <h3 class="book-title">{{$bookRow['name']}}</h3>
                                        <span class="book-author">
                                <svg class="icon icon-arrow-r" aria-hidden="true"><use xlink:href="#icon-arrow-r"></use></svg>
                            </span>
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ol>
                </div>
                <div class="module module-toplist" data-l2="4">
                    <a href="javascript:void 0" class="book-toplist">
                        <img src="/wap/img/rank-bg-4.jpg" class="book-toplist-cover" alt="推荐榜">
                        <h2 class="book-toplist-title">推荐榜</h2>
                        <i class="icon icon-point-r"></i>
                    </a>
                    <ol class="book-ol book-ol-rank" data-l3="2">
                        @foreach($rankData['bookTodayRecommendList'] as $bookRow)
                            @if($loop->iteration < 6)
                                <li class="book-li">
                                    <a href="{{url('book_detail/'. $bookRow['id'])}}" class="book-layout">
                                        <h3 class="book-title">{{$bookRow['name']}}</h3>
                                        <span class="book-author">
                                <svg class="icon icon-arrow-r" aria-hidden="true"><use xlink:href="#icon-arrow-r"></use></svg>
                            </span>
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ol>
                </div>
                <div class="module module-toplist" data-l2="5">
                    <a href="javascript:void 0" class="book-toplist">
                        <img src="/wap/img/rank-bg-5.jpg" class="book-toplist-cover" alt="男生榜">
                        <h2 class="book-toplist-title">男生榜</h2>
                        <i class="icon icon-point-r"></i>
                    </a>
                    <ol class="book-ol book-ol-rank" data-l3="2">
                        @foreach($rankData['bookManReadWeekRankList'] as $bookRow)
                            @if($loop->iteration < 6)
                                <li class="book-li">
                                    <a href="{{url('book_detail/'. $bookRow['id'])}}" class="book-layout">
                                        <h3 class="book-title">{{$bookRow['name']}}</h3>
                                        <span class="book-author">
                                <svg class="icon icon-arrow-r" aria-hidden="true"><use xlink:href="#icon-arrow-r"></use></svg>
                            </span>
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ol>
                </div>
                <div class="module module-toplist" data-l2="6">
                    <a href="javascript:void 0" class="book-toplist" data-l3="1" data-eid="mqd_C1">
                        <img src="/wap/img/rank-bg-6.jpg" class="book-toplist-cover" alt="女生榜">
                        <h2 class="book-toplist-title">女生榜</h2>
                        <i class="icon icon-point-r"></i>
                    </a>
                    <ol class="book-ol book-ol-rank" data-l3="2">
                        @foreach($rankData['bookWomanReadWeekRankList'] as $bookRow)
                            @if($loop->iteration < 6)
                                <li class="book-li">
                                    <a href="{{url('book_detail/'. $bookRow['id'])}}" class="book-layout">
                                        <h3 class="book-title">{{$bookRow['name']}}</h3>
                                        <span class="book-author">
                                <svg class="icon icon-arrow-r" aria-hidden="true"><use xlink:href="#icon-arrow-r"></use></svg>
                            </span>
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ol>
                </div>
                <div class="module module-toplist" data-l2="7">
                    <a href="javascript:void 0" class="book-toplist">
                        <img src="/wap/img/rank-bg-7.jpg" class="book-toplist-cover" alt="热搜榜">
                        <h2 class="book-toplist-title">热搜榜</h2>
                        <i class="icon icon-point-r"></i>
                    </a>
                    <ol class="book-ol book-ol-rank" data-l3="2">
                        @foreach($rankData['bookHourSearchList'] as $key => $bookRow)
                            @if($loop->iteration < 6)
                                <li class="book-li">
                                    <a href="{{url('book_detail/'. $bookRow['id'])}}" class="book-layout">
                                        <h3 class="book-title">{{$bookRow['name']}}</h3>
                                        <span class="book-author">
                                <svg class="icon icon-arrow-r" aria-hidden="true"><use xlink:href="#icon-arrow-r"></use></svg>
                            </span>
                                    </a>
                                </li>
                            @endif
                        @endforeach

                    </ol>
                </div>
                <div class="module module-toplist" data-l2="8">
                    <a href="javascript:void 0" class="book-toplist">
                        <img src="wap/img/rank-bg-8.jpg" class="book-toplist-cover" alt="收藏榜">
                        <h2 class="book-toplist-title">收藏榜</h2>
                        <i class="icon icon-point-r"></i>
                    </a>
                    <ol class="book-ol book-ol-rank" data-l3="2">
                        @foreach($rankData['bookCollectList'] as $key => $bookRow)
                            @if($loop->iteration < 6)
                                <li class="book-li">
                                    <a href="{{url('book_detail/'. $bookRow['id'])}}" class="book-layout" data-eid="mqd_C2" data-bid="1013354614" data-auid="403291756">
                                        <h3 class="book-title">{{$bookRow['name']}}</h3>
                                        <span class="book-author">
                                <svg class="icon icon-arrow-r" aria-hidden="true"><use xlink:href="#icon-arrow-r"></use></svg>
                            </span>
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ol>
                </div>
                <div class="module module-toplist" data-l2="9">
                    <a href="javascript:void 0" class="book-toplist">
                        <img src="wap/img/rank-bg-9.jpg" class="book-toplist-cover" alt="新书榜">
                        <h2 class="book-toplist-title">新书榜</h2>
                        <i class="icon icon-point-r"></i>
                    </a>
                    <ol class="book-ol book-ol-rank" data-l3="2">
                        @foreach($rankData['bookUpdateList'] as $bookRow)
                            @if($loop->iteration < 6)
                                <li class="book-li">
                                    <a href="{{url('book_detail/'. $bookRow['id'])}}" class="book-layout">
                                        <h3 class="book-title">{{$bookRow['name']}}</h3>
                                        <span class="book-author">
                                <svg class="icon icon-arrow-r" aria-hidden="true"><use xlink:href="#icon-arrow-r"></use></svg>
                            </span>
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ol>
                </div>
                <div class="module module-toplist" data-l2="9">
                    <a href="javascript:void 0" class="book-toplist" data-l3="1" data-eid="mqd_C1">
                        <img src="wap/img/rank-bg-10.jpg" class="book-toplist-cover" alt="潜力榜">
                        <h2 class="book-toplist-title">潜力榜</h2>
                        <i class="icon icon-point-r"></i>
                    </a>
                    <ol class="book-ol book-ol-rank" data-l3="2">
                        @foreach($rankData['bookHourSearchList'] as $key => $bookRow)
                            @if($loop->iteration < 6)
                                <li class="book-li">
                                    <a href="{{url('book_detail/'. $bookRow['id'])}}" class="book-layout">
                                        <h3 class="book-title">{{$bookRow['name']}}</h3>
                                        <span class="book-author">
                                <svg class="icon icon-arrow-r" aria-hidden="true"><use xlink:href="#icon-arrow-r"></use></svg>
                            </span>
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ol>
                </div>
            </div>
        </div>
    </div>
    </body>
</html>
@endsection