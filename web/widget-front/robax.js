var hostWidget = "r.oblax.ru", helperMask, callbackID, JSON_social, Widget_date, ClickCall = false;
(function(w,d){
    var helper={};
    var widgetsound = 0;
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
            return (helper.cssQuery("html").width <= 678);
        },
        any: function() {
            return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows()) || isMobile.iFrameMobile();
        }
    };
    helperMask = helper;
    /**
     * @return {number}
     */
    helper.ObjectLength = function(o){
        var s = 0, k;
        for (k in o) {
            if (o.hasOwnProperty(k)) s++;
        }
        return s;
    };
    //My typeof. For WHY? IS UNDERSTEND THAT IS A OBJECT AND THAT IS A ARRAY.
    /**
     * @return {string}
     */
    helper.ObjectType = function(e){
        var t=Object.prototype.toString.call(e),r='';
        if(/\[object HTML([a-zA-Z]+)Element\]/.test(t)) r=t.match(/\[object HTML([a-zA-Z]+)Element\]/)[1].toLowerCase();
        else if(/\[object ([a-zA-Z]+)\]/.test(t)) r=t.match(/\[object ([a-zA-Z]+)\]/)[1].toLowerCase();
        else if(r=='') {
            if('toString' in e && 'length' in e && 'join' in e && 'splice' in e && 'pop' in e) r='array';
            else r=typeof(e);
        }
        return r;
    };
    helper.isHTML = function (e){
        var t=Object.prototype.toString.call(e);
        return !!/\[object HTML([a-zA-Z]+)\]/.test(t);
    };
    helper.get = function (p,o,s,b,m){
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
            };
            xhttp.send(null);
        }else{
            xhttp.send(null);
            return xhttp.responseText;
        }
    };
    helper.post = function (p,o,s,b,m){
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
            };
            xhttp.send(body);
        }else{
            xhttp.send(body);
            return xhttp.responseText;
        }
    };
    helper.replaceAll = function (t,o){
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
        while(i<=n);
        //loop end
        return HTML;
    };
    helper.addClass = function (el, cls) {
        el.className += " "+cls;
    };
    helper.removeClass = function (el, cls) {
        var re = new RegExp('(\\s|^)' + cls + '(\\s|$)');
        el.className = el.className.replace(re, ' ');
    };
    helper.parseHourse = function (t){
        var h=t/60,m=t%60;
        return Math.ceil(h)+':'+(m<10?m+'0':m);
    };
    helper.cssQuery = function (q){
        return document.querySelector(q);
    };
    helper.cssQueryAll = function (q){
        return document.querySelectorAll(q);
    };
    helper.getTime = function(day, dataJSON, strDay) {
        switch (day) {
            case "Monday": {
                if (strDay == "Сегодня") {
                    return dataJSON["date"]["time"]["Monday"];
                } else if (strDay == "Завтра") {
                    return dataJSON["date"]["time"]["Tuesday"];
                } else if (strDay == "Послезавтра") {
                    return dataJSON["date"]["time"]["Wednesday"];
                } else if (strDay == "Послепослезавтра") {
                    return dataJSON["date"]["time"]["Thursday"];
                }
                break;
            }
            case "Tuesday": {
                if (strDay == "Сегодня") {
                    return dataJSON["date"]["time"]["Tuesday"];
                } else if (strDay == "Завтра") {
                    return dataJSON["date"]["time"]["Wednesday"];
                } else if (strDay == "Послезавтра") {
                    return dataJSON["date"]["time"]["Thursday"];
                } else if (strDay == "Послепослезавтра") {
                    return dataJSON["date"]["time"]["Friday"];
                }
                break;
            }
            case "Wednesday": {
                if (strDay == "Сегодня") {
                    return dataJSON["date"]["time"]["Wednesday"];
                } else if (strDay == "Завтра") {
                    return dataJSON["date"]["time"]["Thursday"];
                } else if (strDay == "Послезавтра") {
                    return dataJSON["date"]["time"]["Friday"];
                } else if (strDay == "Послепослезавтра") {
                    return dataJSON["date"]["time"]["Saturday"];
                }
                break;
            }
            case "Thursday": {
                if (strDay == "Сегодня") {
                    return dataJSON["date"]["time"]["Thursday"];
                } else if (strDay == "Завтра") {
                    return dataJSON["date"]["time"]["Tuesday"];
                } else if (strDay == "Послезавтра") {
                    return dataJSON["date"]["time"]["Friday"];
                } else if (strDay == "Послепослезавтра") {
                    return dataJSON["date"]["time"]["Saturday"];
                }
                break;
            }
            case "Friday": {
                if (strDay == "Сегодня") {
                    return dataJSON["date"]["time"]["Friday"];
                } else if (strDay == "Завтра") {
                    return dataJSON["date"]["time"]["Saturday"];
                } else if (strDay == "Послезавтра") {
                    return dataJSON["date"]["time"]["Sunday"];
                } else if (strDay == "Послепослезавтра") {
                    return dataJSON["date"]["time"]["Monday"];
                }
                break;
            }
            case "Saturday": {
                if (strDay == "Сегодня") {
                    return dataJSON["date"]["time"]["Saturday"];
                } else if (strDay == "Завтра") {
                    return dataJSON["date"]["time"]["Sunday"];
                } else if (strDay == "Послезавтра") {
                    return dataJSON["date"]["time"]["Monday"];
                } else if (strDay == "Послепослезавтра") {
                    return dataJSON["date"]["time"]["Tuesday"];
                }
                break;
            }
            case "Sunday": {
                if (strDay == "Сегодня") {
                    return dataJSON["date"]["time"]["Sunday"];
                } else if (strDay == "Завтра") {
                    return dataJSON["date"]["time"]["Monday"];
                } else if (strDay == "Послезавтра") {
                    return dataJSON["date"]["time"]["Tuesday"];
                } else if (strDay == "Послепослезавтра") {
                    return dataJSON["date"]["time"]["Wednesday"];
                }
                break;
            }
        }

        return null;
    };
    helper.setTime = function (dataTime) {
        var s=Number(dataTime['start'].split(':')[0])*60+Number(dataTime['start'].split(':')[1]),
            e=Number(dataTime['end'].split(':')[0])*60+Number(dataTime['end'].split(':')[1]),
            m=e-s,
            i=0,
            html='';
        while (i<=m) {
            if (i == (m - dataTime['end'].split(':')[1])) {
                html+='<li data-time="'+dataTime['end']+'">'+dataTime['end']+'</li>';
                i=i+60;
            } else if (i == 0) {
                html+='<li data-time="'+dataTime['start']+'">'+dataTime['start']+'</li>';
                i=i+60;
            } else {
                html+='<li data-time="'+helper.parseHourse(s+i)+'">'+helper.parseHourse(s+i)+'</li>';
                i=i+60;
            }
        }
        helper.cssQuery('.robax-later__hour-val').innerHTML=dataTime['start'];
        helper.cssQuery('.robax-later-sel__hold__hour').innerHTML=html;
        var e=helper.cssQueryAll('.robax-later__hour li'),i=0,n=e.length;
        while(i<n){
            e[i].onclick = function(){
                helper.cssQuery('.robax-later-data-hour').value=this.getAttribute("data-day");
                helper.cssQuery('.robax-later__hour-val').innerHTML=this.innerHTML;
            };
            i++;
        }
    };
    helper.setMask = function(I, M) {
        function R(s) {
            return new RegExp('('+s.replace(/\(/g,'\\(').replace(/\)/g,'\\)').replace(/\//g,'\\/').replace(/9/g,'\\d').replace(/a/g,'[a-zР°-СЏС‘]').replace(/\*/g,'[a-zР°-СЏС‘0-9]')+')','gi')
        }
        function N(c,j,x) {
            for(var k=0,s='';k<L;k++)s+=$[k]||c||'_';
            I.value=s;
            x?0:I.sC(!j?i:0)
        }
        function D(e,p,i) {
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

                    c = String.fromCharCode(c);
                    if (R(M.charAt(i)).test(c)) {
                        D(1);
                        $[i++] = c;
                        j++;
                        while(i<L&&S[i]){i++}
                    }
                    return 0;
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
        };
        I.gC = function(r,b){
            if (this.setSelectionRange) return [this.selectionStart,this.selectionEnd];
            else {
                r = d['selection'].createRange();
                b = 0-r.duplicate().moveStart(c,y);
                return [b,b+r.text.length]
            }
        };
        I.onfocus = function(){
            setTimeout(function(){N(0,!j)},0)
        };
        I.onblur = function(){
            j ? N(' ',0,1) : this.value=''
        };
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
        };
        I.onkeypress = function(e){
            if (G) return G=!G;

            e = e||event;

            if (P(e.keyCode||e.charCode)) return !G;

            N();

            return G
        };

        if (d.all&&!window.opera){
            I.onpaste=V;
        } else {
            I.addEventListener('input', V, false);
        }
        I.onselect = function(){
            helper.setCaretPosition(this,this.getAttribute("placeholder").indexOf('_'));
            this.onselect='';
        };
    };
    helper.setCaretPosition = function(ctrl, pos) {
        if(ctrl.setSelectionRange) {
            ctrl.focus();
            ctrl.setSelectionRange(pos,pos);
            //alert(ctrl.setSelectionRange(pos,pos));
        } else if (ctrl.createTextRange) {
            var range = ctrl.createTextRange();
            range.collapse(true);
            range.moveEnd('character', pos);
            range.moveStart('character', pos);
            //alert(range.moveStart('character', pos));
            range.select();
        }
    };
    helper.typing = function(obj, callBack) {
        /*helper.cssQuery(obj['type_h1']).innerHTML = obj[obj['type_h1']];
        helper.cssQuery(obj['type_div']).innerHTML = obj[obj['type_div']];

        if (typeof callBack == 'function') callBack();*/
        phh1 = obj[obj['type_h1']];
        phdiv = obj[obj['type_div']];

        helper.cssQuery(obj['type_h1']).innerHTML = '';
        helper.cssQuery(obj['type_div']).innerHTML = '';

        var tText = phh1;
        var tLength = 0;

        typingH1();
        function typingH1(){
            tLength++;
            if(tLength <= tText.length) {
                helper.cssQuery(obj['type_h1']).innerHTML = tText.substr(0, tLength);
                if(tLength == tText.length) {
                    tText = phdiv;
                    tLength = 0;
                    typingDIV();
                } else {
                    setTimeout(typingH1, 30);
                }
            }
        }
        function typingDIV(){
            tLength++;
            if(tLength <= tText.length) {
                helper.cssQuery(obj['type_div']).innerHTML = tText.substr(0, tLength);
                if(tLength == tText.length) {
                    if (typeof callBack == 'function') callBack();
                } else {
                    setTimeout(typingDIV, 30);
                }
            }
        }
    };
    helper.rate = function() {
        helper.cssQuery(".rate").style.display = "block";
        helper.cssQuery(".rate-form").style.display = "block";
        //Star 1
        helper.cssQuery(".rate i:nth-child(1)").onmouseover = function(){
            var i = 1;
            while (i <= 1) {
                helper.cssQuery(".rate i:nth-child("+i+")").style.color = 'gold';
                i++
            }
        };
        helper.cssQuery(".rate i:nth-child(1)").onmouseout = function(){
            if (!helper.cssQuery(".rate i:nth-child(1)").getAttribute('select-star')) {
                var i = 1;
                while (i <= 1) {
                    helper.cssQuery(".rate i:nth-child("+i+")").style.color = 'black';
                    i++
                }
            } else {
                var i = 1;
                while (i <= 1) {
                    helper.cssQuery(".rate i:nth-child("+i+")").style.color = 'darkgoldenrod';
                    i++
                }
            }
        };
        helper.cssQuery(".rate i:nth-child(1)").onclick = function(){
            var i = 1;
            while (i <= 5) {
                helper.cssQuery(".rate i:nth-child("+i+")").setAttribute('select-star', false);
                i++
            }
            var i = 1;
            while (i <= 1) {
                helper.cssQuery(".rate i:nth-child("+i+")").style.color = 'darkgoldenrod';
                helper.cssQuery(".rate i:nth-child("+i+")").setAttribute('select-star', true);
                i++
            }
            helper.cssQuery(".rate i:nth-child(2)").style.color = 'black';
            helper.cssQuery(".rate i:nth-child(3)").style.color = 'black';
            helper.cssQuery(".rate i:nth-child(4)").style.color = 'black';
            helper.cssQuery(".rate i:nth-child(5)").style.color = 'black';
        };
        //Star 2
        helper.cssQuery(".rate i:nth-child(2)").onmouseover = function(){
            var i = 1;
            while (i <= 2) {
                helper.cssQuery(".rate i:nth-child("+i+")").style.color = 'gold';
                i++
            }
        };
        helper.cssQuery(".rate i:nth-child(2)").onmouseout = function(){
            if (!helper.cssQuery(".rate i:nth-child(2)").getAttribute('select-star')) {
                var i = 1;
                while (i <= 2) {
                    helper.cssQuery(".rate i:nth-child("+i+")").style.color = 'black';
                    i++
                }
            } else {
                var i = 1;
                while (i <= 2) {
                    helper.cssQuery(".rate i:nth-child("+i+")").style.color = 'darkgoldenrod';
                    i++
                }
            }
        };
        helper.cssQuery(".rate i:nth-child(2)").onclick = function(){
            var i = 1;
            while (i <= 5) {
                helper.cssQuery(".rate i:nth-child("+i+")").setAttribute('select-star', false);
                i++
            }
            var i = 1;
            while (i <= 2) {
                helper.cssQuery(".rate i:nth-child("+i+")").style.color = 'darkgoldenrod';
                helper.cssQuery(".rate i:nth-child("+i+")").setAttribute('select-star', true);
                i++
            }
            helper.cssQuery(".rate i:nth-child(3)").style.color = 'black';
            helper.cssQuery(".rate i:nth-child(4)").style.color = 'black';
            helper.cssQuery(".rate i:nth-child(5)").style.color = 'black';
        };
        //Star 3
        helper.cssQuery(".rate i:nth-child(3)").onmouseover = function(){
            var i = 1;
            while (i <= 3) {
                helper.cssQuery(".rate i:nth-child("+i+")").style.color = 'gold';
                i++
            }
        };
        helper.cssQuery(".rate i:nth-child(3)").onmouseout = function(){
            if (!helper.cssQuery(".rate i:nth-child(3)").getAttribute('select-star')) {
                var i = 1;
                while (i <= 3) {
                    helper.cssQuery(".rate i:nth-child("+i+")").style.color = 'black';
                    i++
                }
            } else {
                var i = 1;
                while (i <= 3) {
                    helper.cssQuery(".rate i:nth-child("+i+")").style.color = 'darkgoldenrod';
                    i++
                }
            }
        };
        helper.cssQuery(".rate i:nth-child(3)").onclick = function(){
            var i = 1;
            while (i <= 5) {
                helper.cssQuery(".rate i:nth-child("+i+")").setAttribute('select-star', false);
                i++;
            }
            var i = 1;
            while (i <= 3) {
                helper.cssQuery(".rate i:nth-child("+i+")").style.color = 'darkgoldenrod';
                helper.cssQuery(".rate i:nth-child("+i+")").setAttribute('select-star', true);
                i++
            }
            helper.cssQuery(".rate i:nth-child(4)").style.color = 'black';
            helper.cssQuery(".rate i:nth-child(5)").style.color = 'black';
        };
        //Star 4
        helper.cssQuery(".rate i:nth-child(4)").onmouseover = function(){
            var i = 1;
            while (i <= 4) {
                helper.cssQuery(".rate i:nth-child("+i+")").style.color = 'gold';
                i++
            }
        };
        helper.cssQuery(".rate i:nth-child(4)").onmouseout = function(){
            if (!helper.cssQuery(".rate i:nth-child(4)").getAttribute('select-star')) {
                var i = 1;
                while (i <= 4) {
                    helper.cssQuery(".rate i:nth-child("+i+")").style.color = 'black';
                    i++
                }
            } else {
                var i = 1;
                while (i <= 4) {
                    helper.cssQuery(".rate i:nth-child("+i+")").style.color = 'darkgoldenrod';
                    i++
                }
            }
        };
        helper.cssQuery(".rate i:nth-child(4)").onclick = function(){
            var i = 1;
            while (i <= 5) {
                helper.cssQuery(".rate i:nth-child("+i+")").setAttribute('select-star', false);
                i++
            }
            var i = 1;
            while (i <= 4) {
                helper.cssQuery(".rate i:nth-child("+i+")").style.color = 'darkgoldenrod';
                helper.cssQuery(".rate i:nth-child("+i+")").setAttribute('select-star', true);
                i++
            }
            helper.cssQuery(".rate i:nth-child(5)").style.color = 'black';
        };
        //Star 5
        helper.cssQuery(".rate i:nth-child(5)").onmouseover = function(){
            var i = 1;
            while (i <= 5) {
                helper.cssQuery(".rate i:nth-child("+i+")").style.color = 'gold';
                i++
            }
        };
        helper.cssQuery(".rate i:nth-child(5)").onmouseout = function(){
            if (!helper.cssQuery(".rate i:nth-child(5)").getAttribute('select-star')) {
                var i = 1;
                while (i <= 5) {
                    helper.cssQuery(".rate i:nth-child("+i+")").style.color = 'black';
                    i++
                }
            } else {
                var i = 1;
                while (i <= 5) {
                    helper.cssQuery(".rate i:nth-child("+i+")").style.color = 'darkgoldenrod';
                    i++
                }
            }
        };
        helper.cssQuery(".rate i:nth-child(5)").onclick = function(){
            var i = 1;
            while (i <= 5) {
                helper.cssQuery(".rate i:nth-child("+i+")").setAttribute('select-star', false);
                i++
            }
            var i = 1;
            while (i <= 5) {
                helper.cssQuery(".rate i:nth-child("+i+")").style.color = 'darkgoldenrod';
                helper.cssQuery(".rate i:nth-child("+i+")").setAttribute('select-star', true);
                i++
            }
        };
    };
    helper.afterReview = function(){
        $(".rate i").each(function (i, e) {
            $(this).css("color", "black");
            $(this).attr("select-star", false);
        });
        $(".form-review").val("");
        $(".rate").hide();
        $(".rate-form").hide();

        $("#cbh_timer_seconds").text("07");
        $("#cbh_timer_ms").text("99");

        var new_json = JSON_social.replace('\\', '');
        new_json = new_json.replace('\\', '');
        new_json = JSON.parse(new_json);
        if (
            new_json["vk"].length ||
            new_json["ok"].length ||
            new_json["facebook"].length ||
            new_json["twitter"].length ||
            new_json["insta"].length
        ) {
            $(".robax-social").html('');
            $(".robax-social").append('<h3>Присоединяйтесь к нам</h3>');
        }
        if (new_json["vk"].length) $(".robax-social").append('<a href="http://'+new_json["vk"]+'"><img src="http://'+hostWidget+'/images/vkontakte.png"/></a>');
        if (new_json["ok"].length) $(".robax-social").append('<a href="http://'+new_json["ok"]+'"><img src="http://'+hostWidget+'/images/odnoklassniki.png"/></a>');
        if (new_json["facebook"].length) $(".robax-social").append('<a href="http://'+new_json["facebook"]+'"><img src="http://'+hostWidget+'/images/facebook.png"/></a>');
        if (new_json["twitter"].length) $(".robax-social").append('<a href="http://'+new_json["twitter"]+'"><img src="http://'+hostWidget+'/images/twitter_new.png"/></a>');
        if (new_json["insta"].length) $(".robax-social").append('<a href="http://'+new_json["insta"]+'"><img src="http://'+hostWidget+'/images/instagram-new.png"/></a>');

        $(".robax-social").show();
    };
    helper.resetRobax = function() {
        helper.cssQuery(".rate").style.display = 'none';
        helper.cssQuery(".rate-form").style.display = 'none';
        helper.cssQuery(".robax-social").style.display = 'none';
        helper.cssQuery(".robax-widget-phone-form").style.display = 'block';
        helper.cssQuery(".btn-call").style.display = 'block';
        helper.cssQuery(".robax-timer").style.display = 'block';
        helper.cssQuery(".robax-item-later").style.display = 'block';

        var dc = new Date();
        timeNow = dc.getHours() * 60 + dc.getMinutes();
        dc = Widget_date['work-start-time'];
        timeStart = Number(dc.split(':')[0]) * 60 + Number(dc.split(':')[1]);
        dc = Widget_date['work-end-time'];
        timeEnd = Number(dc.split(':')[0]) * 60 + Number(dc.split(':')[1]);

        if(timeNow > timeEnd || timeNow < timeStart) {
            helper.cssQuery('.robax-timer').style.display='none';
            helper.cssQuery('.robax-later').style.display='block';
            helper.cssQuery('.robax-item-later').style.display='none';
            helper.cssQuery('.robax-later-data').value='true';
            helper.cssQuery('.robax-item-now').style.display='none';
            helper.cssQueryAll('.robax-later-sel__hold__day li')[0].style.display = 'none';
            helper.cssQueryAll('.robax-later-sel__hold__day li')[1].onclick();
        }
    };
    RobaxWidget = function(param){
        var t = this;
        var template = 'desktop';
        var div = document.createElement("div");
        div.setAttribute("class","robax");

        if (isMobile.any()) {
            template = 'mobile';
        }
        var dataJSON = JSON.parse(helper.get('//'+hostWidget+'/widget/get-widget',{
            'action': 'widget-get',
            'key': param.key,
            'site_url': window.location.hostname,
            'protocol': window.location.protocol,
            'template': template
        }).replace(/\ufeff/g,''));
        window.widget_key = param.key;
        JSON_social = dataJSON['social'];
        Widget_date = dataJSON['date'];

        widgetsound = dataJSON['widget_sound']; //Получаем параметры звука
        //var colorTheme = dataJSON['theme_color'];

        var css = d.createElement("link");
        css.href="//"+hostWidget+"/widget-front/WidGet.css";
        css.rel="stylesheet";

        var css2 = d.createElement("link");
        css2.href="//bootstrapformhelpers.com/assets/css/bootstrap-formhelpers.min.css";
        css2.rel="stylesheet";

        var js = d.createElement("script");
        js.src="https://use.fontawesome.com/49d2433643.js";

        d.getElementsByTagName("link")[0].parentNode.insertBefore(css, d.getElementsByTagName("link")[0]);
        d.getElementsByTagName("link")[0].parentNode.insertBefore(css2, d.getElementsByTagName("link")[0]);
        d.getElementsByTagName("script")[0].parentNode.insertBefore(js, d.getElementsByTagName("script")[0]);

        helper.cssQuery('body').appendChild(div);
        helper.cssQuery('.robax').innerHTML += helper.replaceAll(dataJSON['tmp'],dataJSON);
        helper.setMask(helper.cssQuery('.robax-phone-input'),'+7(999)999-99-99');

        document.getElementById("open-button").style.background = dataJSON['widget_button_color'];

        this.controller.open(dataJSON);
        this.controller.closed();
        this.controller.phone();
        this.controller.menu(dataJSON);
        this.controller.phone_item(dataJSON);

        for(var k in param){
            t.settings[k]=param[k];
        }

        helper.cssQuery('.btn-call').onclick = function() {
            console.log(ClickCall);
            if (!ClickCall) {
                ClickCall = true;
                if (helper.cssQuery(".robax-later__day-val").innerHTML == "Сегодня") {
                    if (helper.cssQuery(".robax-widget-phone-form .robax-phone-input").value) {
                        t.postCall(helper.cssQuery(".robax-widget-phone-form .robax-phone-input").value);
                        t.controller.timer();
                    } else {
                        helper.typing({
                            '#phone-h1': '— Упс,',
                            '#phone-div': 'вы забыли ввести номер телефона. _',
                            'type_h1': '#phone-h1',
                            'type_div': '#phone-div'
                        });
                    }
                } else {
                    t.postOrderCall(
                        helper.cssQuery(".robax-widget-phone-form .robax-phone-input").value,
                        helper.cssQuery(".robax-later__day-val").innerHTML,
                        helper.cssQuery(".robax-later__hour-val").innerHTML
                    );
                    helper.typing({
                        '#phone-h1': '— Спасибо,',
                        '#phone-div': 'ваша заявка на звонок успешно отправлена. _',
                        'type_h1': '#phone-h1',
                        'type_div': '#phone-div'
                    });
                }
            }
        };
        helper.cssQuery('.btn-mail').onclick = function() {
            if (!helper.cssQuery('.form-question').value && !helper.cssQuery('.form-mail').value) {
                helper.typing({
                    '#mail-h1': '— Упс,',
                    '#mail-div': 'вы забыли задать вопрос и написать E-mail, эти поля обязательны. _',
                    'type_h1': '#mail-h1',
                    'type_div': '#mail-div'
                });
            } else if (helper.cssQuery('.form-question').value && !helper.cssQuery('.form-mail').value) {
                helper.typing({
                    '#mail-h1': '— Упс,',
                    '#mail-div': 'вы забыли заполнить E-mail. _',
                    'type_h1': '#mail-h1',
                    'type_div': '#mail-div'
                });
            } else if (!helper.cssQuery('.form-question').value && helper.cssQuery('.form-mail').value) {
                helper.typing({
                    '#mail-h1': '— Упс,',
                    '#mail-div': 'вы забыли задать вопрос. _',
                    'type_h1': '#mail-h1',
                    'type_div': '#mail-div'
                });
            } else {
                t.postMail(
                    helper.cssQuery('.form-question').value,
                    helper.cssQuery('.form-mail').value,
                    helper.cssQuery('.form-phone').value
                );
            }
        };
        helper.cssQuery(".btn-review").onclick = function() {
            var i = 1, starCount = 0;
            $(".rate i").each(function (i, e) {
                if ($(this).attr("select-star")) {
                    starCount++;
                }
            });
            if (starCount && helper.cssQuery(".form-review").value) {
                helper.typing({
                    '#phone-h1': '— Спасибо Вам,',
                    '#phone-div': 'за то, что помогаете, улучшить качество обслуживания клиентов. _',
                    'type_h1': '#phone-h1',
                    'type_div': '#phone-div'
                }, helper.afterReview);
                t.postReview(
                    starCount,
                    helper.cssQuery(".form-review").value
                );
            } else if (!starCount && helper.cssQuery(".form-review").value) {
                helper.typing({
                    '#phone-h1': '— Спасибо Вам,',
                    '#phone-div': 'за оставленый отзыв. Он для нас очень важен. Удачного вам дня! _',
                    'type_h1': '#phone-h1',
                    'type_div': '#phone-div'
                }, helper.afterReview);
                t.postReview(
                    starCount,
                    helper.cssQuery(".form-review").value
                );
            } else if (starCount && !helper.cssQuery(".form-review").value) {
                helper.typing({
                    '#phone-h1': '— Спасибо Вам,',
                    '#phone-div': 'за оценку менеджера. Для нас это важно. _',
                    'type_h1': '#phone-h1',
                    'type_div': '#phone-div'
                }, helper.afterReview);
                t.postReview(
                    starCount,
                    helper.cssQuery(".form-review").value
                );
            } else if (!starCount && !helper.cssQuery(".form-review").value) {
                helper.typing({
                    '#phone-h1': '— Нам очень жаль,',
                    '#phone-div': 'что Вы не поставили оценку и не оставили отзыв о работе менеджера... _',
                    'type_h1': '#phone-h1',
                    'type_div': '#phone-div'
                }, helper.afterReview);
            }
            starCount = 0;
        };

        var dc = new Date();
        timeNow = dc.getHours() * 60 + dc.getMinutes();
        dc = dataJSON['date']['work-start-time'];
        timeStart = Number(dc.split(':')[0]) * 60 + Number(dc.split(':')[1]);
        dc = dataJSON['date']['work-end-time'];
        timeEnd = Number(dc.split(':')[0]) * 60 + Number(dc.split(':')[1]);
        if(timeNow > timeEnd || timeNow < timeStart){
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
        if (getCookie('__utmctr') != undefined) {
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
            }, 60000);

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
        t.dataJSON = dataJSON;
    };
    RobaxWidget.prototype.settings = {};
    RobaxWidget.prototype.getToken = function(){};
    RobaxWidget.prototype.getOldMessage = function(){};
    RobaxWidget.prototype.postMessage = function(){};
    RobaxWidget.prototype.postOrderCall = function(phone, date, time){
        helper.get('//'+hostWidget+'/widget/widget-order',{
            'key': this.settings.key,
            'phone': phone,
            'date': date,
            'time': time,
            'site_url': window.location.hostname,
            'protocol' :window.location.protocol
        });
        ClickCall = false;
    };
    RobaxWidget.prototype.postReview = function(starCount, review){
        helper.get('//'+hostWidget+'/widget/widget-review',{
            'key': this.settings.key,
            'review': review,
            'starCount': starCount,
            'callbackID': callbackID,
            'site_url': window.location.hostname,
            'protocol' :window.location.protocol
        });
    };
    RobaxWidget.prototype.postMail = function(question, mail, phone){
        helper.get('//'+hostWidget+'/widget/widget-mail',{
            'key': this.settings.key,
            'question': question,
            'phone': phone,
            'mail': mail,
            'site_url': window.location.hostname,
            'protocol' :window.location.protocol
        });
    };
    RobaxWidget.prototype.postCall = function(phone){
        var megaEvent = document.getElementById("megaEvent").value;
        var t=this;
        t.settings.PhonePosted=true;
        helper.get('//'+hostWidget+'/widget/widget-call',{
            'key':this.settings.key,
            'phone':phone,
            'event':megaEvent,
            'site_url':window.location.hostname,
            'protocol':window.location.protocol
        }, function(r){
            if (t.dataJSON['widget_yandex_metrika']) {
                window["yaCounter" + t.dataJSON['widget_yandex_metrika']].reachGoal(t.dataJSON['widget_name'], {
                    'phone': phone,
                    'url': window.location.hostname + window.location.pathname
                });
            }
            if (window.ga && t.dataJSON['widget_google_metrika']) {
                window.ga("send", "event", t.dataJSON['widget_name'], 'phone-' + phone + '-url-' + window.location.hostname + window.location.pathname);
            }
            setTimeout(function(){
                $.ajax({
                    url: '//'+hostWidget+'/widget/get-callback',
                    dataType: "json",
                    data: {
                        key: window.widget_key,
                        site_url: window.location.hostname,
                        protocol: window.location.protocol
                    },
                    success: function(data){
                        callbackID = data.callbackID;
                    }
                });
            }, 3000);
        });
    };
    RobaxWidget.prototype.controller = {
        open:function(dataJSON) {
            helper.cssQuery('.robax-widget-open-button, .robax-widget-open-button-mobile').onclick = function(){
                helper.resetRobax();
                var dc = new Date();
                timeNow = dc.getHours() * 60 + dc.getMinutes();
                dc = dataJSON['date']['work-start-time'];
                timeStart = Number(dc.split(':')[0]) * 60 + Number(dc.split(':')[1]);
                dc = dataJSON['date']['work-end-time'];
                timeEnd = Number(dc.split(':')[0]) * 60 + Number(dc.split(':')[1]);
                if(timeNow > timeEnd || timeNow < timeStart) {
                    helper.typing({
                        '#phone-h1': dataJSON['widget-msg']['h1'],
                        '#phone-div': dataJSON['widget-msg']['item-text'],
                        'type_h1': '#phone-h1',
                        'type_div': '#phone-div'
                    });
                } else {
                    if ($(".rate").css("display") == "none" || $(".rate-social").css("display") == "none") {
                        helper.typing({
                            '#phone-h1': dataJSON['phone']['h1'],
                            '#phone-div': dataJSON['phone']['item-text'],
                            'type_h1': '#phone-h1',
                            'type_div': '#phone-div'
                        });
                    }
                }
                helper.cssQuery('#cbh_timer_minutes').innerHTML = '00';
                helper.cssQuery('#cbh_timer_seconds').innerHTML = '07';
                helper.cssQuery('#cbh_timer_ms').innerHTML = '99';
                $('.robax-d').text(':');
                if (widgetsound == 1) {
                    var audio = new Audio(); // Создаём новый элемент Audio
                    audio.src = 'http://'+hostWidget+'/widget-front/open_1.mp3'; // Указываем путь к звуку "клика"
                    audio.autoplay = true; // Автоматически запускаем
                }
                helper.cssQuery('.overlay').setAttribute("style","display:block;");
                helper.cssQuery('.robax-widget, .robax-widget-mobile').setAttribute("style","right:0;");
                helper.cssQuery('#megaEvent').setAttribute('value', 'robax_button_clicked');
            };
            helper.cssQuery('.overlay').onclick=function () {
                helper.cssQuery('.overlay').setAttribute("style","display:none;");
                if (!$('.robax-widget-mobile').length) {
                    helper.cssQuery('.robax-widget').setAttribute("style","right:-350px;");
                } else {
                    $('.robax-widget-active').removeClass('robax-widget-active');
                    helper.cssQuery('.robax-widget-mobile').setAttribute("style","right:-360px;");
                }
            };
            //textEcho({selector:helper.cssQuery('.robax-widget-open-button'),});
        },
        closed:function() {
            helper.cssQuery('.robax-widget-closed').onclick = function(){
                helper.cssQuery('.overlay').setAttribute("style","display:none;");
                if (!$('.robax-widget-mobile').length) {
                    helper.cssQuery('.robax-widget').setAttribute("style","right:-350px;");
                } else {
                    $('.robax-widget-active').removeClass('robax-widget-active');
                    helper.cssQuery('.robax-widget-mobile').setAttribute("style","right:-360px;");
                }
                helper.resetRobax();
            };
            if (!$('.robax-widget-mobile').length) {
                helper.cssQuery('.robax-arrow').onclick = function(){
                    helper.cssQuery('.overlay').setAttribute("style","display:none;");
                    helper.cssQuery('.robax-widget').setAttribute("style","right:-350px;");
                    helper.resetRobax();
                }
            }
        },
        phone:function() {
            /*var e=helper.cssQueryAll('.robax-phone-type-list div'),i=0,n=e.length;
             while(i<n){
             e[i].onclick=function(){
             helper.cssQuery('.robax-phone-input').setAttribute("placeholder",this.getAttribute("data-placeholder"));
             helper.setMask(helper.cssQuery('.robax-phone-input'),this.getAttribute("data-mask"));
             helper.cssQuery('.robax-country-box .robax-flag').setAttribute("class",this.querySelector("i").getAttribute("class"));
             }
             i++;
             }*/
        },
        menu:function(dataJSON) {
            var e = helper.cssQueryAll('.robax-menu-button'),el,i=0,z=0,y=0,n=e.length;
            while(i < n){
                e[i].onclick = function(){
                    el = helper.cssQuery(this.getAttribute("data-target")).parentNode.children;
                    z = 0;
                    y = 0;
                    while(z < n){
                        helper.removeClass(e[z],'robax-widget-active');
                        z++;
                    }
                    z = 0;
                    this.setAttribute("class","robax-menu-button robax-widget-active");
                    while(y < el.length){
                        helper.removeClass(el[y],'robax-widget-active');
                        y++;
                    }
                    helper.addClass(helper.cssQuery(this.getAttribute("data-target")),' robax-widget-active');
                    if (this.getAttribute("data-target") == ".robax-widget-phone") {
                        if ($(".rate").css("display") == "none") {
                            helper.typing({
                                '#phone-h1': dataJSON['phone']['h1'],
                                '#phone-div': dataJSON['phone']['item-text'],
                                'type_h1': '#phone-h1',
                                'type_div': '#phone-div'
                            });
                        }
                    } else if (this.getAttribute("data-target") == ".robax-widget-mail") {
                        helper.typing({
                            '#mail-h1': dataJSON['mail']['h1'],
                            '#mail-div': dataJSON['mail']['item-text'],
                            'type_h1': '#mail-h1',
                            'type_div': '#mail-div'
                        });
                        if ($(".rate").css("display") == "none") {
                            helper.resetRobax();
                        }
                    }
                };
                i++;
            }
        },
        phone_item:function(dataJSON) {
            helper.cssQuery('.robax-item-later-link').onclick = function(){
                helper.cssQuery('.robax-timer').style.display = 'none';
                helper.cssQuery('.robax-later').style.display = 'block';
                helper.cssQuery('.robax-item-later').style.display = 'none';
                helper.cssQuery('.robax-item-now').style.display = 'block';
                helper.cssQuery('.robax-later-data').value='true';
            };
            helper.cssQuery('.robax-item-later-now').onclick = function(){
                helper.cssQuery('.robax-timer').style.display = 'block';
                helper.cssQuery('.robax-later').style.display = 'none';
                helper.cssQuery('.robax-item-later').style.display = 'block';
                helper.cssQuery('.robax-item-now').style.display = 'none';
                helper.cssQuery('.robax-later-data').value = 'false';
            };
            var date = new Date(Date.now() + 2592e5);
            var month = ["Января", "Февраля", "Марта", "Апрела", "Мая", "Июня", "Июля", "Августа", "Сентября", "Октября", "Ноября", "Декабря"];
            helper.cssQuery('.robax-later-sel__hold__day').innerHTML+='<li data-day="after-after-tomorrow">'+date.getDate()+' '+month[date.getMonth()]+'</li>';

            var e=helper.cssQueryAll('.robax-later-sel__hold__day li'),
                i=0,
                n=e.length;
            while(i<n){
                e[i].onclick=function(){
                    helper.cssQuery('.robax-later-data-day').value=this.getAttribute("data-day");
                    helper.cssQuery('.robax-later__day-val').innerHTML=this.innerHTML;
                    switch (this.innerText) {
                        case "Сегодня": {
                            helper.setTime(helper.getTime(dataJSON["date"]["day"], dataJSON, "Сегодня"));
                            break;
                        }
                        case "Завтра": {
                            helper.setTime(helper.getTime(dataJSON["date"]["day"], dataJSON, "Завтра"));
                            break;
                        }
                        case "Послезавтра": {
                            helper.setTime(helper.getTime(dataJSON["date"]["day"], dataJSON, "Послезавтра"));
                            break;
                        }
                        default: {
                            helper.setTime(helper.getTime(dataJSON["date"]["day"], dataJSON, "Послепослезавтра"));
                            break;
                        }
                    }
                };
                i++;
            }
            var s=Number(dataJSON["date"]['work-start-time'].split(':')[0])*60+Number(dataJSON["date"]['work-start-time'].split(':')[1]),e=Number(dataJSON["date"]['work-end-time'].split(':')[0])*60+Number(dataJSON["date"]['work-end-time'].split(':')[1]),m=e-s,i=0,html='';
            while (i<=m) {
                html+='<li data-time="'+helper.parseHourse(s+i)+'">'+helper.parseHourse(s+i)+'</li>';
                i=i+60;
            }

            helper.cssQuery('.robax-later-sel__hold__hour').innerHTML = html;
            helper.cssQuery('.robax-later__hour-val').innerHTML = helper.cssQuery('.robax-later-sel__hold__hour li').innerHTML;
            var e=helper.cssQueryAll('.robax-later__hour li'),i=0,n=e.length;
            while(i<n){
                e[i].onclick = function(){
                    helper.cssQuery('.robax-later-data-hour').value = this.getAttribute("data-day");
                    helper.cssQuery('.robax-later__hour-val').innerHTML = this.innerHTML;
                };
                i++;
            }
            var dc = new Date();
            timeNow = dc.getHours()*60+dc.getMinutes();
            dc = dataJSON['date']['work-start-time'];
            timeStart = Number(dc.split(':')[0]) * 60 + Number(dc.split(':')[1]);
            dc = dataJSON['date']['work-end-time'];
            timeEnd = Number(dc.split(':')[0]) * 60 + Number(dc.split(':')[1]);
            if(timeNow > timeEnd || timeNow < timeStart){
                helper.cssQueryAll('.robax-later-sel__hold__day li')[0].style.display = 'none';
                helper.cssQueryAll('.robax-later-sel__hold__day li')[1].onclick();
            }
        },
        timer:function timer(s){
            var ms = Number(helper.cssQuery('#cbh_timer_ms').innerHTML)-1;
            helper.cssQuery("#cbh_timer_ms").innerHTML=(ms < 10 ? '0' + ms : ms);
            if (ms > 0) {
                setTimeout(timer, 10);
            } else {
                //noinspection JSDuplicatedDeclaration
                var s = Number(helper.cssQuery("#cbh_timer_seconds").innerHTML)-1;
                if(s >= 0) {
                    helper.cssQuery("#cbh_timer_seconds").innerHTML = (s < 10 ? '0' + s : s);
                    helper.cssQuery("#cbh_timer_ms").innerHTML = 99;
                    setTimeout(timer, 10);
                } else {
                    helper.cssQuery(".robax-widget-phone-form").style.display = 'none';
                    helper.cssQuery(".btn-call").style.display = 'none';
                    helper.cssQuery(".robax-timer").style.display = 'none';
                    helper.cssQuery(".robax-item-later").style.display = 'none';
                    helper.typing({
                        '#phone-h1': '— Спасибо за заказ.',
                        '#phone-div': 'Оцените пожалуйста работу менеджера по 5-ти бальной шкале и оставте пожалуйста ваш отзыв. _',
                        'type_h1': '#phone-h1',
                        'type_div': '#phone-div'
                    }, helper.rate);
                    ClickCall = false;
                    if (typeof(s) == 'function') s();
                }
            }
        },
        open_utp:function(){
            var css = {'width':helper.cssQuery('.robax-utp-img').offsetWidth+'px','height':helper.cssQuery('.robax-utp-img').offsetHeight+'px','left':((document.body.offsetWidth-helper.cssQuery('.robax-utp-img').offsetWidth)/2)+'px','top':((document.body.offsetHeight-helper.cssQuery('.robax-utp-img').offsetHeight)/2)+'px'};
            for(var k in css){
                helper.cssQuery('.robax-utp').style[k]=css[k];
            }
            helper.cssQuery('.robax-utp-body').style.display='block';
            if(helper.cssQuery('.robax-utp-closed').onclick==''){
                helper.cssQuery('.robax-utp-closed').onclick=function(){
                    helper.cssQuery('.robax-utp-body').style.display='none';
                };
            }
            helper.cssQuery('.robax-utp-body').addEventListener('click',function(e){
                var ev=(e || window.event);
                if(ev.target.className=="robax-utp-body")
                    helper.cssQuery('.robax-utp-body').style.display='none';
                else
                    ev.stopPropagation();
            },true);
        }
    };
    var textEcho=function (options){
        var o=options;
        if(typeof(o.text)!='string')o.text = helper.cssQuery(o.selector).innerHTML;
        if(isNaN(o.io))o.io=0;
        helper.cssQuery(o.selector).innerHTML='';
        var i=0;
        while(i<o.io){
            helper.cssQuery(o.selector).innerHTML+=o.text[i];
            i++;
        }
        if(o.text.length>o.io) {o.io=o.io+1;setTimeout(function(){textEcho(o)},50);}
        else if(typeof(o.s)=='function') o.s();
    }

})(this, this.document);

