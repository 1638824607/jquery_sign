@extends('layouts.wap.common')

@section('title', '入香阁-全本小说网-书单')

@section('content')

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
            width: 12%;
        }

        .select-sign{
            margin-left: 10px;
            background: url('/wap/img/select_under1.png') no-repeat;
            background-position: right;
            background-size: auto 60%;
            padding:2px;
            text-align: left;
            float: left;
            font-size: 15px;
            width: 12%;
            color: #ff5a4b;
        }

        .book-item{
            /*width: 100%;*/
            /*height: 100%;*/
            position: relative;
            background-color: #fff;
            z-index: 22;
            margin-top: 10px;
            padding:5%;
        }

        .inner{
            width: 100%;
            height: 100%;
            overflow-y: auto;
            padding: .26667rem .4rem 1.6rem;
        }

        .item-section .title{
            height: .66667rem;
            line-height: .66667rem;
            margin-bottom: 10px;
            margin-top: 10px;
            font-weight: 400;
            display: block;
            margin-block-start: 1.33em;
            margin-block-end: 1.33em;
            margin-inline-start: 0px;
            margin-inline-end: 0px;
            /*font-weight: bold;*/
        }

        .item-section li{
            display: inline-block;
            vertical-align: middle;
            width: 23%;
            height: 2rem;
            line-height: 2rem;
            /*margin-right: .6rem;*/
            margin-bottom: .4rem;
            text-align: center;
            border: 1px solid #ebebeb;
            border-radius: 2px;
            background: #fff;
            color: #aaa;
            font-size: 12px;
        }

        .book-tag a{
            font-size: 10px;
            border: 1px solid white;
            width: 12%;
        }

        .shuangwen .active{
            border: 1px solid;
            color: #ff5a4b;
        }


    </style>
    <div class="modelx shuangwen  bg clearfix" style="margin:auto">
        <div class="smn book-sort" style="padding: 5%">
            <a data-sort="collectorCount" data-duration="last-seven-days"  style="width: 30%" class="active" title="本周最热">本周最热</a>
            <a data-sort="created" data-duration="all" style="width: 30%" title="最新发布">最新发布</a>
            <a data-sort="collectorCount" data-duration="all" style="width: 30%" title="最多收藏">最多收藏</a>
        </div>

        <div class="smn book-tag" style="padding: 5%">
            <a data-tag="" class="tag-li active" title="全部">全部</a>
            <a data-tag="言情" class="tag-li" title="言情">言情</a>
            <a data-tag="穿越" class="tag-li" title="穿越">穿越</a>
            <a data-tag="职场" class="tag-li" title="职场">职场</a>
            <a data-tag="都市" class="tag-li" title="都市">都市</a>
            <span class="select-sign">筛选</span>
        </div>

        <div class="book-item none">
            <div class="inner">
                <div class="item-section book-gender">
                    <h4 class="title" data-gender="">性别</h4>
                    <ul>
                        <li data-gender="male">男生</li>
                        <li data-gender="female">女生</li>
                    </ul>
                </div>
                <div class="book-tag">
                    <div class="item-section">
                        <h4 class="title">时空</h4>
                        <ul>
                            <li class="tag-li" data-tag="都市">都市</li>
                            <li class="tag-li" data-tag="古代">古代</li>
                            <li class="tag-li" data-tag="科幻">科幻</li>
                            <li class="tag-li" data-tag="架空">架空</li>
                            <li class="tag-li" data-tag="重生">重生</li>
                            <li class="tag-li" data-tag="未来">未来</li>
                            <li class="tag-li" data-tag="穿越">穿越</li>
                            <li class="tag-li" data-tag="历史">历史</li>
                            <li class="tag-li" data-tag="快穿">快穿</li>
                            <li class="tag-li" data-tag="末世">末世</li>
                            <li class="tag-li" data-tag="异界位面">异界位面</li>
                        </ul>
                    </div>
                    <div class="item-section">
                        <h4 class="title">情感</h4>
                        <ul>
                            <li class="tag-li" data-tag="纯爱">纯爱</li>
                            <li class="tag-li" data-tag="热血">热血</li>
                            <li class="tag-li" data-tag="言情">言情</li>
                            <li class="tag-li" data-tag="现言">现言</li>
                            <li class="tag-li" data-tag="古言">古言</li>
                            <li class="tag-li" data-tag="情有独钟">情有独钟</li>
                            <li class="tag-li" data-tag="搞笑">搞笑</li>
                            <li class="tag-li" data-tag="青春">青春</li>
                            <li class="tag-li" data-tag="欢喜冤家">欢喜冤家</li>
                            <li class="tag-li" data-tag="爽文">爽文</li>
                            <li class="tag-li" data-tag="虐文">虐文</li>
                        </ul>
                    </div>
                    <div class="item-section">
                        <h4 class="title">人设</h4>
                        <ul>
                            <li class="tag-li" data-tag="同人">同人</li>
                            <li class="tag-li" data-tag="娱乐明星">娱乐明星</li>
                            <li class="tag-li" data-tag="女强">女强</li>
                            <li class="tag-li" data-tag="帝王">帝王</li>
                            <li class="tag-li" data-tag="职场">职场</li>
                            <li class="tag-li" data-tag="女配">女配</li>
                            <li class="tag-li" data-tag="网配">网配</li>
                            <li class="tag-li" data-tag="火影">火影</li>
                            <li class="tag-li" data-tag="金庸">金庸</li>
                            <li class="tag-li" data-tag="豪门">豪门</li>
                            <li class="tag-li" data-tag="扮猪吃虎">扮猪吃虎</li>
                            <li class="tag-li" data-tag="谋士">谋士</li>
                            <li class="tag-li" data-tag="特种兵">特种兵</li>
                            <li class="tag-li" data-tag="教师">教师</li>
                        </ul>
                    </div>
                    <div class="item-section">
                        <h4 class="title">流派</h4>
                        <ul>
                            <li class="tag-li" data-tag="变身">变身</li>
                            <li class="tag-li" data-tag="悬疑">悬疑</li>
                            <li class="tag-li" data-tag="系统">系统</li>
                            <li class="tag-li" data-tag="网游">网游</li>
                            <li class="tag-li" data-tag="推理">推理</li>
                            <li class="tag-li" data-tag="玄幻">玄幻</li>
                            <li class="tag-li" data-tag="武侠">武侠</li>
                            <li class="tag-li" data-tag="仙侠">仙侠</li>
                            <li class="tag-li" data-tag="恐怖">恐怖</li>
                            <li class="tag-li" data-tag="奇幻">奇幻</li>
                            <li class="tag-li" data-tag="洪荒">洪荒</li>
                            <li class="tag-li" data-tag="犯罪">犯罪</li>
                            <li class="tag-li" data-tag="百合">百合</li>
                            <li class="tag-li" data-tag="种田">种田</li>
                            <li class="tag-li" data-tag="惊悚">惊悚</li>
                            <li class="tag-li" data-tag="轻小说">轻小说</li>
                            <li class="tag-li" data-tag="技术流">技术流</li>
                            <li class="tag-li" data-tag="耽美">耽美</li>
                            <li class="tag-li" data-tag="竞技">竞技</li>
                            <li class="tag-li" data-tag="无限">无限</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="container book-list-container" style="margin-top: 2.5rem">
        </div>
    </div>
