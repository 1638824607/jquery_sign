@extends('layouts.web.common')

@section('title', $chapterRow['name'].'-'.$bookRow['name'].'-入香阁')

@section('content')
    <style>
        body{
            background:#e5e4db
        }

    </style>
    <link rel="stylesheet" type="text/css" href="/web/css/reads.css" />
    <div class="reads">
        <div class="container">
            <div class="reading">
                <h2>
                    <b class="bd-radius50"></b>
                    <a href="{{url('/')}}" title="">首页</a>&gt;
                    <a href="{{url('book_list/'.$bookReaderList[$bookRow['reader_type']]['id'])}}" title="">
                        {{$bookReaderList[$bookRow['reader_type']]['name']}}</a> &gt;
                    <a href="{{url('book_list/0/'.$bookTypeList[$bookRow['type']]['id'])}}" title="">
                        {{$bookTypeList[$bookRow['type']]['name']}}
                    </a> &gt;
                    <a href="{{url('book_detail/'. $bookRow['id'])}}" title="{{$bookRow['name']}}">
                        {{$bookRow['name']}}
                    </a> &gt;
                    {{$chapterRow['name']}}
                </h2>

                <!--循环内容区-->
                <div class="contents">
                    <h1>{{$chapterRow['name']}}</h1>
                    <p class="otinfo">作者：<a class="authorFont" href="{{url('book_author/'. $bookRow['id']. '/' .$bookRow['author_name'])}}">{{$bookRow['author_name']}}</a><b>|</b>{{$chapterRow['updated_at']}}&nbsp;更新<b>|</b><span class="chapter-word"></span>字</p>
                    <!--文字-->
                    <div class="fonts">
                        <!--文字内容-->
                        <div class="allfonts">
                            <p style="text-indent:2em;"></p>
                            <?php echo empty($chapterContent) ? '' : $chapterContent ?>
                        </div>
                        <!--文字内容 end-->
                        <!--作者的话-->
                        <!--作者的话 end-->
                        <!--提示操作-->
                        <div class="read_tool clearfix">
                            <span class="fl">
                                可以使用键盘  ←
                                <a href="{{url('book_chapter_detail/'.$chapterFirstId.'/'.$bookRow['id'])}}" class="prepage">
                                    上一章
                                </a>
                            </span>
                            {{--<span class="fl center">--}}
                                {{--<b>2/54</b>--}}
                            {{--</span>--}}
                            <span class="fr right">
                                <a href="{{url('book_chapter_detail/'.$chapterLastId.'/'.$bookRow['id'])}}" class="nextpage">
                                    下一章
                                </a>
                                可以使用键盘  →
                            </span>
                        </div>
                    </div>

                </div>

                <!--右边工具条-->
                <div class="right_tool">
                    <div class="tools">
                        <a href="{{url('book_detail/'.$bookRow['id'])}}#book_dir" title="返回目录">目录</a>
                        <a href="{{url('book_detail/'.$bookRow['id'])}}#book_info" title="查看简介">简介</a>
                        <a href="javascript:;" title="放大字体" class="bigfonts" onclick="$.bigsize(this)">A+</a>
                        <a href="javascript:;" title="缩小字体" class="smfonts" onclick="$.smsize(this)">A-</a>
                        <a href="javascript:;" title="上下自动加载" class="udread" onclick="$.keyLrRd(this)"></a>
                        <b title="白天夜晚切换" class="lrlight" onclick="$.lrlight(this)"></b>
                    </div>
                </div>
                <!--右边工具条end-->
            </div>
        </div>
    </div>

    <script type="text/javascript" src="/web/js/jquery.qqFace.js"></script>
    <script type="text/javascript" src="/web/js/readings.js"></script>
    <script type="text/javascript" src="/web/js/erweima.js"></script>
    <script type="text/javascript">
        $(function(){
            //统计章节字数
            $('.chapter-word').text($('.allfonts').text().length);

            //鼠标左右翻页
            //上一章
            function loadpre(){
                location.href="{{url('book_chapter_detail/'.$chapterFirstId.'/'.$bookRow['id'])}}";
            }

            //下一章
            function loadnext(){
                location.href="{{url('book_chapter_detail/'.$chapterLastId.'/'.$bookRow['id'])}}";
            }
            $('html,body').keydown(function(event){
                if(event.keyCode == 37){
                    loadpre();
                }else if (event.keyCode == 39){
                    loadnext();
                }
            })

            //点击
            $('.reads .prepage').on('click',function(){
                loadpre()
            })

            $('.reads .nextpage').on('click',function(){
                loadnext()
            })

            var readbg = $.cookie('www_readbg');

            if(readbg){
                if(readbg == 'night'){
                    $('.reads').addClass('readnight');
                }
                if(readbg == 'day'){
                    $('.reads').removeClass('readnight');
                }
            }
            //黑夜
            $.lrlight = function lrlight(){
                $('.reads').toggleClass('readnight');
                if($('.reads').hasClass('readnight')){
                    $.cookie('www_readbg','night',{expires:30,path:'/'});
                }else{
                    $.cookie('www_readbg','day',{expires:30,path:'/'});
                }
            }

            var readfont = $.cookie('www_readfont');
            if(readfont){
                $('.reads .contents .fonts').css({'font-size':readfont+'px'});
            }
            //字体大小
            var fontSize = 18;
            $.bigsize = function bigsize(obj){
                fontSize++;
                if(fontSize>30){
                    fontSize =30;
                }
                $('.reads .contents .fonts').css({'font-size':fontSize});
                $.cookie('www_readfont',fontSize,{expires:30,path:'/'});
            }
            //小字体
            $.smsize = function smsize(){
                fontSize--;
                if(fontSize<14){
                    fontSize =14;
                }
                $('.reads .contents .fonts').css({'font-size':fontSize});
                $.cookie('www_readfont',fontSize,{expires:30,path:'/'});
            }

            $.keyLrRd = function keyLrRd(obj){
                $.cookie('www_keySwitch','0',{expires:30,path:'/'});
                window.location.reload();
            }
        })

        document.body.onselectstart=document.body.oncontextmenu=function(){return false;};
        document.body.onselectstart = document.body.ondrag = function(){return false;}

    </script>
    <script>
        $('#metakeywords').attr('content', "{{$chapterRow['name']}},{{$bookRow['name']}}");
        $('#metadescription').attr('content', "{{$bookRow['name']}}最新章节{{$chapterRow['name']}}免费阅读");
    </script>
@endsection