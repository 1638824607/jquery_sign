 //幻灯片
        function ZoomPic ()
        {
            this.initialize.apply(this, arguments)	
        }
        function ZoomPicB ()
        {
            this.initialize.apply(this, arguments)	
        }
        ZoomPic.prototype = 
        {
            initialize : function (id)
            {
		var _this = this;
		this.wrap = typeof id === "string" ? document.getElementById(id) : id;
		this.oUl = this.wrap.getElementsByTagName("ul")[0];
		this.aLi = this.wrap.getElementsByTagName("li");
		this.prev = this.wrap.getElementsByTagName("pre")[0];
		this.next = this.wrap.getElementsByTagName("pre")[1];
		this.timer = null;
		this.aSort = [];
		this.iCenter = 2;
		this._doPrev = function () {return _this.doPrev.apply(_this)};
		this._doNext = function () {return _this.doNext.apply(_this)};
		this.options = [
			{width:130, height:366, top:0, left:6, zIndex:1},
			{width:130, height:366, top:0, left:145, zIndex:2}, 
			{width:180, height:422, top:-35, left:285, zIndex:3}, 
			{width:130, height:366, top:0, left:475, zIndex:2},
			{width:130, height:366, top:0, left:615, zIndex:1}
		];
		for (var i = 0; i < this.aLi.length; i++) this.aSort[i] = this.aLi[i];
		this.aSort.unshift(this.aSort.pop());
		this.setUp();
		this.addEvent(this.prev, "click", this._doPrev);
		this.addEvent(this.next, "click", this._doNext);
		this.doImgClick();		
		this.timer = setInterval(function ()
		{
			_this.doNext()	
		}, 5000);		
		this.wrap.onmouseover = function ()
		{
			clearInterval(_this.timer)	
		};
		this.wrap.onmouseout = function ()
		{
			_this.timer = setInterval(function ()
			{
				_this.doNext()	
			}, 5000);	
		}
	},
	doPrev : function ()
	{
		this.aSort.unshift(this.aSort.pop());
		this.setUp()
	},
	doNext : function ()
	{
		this.aSort.push(this.aSort.shift());
		this.setUp()
	},
	doImgClick : function ()
	{
		var _this = this;
//		for (var i = 0; i < this.aSort.length; i++)
//		{
//			this.aSort[i].onclick = function ()
//			{
//				if (this.index > _this.iCenter)
//				{
//					for (var i = 0; i < this.index - _this.iCenter; i++) _this.aSort.push(_this.aSort.shift());
//					_this.setUp()
//				}
//				else if(this.index < _this.iCenter)
//				{
//					for (var i = 0; i < _this.iCenter - this.index; i++) _this.aSort.unshift(_this.aSort.pop());
//					_this.setUp()
//				}
//			}
//		}
	},
	setUp : function ()
	{
		var _this = this;
		var i = 0;
		for (i = 0; i < this.aSort.length; i++) this.oUl.appendChild(this.aSort[i]);
		for (i = 0; i < this.aSort.length; i++)
		{
			this.aSort[i].index = i;
			if (i < 5)
			{
                var NewBox =  $('.newbox li'); //
				this.css(this.aSort[i], "display", "block");
                NewBox.find('b').css({'background':'#fff','color':'#d7b882'});
                NewBox.eq(this.iCenter).find('b').css({'background':'#d7b882','color':'#fff'});
                NewBox.find('em').hide();
                NewBox.eq(this.iCenter).find('em').show();
                NewBox.find('h2').find('img').hide();
                NewBox.eq(this.iCenter).find('h2').find('img').show();
				this.doMove(this.aSort[i], this.options[i], function ()
				{
                    
					_this.doMove(_this.aSort[_this.iCenter].getElementsByTagName("img")[0], {opacity:100}, function ()
					{ 
//                          $('.newbox li').find('a').hide();
                        
						_this.doMove(_this.aSort[_this.iCenter].getElementsByTagName("img")[0], {opacity:100}, function ()
						{
							_this.aSort[_this.iCenter].onmouseover = function ()
							{
//								_this.doMove(this.getElementsByTagName("div")[0], {bottom:0})
							};
							_this.aSort[_this.iCenter].onmouseout = function ()
							{
//								_this.doMove(this.getElementsByTagName("div")[0], {bottom:-100})
							}
						})
					})
				});
			}
			else
			{
                    this.css(this.aSort[i], "display", "none");
                    this.css(this.aSort[i], "width", 0);
                    this.css(this.aSort[i], "height", 0);
                    this.css(this.aSort[i], "top", 37);
                    this.css(this.aSort[i], "left", this.oUl.offsetWidth / 2)
                }
                if (i < this.iCenter || i > this.iCenter)
                {
                    this.css(this.aSort[i].getElementsByTagName("img")[0], "opacity", 30)
                    this.aSort[i].onmouseover = function ()
                    {
                        _this.doMove(this.getElementsByTagName("img")[0], {opacity:100})	



                        };
                        this.aSort[i].onmouseout = function ()
                        {
                            _this.doMove(this.getElementsByTagName("img")[0], {opacity:35})
                        };
                        this.aSort[i].onmouseout();
                    }
                    else
                    {
                        this.aSort[i].onmouseover = this.aSort[i].onmouseout = null
                    }
                }		
            },
            addEvent : function (oElement, sEventType, fnHandler)
            {
                return oElement.addEventListener ? oElement.addEventListener(sEventType, fnHandler, false) : oElement.attachEvent("on" + sEventType, fnHandler)
            },
            css : function (oElement, attr, value)
            {
                if (arguments.length == 2)
                {
                    return oElement.currentStyle ? oElement.currentStyle[attr] : getComputedStyle(oElement, null)[attr]
                }
                else if (arguments.length == 3)
                {
                    switch (attr)
                    {
                        case "width":
//                        case "height":
                        case "top":
                        case "left":
                        case "bottom":
                            oElement.style[attr] = value + "px";
                            break;
                        case "opacity" :
                            oElement.style.filter = "alpha(opacity=" + value + ")";
                            oElement.style.opacity = value / 100;
                            break;
                        default :
                        oElement.style[attr] = value;
                        break
                }	
            }
        },
            doMove : function (oElement, oAttr, fnCallBack)
            {
                var _this = this;
                clearInterval(oElement.timer);
                oElement.timer = setInterval(function ()
                {
                    var bStop = true;
                    for (var property in oAttr)
                    {
                        var iCur = parseFloat(_this.css(oElement, property));
                        property == "opacity" && (iCur = parseInt(iCur.toFixed(2) * 100));
                        var iSpeed = (oAttr[property] - iCur) / 5;
                        iSpeed = iSpeed > 0 ? Math.ceil(iSpeed) : Math.floor(iSpeed);

                        if (iCur != oAttr[property])
                        {
                            bStop = false;
                            _this.css(oElement, property, iCur + iSpeed)
                        }
                    }
                    if (bStop)
                    {
                        clearInterval(oElement.timer);
                        fnCallBack && fnCallBack.apply(_this, arguments)	
                    }
                }, 30)
            }
        };
      
        window.onload = function () { 
            new ZoomPic("box");
            var oBut = document.getElementById('list');

            var oTop = document.getElementById('top');

            var oTli = oTop.getElementsByTagName('li');

            var aLi = oBut.getElementsByTagName('li');

            var aA = oBut.getElementsByTagName('a');

            var aP = getClass(oBut, 'b_tit');

            var oSmall = getClass(oTop, 'small')[0];

            var i = iNow = 0;

            var timer = null;

            var aSort = [];

            var aPosition = [

					{width:180,height:240,top:30,left:245,zIndex:10},

					{width:135,height:180,top:65,left:112,zIndex:8},

					{width:112,height:150,top:78,left:0,zIndex:6},

					{width:135,height:180,top:65,left:425,zIndex:4},

					{width:112,height:150,top:78,left:560,zIndex:2},
 
//                    {width:112, height:150, top:78, left:0, zIndex:1},
//                    {width:135, height:180, top:65, left:112, zIndex:2},
//                    {width:135, height:180, top:65, left:425, zIndex:2},
//                    {width:180, height:240, top:30, left:245, zIndex:3},
//                    {width:112, height:150, top:78, left:560, zIndex:1}
		]

	for(i=0;i<oTli.length;i++){

		oTli[i].index = i;

//		myAddEvent(oTli[i], 'mouseover', function(){
//
//			startMove(this, {opacity:100});
//
//		})
//
//		myAddEvent(oTli[i], 'mouseout', function(){
//
//			if(this.className != 'hove')startMove(this, {opacity:40});
//
//		})

		myAddEvent(oTli[i], 'click', function(){

			iNow = this.index;

			tab();

		})

	}

	for(i=0;i<aLi.length;i++){

		aLi[i].index = i;

		aLi[i].style.width = aPosition[i].width +'px';

		aLi[i].style.height = aPosition[i].height +'px';

		aLi[i].style.top = aPosition[i].top +'px';

		aLi[i].style.left = aPosition[i].left +'px';

		aLi[i].style.zIndex = aPosition[i].zIndex;

		aSort[i] = aPosition[i];

		myAddEvent(aLi[i], 'mouseover', function(){

			var oDiv = this.getElementsByTagName('div')[0];
 
			startMove(oDiv, {opacity:0});

//			if(this.style.width == '180px'){
//
//				startMove(aP[this.index], {bottom:0});
//
//			}

		});

		myAddEvent(aLi[i], 'mouseout', function(){ 

				var oDiv = this.getElementsByTagName('div')[0];

				startMove(oDiv, {opacity:60});
 

		}); 
////
		myAddEvent(aLi[i], 'click', function(){
//alert(1)
//			iNow = this.index;
//
//			tab();

		});

	}

	myAddEvent(aA[0], 'click', function(){

		aSort.unshift(aSort.pop());

		sMove();

		setInter();

	});

	myAddEvent(aA[1], 'click', function(){

		aSort.push(aSort.shift());

		sMove();

		iNow--;

		if(iNow<0)iNow = aLi.length - 1;

		tab();

	});

	oSmall.onmouseover = oBut.onmouseover = function(){

		clearInterval(timer);

	};

	oSmall.onmouseout = oBut.onmouseout = function(){

		clearInterval(timer);

		timer = setInterval(setInter,5000);

	};

	timer = setInterval(setInter,5000);

	function setInter(){

		iNow++;

		if(iNow>aLi.length-1)iNow = 0;

		tab();

	}
            //进度
     function loadIng(e){
         
            var newLoadX = $('.small li').eq(e).find('.newload')
            var newLoadB = $('.small li').eq(e).find('.newloadb')
            var newload =  newLoadX.attr('data-rel');
            var newloadb =  newLoadB.attr('data-rel');  
               newLoadX.find('em').animate({
                    'width':newload+'%'
                },1000);
                newLoadB.find('em').animate({
                    'width':newloadb+'%'
                },200); 
         
     }
	function tab(){

		for(i=0;i<oTli.length;i++)oTli[i].className = '',startMove(oTli[i], {opacity:0});
         $('.small li').css('z-index','10');
        $('.small li').eq(iNow).css('z-index','100');
		oTli[iNow].className = 'hove';  
         loadIng(iNow); //进度
		startMove(oTli[iNow], {opacity:100})

		var iSort = iNow;

		Sort();

		for(i=0;i<iSort;i++){

			aSort.unshift(aSort.pop());

		}

		sMove();

	}

	function Sort(){

		for(i=0;i<aLi.length;i++){

			aSort[i] = aPosition[i];

		}

	}

	function sMove(){

		for(i=0;i<aLi.length;i++){

			var oDiv = aLi[i].getElementsByTagName('div')[0];

			startMove(oDiv, {opacity:60});

			startMove(aLi[i], aSort[i], function(){one();});

			aLi[i].className = '';

		}

		aLi[iNow].className = 'hove';

	}

	function one(){

		for(i=0;i<aLi.length;i++){

			if(aLi[i].style.width == '180px'){
  
				var oDiv = aLi[i].getElementsByTagName('div')[0];
                 loadIng(i); //进度
				startMove(oDiv, {opacity:0});
                 $('.small li').css('z-index','10');
                $('.small li').eq(i).css('z-index','100');
			}

		}

	}

	one();

};

