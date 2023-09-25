/* This compressed file is part of Xinha. For uncompressed sources, forum, and bug reports, go to xinha.org */
ColorPicker._pluginInfo={name:"colorPicker",version:"$LastChangedRevision: 1237 $".replace(/^[^:]*:\s*(.*)\s*\$$/,"$1"),developer:"James Sleeman",developer_url:"http://www.gogo.co.nz/",c_owner:"Gogo Internet Services",license:"htmlArea",sponsor:"Gogo Internet Services",sponsor_url:"http://www.gogo.co.nz/"};function ColorPicker(){}try{if(window.opener&&window.opener.Xinha){var openerColorPicker=window.opener.Xinha.colorPicker;Xinha._addEvent(window,"unload",function(){Xinha.colorPicker=openerColorPicker})}}catch(e){}Xinha.colorPicker=function(y){if(Xinha.colorPicker.savedColors.length===0){Xinha.colorPicker.loadColors()}this.is_ie_6=(Xinha.is_ie&&Xinha.ie_version<7);var N=this;var P=false;var H=false;var E=0;var z=0;this.callback=y.callback?y.callback:function(a){alert("You picked "+a)};this.websafe=y.websafe?y.websafe:false;this.savecolors=y.savecolors?y.savecolors:20;this.cellsize=parseInt(y.cellsize?y.cellsize:"10px",10);this.side=y.granularity?y.granularity:18;var L=this.side+1;var O=this.side-1;this.value=1;this.saved_cells=null;this.table=document.createElement("table");this.table.className="dialog";this.table.cellSpacing=this.table.cellPadding=0;this.table.onmouseup=function(){P=false;H=false};this.tbody=document.createElement("tbody");this.table.appendChild(this.tbody);this.table.style.border="1px solid WindowFrame";this.table.style.zIndex="1050";var R=document.createElement("tr");var J=document.createElement("td");J.colSpan=this.side;J.className="title";J.style.fontFamily="small-caption,caption,sans-serif";J.style.fontSize="x-small";J.unselectable="on";J.style.MozUserSelect="none";J.style.cursor="default";J.appendChild(document.createTextNode(Xinha._lc("Click a color...")));J.style.borderBottom="1px solid WindowFrame";R.appendChild(J);J=null;var J=document.createElement("td");J.className="title";J.colSpan=2;J.style.fontFamily="Tahoma,Verdana,sans-serif";J.style.borderBottom="1px solid WindowFrame";J.style.paddingRight="0";R.appendChild(J);var D=document.createElement("div");D.title=Xinha._lc("Close");D.className="buttonColor";D.style.height="11px";D.style.width="11px";D.style.cursor="pointer";D.onclick=function(){N.close()};D.appendChild(document.createTextNode("\u00D7"));D.align="center";D.style.verticalAlign="top";D.style.position="relative";D.style.cssFloat="right";D.style.styleFloat="right";D.style.padding="0";D.style.margin="2px";D.style.backgroundColor="transparent";D.style.fontSize="11px";if(!Xinha.is_ie){D.style.lineHeight="9px"}D.style.letterSpacing="0";J.appendChild(D);this.tbody.appendChild(R);D=R=J=null;this.constrain_cb=document.createElement("input");this.constrain_cb.type="checkbox";this.chosenColor=document.createElement("input");this.chosenColor.type="text";this.chosenColor.maxLength=7;this.chosenColor.style.width="50px";this.chosenColor.style.fontSize="11px";this.chosenColor.onchange=function(){if(/#[0-9a-f]{6,6}/i.test(this.value)){N.backSample.style.backgroundColor=this.value;N.foreSample.style.color=this.value}};this.backSample=document.createElement("div");this.backSample.appendChild(document.createTextNode("\u00A0"));this.backSample.style.fontWeight="bold";this.backSample.style.fontFamily="small-caption,caption,sans-serif";this.backSample.fontSize="x-small";this.foreSample=document.createElement("div");this.foreSample.appendChild(document.createTextNode(Xinha._lc("Sample")));this.foreSample.style.fontWeight="bold";this.foreSample.style.fontFamily="small-caption,caption,sans-serif";this.foreSample.fontSize="x-small";function x(a){var b=a.toString(16);if(b.length<2){b="0"+b}return b}function B(a){return"#"+x(a.red)+x(a.green)+x(a.blue)}function A(b,a){return Math.round(Math.round(b/a)*a)}function M(a){return parseInt(a.toString(16)+a.toString(16),16)}function I(a){a.red=M(A(parseInt(x(a.red).charAt(0),16),3));a.blue=M(A(parseInt(x(a.blue).charAt(0),16),3));a.green=M(A(parseInt(x(a.green).charAt(0),16),3));return a}function S(b,g,i){var j;if(g===0){j={red:i,green:i,blue:i}}else{b/=60;var c=Math.floor(b);var a=b-c;var d=i*(1-g);var f=i*(1-g*a);var h=i*(1-g*(1-a));switch(c){case 0:j={red:i,green:h,blue:d};break;case 1:j={red:f,green:i,blue:d};break;case 2:j={red:d,green:i,blue:h};break;case 3:j={red:d,green:f,blue:i};break;case 4:j={red:h,green:d,blue:i};break;default:j={red:i,green:d,blue:f};break}}j.red=Math.ceil(j.red*255);j.green=Math.ceil(j.green*255);j.blue=Math.ceil(j.blue*255);return j}var C=this;function F(a){a=a?a:window.event;el=a.target?a.target:a.srcElement;do{if(el==C.table){return}}while(el=el.parentNode);C.close()}this.open=function(c,g,i){this.table.style.display="";this.pick_color();if(i&&/#[0-9a-f]{6,6}/i.test(i)){this.chosenColor.value=i;this.backSample.style.backgroundColor=i;this.foreSample.style.color=i}Xinha._addEvent(document.body,"mousedown",F);this.table.style.position="absolute";var d=g;var f=0;var b=0;do{if(d.style.position=="fixed"){this.table.style.position="fixed"}f+=d.offsetTop-d.scrollTop;b+=d.offsetLeft-d.scrollLeft;d=d.offsetParent}while(d);var h,a;if(/top/.test(c)||(f+this.table.offsetHeight>document.body.offsetHeight)){if(f-this.table.offsetHeight>0){this.table.style.top=(f-this.table.offsetHeight)+"px"}else{this.table.style.top=0}}else{this.table.style.top=(f+g.offsetHeight)+"px"}if(/left/.test(c)||(b+this.table.offsetWidth>document.body.offsetWidth)){if(b-(this.table.offsetWidth-g.offsetWidth)>0){this.table.style.left=(b-(this.table.offsetWidth-g.offsetWidth))+"px"}else{this.table.style.left=0}}else{this.table.style.left=b+"px"}if(this.is_ie_6){this.iframe.style.top=this.table.style.top;this.iframe.style.left=this.table.style.left}};function G(a){N.chosenColor.value=a.colorCode;N.backSample.style.backgroundColor=a.colorCode;N.foreSample.style.color=a.colorCode;if((a.hue>=195&&a.saturation>0.5)||(a.hue===0&&a.saturation===0&&a.value<0.5)||(a.hue!==0&&N.value<0.75)){a.style.borderColor="#fff"}else{a.style.borderColor="#000"}E=a.thisrow;z=a.thiscol}function Q(a){if(N.value<0.5){a.style.borderColor="#fff"}else{a.style.borderColor="#000"}O=a.thisrow;L=a.thiscol;N.chosenColor.value=N.saved_cells[E][z].colorCode;N.backSample.style.backgroundColor=N.saved_cells[E][z].colorCode;N.foreSample.style.color=N.saved_cells[E][z].colorCode}function K(a,b){N.saved_cells[a][b].style.borderColor=N.saved_cells[a][b].colorCode}this.pick_color=function(){var n,j;var l=this;var b=359/(this.side);var w=1/(this.side-1);var o=1/(this.side-1);var a=this.constrain_cb.checked;if(this.saved_cells===null){this.saved_cells=[];for(var v=0;v<this.side;v++){var p=document.createElement("tr");this.saved_cells[v]=[];for(var U=0;U<this.side;U++){var s=document.createElement("td");if(a){s.colorCode=B(I(S(b*v,w*U,this.value)))}else{s.colorCode=B(S(b*v,w*U,this.value))}this.saved_cells[v][U]=s;s.style.height=this.cellsize+"px";s.style.width=this.cellsize-2+"px";s.style.borderWidth="1px";s.style.borderStyle="solid";s.style.borderColor=s.colorCode;s.style.backgroundColor=s.colorCode;if(v==E&&U==z){s.style.borderColor="#000";this.chosenColor.value=s.colorCode;this.backSample.style.backgroundColor=s.colorCode;this.foreSample.style.color=s.colorCode}s.hue=b*v;s.saturation=w*U;s.thisrow=v;s.thiscol=U;s.onmousedown=function(){P=true;l.saved_cells[E][z].style.borderColor=l.saved_cells[E][z].colorCode;G(this)};s.onmouseover=function(){if(P){G(this)}};s.onmouseout=function(){if(P){this.style.borderColor=this.colorCode}};s.ondblclick=function(){Xinha.colorPicker.remember(this.colorCode,l.savecolors);l.callback(this.colorCode);l.close()};s.appendChild(document.createTextNode(" "));s.style.cursor="pointer";p.appendChild(s);s=null}var s=document.createElement("td");s.appendChild(document.createTextNode(" "));s.style.width=this.cellsize+"px";p.appendChild(s);s=null;var s=document.createElement("td");this.saved_cells[v][U+1]=s;s.appendChild(document.createTextNode(" "));s.style.width=this.cellsize-2+"px";s.style.height=this.cellsize+"px";s.constrainedColorCode=B(I(S(0,0,o*v)));s.style.backgroundColor=s.colorCode=B(S(0,0,o*v));s.style.borderWidth="1px";s.style.borderStyle="solid";s.style.borderColor=s.colorCode;if(v==O){s.style.borderColor="black"}s.hue=b*v;s.saturation=w*U;s.hsv_value=o*v;s.thisrow=v;s.thiscol=U+1;s.onmousedown=function(){H=true;l.saved_cells[O][L].style.borderColor=l.saved_cells[O][L].colorCode;l.value=this.hsv_value;l.pick_color();Q(this)};s.onmouseover=function(){if(H){l.value=this.hsv_value;l.pick_color();Q(this)}};s.onmouseout=function(){if(H){this.style.borderColor=this.colorCode}};s.style.cursor="pointer";p.appendChild(s);s=null;this.tbody.appendChild(p);p=null}var p=document.createElement("tr");this.saved_cells[v]=[];for(var U=0;U<this.side;U++){var s=document.createElement("td");if(a){s.colorCode=B(I(S(0,0,o*(this.side-U-1))))}else{s.colorCode=B(S(0,0,o*(this.side-U-1)))}this.saved_cells[v][U]=s;s.style.height=this.cellsize+"px";s.style.width=this.cellsize-2+"px";s.style.borderWidth="1px";s.style.borderStyle="solid";s.style.borderColor=s.colorCode;s.style.backgroundColor=s.colorCode;s.hue=0;s.saturation=0;s.value=o*(this.side-U-1);s.thisrow=v;s.thiscol=U;s.onmousedown=function(){P=true;l.saved_cells[E][z].style.borderColor=l.saved_cells[E][z].colorCode;G(this)};s.onmouseover=function(){if(P){G(this)}};s.onmouseout=function(){if(P){this.style.borderColor=this.colorCode}};s.ondblclick=function(){Xinha.colorPicker.remember(this.colorCode,l.savecolors);l.callback(this.colorCode);l.close()};s.appendChild(document.createTextNode(" "));s.style.cursor="pointer";p.appendChild(s);s=null}this.tbody.appendChild(p);p=null;var p=document.createElement("tr");var s=document.createElement("td");p.appendChild(s);s.colSpan=this.side+2;s.style.padding="3px";if(this.websafe){var i=document.createElement("div");var q=document.createElement("label");q.appendChild(document.createTextNode(Xinha._lc("Web Safe: ")));this.constrain_cb.onclick=function(){l.pick_color()};q.appendChild(this.constrain_cb);q.style.fontFamily="small-caption,caption,sans-serif";q.style.fontSize="x-small";i.appendChild(q);s.appendChild(i);i=null}var i=document.createElement("div");var q=document.createElement("label");q.style.fontFamily="small-caption,caption,sans-serif";q.style.fontSize="x-small";q.appendChild(document.createTextNode(Xinha._lc("Color: ")));q.appendChild(this.chosenColor);i.appendChild(q);var g=document.createElement("span");g.className="buttonColor ";g.style.fontSize="13px";g.style.width="24px";g.style.marginLeft="2px";g.style.padding="0px 4px";g.style.cursor="pointer";g.onclick=function(){Xinha.colorPicker.remember(l.chosenColor.value,l.savecolors);l.callback(l.chosenColor.value);l.close()};g.appendChild(document.createTextNode(Xinha._lc("OK")));g.align="center";i.appendChild(g);s.appendChild(i);var r=document.createElement("table");r.style.width="100%";var f=document.createElement("tbody");r.appendChild(f);var k=document.createElement("tr");f.appendChild(k);var h=document.createElement("td");k.appendChild(h);h.appendChild(this.backSample);h.style.width="50%";var d=document.createElement("td");k.appendChild(d);d.appendChild(this.foreSample);d.style.width="50%";s.appendChild(r);var c=document.createElement("div");c.style.clear="both";function t(T){var X=Xinha.is_ie;var Y=document.createElement("div");Y.style.width=l.cellsize+"px";Y.style.height=l.cellsize+"px";Y.style.margin="1px";Y.style.border="1px solid black";Y.style.cursor="pointer";Y.style.backgroundColor=T;Y.style[X?"styleFloat":"cssFloat"]="left";Y.ondblclick=function(){l.callback(T);l.close()};Y.onclick=function(){l.chosenColor.value=T;l.backSample.style.backgroundColor=T;l.foreSample.style.color=T};c.appendChild(Y)}for(var u=0;u<Xinha.colorPicker.savedColors.length;u++){t(Xinha.colorPicker.savedColors[u])}s.appendChild(c);this.tbody.appendChild(p);document.body.appendChild(this.table);if(this.is_ie_6){if(!this.iframe){this.iframe=document.createElement("iframe");this.iframe.frameBorder=0;this.iframe.src="javascript:;";this.iframe.style.position="absolute";this.iframe.style.width=this.table.offsetWidth;this.iframe.style.height=this.table.offsetHeight;this.iframe.style.zIndex="1049";document.body.insertBefore(this.iframe,this.table)}this.iframe.style.display=""}}else{for(var v=0;v<this.side;v++){for(var U=0;U<this.side;U++){if(a){this.saved_cells[v][U].colorCode=B(I(S(b*v,w*U,this.value)))}else{this.saved_cells[v][U].colorCode=B(S(b*v,w*U,this.value))}this.saved_cells[v][U].style.backgroundColor=this.saved_cells[v][U].colorCode;this.saved_cells[v][U].style.borderColor=this.saved_cells[v][U].colorCode}}var m=this.saved_cells[E][z];this.chosenColor.value=m.colorCode;this.backSample.style.backgroundColor=m.colorCode;this.foreSample.style.color=m.colorCode;if((m.hue>=195&&m.saturation>0.5)||(m.hue===0&&m.saturation===0&&m.value<0.5)||(m.hue!==0&&l.value<0.75)){m.style.borderColor="#fff"}else{m.style.borderColor="#000"}}};this.close=function(){Xinha._removeEvent(document.body,"mousedown",F);this.table.style.display="none";if(this.is_ie_6){if(this.iframe){this.iframe.style.display="none"}}}};Xinha.colorPicker.savedColors=[];Xinha.colorPicker.remember=function(h,f){for(var g=Xinha.colorPicker.savedColors.length;g--;){if(Xinha.colorPicker.savedColors[g]==h){return false}}Xinha.colorPicker.savedColors.splice(0,0,h);Xinha.colorPicker.savedColors=Xinha.colorPicker.savedColors.slice(0,f);var i=new Date();i.setMonth(i.getMonth()+1);document.cookie="XinhaColorPicker="+escape(Xinha.colorPicker.savedColors.join("-"))+";expires="+i.toGMTString();return true};Xinha.colorPicker.loadColors=function(){var g=document.cookie.indexOf("XinhaColorPicker");if(g!=-1){var f=(document.cookie.indexOf("=",g)+1);var d=document.cookie.indexOf(";",g);if(d==-1){d=document.cookie.length}Xinha.colorPicker.savedColors=unescape(document.cookie.substring(f,d)).split("-")}};Xinha.colorPicker.InputBinding=function(i,h){var l=i.ownerDocument;var j=l.createElement("span");j.className="buttonColor";var m=this.chooser=l.createElement("span");m.className="chooser";if(i.value){m.style.backgroundColor=i.value}m.onmouseover=function(){m.className="chooser buttonColor-hilite"};m.onmouseout=function(){m.className="chooser"};m.appendChild(l.createTextNode("\u00a0"));j.appendChild(m);var k=l.createElement("span");k.className="nocolor";k.onmouseover=function(){k.className="nocolor buttonColor-hilite";k.style.color="#f00"};k.onmouseout=function(){k.className="nocolor";k.style.color="#000"};k.onclick=function(){i.value="";m.style.backgroundColor=""};k.appendChild(l.createTextNode("\u00d7"));j.appendChild(k);i.parentNode.insertBefore(j,i.nextSibling);Xinha._addEvent(i,"change",function(){m.style.backgroundColor=this.value});h=(h)?Xinha.cloneObject(h):{cellsize:"5px"};h.callback=(h.callback)?h.callback:function(a){m.style.backgroundColor=a;i.value=a};m.onclick=function(){var a=new Xinha.colorPicker(h);a.open("",m,i.value)};Xinha.freeLater(this,"chooser")};Xinha.colorPicker.InputBinding.prototype.setColor=function(b){this.chooser.style.backgroundColor=b};