// Проверка на поведенческий фактор "Посещение конкретной страницы или раздела сайта"
window.onload=function(){
    $.ajax({
        url: '//'+hostWidget+'/widget/get-urls',
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
        }
    });
    $.ajax({
        url: '//'+hostWidget+'/widget/get-marks',
        data: {key:window.widget_key,
            site_url:window.location.hostname,
            protocol:window.location.protocol},
        success: function(result){
            dataMarks = JSON.parse(result);
        }
    });
};
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
    $(document).mouseup(function () {
        if ($(event.target).closest(".open").length) return;
        $('.dropdown-menu').each(function (i, e) {
            aria = $(this).attr('aria-labelledby');
            $(this).hide();
            $('#' + aria).removeClass('open');
        });
        event.stopPropagation();
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
            url: '//'+hostWidget+'/widget/location',
            data: {site_url:window.location.hostname,
                protocol:window.location.protocol},
            cache: false,
            success: function(result){
                $.ajax({
                    url: '//'+hostWidget+'/widget/catched',
                    data: {event:event,
                        ip: result,
                        site_url:window.location.hostname,
                        protocol:window.location.protocol},
                    success: function(result){
                    },
                });
            }
        });
        document.getElementById('megaEvent').setAttribute('value','"'+event+'"');
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
    url: '//'+hostWidget+'/widget/avgtime',
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
        try{
            getPoints('more_avgtime',window.dataMarks['more_avgtime']);
            more_avgtime = true;
        }
        catch(e){
            console.log('An error has occurred: '+e.message)
        }
    }
}, 1000);
// Для подсчёта среднего времени на сайте - работает коряво
/*window.onbeforeunload = function() {
 //$.ajax({
 //    url: '//'+hostWidget+'/widget/location',
 //    data: {site_url:window.location.hostname,
 //        protocol:window.location.protocol},
 //    cache: false,
 //    success: function(result){
 //        $.ajax({
 //            url: '//'+hostWidget+'/widget/catched',
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
        url: '//'+hostWidget+'/widget/catched',
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
            end = cookie.indexOf(";", offset);
            if (end == -1) {
                end = cookie.length;
            }
            setStr = unescape(cookie.substring(offset, end));
        }
    }
    return(setStr);
}

function countryChange(lang, element, s) {
    ul = element.parent('ul');
    id_button = ul.attr('aria-labelledby');
    button = ul.siblings('button');
    input = document.querySelector(s);
    switch (lang) {
        case 'RU': {
            ul.hide();
            el = ul.siblings('.flag-select');
            el.removeClass('open');
            button.html('<i class="glyphicon bfh-flag-RU"></i><span class="caret">');
            input.value = '';
            input.setAttribute('placeholder', '+7(___)___-__-__');
            helperMask.setMask(input, '+7(999)999-99-99');
            break;
        }
        case 'BY': {
            ul.hide();
            el = ul.siblings('.flag-select');
            el.removeClass('open');
            button.html('<i class="glyphicon bfh-flag-BY"></i><span class="caret">');
            input.value = '';
            input.setAttribute('placeholder', '+375(___)___-__-__');
            helperMask.setMask(input, '+375(999)999-99-99');
            break;
        }
        case 'UA': {
            ul.hide();
            el = ul.siblings('.flag-select');
            el.removeClass('open');
            button.html('<i class="glyphicon bfh-flag-UA"></i><span class="caret">');
            input.value = '';
            input.setAttribute('placeholder', '+380(___)___-__-__');
            helperMask.setMask(input, '+380(999)999-99-99');
            break;
        }
        case 'US': {
            ul.hide();
            el = ul.siblings('.flag-select');
            el.removeClass('open');
            button.html('<i class="glyphicon bfh-flag-US"></i><span class="caret">');
            input.value = '';
            input.setAttribute('placeholder', '+1(___)___-__-__');
            helperMask.setMask(input, '+1(999)999-99-99');
            break;
        }
    }
}

function openDropDown(element) {
    labelledby = element.prop('id');
    if (element.hasClass('open')) {
        $('ul[aria-labelledby="'+labelledby+'"]').hide();
        element.removeClass('open');
    } else {
        $('ul[aria-labelledby="'+labelledby+'"]').show();
        element.addClass('open');
        $('.dropdown-menu').each(function (i, e) {
            aria = $(this).attr('aria-labelledby');
            if ($('#' + aria).hasClass('open') && labelledby != aria) {
                $(this).hide();
                $('#' + aria).removeClass('open')
            }
        });
    }
}