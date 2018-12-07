@extends('layouts.wap.common')

@section('title', '入香阁-全本小说网-我的书架')

@section('content')
<div class="newwap">
    <div class="readhistory bg clearfix">
        <div class="container">
            <div class="hita">
                <div class="hista">
                    <a href="{{url('poly/book_history')}}">浏览历史</a>
                    <a href="{{url('poly/book_collect_list')}}" class="active">我的书架</a>
                </div>
                @if(! empty($userBookList))
                <h2>共{{count($userBookList)}}本 <span class="fr "><b class="edqxl">取消</b><b class="editdel " data-rel="0">管理</b></span></h2>
                <ul class="clearfix">

                        @foreach($userBookList as $userBookRow)
                            <li>
                                <em class="delmb" onclick="delCollect(this)" data-id="{{$userBookRow['id']}}" style="height: 1.8rem"></em>
                                <a href="@if(!empty($userBookRow['poly_status'])){{url('poly/detail/'.$userBookRow['id'])}}@else{{url('book_detail/'.$userBookRow['id'])}}@endif">
                                    <span class="fl left">
                                        <img class="lazy" data-original="{{$userBookRow['cover']}}" />
                                    </span>
                                    <span class="fl right">
                                        <h3>
                                            <span>{{$userBookRow['name']}}<b>{{isset($userBookRow['is_serial']) && !empty($userBookRow['is_serial']) ? '连载' : '完结'}}</b></span>
                                        </h3>
                                        <h5>{{$userBookRow['author_name']}}</h5>
                                        {{--<h5>全文完结：第八百四十章 大结局</h5>--}}
                                    </span>
                                </a>
                            </li>
                        @endforeach
                </ul>
                @endif
            </div>
        </div>
    </div>
    <!--尾部 end-->
</div>
<script type="text/javascript" src="/web/lib/layer/mobile/layer.js"></script>
<script>
    var delcollectUrl = "{{url('book_collect_del')}}";

    var del_collect_id = new Array();

    function delCollect(obj){
        var collect_id = $(obj).attr('data-id');

        if($(obj).hasClass('delx')){
            $(obj).removeClass('delx');
            del_collect_id.remove(collect_id);
        }else{
            $(obj).addClass('delx');
            del_collect_id.push(collect_id);
        }
        if(del_collect_id!=''){
            $('.readhistory .editdel').attr('data-rel','1');
        }else{
            $('.readhistory .editdel').attr('data-rel','0');
        }

    }

    //删除书架管理
    $('.readhistory .editdel').on('click',function(){
        var IsDel = $(this).attr('data-rel');
        $(this).addClass('edel').html('删除');
        $('.readhistory .edqxl,.readhistory li .delmb').show();
        if(IsDel == 1 ){

            layer.open({
                content: '删除后无法恢复，您确定删除吗？'
                ,btn: ['确定', '取消']
                ,yes: function(index){
                    var collect_id = '';
                    for(var i=0;i<del_collect_id.length;i++){
                        collect_id+=del_collect_id[i]+',';
                    }
                    collect_id.substring(0,del_collect_id.length-1);

                    $.ajax({
                        url:delcollectUrl,
                        type:"POST",
                        async:false,
                        cache:false,
                        data:{
                            book_ids:collect_id
                        },
                        success:function(data){
                            console.log(data);
                            if(data.status === 3){
                                location.reload();
                                layer.close(index);
                            }else{
                                layer.close(index);
                                layer.open({
                                    content: data.msg
                                    ,skin: 'msg'
                                    ,time: 1 //2秒后自动关闭
                                });
                            }
                        }
                    });



                }
            });
        }
    });

    //取消书架管理
    function DelEnd(){
        $('.readhistory .edqxl,.readhistory li .delmb').hide();
        $('.readhistory .editdel').attr('data-rel','0');
        $('.readhistory .editdel').removeClass('edel').html('管理');
        $('.readhistory .delmb').removeClass('delx');
        del_collect_id = new Array();
    }
    $('.readhistory .edqxl').on('click',function(){
        DelEnd();
    });

    Array.prototype.remove = function(val) {
        var index = this.indexOf(val);
        if (index > -1) {
            this.splice(index, 1);
        }
    };

</script>
</body>
</html>
@endsection