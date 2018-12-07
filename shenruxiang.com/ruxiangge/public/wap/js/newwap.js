(function(factory){if(typeof define==='function'&&define.amd){define(['jquery'],factory)}else if(typeof exports==='object'){factory(require('jquery'))}else{factory(jQuery)}}(function($){var pluses=/\+/g;function encode(s){return config.raw?s:encodeURIComponent(s)}function decode(s){return config.raw?s:decodeURIComponent(s)}function stringifyCookieValue(value){return encode(config.json?JSON.stringify(value):String(value))}function parseCookieValue(s){if(s.indexOf('"')===0){s=s.slice(1,-1).replace(/\\"/g,'"').replace(/\\\\/g,'\\')}try{s=decodeURIComponent(s.replace(pluses,' '));return config.json?JSON.parse(s):s}catch(e){}}function read(s,converter){var value=config.raw?s:parseCookieValue(s);return $.isFunction(converter)?converter(value):value}var config=$.cookie=function(key,value,options){if(value!==undefined&&!$.isFunction(value)){options=$.extend({},config.defaults,options);if(typeof options.expires==='number'){var days=options.expires,t=options.expires=new Date();t.setTime(+t+days*864e+5)}return(document.cookie=[encode(key),'=',stringifyCookieValue(value),options.expires?'; expires='+options.expires.toUTCString():'',options.path?'; path='+options.path:'',options.domain?'; domain='+options.domain:'',options.secure?'; secure':''].join(''))}var result=key?undefined:{};var cookies=document.cookie?document.cookie.split('; '):[];for(var i=0,l=cookies.length;i<l;i++){var parts=cookies[i].split('=');var name=decode(parts.shift());var cookie=parts.join('=');if(key&&key===name){result=read(cookie,value);break}if(!key&&(cookie=read(cookie))!==undefined){result[name]=cookie}}return result};config.defaults={};$.removeCookie=function(key,options){if($.cookie(key)===undefined){return false}$.cookie(key,'',$.extend({},options,{expires:-1}));return!$.cookie(key)}}));

  //更多栏目
     $('.readhd .home').on('click',function(){
          IsSc = false; 
         $('.moremenu').toggle();   
         $('.settingx').hide();      
     });
      //解决苹果不支持 e.target问题
               var ua = navigator.userAgent.toLowerCase();	
                     if (/iphone|ipad|ipod/.test(ua)) { 
                         $('body,html').css({
                             'cursor':'pointer',
                              '-webkit-tap-highlight-color':'transparent',
                             'tap-highlight-color':'transparent'
                         })   
                     }
            //关闭评论框
            $('body,html').on('click',function(e){
                  if(
                         $(e.target).eq(0).is($('.infobtns')) || 
                         $(e.target).eq(0).is($('.sendsay'))  || 
                         $(e.target).eq(0).is($('.sayword'))  || 
                         $(e.target).eq(0).is($('.sendsay .atxt'))   ||
                         $(e.target).eq(0).is($('.sendsay .sendx')) ||
                         $(e.target).eq(0).is($('.infobtns .expedite')) ||
                         $(e.target).eq(0).is($('.infobtns .expedite i')) ||
                         $(e.target).eq(0).is($('.readhd .home')) 
                    ){
                      return;
                  }
                //简介页
                $('.moremenu').hide();   
                $('.infobtns').stop().animate({
                      'bottom':'0'
                  },300);
              $('.sendsay').stop().animate({
                  'bottom':'-6rem'
              },300);
            });
            //滚动
            $(window).scroll(function(){
               $('.moremenu').hide();    
            });
  
  
















