@extends('layouts.web.common')

@section('title', '入香阁-全本小说网')

@section('content')
    <link rel="stylesheet" type="text/css" href="/web/css/bookauthor.css" />

    <div class="setCenter" style="margin-top: 50px">
        <div class="nMC_information">
            <div class="nMC_userImg">
                <img src="{{$user['avatar']}}" alt="" class="my-user">
            </div>
            <div class="nMC_userName">
                {{$user['nick_name']}}
            </div>
            <div class="nMC_userList">
                <img src="/web/img/user2.png" alt="">
                阅读量:{{$user['read_num']}}
                <img src="/web/img/user4.png" alt="">
                阅龄:{{$user['day_num']}}天
            </div>
        </div>
        <div class="nMC_work clearfix">
            <div class="nMC_workRight" style="width: 1060px;border-left:0px">
                <div class="nMC_workFrame clearfix" style="border-bottom:0px;margin-left:300px">
                    <a href="javascript:void 0" class="nMC_frame nMC_frameActive" data-tab="book-list">
                        我的书架
                    </a>
                    <a href="javascript:void 0" class="nMC_frame" data-tab="user-info">
                        编辑信息
                    </a>
                </div>
                <div class="book-list nMC_myCenter">
                    @if(! empty($bookList))
                        @foreach($bookList as $bookRow)
                            <div class="nMC_row clearfix">
                                @foreach($bookRow as $book)
                                    <div class="nMC_myBookList">
                                        <img src="{{$book['cover']}}" style="height: 193px;" class="nMC_bookImg" alt="" />
                                        <a href="{{url('book_detail/'. $book['id'])}}">
                                            <img src="/web/img/user11.png" class="bookShadow" alt="" />
                                        </a>
                                        <p>
                                            <a href="{{url('book_detail/'. $book['id'])}}">
                                                {{$book['name']}}
                                            </a>
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    @endif
                </div>

                <div class="user-info nMC_myCenter none">
                    <div class="nMC_edit clearfix">
                        <div class="nMC_editLeft nMC_lineHeight">
                            修改头像
                        </div>
                        <div class="nMC_editMiddle clearfix">
                            <div class="nMC_editPicture">
                                <img src="{{$user['avatar']}}" class="my-user">
                            </div>
                            <div class="nMC_choosePicture blueHover">
                                上传图片
                                <input type="file" id="selectPicture" accept="image/*" name="selectPicture">
                            </div>
                        </div>
                        <div class="nMC_editRight nMC_lineHeight">
                            {{--头像只支持JPG PNG，大小不要超过2M--}}
                        </div>
                    </div>
                    <script>
                        $("#selectPicture").change(function(){
                            $(".my-user").attr("src",URL.createObjectURL($(this)[0].files[0]));
                        })
                    </script>
                    <div class="nMC_edit clearfix">
                        <div class="nMC_editLeft">
                            修改昵称
                        </div>
                        <div class="nMC_editMiddle">
                            <input type="text" id="nick_name" class="nMC_editName nMC_input" value="{{$user['nick_name']}}">
                        </div>
                        <div class="nMC_editRight nMC_lineHeight2">
                            <p>昵称可以使用中英文或者数字符号，</p>
                            <p>限制长度在20个字符。</p>
                        </div>
                    </div>
                    <div class="nMC_edit clearfix">
                        <div class="nMC_editLeft">
                            性别选择
                        </div>
                        <div class="nMC_editMiddle">
                            <div class="nMC_sex">
                                <input class="nMC_sex" type="radio" name="sex" value="1"  @if(empty($user['sex']) || $user['sex'] == 1) checked @endif>男
                                <input class="nMC_sex" type="radio" name="sex" value="2" @if($user['sex'] == 2) checked @endif>女
                                <input class="nMC_sex" type="radio" name="sex" value="3" @if($user['sex'] == 3) checked @endif>保密
                            </div>
                        </div>
                    </div>

                    <div class="nMC_edit clearfix">
                        <div class="nMC_editLeft">
                            电子邮箱
                        </div>
                        <div class="nMC_editMiddle">
                            <input type="text" id="email" autocomplete="off" class="nMC_editbirth nMC_input" value="{{$user['email']}}">
                            <span class="nMC_bind blueHover" id="nMC_bindMail">
                                绑定邮箱
                            </span>
                            @isset($user['email'])
                                <span class="nMC_bindDone">已绑定</span>
                            @endisset
                        </div>
                        <div class="nMC_editRight nMC_lineHeight2">
                            <p>
                                &nbsp;
                            </p>
                            <p>
                                使用电子邮箱号登录或是找回密码
                            </p>
                        </div>
                    </div>
                    <div class="nMC_edit clearfix email_code none">
                        <div class="nMC_editLeft">
                            邮箱验证码
                        </div>
                        <div class="nMC_editMiddle">
                            <input type="text" id="email_code" class="nMC_editbirth nMC_input">
                            <span style="margin-left: 20px;color:#acacac" class="email_code_time">60秒后重新获取</span>
                        </div>
                    </div>

                    <div class="nMC_editSubmit">
                        <span class="blueHover">
                            保存修改
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $('.nMC_frame').click(function(){
            $('.nMC_frame').removeClass('nMC_frameActive');
            $(this).addClass('nMC_frameActive');
            $('.nMC_myCenter').addClass('none');
            $('.'+$(this).attr('data-tab')).removeClass('none');
        });

        function getStrLength(str) {
            var cArr = str.match(/[^\x00-\xff]/ig);
            return str.length + (cArr == null ? 0 : cArr.length);
        }

        var sendSubmitUrl = "{{url('user_save')}}";

        $(".nMC_editSubmit span").on("click",function(){ //点击保存或取消
            $('.nMC_input').css('border','');

            var nick_name = $("#nick_name").val();
            var sex = $("input[name='sex']:checked").val();
            var email = $("#email").val();
            var email_code = $('#email_code').val();


            if(nick_name == '' || nick_name.length > 20) {
                $("#nick_name").css("border","1px solid red");
                return false;
            }

            if(email == '') {
                $("#email").css("border","1px solid red");
                return false;
            }

            if(!(/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(email))) {
                $("#email").css("border","1px solid red");
                return false;
            }

            if(email_code == '') {
                $("#email_code").css("border","1px solid red");
            }

            var fd = new FormData();
            fd.append("nick_name", nick_name);
            fd.append("sex", sex);
            fd.append("email", email);
            fd.append("email_code", email_code);
            fd.append("avatar", $("#selectPicture")[0].files[0]);

            $.ajax({
                type:"POST",
                url:sendSubmitUrl,
                data:fd,
                processData:false,
                contentType:false,
                success:function(data){
                    layer.msg(data.msg);
                    if(data.status == 3) {
                        setTimeout(function(){
                            window.location.reload();
                        }, 1000)
                    }

                }
            });

        });

        var sendEmailUrl = "{{url('send_email')}}";

        //bind mail  绑定邮箱
        (function bindMail(){
            var mailTimer=null; //手机计时器
            var mailStart=60;
            var mailBoolean = true; //不能重复触发
            $("#nMC_bindMail").on("click",function(){
                $("#email").css("border","");
                var email = $("#email").val();
                var mailTest=(/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(email));

                if(mailTest){  //正则验证邮箱号
                    $(".email_code").removeClass('none');
                    if(mailBoolean){
                        $.ajax({
                            type:"POST",
                            url:sendEmailUrl,
                            data:{email:email},
                            success:function(data){
                            }
                        });

                        mailTimer=setInterval(function(){
                            mailStart--;
                            $(".email_code_time").html( mailStart+"秒后重新获取");
                            if( mailStart <= 0){
                                mailStart = 60;
                                mailBoolean = true;
                                $(".email_code_time").html( mailStart+"秒后重新获取");
                                clearInterval(mailTimer);
                            }
                        },1000);
                    }
                    mailBoolean = false; //阻止重复触发计时器
                }else{
                    $("#email").css("border","1px solid red");
                }
            });
        })();
    </script>

@endsection