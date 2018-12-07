@extends('layouts.wap.common')

@section('title', '入香阁-全本小说网-'.$bookTypeList[$type]['name'])

@section('content')
    <div class="modelx shuangwen bg clearfix" style="margin: 0">
        <div class="container">
            <h2 class="boy1">{{$bookTypeList[$type]['name']}}</h2>
        </div>
    </div>
    <div class="meinfo daypush bg clearfix">
        <div class="clearfix blurs swiper-container" style="padding: 0px" id="banner">
            <div class="swiper-wrapper">
                @foreach($bookCarouselList as $key => $bookRow)
                    <a class="swiper-slide" href="{{url('book_detail/'.$bookRow['id'])}}">
                        <div class="myblur">
                            <b class="dtip">推荐精选</b>
                            <img src="{{$bookRow['cover']}}" id="blur" class="blur" />
                        </div>
                        <div class="dinfo clearfix">
                            <div class="fl dleft">
                                <img src="{{$bookRow['cover']}}" />
                            </div>
                            <div class="fl dright">
                                <h3>{{$bookRow['name']}}</h3>
                                <p class="twd">{!! $bookRow['description'] !!}</p>
                                <p><b>{{$bookTypeList[$bookRow['type']]['name']}}</b></p>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

        </div>

        <script type="text/javascript">
            var swiper = new Swiper('#banner',{
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                },
                speed:1000,
                autoplayDisableOnInteraction : false,
                loop:'loop',
                centeredSlides : true,
                slidesPerView:1,
                pagination : '.swiper-pagination',
                paginationClickable:true,
                prevButton:'.swiper-button-prev',
                nextButton:'.swiper-button-next',
                onInit:function(swiper){
                    swiper.slides[2].className="swiper-slide swiper-slide-active";//第一次打开不要动画
                },
                breakpoints: {
                    668: {
                        slidesPerView:1,
                    }
                },spaceBetween: 0
            });
        </script>
    </div>
    <style>
        .smn .active {
            border: 1px solid;
            border-radius: 99px;
        }
        .smn a{
            padding:4px;
        }
    </style>
    <div class="modelx shuangwen  bg clearfix search-book-a">
        <div class="smn" style="padding: 5%">
        <a data-type="popular" style="width: 16%" class="active" title="人气">人气</a>
        <a data-type="word" style="width: 16%" title="字数">字数</a>
        <a data-type="update" style="width: 16%" title="更新">更新</a>
        <a data-type="collect" style="width: 16%" title="收藏">收藏</a>
        <a data-type="read" style="width: 16%" title="点击">点击</a>
        </div>
        <div class="container book-list-container" style="margin-top: 1.5rem">
        </div>

    </div>
</body>
</html>
    <script src="/web/lib/layer/layer.js"></script>
<script>
    var type = "{{$type}}";
    var book_detail_url = "{{url('book_detail')}}/";
    var book_type_list = eval({!! json_encode(($bookTypeList)) !!});
    var h = 0;
    var current_click = 0;
    var page = 1;
    var load_type = 'type';
    var searchType = 'popular';
    var load_status = true;

    $(function(){
        ajax_book_list(type, searchType);
    });

    $('.search-book-a a').click(function()
    {
        current_click = $('.smn>.active').attr('data-type');

        page = 1;
        load_type = 'type';

        $(this).addClass('active').siblings('a').removeClass('active');

        searchType = $(this).attr('data-type');

        ajax_book_list(type, searchType,page, load_type);

        h = $('.search-book-a').offset().top;
        $('body,html').animate({scrollTop:h},500)
    });

    function ajax_book_list(type, searchType, current_page, load_type)
    {
        var appendHtml = '';

        if(load_status){
            layer.load(2);
            load_status = false;

            $.ajax({
                type: "POST",
                url: "{{url('book_list_load')}}",
                data:
                    {
                        type:type,
                        search_type:searchType,
                        page:current_page||1
                    },
                dataType:'json',
                success: function(data)
                {
                    if(! $.isEmptyObject(data.data.data)) {
                        $.each(data.data.data, function(k, v){
                            appendHtml += '<div class="rowone clearfix">';
                            appendHtml += '<a href="'+book_detail_url+ v.id +'">';
                            appendHtml += '<div class="fl rleft">';
                            appendHtml += '<img class="lazy" data-original="'+v.cover+'" /></div>';
                            appendHtml += '<div class="fl rright">';
                            appendHtml += '<h3>'+v.name+'</h3>';
                            appendHtml += '<p class="twd">'+v.description.replace('<br>', '')+'</p>';
                            appendHtml += '<p>'+v.author_name+'|<b>'+book_type_list[v.type]['name']+'</b><b class="fr">完结</b></p></div> </a> </div>';
                        });

                        if(load_type == 'type')
                        {
                            $('.book-list-container').html(appendHtml);
                        }else {
                            $('.book-list-container').append(appendHtml);
                        }

                        $("img.lazy").lazyload({
                            placeholder : "/wap/img/book-cover.svg",
                            effect: "fadeIn"
                        });

                        page++;
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

        load_type = 'scroll';

        if(scrollTop + clientHeight >= scrollHeight){   //距离顶部+当前高度 >=文档总高度 即代表滑动到底部 count++;         //每次滑动count加1
            ajax_book_list(type, searchType, page, load_type);

        }
    });

</script>
@endsection
