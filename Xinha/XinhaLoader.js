/* This compressed file is part of Xinha. For uncompressed sources, forum, and bug reports, go to xinha.org */
var Xinha={};if(!window._editor_url){(function(){var scripts=document.getElementsByTagName("script");var this_script=scripts[scripts.length-1];var args=this_script.src.split("?");args=args.length==2?args[1].split("&"):"";for(var index=0;index<args.length;++index){var arg=args[index].split("=");if(arg.length==2){switch(arg[0]){case"lang":case"icons":case"skin":case"url":window["_editor_"+arg[0]]=arg[1];break}}}if(this_script.innerHTML.replace(/\s+/,"")){eval(this_script.innerHTML)}_editor_lang=window._editor_lang||"en";_editor_url=window._editor_url||this_script.src.split("?")[0].split("/").slice(0,-1).join("/")})()}_editor_url=_editor_url.replace(/\x2f*$/,"/");Xinha.agt=navigator.userAgent.toLowerCase();Xinha.is_ie=((Xinha.agt.indexOf("msie")!=-1)&&(Xinha.agt.indexOf("opera")==-1));Xinha.ie_version=parseFloat(Xinha.agt.substring(Xinha.agt.indexOf("msie")+5));Xinha.is_opera=(Xinha.agt.indexOf("opera")!=-1);Xinha.is_khtml=(Xinha.agt.indexOf("khtml")!=-1);Xinha.is_webkit=(Xinha.agt.indexOf("applewebkit")!=-1);Xinha.is_safari=(Xinha.agt.indexOf("safari")!=-1);Xinha.opera_version=navigator.appVersion.substring(0,navigator.appVersion.indexOf(" "))*1;Xinha.is_mac=(Xinha.agt.indexOf("mac")!=-1);Xinha.is_mac_ie=(Xinha.is_ie&&Xinha.is_mac);Xinha.is_win_ie=(Xinha.is_ie&&!Xinha.is_mac);Xinha.is_gecko=(navigator.product=="Gecko"&&!Xinha.is_safari);Xinha.isRunLocally=document.URL.toLowerCase().search(/^file:/)!=-1;Xinha.is_designMode=(typeof document.designMode!="undefined"&&!Xinha.is_ie);Xinha.isSupportedBrowser=Xinha.is_gecko||(Xinha.is_opera&&Xinha.opera_version>=9.1)||Xinha.ie_version>=5.5||Xinha.is_safari;Xinha.loadPlugins=function(f,d){if(!Xinha.isSupportedBrowser){return}Xinha.loadStyle(typeof _editor_css=="string"?_editor_css:"Xinha.css","XinhaCoreDesign");Xinha.createLoadingMessages(xinha_editors);var e=Xinha.loadingMessages;Xinha._loadback(_editor_url+"XinhaCore.js",function(){Xinha.removeLoadingMessages(xinha_editors);Xinha.createLoadingMessages(xinha_editors);d()});return false};Xinha._loadback=function(k,l,j,g){var i=!Xinha.is_ie?"onload":"onreadystatechange";var h=document.createElement("script");h.type="text/javascript";h.src=k;if(l){h[i]=function(){if(Xinha.is_ie&&(!(/loaded|complete/.test(window.event.srcElement.readyState)))){return}l.call(j?j:this,g);h[i]=null}}document.getElementsByTagName("head")[0].appendChild(h)};Xinha.getElementTopLeft=function(f){var e=0;var d=0;if(f.offsetParent){e=f.offsetLeft;d=f.offsetTop;while(f=f.offsetParent){e+=f.offsetLeft;d+=f.offsetTop}}return{top:d,left:e}};Xinha.findPosX=function(d){var c=0;if(d.offsetParent){return Xinha.getElementTopLeft(d).left}else{if(d.x){c+=d.x}}return c};Xinha.findPosY=function(c){var d=0;if(c.offsetParent){return Xinha.getElementTopLeft(c).top}else{if(c.y){d+=c.y}}return d};Xinha.createLoadingMessages=function(c){if(Xinha.loadingMessages||!Xinha.isSupportedBrowser){return}Xinha.loadingMessages=[];for(var d=0;d<c.length;d++){if(!document.getElementById(c[d])){continue}Xinha.loadingMessages.push(Xinha.createLoadingMessage(document.getElementById(c[d])))}};Xinha.createLoadingMessage=function(f,j){if(document.getElementById("loading_"+f.id)||!Xinha.isSupportedBrowser){return}var i=document.createElement("div");i.id="loading_"+f.id;i.className="loading";i.style.left=(Xinha.findPosX(f)+f.offsetWidth/2)-106+"px";i.style.top=(Xinha.findPosY(f)+f.offsetHeight/2)-50+"px";var h=document.createElement("div");h.className="loading_main";h.id="loading_main_"+f.id;h.appendChild(document.createTextNode(Xinha._lc("Loading in progress. Please wait!")));var g=document.createElement("div");g.className="loading_sub";g.id="loading_sub_"+f.id;j=j?j:Xinha._lc("Loading Core");g.appendChild(document.createTextNode(j));i.appendChild(h);i.appendChild(g);document.body.appendChild(i);return g};Xinha.loadStyle=function(g,j){var i=_editor_url||"";i+=g;var h=document.getElementsByTagName("head")[0];var f=document.createElement("link");f.rel="stylesheet";f.href=i;if(j){f.id=j}h.appendChild(f)};Xinha._lc=function(b){return b};Xinha._addEvent=function(f,d,e){if(document.addEventListener){f.addEventListener(d,e,true)}else{f.attachEvent("on"+d,e)}};Xinha.addOnloadHandler=function(d){var c=function(){if(arguments.callee.done){return}arguments.callee.done=true;if(Xinha.onloadTimer){clearInterval(Xinha.onloadTimer)}d.call()};if(Xinha.is_ie){document.attachEvent("onreadystatechange",function(){if(document.readyState==="complete"){document.detachEvent("onreadystatechange",arguments.callee);c()}});if(document.documentElement.doScroll&&typeof window.frameElement==="undefined"){(function(){if(arguments.callee.done){return}try{document.documentElement.doScroll("left")}catch(a){setTimeout(arguments.callee,0);return}c()})()}}else{if(/WebKit/i.test(navigator.userAgent)){Xinha.onloadTimer=setInterval(function(){if(/loaded|complete/.test(document.readyState)){c()}},10)}else{document.addEventListener("DOMContentLoaded",c,false)}}};