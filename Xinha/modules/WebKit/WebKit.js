/* This compressed file is part of Xinha. For uncompressed sources, forum, and bug reports, go to xinha.org */
WebKit._pluginInfo={name:"WebKit",origin:"Xinha Core",version:"$LastChangedRevision: 1146 $".replace(/^[^:]*:\s*(.*)\s*\$$/,"$1"),developer:"The Xinha Core Developer Team",developer_url:"$HeadURL: http://svn.xinha.org/trunk/modules/WebKit/WebKit.js $".replace(/^[^:]*:\s*(.*)\s*\$$/,"$1"),sponsor:"",sponsor_url:"",license:"htmlArea"};function WebKit(b){this.editor=b;b.WebKit=this}WebKit.prototype.onKeyPress=function(G){var H=this.editor;var C=H.getSelection();if(H.isShortCut(G)){switch(H.getKey(G).toLowerCase()){case"z":if(H._unLink&&H._unlinkOnUndo){Xinha._stopEvent(G);H._unLink();H.updateToolbar();return true}break;case"a":break;case"v":if(!H.config.htmlareaPaste){return true}break}}switch(H.getKey(G)){case" ":var J=function(c,b){var d=c.nextSibling;if(typeof b=="string"){b=H._doc.createElement(b)}var e=c.parentNode.insertBefore(b,d);Xinha.removeFromParent(c);e.appendChild(c);d.data=" "+d.data;C.collapse(d,1);H._unLink=function(){var f=e.firstChild;e.removeChild(f);e.parentNode.insertBefore(f,e);Xinha.removeFromParent(e);H._unLink=null;H._unlinkOnUndo=false};H._unlinkOnUndo=true;return e};if(H.config.convertUrlsToLinks&&C&&C.isCollapsed&&C.anchorNode.nodeType==3&&C.anchorNode.data.length>3&&C.anchorNode.data.indexOf(".")>=0){var y=C.anchorNode.data.substring(0,C.anchorOffset).search(/\S{4,}$/);if(y==-1){break}if(H._getFirstAncestor(C,"a")){break}var E=C.anchorNode.data.substring(0,C.anchorOffset).replace(/^.*?(\S*)$/,"$1");var L=E.match(Xinha.RE_email);if(L){var B=C.anchorNode;var M=B.splitText(C.anchorOffset);var a=B.splitText(y);J(a,"a").href="mailto:"+L[0];break}RE_date=/([0-9]+\.)+/;RE_ip=/(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)/;var x=E.match(Xinha.RE_url);if(x){if(RE_date.test(E)){break}var F=C.anchorNode;var N=F.splitText(C.anchorOffset);var K=F.splitText(y);J(K,"a").href=(x[1]?x[1]:"http://")+x[2];break}}break}switch(G.keyCode){case 13:if(G.shiftKey){}break;case 27:if(H._unLink){H._unLink();Xinha._stopEvent(G)}break;case 8:case 46:if(!G.shiftKey&&this.handleBackspace()){Xinha._stopEvent(G)}break;default:H._unlinkOnUndo=false;if(C.anchorNode&&C.anchorNode.nodeType==3){var m=H._getFirstAncestor(C,"a");if(!m){break}if(!m._updateAnchTimeout){if(C.anchorNode.data.match(Xinha.RE_email)&&m.href.match("mailto:"+C.anchorNode.data.trim())){var z=C.anchorNode;var D=function(){m.href="mailto:"+z.data.trim();m._updateAnchTimeout=setTimeout(D,250)};m._updateAnchTimeout=setTimeout(D,1000);break}var A=C.anchorNode.data.match(Xinha.RE_url);if(A&&m.href.match(new RegExp("http(s)?://"+Xinha.escapeStringForRegExp(C.anchorNode.data.trim())))){var s=C.anchorNode;var I=function(){A=s.data.match(Xinha.RE_url);if(A){m.href=(A[1]?A[1]:"http://")+A[2]}m._updateAnchTimeout=setTimeout(I,250)};m._updateAnchTimeout=setTimeout(I,1000)}}}break}return false};WebKit.prototype.handleBackspace=function(){var b=this.editor;setTimeout(function(){var o=b.getSelection();var m=b.createRange(o);var n=m.startContainer;var k=m.startOffset;var q=m.endContainer;var l=m.endOffset;var a=n.nextSibling;if(n.nodeType==3){n=n.parentNode}if(!(/\S/.test(n.tagName))){var p=document.createElement("p");while(n.firstChild){p.appendChild(n.firstChild)}n.parentNode.insertBefore(p,n);Xinha.removeFromParent(n);var r=m.cloneRange();r.setStartBefore(a);r.setEndAfter(a);r.extractContents();o.removeAllRanges();o.addRange(r)}},10)};WebKit.prototype.inwardHtml=function(b){return b};WebKit.prototype.outwardHtml=function(b){return b};WebKit.prototype.onExecCommand=function(w,y,x){this.editor._doc.execCommand("styleWithCSS",false,false);switch(w){case"paste":alert(Xinha._lc("The Paste button does not work in the Safari browser for security reasons. Press CTRL-V on your keyboard to paste directly."));return true;break;case"removeformat":var B=this.editor;var z=B.getSelection();var A=B.saveSelection(z);var s=B.createRange(z);var v=B._doc.getElementsByTagName("*");v=Xinha.collectionToArray(v);var i=(s.startContainer.nodeType==1)?s.startContainer:s.startContainer.parentNode;var u,C,E,t,D,F=B._doc.createRange();function r(a){if(a.nodeType!=1){return}a.removeAttribute("style");for(var b=0;b<a.childNodes.length;b++){r(a.childNodes[b])}if((a.tagName.toLowerCase()=="span"&&!a.attributes.length)||a.tagName.toLowerCase()=="font"){F.selectNodeContents(a);t=F.extractContents();while(t.firstChild){D=t.removeChild(t.firstChild);a.parentNode.insertBefore(D,a)}a.parentNode.removeChild(a)}}if(z.isCollapsed){v=B._doc.body.childNodes;for(u=0;u<v.length;u++){C=v[u];if(C.nodeType!=1){continue}if(C.tagName.toLowerCase()=="span"){E=B.convertNode(C,"div");C.parentNode.replaceChild(E,C);C=E}r(C)}}else{for(u=0;u<v.length;u++){C=v[u];if(s.isPointInRange(C,0)||(v[u]==i&&s.startOffset==0)){r(C)}}}F.detach();B.restoreSelection(A);return true;break}return false};WebKit.prototype.onMouseDown=function(b){if(b.target.tagName.toLowerCase()=="hr"||b.target.tagName.toLowerCase()=="img"){this.editor.selectNodeContents(b.target)}};Xinha.prototype.insertNodeAtSelection=function(i){var g=this.getSelection();var j=this.createRange(g);g.removeAllRanges();j.deleteContents();var h=j.startContainer;var k=j.startOffset;var l=i;switch(h.nodeType){case 3:if(i.nodeType==3){h.insertData(k,i.data);j=this.createRange();j.setEnd(h,k+i.length);j.setStart(h,k+i.length);g.addRange(j)}else{h=h.splitText(k);if(i.nodeType==11){l=l.firstChild}h.parentNode.insertBefore(i,h);this.selectNodeContents(l);this.updateToolbar()}break;case 1:if(i.nodeType==11){l=l.firstChild}h.insertBefore(i,h.childNodes[k]);this.selectNodeContents(l);this.updateToolbar();break}};Xinha.prototype.getParentElement=function(f){if(typeof f=="undefined"){f=this.getSelection()}var h=this.createRange(f);try{var e=h.commonAncestorContainer;if(!h.collapsed&&h.startContainer==h.endContainer&&h.startOffset-h.endOffset<=1&&h.startContainer.hasChildNodes()){e=h.startContainer.childNodes[h.startOffset]}while(e.nodeType==3){e=e.parentNode}return e}catch(g){return null}};Xinha.prototype.activeElement=function(b){if((b===null)||this.selectionEmpty(b)){return null}if(!b.isCollapsed){if(b.anchorNode.childNodes.length>b.anchorOffset&&b.anchorNode.childNodes[b.anchorOffset].nodeType==1){return b.anchorNode.childNodes[b.anchorOffset]}else{if(b.anchorNode.nodeType==1){return b.anchorNode}else{return null}}}return null};Xinha.prototype.selectionEmpty=function(b){if(!b){return true}if(typeof b.isCollapsed!="undefined"){return b.isCollapsed}return true};Xinha.prototype.saveSelection=function(){return this.createRange(this.getSelection()).cloneRange()};Xinha.prototype.restoreSelection=function(c){var d=this.getSelection();d.removeAllRanges();d.addRange(c)};Xinha.prototype.selectNodeContents=function(g,i){this.focusEditor();this.forceRedraw();var h;var j=typeof i=="undefined"?true:false;var f=this.getSelection();h=this._doc.createRange();if(j&&g.tagName&&g.tagName.toLowerCase().match(/table|img|input|textarea|select/)){h.selectNode(g)}else{h.selectNodeContents(g)}f.removeAllRanges();f.addRange(h);if(typeof i!="undefined"){if(i){f.collapse(h.startContainer,h.startOffset)}else{f.collapse(h.endContainer,h.endOffset)}}};Xinha.prototype.insertHTML=function(h){var l=this.getSelection();var j=this.createRange(l);this.focusEditor();var i=this._doc.createDocumentFragment();var k=this._doc.createElement("div");k.innerHTML=h;while(k.firstChild){i.appendChild(k.firstChild)}var g=this.insertNodeAtSelection(i)};Xinha.prototype.getSelectedHTML=function(){var c=this.getSelection();if(c.isCollapsed){return""}var d=this.createRange(c);if(d){return Xinha.getHTML(d.cloneContents(),false,this)}else{return""}};Xinha.prototype.getSelection=function(){return this._iframe.contentWindow.getSelection()};Xinha.prototype.createRange=function(c){this.activateEditor();if(typeof c!="undefined"){try{return c.getRangeAt(0)}catch(d){return this._doc.createRange()}}else{return this._doc.createRange()}};Xinha.prototype.isKeyEvent=function(b){return b.type=="keydown"};Xinha.prototype.getKey=function(c){var d=String.fromCharCode(parseInt(c.keyIdentifier.replace(/^U\+/,""),16));if(c.shiftKey){return d}else{return d.toLowerCase()}};Xinha.getOuterHTML=function(b){return(new XMLSerializer()).serializeToString(b)};Xinha.cc=String.fromCharCode(8286);Xinha.prototype.setCC=function(p){var n=Xinha.cc;try{if(p=="textarea"){var m=this._textArea;var l=m.selectionStart;var e=m.value.substring(0,l);var q=m.value.substring(l,m.value.length);if(q.match(/^[^<]*>/)){var r=q.indexOf(">")+1;m.value=e+q.substring(0,r)+n+q.substring(r,q.length)}else{m.value=e+n+q}m.value=m.value.replace(new RegExp("(&[^"+n+";]*?)("+n+")([^"+n+"]*?;)"),"$1$3$2");m.value=m.value.replace(new RegExp("(<script[^>]*>[^"+n+"]*?)("+n+")([^"+n+"]*?<\/script>)"),"$1$3$2");m.value=m.value.replace(new RegExp("^([^"+n+"]*)("+n+")([^"+n+"]*<body[^>]*>)(.*?)"),"$1$3$2$4")}else{var o=this.getSelection();o.getRangeAt(0).insertNode(this._doc.createTextNode(n))}}catch(k){}};Xinha.prototype.findCC=function(q){var o=Xinha.cc;if(q=="textarea"){var e=this._textArea;var v=e.value.indexOf(o);if(v==-1){return}var n=v+o.length;var s=e.value.substring(0,v);var r=e.value.substring(n,e.value.length);e.value=s;e.scrollTop=e.scrollHeight;var p=e.scrollTop;e.value+=r;e.setSelectionRange(v,v);e.focus();e.scrollTop=p}else{var t=this;try{var u=this._doc;u.body.innerHTML=u.body.innerHTML.replace(new RegExp(o),'<span id="XinhaEditingPostion"></span>');var w=u.getElementById("XinhaEditingPostion");this.selectNodeContents(w);this.scrollToElement(w);w.parentNode.removeChild(w);this._iframe.contentWindow.focus()}catch(x){}}};Xinha.prototype._standardToggleBorders=Xinha.prototype._toggleBorders;Xinha.prototype._toggleBorders=function(){var e=this._standardToggleBorders();var d=this._doc.getElementsByTagName("TABLE");for(var f=0;f<d.length;f++){d[f].style.display="none";d[f].style.display="table"}return e};Xinha.getDoctype=function(d){var c="";if(d.doctype){c+="<!DOCTYPE "+d.doctype.name+" PUBLIC ";c+=d.doctype.publicId?'"'+d.doctype.publicId+'"':"";c+=d.doctype.systemId?' "'+d.doctype.systemId+'"':"";c+=">"}return c};