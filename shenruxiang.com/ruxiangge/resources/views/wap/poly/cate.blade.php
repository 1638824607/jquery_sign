@extends('layouts.wap.common')

@section('title', '入香阁-全本小说网-'.$major)

@section('content')
    <div class="modelx shuangwen bg clearfix" style="margin: 0">
        <div class="container">
            <h2 class="boy1">{{$major}}</h2>
        </div>
    </div>
    <style>
        .smn .active {
            border: 1px solid;
            border-radius: 99px;
        }
        .smn a{
            padding:4px;
        }
        .book-minor a{
            font-size: 10px;
            border: 1px solid white;
            width: 16%;
        }
    </style>
    <div class="modelx shuangwen  bg clearfix search-book-a" style="margin:auto">
        <div class="smn book-type book-major" style="padding: 5%">
            <a data-type="hot" style="width: 16%" class="active" title="热门">热门</a>
            <a data-type="new" style="width: 16%" title="新书">新书</a>
            <a data-type="reputation" style="width: 16%" title="好评">好评</a>
            <a data-type="over" style="width: 16%" title="完结">完结</a>
        </div>

        @if(!empty($cateLvList))
            <div class="smn book-minor" style="padding: 5%">
                <a data-type="" class="active" title="所有">所有</a>
                @foreach($cateLvList as $cateLvRow)
                    <a data-type="{{$cateLvRow}}" title="{{$cateLvRow}}">{{$cateLvRow}}</a>
                @endforeach
            </div>
            <br>
        @endif
        <div class="container book-list-container" style="margin-top: 2.5rem">
        </div>
    </div>

    </body>
    </html>
    <script src="/web/lib/layer/layer.js"></script>
    <script>
        var book_detail_url = "{{url('poly/detail')}}/";
        var h = 0;
        var start = 1;
        var load_status = true;

        var static_url = "{{config('app.static_url')}}";
        var gender = "{{$gender}}";
        var major = "{{$major}}";

        $(function(){
            ajax_book_list('hot', '', start, 'click');
        });

        $('.search-book-a a').click(function()
        {
            start = 1;

            $(this).addClass('active').siblings('a').removeClass('active');

            var type = $('.book-major > .active').attr('data-type');
            var minor = $('.book-minor > .active').attr('data-type');

            ajax_book_list(type, minor, start, 'click');

            h = $('.search-book-a').offset().top;

            $('body,html').animate({scrollTop:h},500)
        });

        function ajax_book_list(type, minor, page, load_type)
        {
            var appendHtml = '';

            if(load_status){
                layer.load(2);
                load_status = false;

                $.ajax({
                    type: "POST",
                    url: "{{url('poly/cate')}}",
                    data:
                        {
                            gender : gender,
                            major : major,
                            type: type,
                            minor:minor,
                            start:page
                        },
                    dataType:'json',
                    success: function(data)
                    {
                        if(! $.isEmptyObject(data.data.books)) {
                            $.each(data.data.books, function(k, v){
                                appendHtml += '<div class="rowone clearfix">';
                                appendHtml += '<a href="'+book_detail_url+ v._id +'">';
                                appendHtml += '<div class="fl rleft">';
                                appendHtml += '<img class="lazy" data-original="'+static_url + v.cover+'" /></div>';
                                appendHtml += '<div class="fl rright">';
                                appendHtml += '<h3>'+v.title+'</h3>';
                                appendHtml += '<p class="twd">'+delHtmlTag(v.shortIntro)+'</p>';
                                appendHtml += '<p>'+v.author+'|<b>'+v.majorCate+'</b><b class="fr">'+v.latelyFollower+'人气</b></p></div> </a> </div>';
                            });

                            if(load_type == 'click')
                            {
                                $('.book-list-container').html(appendHtml);
                            }else {
                                $('.book-list-container').append(appendHtml);
                            }
                            $("img.lazy").lazyload({
                                placeholder : "/wap/img/book-cover.svg",
                                effect: "fadeIn"
                            });

                            start++;
                        }else{
//                            $('.book-list-container').append('<div class="nomore clearfix">已经到底啦~</div>');
                        }



                        load_status = true;

                        layer.closeAll();

                    }
                });
            }
        }

        $(window).scroll(function(){
            var scrollTop = $(this).scrollTop();    //滚动条距离顶部的高度
            var scrollHeight = $(document).height();   //当前页面的总高度
            var clientHeight = $(this).height();    //当前可视的页面高度

            if(scrollTop + clientHeight >= scrollHeight){   //距离顶部+当前高度 >=文档总高度 即代表滑动到底部 count++;         //每次滑动count加1
                var type = $('.book-major > .active').attr('data-type');
                var minor = $('.book-minor > .active').attr('data-type');
                ajax_book_list(type, minor, start, 'scroll');

            }
        });

        function delHtmlTag(str)
        {
            return str.replace(/<[^>]+>/g,"");//去掉所有的html标记
        }

    </script>
@endsection