</body>
</html>
    <script src="/web/lib/layer/layer.js"></script>
<script>
    var book_detail_url = "{{url('poly/book_detail')}}/";
    var h = 0;
    var start = 1;
    var load_status = true;

    var static_url = "{{config('app.static_url')}}";

    $(function(){
        ajax_book_list('collectorCount', 'last-seven-days', '', '',start, 'click');
    });

    $('.book-sort a').click(function()
    {
        start = 1;
        load_status = true;

        $(this).addClass('active').siblings('a').removeClass('active');

        var sort     = $('.book-sort').find('.active').attr('data-sort');
        var duration = $('.book-sort').find('.active').attr('data-duration');
        var gender   = $('.book-gender').find('.active').attr('data-gender');
        var tag      = $('.book-tag').find('.active').attr('data-tag');


        ajax_book_list(sort, duration, gender, tag, start, 'click');

        h = $('.shuangwen').offset().top;

        $('body,html').animate({scrollTop:h},500)
    });


    $('.book-gender li').click(function()
    {
        start = 1;
        load_status = true;

        $(this).addClass('active').siblings('li').removeClass('active');

        var sort     = $('.book-sort').find('.active').attr('data-sort');
        var duration = $('.book-sort').find('.active').attr('data-duration');
        var gender   = $('.book-gender').find('.active').attr('data-gender');
        var tag      = $('.book-tag').find('.active').attr('data-tag');

        ajax_book_list(sort, duration, gender, tag, start, 'click');

        h = $('.shuangwen').offset().top;

        $('body,html').animate({scrollTop:h},500)
    });

    $('.book-tag .tag-li').click(function()
    {
        start = 1;
        load_status = true;

        $('.tag-li').removeClass('active');
        $(this).addClass('active');

        var sort     = $('.book-sort').find('.active').attr('data-sort');
        var duration = $('.book-sort').find('.active').attr('data-duration');
        var gender   = $('.book-gender').find('.active').attr('data-gender');
        var tag      = $('.book-tag').find('.active').attr('data-tag');

        ajax_book_list(sort, duration, gender, tag, start, 'click');

        h = $('.shuangwen').offset().top;

        $('body,html').animate({scrollTop:h},500)
    });

    var bookListStatus = true;

    $('.select-sign').click(function(){
        $('.book-item').toggleClass('none');
        $('.book-list-container').toggleClass('none');
        if($('.book-item').hasClass('none')) {
            bookListStatus = true;
        }else{
            bookListStatus = false;
        }

    });
    function ajax_book_list(sort , duration, gender, tag, page, load_type)
    {
        $('.book-item').addClass('none');
        $('.book-list-container').removeClass('none');

        var appendHtml = '';


        if(load_status){
            layer.load(2);
            load_status = false;

            $.ajax({
                type: "POST",
                url: "{{url('poly/book_list')}}",
                data:
                    {
                        sort:sort,
                        duration:duration,
                        gender:gender,
                        tag:tag,
                        start:page
                    },
                dataType:'json',
                success: function(data)
                {
                    console.log(data);
                    if(! $.isEmptyObject(data.data)) {
                        $.each(data.data, function(k, v){
                            appendHtml += '<div class="rowone clearfix">';
                            appendHtml += '<a href="'+book_detail_url+ v._id +'">';
                            appendHtml += '<div class="fl rleft">';
                            appendHtml += '<img class="lazy" data-original="'+static_url + v.cover+'" /></div>';
                            appendHtml += '<div class="fl rright">';
                            appendHtml += '<h3>'+v.title+'</h3>';
                            appendHtml += '<p class="twd">'+v.desc+'</p>';
                            appendHtml += '<p>'+v.author+'|<b>'+v.bookCount+'</b><b class="fr">'+v.collectorCount+'收藏</b></p></div> </a> </div>';
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

                        load_status = true;

                        start++;
                    }else{
                        if(load_type == 'click'){
                            $('.book-list-container').html('<div class="nomore clearfix">暂无数据~</div>');
                        }else{
                            $('.book-list-container').append('<div class="nomore clearfix">已经到底啦~</div>');
                        }
                    }

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
            var sort     = $('.book-sort').find('.active').attr('data-sort');
            var duration = $('.book-sort').find('.active').attr('data-duration');
            var gender   = $('.book-gender').find('.active').attr('data-gender');
            var tag      = $('.book-tag').find('.active').attr('data-tag');

            if($('.book-item').hasClass('none')) {
                ajax_book_list(sort, duration, gender, tag, start, 'scroll');
            }

        }
    });

    function delHtmlTag(str)
    {
        return str.replace(/<[^>]+>/g,"");//去掉所有的html标记
    }

</script>
@endsection
