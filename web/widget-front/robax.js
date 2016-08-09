(function(w,d){
	var helper={};
	var isMobile = {
		Android: function() {
			return navigator.userAgent.match(/Android/i);
		},
		BlackBerry: function() {
			return navigator.userAgent.match(/BlackBerry/i);
		},
		iOS: function() {
			return navigator.userAgent.match(/iPhone|iPad|iPod/i);
		},
		Opera: function() {
			return navigator.userAgent.match(/Opera Mini/i);
		},
		Windows: function() {
			return navigator.userAgent.match(/IEMobile/i);
		},
		iFrameMobile: function() {
			return $('html').width() <= 678 ? true : false;
		},
		any: function() {
			return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows()) || isMobile.iFrameMobile();
		}
	};
	helper.ObjectLength=function(o){
		var s = 0, k;
		for (k in o) {
			if (o.hasOwnProperty(k)) s++;
		}
		return s;
	};
	//My typeof. For WHY? IS UNDERSTEND THAT IS A OBJECT AND THAT IS A ARRAY.
	helper.ObjectType=function(e){
		var t=Object.prototype.toString.call(e),r='';
		if(/\[object HTML([a-zA-Z]+)Element\]/.test(t)) r=t.match(/\[object HTML([a-zA-Z]+)Element\]/)[1].toLowerCase();
		else if(/\[object ([a-zA-Z]+)\]/.test(t)) r=t.match(/\[object ([a-zA-Z]+)\]/)[1].toLowerCase();
		else if(r=='') {
			if('toString' in e && 'length' in e && 'join' in e && 'splice' in e && 'pop' in e) r='array';
			else r=typeof(e);
		}
		return r;
	}
	helper.isHTML=function (e){
		var t=Object.prototype.toString.call(e);
		if(/\[object HTML([a-zA-Z]+)\]/.test(t)) return true;
		else return false;
	}
	helper.get=function (p,o,s,b,m){
		var xhttp= new XMLHttpRequest();
		var url=p+"?";
		if(o||o!=""){
			//body
			for (var k in o)
			{
				if(typeof(o[k])=='object')url+=k+"="+encodeURIComponent(JSON.stringify(o[k]))+'&';
				else url+=k+"="+o[k]+'&';
			}
		}
		xhttp.open('GET', url, b);
		//Meta tegs
		if(m!=undefined){if(!('Content-Type' in m))xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');}
		if(m){
			for (var k in m)
			{
				xhttp.setRequestHeader(k,m);
			}
		}
		//---
		if(s){
			xhttp.onreadystatechange = function () {
				if(xhttp.readyState==4) s(xhttp.responseText,xhttp.readyState);
			}
			xhttp.send(null);
		}else{
			xhttp.send(null);
			return xhttp.responseText;
		}
	}
	helper.post=function (p,o,s,b,m){
		var xhttp= new XMLHttpRequest();
		var body="";
		var response,redy;
		if(o||o!=""){
			//body
			for (var k in o)
			{
				body+=k+"="+encodeURIComponent(JSON.stringify(o[k]))+"&";
			}
		}
		xhttp.open('POST', p, b);
		//Meta tegs
		if(m!=undefined)if(!('Content-Type' in m)){xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');}
		if(m){
			for (var k in m)
			{
				xhttp.setRequestHeader(k,m);
			}
		}
		//---
		if(s){
			xhttp.onreadystatechange = function () {
				if(xhttp.readyState==4) s(xhttp.responseText,xhttp.readyState);
			}
			xhttp.send(body);
		}else{
			xhttp.send(body);
			return xhttp.responseText;
		}
	}
	helper.replaceAll=function (t,o){
		var i=0, n=helper.ObjectLength(o), HTML=t,r=new RegExp("(<{\\S+}>)","g"),a=[],b=[],TypeCache='',c,ca,z,zn;
		//loop start
		do
		{
			HTML=HTML.replace(r,function (s,p,b){
				a=s.split("<{"),b=a[1].split("}>"),c=o;
				if(b[0]!=undefined&&b[0].indexOf('.')!=-1){
					ca=b[0].split('.'),z=0,zn=ca.length,c=o,i=i+zn,n=n+zn;
					while (z<zn) {
						if(c!=undefined&&ca[z]!=undefined) c=c[ca[z]];
						z++;
					}
				} else c=o[b[0]];
				TypeCache=helper.ObjectType(c);
				if(TypeCache=='string'||TypeCache=='number'||TypeCache=='null'||TypeCache=='undefined') return c;
				else if(TypeCache=='function') {try{return c()} catch (e){console.error(e)}}
				else if(TypeCache=='object'&&c.hasOwnProperty('template')) return new Theme(c['template']).outTheme(c);
				else if(TypeCache=='object'&&!c.hasOwnProperty('template')) console.error("Object "+c+" in "+o+" have not template. Can`t use object without template");
				else console.log('Can`t use object by type'+TypeCache);
			});
			i++;
		}
		while(i<=n)
		//loop end
		return HTML;
	}
	helper.setCaretPosition=function (ctrl, pos) {
		if(ctrl.setSelectionRange) {
			ctrl.focus();
			ctrl.setSelectionRange(pos,pos);
			//alert(ctrl.setSelectionRange(pos,pos));
		}
		else if (ctrl.createTextRange) {
			var range = ctrl.createTextRange();
			range.collapse(true);
			range.moveEnd('character', pos);
			range.moveStart('character', pos);
			//alert(range.moveStart('character', pos));
			range.select();
		}
	}
	helper.setMask=function(I,M){
		function R(s){return new RegExp('('+s.replace(/\(/g,'\\(').replace(/\)/g,'\\)').replace(/\//g,'\\/').replace(/9/g,'\\d').replace(/a/g,'[a-zР°-СЏС‘]').replace(/\*/g,'[a-zР°-СЏС‘0-9]')+')','gi')}
		function N(c,j,x){
			for(var k=0,s='';k<L;k++)s+=$[k]||c||'_';
			I.value=s;
			x?0:I.sC(!j?i:0)
		}
		function D(e,p,i){
			p=I.gC();
			if (p[0]==p[1]) {
				if(e)p[1]++;
				else p[0]--
			}
			for(i=p[0];i<p[1];i++)
				if(!S[i]&&$[i]){
					$[i]=0;
					j--
				}
			return p
		}
		function V(){
			setTimeout(function(k){
				if (R(M).test(I.value)) {
					I.value=RegExp.$1;
					$=I.value.split('');
					for(k=j=0;k<L;k++)if(!S[k])j++
				}
				else N()
			},0)
		}
		function P(c){
			if (c<35&&c!=8||c==45) return 1;
			switch(c){
				case 8:		i=D()[0]; return 0;
				case 46:	i=D(1)[1]; return 0;
				case 35:	i = L; return 1;
				case 36:	i = 1;
				case 37:	if (i-=2<-1) i=-1;
				case 39:	if (++i>L) i=L; return 1;
				default:	i=I.gC()[0];
					while(i<L&&S[i]){i++}
					if (i==L) return 0;

					c = String.fromCharCode(c)
					if (R(M.charAt(i)).test(c)) {
						D(1);
						$[i++] = c;
						j++;
						while(i<L&&S[i]){i++}
					}
					return 0
			}
		}

		var d=document, c='character', y=-100000, L=M.length, G=!c, i=0, j=0, $=M.split(''), S=M.split('');

		for (var k=0;k<L;k++) if (/a|9|\*/.test($[k])) $[k]=S[k]=0;
		I = typeof I=='string' ? d.getElementById(I) : I;

		I.sC = function(l,g){
			if(this.setSelectionRange) this.setSelectionRange(l,l);
			else {
				g = this.createTextRange();
				g.collapse(true);
				g.moveStart(c,y);
				g.move(c,l);
				g.select();
			}
		}
		I.gC = function(r,b){
			if (this.setSelectionRange) return [this.selectionStart,this.selectionEnd];
			else {
				r = d['selection'].createRange();
				b = 0-r.duplicate().moveStart(c,y)
				return [b,b+r.text.length]
			}
		}
		I.onfocus = function(){
			setTimeout(function(){N(0,!j)},0)
		}
		I.onblur = function(){
			j ? N(' ',0,1) : this.value=''
		}
		I.onkeydown = function(e,c){
			e = e||event;
			c = e.keyCode||e.charCode;

			if (c==8||c==46) {
				G = true;
				P(c);
				N();
				return !G
			}
			else if (!window.netscape&&(c>34&&c<38||c==39)) P(c)
		}
		I.onkeypress = function(e){
			if (G) return G=!G;

			e = e||event;

			if (P(e.keyCode||e.charCode)) return !G;

			N();

			return G
		}

		if (d.all&&!window.opera) I.onpaste=V;
		else I.addEventListener('input',V,false);
		I.onselect=function(){helper.setCaretPosition(this,this.getAttribute("placeholder").indexOf('_'));this.onselect='';}
	}
	helper.addClass=function (el, cls) {
		el.className += " "+cls;
	}
	helper.removeClass=function (el, cls) {
		var re = new RegExp('(\\s|^)' + cls + '(\\s|$)');
		el.className = el.className.replace(re, ' ');
	}
	helper.parseHourse=function (t){
		var h=t/60,m=t%60;
		return Math.ceil(h)+':'+(m<10?m+'0':m);
	}
	helper.cssQuery=function (q){
		return document.querySelector(q);
	}
	helper.cssQueryAll=function (q){
		return document.querySelectorAll(q);
	}
	RobaxWidget=function(param){
		var t=this;
		var template = 'desktop';
		var div = document.createElement("div");
		div.setAttribute("class","robax");
		if (isMobile.any()) {
			template = 'mobile';
		}
		var dataJSON=JSON.parse(helper.get('//r.oblax.ru/widget/get-widget',{'action':'widget-get','key':param.key,'site_url':window.location.hostname,'protocol':window.location.protocol,'template':template}).replace(/\ufeff/g,''));
		window.widget_key = param.key;

		var css = d.createElement("link");
		var colorTheme = dataJSON['theme_color'];
		css.href="//r.oblax.ru/widget-front/WidGet.css";
		css.type="text/css"; css.rel="stylesheet";
		d.getElementsByTagName("link")[0].parentNode.insertBefore(css, d.getElementsByTagName("link")[0]);
		helper.cssQuery('body').appendChild(div);
		helper.cssQuery('.robax').innerHTML+=helper.replaceAll(dataJSON['tmp'],dataJSON);
		var color = dataJSON['widget_button_color'];
		document.getElementById("open-button").style.background = color;
		helper.setMask(helper.cssQuery('.robax-phone-input'),'+7(999)999-99-99');
		this.controller.open(dataJSON['widget-button-color']); this.controller.closed(); this.controller.phone(); this.controller.menu(); this.controller.phone_item(dataJSON);
		for(var k in param){
			t.settings[k]=param[k];
		}
		helper.cssQuery('.robax-widget-phone .robax-widget-item-button').onclick=function(){
			t.postCall(helper.cssQuery('.robax-widget-phone-form .robax-phone-input').value);
			t.controller.timer();
		}
		var dc=new Date();
		timeNow=dc.getHours()*60+dc.getMinutes();
		dc=dataJSON['date']['work-start-time'];
		timeStart=Number(dc.split(':')[0])*60+Number(dc.split(':')[1]);
		dc=dataJSON['date']['work-end-time'];
		timeEnd=Number(dc.split(':')[0])*60+Number(dc.split(':')[1]);
		if(timeNow>timeEnd||timeNow<timeStart){
			helper.cssQuery('#widget-msg-h1').style.display='block';
			helper.cssQuery('#widget-msg-div').style.display='block';
			helper.cssQuery('#phone-h1').style.display='none';
			helper.cssQuery('#phone-div').style.display='none';
			helper.cssQuery('.robax-timer').style.display='none';
			helper.cssQuery('.robax-later').style.display='block';
			helper.cssQuery('.robax-item-later').style.display='none';
			helper.cssQuery('.robax-later-data').value='true';
			helper.cssQuery('.robax-item-now').style.display='none';
		}
		if (dataJSON['widget_goal'].length) {
			$('html script').each(function (e, i) {
				if ($(this).attr('src') == 'https://mc.yandex.ru/metrika/watch.js' && $(this).attr('src') == 'http://www.google-analytics.com/analytics.js') {
					if (dataJSON['widget_goal'] && dataJSON['widget_yandex_metrika'] && dataJSON['widget_google_metrika']) {
						helper.cssQuery('.robax-widget-phone .robax-widget-item-button').setAttribute('onclick', "_gaq.push(['_trackEvent', 'Кнопка', '"+dataJSON['widget_goal']+"']);yaCounter"+dataJSON['widget_yandex_metrika']+".reachGoal('"+dataJSON['widget_goal']+"');");
					}
				}
				if ($(this).attr('src') == 'https://mc.yandex.ru/metrika/watch.js') {
					if (dataJSON['widget_goal'] && dataJSON['widget_yandex_metrika']) {
						helper.cssQuery('.robax-widget-phone .robax-widget-item-button').setAttribute('onclick', "yaCounter"+dataJSON['widget_yandex_metrika']+".reachGoal('"+dataJSON['widget_goal']+"');");
					}
				}
				if ($(this).attr('src') == 'http://www.google-analytics.com/analytics.js') {
					if (dataJSON['widget_goal'] && dataJSON['widget_google_metrika']) {
						helper.cssQuery('.robax-widget-phone .robax-widget-item-button').setAttribute('onclick', "_gaq.push(['_trackEvent', 'Кнопка', '"+dataJSON['widget_goal']+"']);");
					}
				}
			});
		}
		if (typeof getCookie('__utmctr') !=="undefined") {
			$('#phone-h1').text(dataJSON['phone']['h1']);
			$('#phone-div').text('Вы наверное ищите ' + getCookie('__utmctr') + '? Связать вас с менеджером?');
		}
		if(dataJSON['utp_img_url'].length>0){
			setTimeout(function(){
				document.addEventListener('mousemove',function(e){
					if((e || window.event).clientY<5){
						if(!t.settings.PhonePosted){
							t.controller.open_utp();
						}
					}
				});
			},60000);

			/*window.onbeforeunload = function (e) {
			 if(!t.settings.PhonePosted){
			 var confirmationMessage = "РџРµСЂРµРґ Р·Р°РєСЂС‹С‚РёРµРј СЃС‚СЂР°РЅРёС†С‹ РѕР·РЅР°РєРѕРјСЊС‚РµСЃСЊ СЃ РЅР°С€РёРј РЈРЅРёРєР°Р»СЊРЅС‹Рј РўРѕСЂРіРѕРІС‹Рј РџСЂРµРґР»РѕР¶РµРЅРёРµРј ";
			 t.controller.open_utp();
			 (e || window.event).returnValue = confirmationMessage;
			 return confirmationMessage;
			 } else return null;
			 };*/
		}
		helper.cssQuery('.robax-utp-form .line button').onclick=function(){
			t.postCall(helper.cssQuery('.robax-utp-form .line input').value);
		};
		t.dataJSON=dataJSON;
	}
	RobaxWidget.prototype.settings=new Object();
	RobaxWidget.prototype.getToken=function(){

	}
	RobaxWidget.prototype.getOldMessage=function(){

	}
	RobaxWidget.prototype.postMessage=function(){

	}
	RobaxWidget.prototype.postMail=function(){
		helper.get('//r.oblax.ru/widget/widget-call',{'key':this.settings.key,'phone':phone,'site_url':window.location.hostname,'protocol':window.location.protocol});
	}
	RobaxWidget.prototype.postCall=function(phone){
		var t=this;
		t.settings.PhonePosted=true;
		helper.get('//r.oblax.ru/widget/widget-call',{'key':this.settings.key,'phone':phone,'site_url':window.location.hostname,'protocol':window.location.protocol},function(r){if(t.dataJSON['widget_yandex_metrika'])window["yaCounter" + t.dataJSON['widget_yandex_metrika']].reachGoal(t.dataJSON['widget_name'],{'phone':phone,'url':window.location.hostname+window.location.pathname});if(window.ga&&t.dataJSON['widget_google_metrika']) window.ga("send", "event", t.dataJSON['widget_name'], 'phone-'+phone+'-url-'+window.location.hostname+window.location.pathname);});
	}
	RobaxWidget.prototype.controller = {
		open:function(){
			helper.cssQuery('.robax-widget-open-button, .robax-widget-open-button-mobile').onclick=function(){
				var audio = new Audio(); // Создаём новый элемент Audio
				audio.src = 'http://r.oblax.ru/widget-front/open_1.mp3'; // Указываем путь к звуку "клика"
				audio.autoplay = true; // Автоматически запускаем
				helper.cssQuery('.overlay').setAttribute("style","display:block;");
				helper.cssQuery('.robax-widget, .robax-widget-mobile').setAttribute("style","right:0;");
			}
			helper.cssQuery('.overlay').onclick=function () {
				helper.cssQuery('.overlay').setAttribute("style","display:none;");
				if (!$('.robax-widget-mobile').length) {
					helper.cssQuery('.robax-widget').setAttribute("style","right:-350px;");
				} else {
					$('.robax-widget-active').removeClass('robax-widget-active');
					helper.cssQuery('.robax-widget-mobile').setAttribute("style","right:-360px;");
				}
			}
			//textEcho({selector:helper.cssQuery('.robax-widget-open-button'),});
		},
		closed:function(){
			helper.cssQuery('.robax-widget-closed').onclick=function(){
				helper.cssQuery('.overlay').setAttribute("style","display:none;");
				if (!$('.robax-widget-mobile').length) {
					helper.cssQuery('.robax-widget').setAttribute("style","right:-350px;");
				} else {
					$('.robax-widget-active').removeClass('robax-widget-active');
					helper.cssQuery('.robax-widget-mobile').setAttribute("style","right:-360px;");
				}
			}
			if (!$('.robax-widget-mobile').length) {
				helper.cssQuery('.robax-arrow').onclick=function(){
					helper.cssQuery('.overlay').setAttribute("style","display:none;");
					helper.cssQuery('.robax-widget').setAttribute("style","right:-350px;");
				}
			}
		},
		phone:function(){
			var e=helper.cssQueryAll('.robax-phone-type-list div'),i=0,n=e.length;
			while(i<n){
				e[i].onclick=function(){
					helper.cssQuery('.robax-phone-input').setAttribute("placeholder",this.getAttribute("data-placeholder"));
					helper.setMask(helper.cssQuery('.robax-phone-input'),this.getAttribute("data-mask"));
					helper.cssQuery('.robax-country-box .robax-flag').setAttribute("class",this.querySelector("i").getAttribute("class"));
				}
				i++;
			}
		},
		menu:function(){
			var e=helper.cssQueryAll('.robax-menu-button'),el,i=0,z=0,y=0,n=e.length;
			while(i<n){
				e[i].onclick=function(){
					el=helper.cssQuery(this.getAttribute("data-target")).parentNode.children,z=0,y=0;
					while(z<n){
						helper.removeClass(e[z],'robax-widget-active');
						z++;
					}
					z=0;
					this.setAttribute("class","robax-menu-button robax-widget-active");
					while(y<el.length){
						helper.removeClass(el[y],'robax-widget-active');
						y++;
					}
					helper.addClass(helper.cssQuery(this.getAttribute("data-target")),' robax-widget-active');
				}
				i++;
			}
		},
		phone_item:function(dataJSON){
			helper.cssQuery('.robax-item-later-link').onclick=function(){
				helper.cssQuery('.robax-timer').style.display='none';
				helper.cssQuery('.robax-later').style.display='block';
				helper.cssQuery('.robax-item-later').style.display='none';
				helper.cssQuery('.robax-item-now').style.display='block';
				helper.cssQuery('.robax-later-data').value='true';
			}
			helper.cssQuery('.robax-item-later-now').onclick=function(){
				helper.cssQuery('.robax-timer').style.display='block';
				helper.cssQuery('.robax-later').style.display='none';
				helper.cssQuery('.robax-item-later').style.display='block';
				helper.cssQuery('.robax-item-now').style.display='none';
				helper.cssQuery('.robax-later-data').value='false';
			}
			var date=new Date(Date.now() + 2592e5);var month=["Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"];
			helper.cssQuery('.robax-later-sel__hold__day').innerHTML+='<li data-day="after-after-tomorrow">'+date.getDate()+' '+month[date.getMonth()]+'</li>';
			var e=helper.cssQueryAll('.robax-later-sel__hold__day li'),i=0,n=e.length;
			while(i<n){
				e[i].onclick=function(){
					helper.cssQuery('.robax-later-data-day').value=this.getAttribute("data-day");
					helper.cssQuery('.robax-later__day-val').innerHTML=this.innerHTML;
				}
				i++;
			}
			var s=Number(dataJSON["date"]['work-start-time'].split(':')[0])*60+Number(dataJSON["date"]['work-start-time'].split(':')[1]),e=Number(dataJSON["date"]['work-end-time'].split(':')[0])*60+Number(dataJSON["date"]['work-end-time'].split(':')[1]),m=e-s,i=0,html='';
			while (i<=m) {
				html+='<li data-time="'+helper.parseHourse(s+i)+'">'+helper.parseHourse(s+i)+'</li>';
				i=i+60;
			}

			helper.cssQuery('#cbh_timer_sel_hour').innerHTML=html;
			helper.cssQuery('.robax-later__hour-val').innerHTML=helper.cssQuery('#cbh_timer_sel_hour li').innerHTML;
			var e=helper.cssQueryAll('.robax-later__hour li'),i=0,n=e.length;
			while(i<n){
				e[i].onclick=function(){
					helper.cssQuery('.robax-later-data-hour').value=this.getAttribute("data-day");
					helper.cssQuery('.robax-later__hour-val').innerHTML=this.innerHTML;
				}
				i++;
			}
			var dc=new Date(),timeNow=dc.getHours()*60+dc.getMinutes(),dc=dataJSON['date']['work-start-time'],timeStart=Number(dc.split(':')[0])*60+Number(dc.split(':')[1]),dc=dataJSON['date']['work-end-time'],timeEnd=Number(dc.split(':')[0])*60+Number(dc.split(':')[1]);
			if(timeNow>timeEnd||timeNow<timeStart){
				helper.cssQueryAll('.robax-later-sel__hold__day li')[0].style.display='none';
				helper.cssQueryAll('.robax-later-sel__hold__day li')[1].onclick();
			}
		},
		timer:function timer(s){
			var ms=Number(document.querySelector('#cbh_timer_ms').innerHTML)-1;
			document.querySelector('#cbh_timer_ms').innerHTML=(ms<10?'0'+ms:ms);
			if(ms>0)setTimeout(timer,10);
			else {
				var s=Number(document.querySelector('#cbh_timer_seconds').innerHTML)-1;
				if(s>=0){
					document.querySelector('#cbh_timer_seconds').innerHTML=(s<10?'0'+s:s);
					document.querySelector('#cbh_timer_ms').innerHTML=99;
					setTimeout(timer,10);
				} else {
					if(typeof(s)=='function') s();
				}
			}
		},
		open_utp:function(){
			var css={'width':helper.cssQuery('.robax-utp-img').offsetWidth+'px','height':helper.cssQuery('.robax-utp-img').offsetHeight+'px','left':((document.body.offsetWidth-helper.cssQuery('.robax-utp-img').offsetWidth)/2)+'px','top':((document.body.offsetHeight-helper.cssQuery('.robax-utp-img').offsetHeight)/2)+'px'};
			for(var k in css){
				helper.cssQuery('.robax-utp').style[k]=css[k];
			}
			helper.cssQuery('.robax-utp-body').style.display='block';
			if(helper.cssQuery('.robax-utp-closed').onclick==''){
				helper.cssQuery('.robax-utp-closed').onclick=function(){
					helper.cssQuery('.robax-utp-body').style.display='none';
				};
			}
			helper.cssQuery('.robax-utp-body').addEventListener('click',function(e){var ev=(e || window.event); if(ev.target.className=="robax-utp-body") helper.cssQuery('.robax-utp-body').style.display='none'; else ev.stopPropagation();},true);
		}
	}
	var textEcho=function (options){
		var o=options;
		if(typeof(o.text)!='string')o.text=document.querySelector(o.selector).innerHTML;
		if(isNaN(o.io))o.io=0;
		document.querySelector(o.selector).innerHTML='';
		var i=0;
		while(i<o.io){
			document.querySelector(o.selector).innerHTML+=o.text[i];
			i++;
		}
		if(o.text.length>o.io) {o.io=o.io+1;setTimeout(function(){textEcho(o)},50);}
		else if(typeof(o.s)=='function') o.s();
	}

})(this,this.document);

// Проверка на поведенческий фактор "Посещение конкретной страницы или раздела сайта"
window.onload=function(){
	$.ajax({
		url: '//r.oblax.ru/widget/get-urls',
		data: {key:window.widget_key,
			site_url:window.location.hostname,
			protocol:window.location.protocol},
		success: function(result){
			widget_urls = JSON.parse(result);
			for (var i = 0; i < widget_urls.pages.length; i++) {
				var page = widget_urls.pages[i];
				if(location.href == page.url)
				{
					getPoints('other_page',parseInt(page.mark));
				}
			}
		},
	});
	$.ajax({
		url: '//r.oblax.ru/widget/get-marks',
		data: {key:window.widget_key,
			site_url:window.location.hostname,
			protocol:window.location.protocol},
		success: function(result){
			dataMarks = JSON.parse(result);
		},
	});
}
if (typeof getCookie('counter') !=="undefined"){
	counter = getCookie('counter');
} else {
	counter = 0;
}
$(document).ready(function(){
	// Проверка на поведенческий фактор "Переход на другую страницу"
	$('a').click(function(){
		window.onbeforeunload = null;
		getPoints('other_page',window.dataMarks['sitepage_activity']);
		window.counter++;
		setCookie("counter", window.counter, '/');
		// Проверка на поведенческий фактор "Посещение более трёх страниц сайта"
		if(window.counter==4) {
			getPoints('sitepage3_activity',window.dataMarks['sitepage3_activity']);
		}
	});
	// Проверка на поведенческий фактор "Взаимодействие с формами"
	$('input').focus(function(){
		getPoints('form_activity',window.dataMarks['form_activity']);
	});
});

if(isNaN(getCookie('points'))) {
	points = 0;
} else {
	points = parseInt(getCookie('points'));
}

// Начисляет баллы с учётом события. При получении 10 баллов виджет отображается и идет запись о ивенте в базу
function getPoints(event, plus_points)
{
	points+=parseInt(plus_points);
	setCookie("points", parseInt(points), '/');
	//console.log(parseInt(points));
	if(parseInt(points)>=10)
	{
		$('.robax-widget-open-button').click();
		$.ajax({
			url: '//r.oblax.ru/widget/location',
			data: {site_url:window.location.hostname,
				protocol:window.location.protocol},
			cache: false,
			success: function(result){
				$.ajax({
					url: '//r.oblax.ru/widget/catched',
					data: {event:event,
						ip: result,
						site_url:window.location.hostname,
						protocol:window.location.protocol},
					success: function(result){
					},
				});
			}
		});
		window.points = 0;
	}
}

// Проверка на поведенческий фактор "Скролл вниз(за 100% страницы)"
$(window).scroll(function(){
	if($(window).scrollTop()+$(window).height()>=$(document).height())
	{
		getPoints('scroll_down',window.dataMarks['scroll_down']);
	}
});

// Проверка на поведенческий фактор "Активность на сайте более 40 секунд"
setTimeout(function() {
	getPoints('active_more40',window.dataMarks['active_more40']);
}, 40000);

// Проверка на поведенческий фактор "Интенсивность движений мышки(после 500 точек)"
var intensivity = 0;
$(document).mousemove(function( event ) {
	intensivity++;
	if(intensivity>=500) {
		getPoints('mouse_intencivity',window.dataMarks['mouse_intencivity']);
		intensivity = 0;
	}
});

// Проверка на поведенческий фактор "Дольше среднего времени на сайте"
avgTime = 0;
$.ajax({
	url: '//r.oblax.ru/widget/avgtime',
	data: {
		site_url: window.location.hostname,
		protocol: window.location.protocol
	},
	cache: false,
	success: function(result) {
		window.avgTime = result;
	}
});
// Проверка на поведенческий фактор "За каждые 30 сек. после 1 минуты"
if (typeof getCookie('seconds') !=="undefined"){
	seconds = getCookie('seconds');
} else {
	seconds = 0;
}
var more_avgtime = false;
setInterval(function() {
	window.seconds++;
	setCookie("seconds", window.seconds, '/');
	if(window.seconds > 60 && window.seconds % 30 == 0) getPoints('moretime_after1min',window.dataMarks['moretime_after1min']);
	if(window.seconds>window.avgTime && more_avgtime == false) {
		getPoints('more_avgtime',window.dataMarks['more_avgtime']);
		more_avgtime = true;
	}
}, 1000);
// Для подсчёта среднего времени на сайте - работает коряво
/*window.onbeforeunload = function() {
 //$.ajax({
 //    url: '//r.oblax.ru/widget/location',
 //    data: {site_url:window.location.hostname,
 //        protocol:window.location.protocol},
 //    cache: false,
 //    success: function(result){
 //        $.ajax({
 //            url: '//r.oblax.ru/widget/catched',
 //            data: {event:'close_page',
 //                ip: result,
 //                time: window.seconds,
 //                site_url:window.location.hostname,
 //                protocol:window.location.protocol},
 //            success: function(result){
 //            },
 //        });
 //    }
 //});
 }*/
window.onbeforeunload = function () {
	$.ajax({
		url: '//r.oblax.ru/widget/catched',
		async : false,
		data: {
			event: 'close_page',
			time: window.seconds,
			site_url: window.location.hostname,
			protocol: window.location.protocol
		}
	});
};

// Проверка на поведенческий фактор "Поведение, похожее на других клиентов" - как формировать "поведение"
function setCookie (name, value, path, expires, domain, secure) {
	document.cookie = name + "=" + parseInt(value) +
		((expires) ? "; expires=" + expires : "") +
		((path) ? "; path=" + path : "") +
		((domain) ? "; domain=" + domain : "") +
		((secure) ? "; secure" : "");
}

function getCookie(name) {
	var cookie = " " + document.cookie;
	var search = " " + name + "=";
	var setStr = null;
	var offset = 0;
	var end = 0;
	if (cookie.length > 0) {
		offset = cookie.indexOf(search);
		if (offset != -1) {
			offset += search.length;
			end = cookie.indexOf(";", offset)
			if (end == -1) {
				end = cookie.length;
			}
			setStr = unescape(cookie.substring(offset, end));
		}
	}
	return(setStr);
}