function getClass(oParent, sClass){

	var aElem = document.getElementsByTagName('*');

	var aClass = [];

	var i = 0;

	for(i=0;i<aElem.length;i++)if(aElem[i].className == sClass)aClass.push(aElem[i]);

	return aClass;

}

function myAddEvent(obj, sEvent, fn){

	if(obj.attachEvent){

		obj.attachEvent('on' + sEvent, function(){

			fn.call(obj);

		});

	}else{

		obj.addEventListener(sEvent, fn, false);

	}

}

function startMove(obj, json, fnEnd){

	if(obj.timer)clearInterval(obj.timer);

	obj.timer = setInterval(function (){

		doMove(obj, json, fnEnd);

	}, 30);

}

function getStyle(obj, attr){

	return obj.currentStyle ? obj.currentStyle[attr] : getComputedStyle(obj, false)[attr];

}

function doMove(obj, json, fnEnd){

	var iCur = 0;

	var attr = '';

	var bStop = true;

	for(attr in json){

		attr == 'opacity' ? iCur = parseInt(100*parseFloat(getStyle(obj, 'opacity'))) : iCur = parseInt(getStyle(obj, attr));

		if(isNaN(iCur))iCur = 0;

		if(navigator.userAgent.indexOf("MSIE 8.0") > 0){

			var iSpeed = (json[attr]-iCur) / 3;

		}else{

			var iSpeed = (json[attr]-iCur) / 5;

		}

		iSpeed = iSpeed > 0 ? Math.ceil(iSpeed) : Math.floor(iSpeed);

		if(parseInt(json[attr])!=iCur)bStop = false;

		if(attr=='opacity'){

			obj.style.filter = "alpha(opacity:"+(iCur+iSpeed)+")";

			obj.style.opacity = (iCur + iSpeed) / 100;

		}else{

			attr == 'zIndex' ? obj.style[attr] = iCur + iSpeed : obj.style[attr] = iCur + iSpeed +'px';

		}

	}

	if(bStop){

		clearInterval(obj.timer);

		obj.timer = null;		

		if(fnEnd)fnEnd();

	}

        };
