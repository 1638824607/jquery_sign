<div class="footer bg">
    <div class="container">
        <div class="ftmenu clearfix">
            <a href="{{url('/')}}">首页</a>
            <a href="{{url('book_category')}}">分类</a>
            <a href="{{url('book_recommend')}}">推荐</a>
            <a href="{{url('book_rank')}}">排行</a>
            <a href="{{url('user')}}">我的</a>
        </div>
        <p>&copy; m.shenruxiang.com 入香阁全本小说网手机版</p>
    </div>
</div>
<script>
    $("img.lazy").lazyload({
        placeholder : "/wap/img/book-cover.svg",
        effect: "fadeIn"
    });
</script>