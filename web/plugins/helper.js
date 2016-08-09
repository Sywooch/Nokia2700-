//helper functions
helper={};
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
			else url+=k+"="+encodeURIComponent(o[k])+'&';

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
	function R(s){return new RegExp('('+s.replace(/\(/g,'\\(').replace(/\)/g,'\\)').replace(/\//g,'\\/').replace(/9/g,'\\d').replace(/a/g,'[a-zà-ÿ¸]').replace(/\*/g,'[a-zà-ÿ¸0-9]')+')','gi')}
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
