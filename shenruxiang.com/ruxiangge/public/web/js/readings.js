$(function(){
         //关闭提示下载
        $('.reads .tipsdown .tipsclose').on('click',function(){
          $('.reads .tipsdown').remove();
//          $('.reads .contents').css('padding','20px');
        }) 
     //打开评论
      $body = (window.opera) ? (document.compatMode == "CSS1Compat" ? $('html') : $('body')) : $('html,body');
      $.tocomt = function tocomt(obj){
          
          var total = $(obj).children().text();
          // var ps = '5';
          // var pageNum = Math.ceil(total/ps);

          if(total>5){
              var ps = '5';
              var totalPage = Math.ceil(total/ps);
              // var start_num = $(obj).parents('.threebtn').next().children('.start_num');
              var page_num = $(obj).parents('.threebtn').next().children('.page_num');
              // start_num.val('0');
              page_num.val('1');
              var N_page = $(obj).parents('.threebtn').next().children('.N_page');
              for(var i=1;i<=totalPage;i++){
                if(i==1){

                  N_page.append('<a href="###" class="N_pageBtn active" onclick="$.page(this)">'+i+'</a>');
                }else{
                  N_page.append('<a href="###" class="N_pageBtn" onclick="$.page(this)">'+i+'</a>');
                }
              }
              N_page.append('<a href="###" class="N_pageN" onclick="$.nextPage(this)">下一页</a>');
              N_page.append('<a href="###" class="N_pageP" onclick="$.prevPage(this)">上一页</a>');
              
              var comtlist = $(obj).parents('.threebtn').next().children('.comment_responseContent').children('.throw_comment').children();
              comtlist.css('display', 'none').slice('0', ps).css('display', 'block');

          }
          $('.comments').hide();
         $('.comments').children('.comtext').find('textarea').attr('class','');
         $(obj).parents('.threebtn').siblings('.comments').show();
         $(obj).parents('.threebtn').siblings('.comments').children('.comtext').find('textarea').attr('class','NC_txt');
          
          var threebtn = $(obj).parents('.threebtn');
          var comments =  threebtn.siblings('.comments'); 
          threebtn.siblings('.comments').toggleClass('comblock'); 
          threebtn.siblings('.comments').find('textarea').focus();
          $body.animate({scrollTop: comments.offset().top - 100}, 1000);
          return false; 
      }

      $.page = function page(obj){
          var page_num = $(obj).text();
          var ps = '5';

          var end_num = ps*page_num;
          var start_num = ps*page_num-ps;

          $(obj).parent().next().val(page_num);

          var comtlist = $(obj).parent().prev().children('.throw_comment').children();
          comtlist.css('display','none').slice(start_num,end_num).css('display','block');

          $(obj).parent().children('.active').removeClass('active');
          $(obj).addClass('active');
      }

      $.prevPage = function prevPage(obj){
          var page_num = $(obj).parent().next().val();
          var go_page = parseInt(page_num)-1;
          var ps = '5';
          if(go_page > 0){
              var end_num = ps*go_page;
              var start_num = ps*go_page-ps;
              $(obj).parent().prev().children('.throw_comment').children().css('display','none').slice(start_num,end_num).css('display','block');
              $(obj).parent().children('.active').removeClass('active');
              $(obj).parent().children().eq(go_page-1).addClass('active');
              $(obj).parent().next().val(go_page);
          }
      }

      $.nextPage = function nextPage(obj){
          var page_num = $(obj).parent().next().val();
          var total = $(obj).parent().parent().prev().children('.tocomt').children().text();
          var ps = '5';

          var go_page = parseInt(page_num)+1;
          var max_page = Math.ceil(total/ps);

          if(go_page <= max_page){
              var end_num = ps*go_page;
              var start_num = ps*go_page-ps;
              $(obj).parent().prev().children('.throw_comment').children().css('display','none').slice(start_num,end_num).css('display','block');
              $(obj).parent().children('.active').removeClass('active');
              $(obj).parent().children().eq(go_page-1).addClass('active');
              $(obj).parent().next().val(go_page);
          }
      }

       //回复
        $(".faceqq_reply").qqFace({
                id : 'facebox', 
                assign:'NC_txt_reply', 
                path:'images/arclist/'  //存放的路径
         });                
         // 单独评论回复  
            $(".comment_announceCopy").each(function(index,element){ 
                    $(element).on("click",function(){  
                        var authorName=$(this).siblings('b').text();  
                        var LeftP = $('.reform');
                        var LeftTextarea = $('.comment_responseContent textarea').focus().val('@'+authorName);
                            var commentShow = LeftP.eq(index).css('display');
                              LeftP.hide();
                        if(commentShow == 'none'){
                              LeftP.eq(index).fadeIn(500);
                        }else{
                               LeftP.eq(index).fadeOut(500);
                        }
                        //添加
                            LeftTextarea.attr('id','');
                            LeftTextarea.eq(index).attr('id',function(){
                                   return  'NC_txt_reply' 
                       }); 
                      
                    }) 
            })    
            // //发表评论
            // $('.comments .sendcomt').on('click',function(){
            //     var thisText = $(this).parents('.fr').siblings('textarea').val();
            //     alert(thisText)
            // })
            // //发表回复
            // $('.comment_responseConfirm').on('click',function(){
            //     var thisText = $(this).parents('.comment_clickConfirm').siblings('textarea').val();
            //     alert(thisText)
            // })

            //关闭赠送
             $('.paytips .close').on('click',function(){
                       $('.paytips,.gray').hide(); 
            }) 


})
