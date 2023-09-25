/* This compressed file is part of Xinha. For uncompressed sources, forum, and bug reports, go to xinha.org */
Opera._pluginInfo={name:"Opera",origin:"Xinha Core",version:"$LastChangedRevision: 1084 $".replace(/^[^:]*:\s*(.*)\s*\$$/,"$1"),developer:"The Xinha Core Developer Team",developer_url:"$HeadURL: http://svn.xinha.org/trunk/modules/Opera/Opera.js $".replace(/^[^:]*:\s*(.*)\s*\$$/,"$1"),sponsor:"Gogo Internet Services Limited",sponsor_url:"http://www.gogo.co.nz/",license:"htmlArea"};function Opera(b){this.editor=b;b.Opera=this}Opera.prototype.onKeyPress=function(G){var H=this.editor;var C=H.getSelection();if(H.isShortCut(G)){switch(H.getKey(G).toLowerCase()){case"z":if(H._unLink&&H._unlinkOnUndo){Xinha._stopEvent(G);H._unLink();H.updateToolbar();return true}break;case"a":sel=H.getSelection();sel.removeAllRanges();range=H.createRange();range.selectNodeContents(H._doc.body);sel.addRange(range);Xinha._stopEvent(G);return true;break;case"v":if(!H.config.htmlareaPaste){return true}break}}switch(H.getKey(G)){case" ":var J=function(c,b){var d=c.nextSibling;if(typeof b=="string"){b=H._doc.createElement(b)}var e=c.parentNode.insertBefore(b,d);Xinha.removeFromParent(c);e.appendChild(c);d.data=" "+d.data;C.collapse(d,1);H._unLink=function(){var f=e.firstChild;e.removeChild(f);e.parentNode.insertBefore(f,e);Xinha.removeFromParent(e);H._unLink=null;H._unlinkOnUndo=false};H._unlinkOnUndo=true;return e};if(H.config.convertUrlsToLinks&&C&&C.isCollapsed&&C.anchorNode.nodeType==3&&C.anchorNode.data.length>3&&C.anchorNode.data.indexOf(".")>=0){var y=C.anchorNode.data.substring(0,C.anchorOffset).search(/\S{4,}$/);if(y==-1){break}if(H._getFirstAncestor(C,"a")){break}var E=C.anchorNode.data.substring(0,C.anchorOffset).replace(/^.*?(\S*)$/,"$1");var L=E.match(Xinha.RE_email);if(L){var B=C.anchorNode;var M=B.splitText(C.anchorOffset);var a=B.splitText(y);J(a,"a").href="mailto:"+L[0];break}RE_date=/([0-9]+\.)+/;RE_ip=/(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)/;var x=E.match(Xinha.RE_url);if(x){if(RE_date.test(E)){break}var F=C.anchorNode;var N=F.splitText(C.anchorOffset);var K=F.splitText(y);J(K,"a").href=(x[1]?x[1]:"http://")+x[2];break}}break}switch(G.keyCode){case 27:if(H._unLink){H._unLink();Xinha._stopEvent(G)}break;break;case 8:case 46:if(!G.shiftKey&&this.handleBackspace()){Xinha._stopEvent(G)}default:H._unlinkOnUndo=false;if(C.anchorNode&&C.anchorNode.nodeType==3){var m=H._getFirstAncestor(C,"a");if(!m){break}if(!m._updateAnchTimeout){if(C.anchorNode.data.match(Xinha.RE_email)&&m.href.match("mailto:"+C.anchorNode.data.trim())){var z=C.anchorNode;var D=function(){m.href="mailto:"+z.data.trim();m._updateAnchTimeout=setTimeout(D,250)};m._updateAnchTimeout=setTimeout(D,1000);break}var A=C.anchorNode.data.match(Xinha.RE_url);if(A&&m.href.match(new RegExp("http(s)?://"+Xinha.escapeStringForRegExp(C.anchorNode.data.trim())))){var s=C.anchorNode;var I=function(){A=s.data.match(Xinha.RE_url);if(A){m.href=(A[1]?A[1]:"http://")+A[2]}m._updateAnchTimeout=setTimeout(I,250)};m._updateAnchTimeout=setTimeout(I,1000)}}}break}return false};Opera.prototype.handleBackspace=function(){var b=this.editor;setTimeout(function(){var o=b.getSelection();var m=b.createRange(o);var n=m.startContainer;var k=m.startOffset;var q=m.endContainer;var l=m.endOffset;var a=n.nextSibling;if(n.nodeType==3){n=n.parentNode}if(!(/\S/.test(n.tagName))){var p=document.createElement("p");while(n.firstChild){p.appendChild(n.firstChild)}n.parentNode.insertBefore(p,n);Xinha.removeFromParent(n);var r=m.cloneRange();r.setStartBefore(a);r.setEndAfter(a);r.extractContents();o.removeAllRanges();o.addRange(r)}},10)};Opera.prototype.inwardHtml=function(b){b=b.replace(/<(\/?)del(\s|>|\/)/ig,"<$1strike$2");return b};Opera.prototype.outwardHtml=function(b){return b};Opera.prototype.onExecCommand=function(t,v,u){switch(t){case"removeformat":var m=this.editor;var i=m.getSelection();var p=m.saveSelection(i);var q=m.createRange(i);var s=m._doc.body.getElementsByTagName("*");var o=(q.startContainer.nodeType==1)?q.startContainer:q.startContainer.parentNode;var r,n;if(i.isCollapsed){q.selectNodeContents(m._doc.body)}for(r=0;r<s.length;r++){n=s[r];if(q.isPointInRange(n,0)||(s[r]==o&&q.startOffset==0)){n.removeAttribute("style")}}this.editor._doc.execCommand(t,v,u);m.restoreSelection(p);return true;break}return false};Opera.prototype.onMouseDown=function(b){};Xinha.prototype.insertNodeAtSelection=function(k){if(k.ownerDocument!=this._doc){try{k=this._doc.adoptNode(k)}catch(e){}}this.focusEditor();var i=this.getSelection();var l=this.createRange(i);l.deleteContents();var j=l.startContainer;var m=l.startOffset;var n=k;i.removeAllRanges();switch(j.nodeType){case 3:if(k.nodeType==3){j.insertData(m,k.data);l=this.createRange();l.setEnd(j,m+k.length);l.setStart(j,m+k.length);i.addRange(l)}else{j=j.splitText(m);if(k.nodeType==11){n=n.firstChild}j.parentNode.insertBefore(k,j);this.selectNodeContents(n);this.updateToolbar()}break;case 1:if(k.nodeType==11){n=n.firstChild}j.insertBefore(k,j.childNodes[m]);this.selectNodeContents(n);this.updateToolbar();break}};Xinha.prototype.getParentElement=function(f){if(typeof f=="undefined"){f=this.getSelection()}var h=this.createRange(f);try{var e=h.commonAncestorContainer;if(!h.collapsed&&h.startContainer==h.endContainer&&h.startOffset-h.endOffset<=1&&h.startContainer.hasChildNodes()){e=h.startContainer.childNodes[h.startOffset]}while(e.nodeType==3){e=e.parentNode}return e}catch(g){return null}};Xinha.prototype.activeElement=function(b){if((b===null)||this.selectionEmpty(b)){return null}if(!b.isCollapsed){if(b.anchorNode.childNodes.length>b.anchorOffset&&b.anchorNode.childNodes[b.anchorOffset].nodeType==1){return b.anchorNode.childNodes[b.anchorOffset]}else{if(b.anchorNode.nodeType==1){return b.anchorNode}else{return null}}}return null};Xinha.prototype.selectionEmpty=function(b){if(!b){return true}if(typeof b.isCollapsed!="undefined"){return b.isCollapsed}return true};Xinha.prototype.saveSelection=function(){return this.createRange(this.getSelection()).cloneRange()};Xinha.prototype.restoreSelection=function(c){var d=this.getSelection();d.removeAllRanges();d.addRange(c)};Xinha.prototype.selectNodeContents=function(g,i){this.focusEditor();this.forceRedraw();var h;var j=typeof i=="undefined"?true:false;var f=this.getSelection();h=this._doc.createRange();if(j&&g.tagName&&g.tagName.toLowerCase().match(/table|img|input|textarea|select/)){h.selectNode(g)}else{h.selectNodeContents(g)}f.removeAllRanges();f.addRange(h);if(typeof i!="undefined"){if(i){f.collapse(h.startContainer,h.startOffset)}else{f.collapse(h.endContainer,h.endOffset)}}};Xinha.prototype.insertHTML=function(h){var l=this.getSelection();var j=this.createRange(l);this.focusEditor();var i=this._doc.createDocumentFragment();var k=this._doc.createElement("div");k.innerHTML=h;while(k.firstChild){i.appendChild(k.firstChild)}var g=this.insertNodeAtSelection(i)};Xinha.prototype.getSelectedHTML=function(){var c=this.getSelection();if(c.isCollapsed){return""}var d=this.createRange(c);return Xinha.getHTML(d.cloneContents(),false,this)};Xinha.prototype.getSelection=function(){var e=this._iframe.contentWindow.getSelection();if(e&&e.focusNode&&e.focusNode.tagName&&e.focusNode.tagName=="HTML"){var f=this._doc.getElementsByTagName("body")[0];var d=this.createRange();d.selectNodeContents(f);e.removeAllRanges();e.addRange(d);e.collapseToEnd()}return e};Xinha.prototype.createRange=function(c){this.activateEditor();if(typeof c!="undefined"){try{return c.getRangeAt(0)}catch(d){return this._doc.createRange()}}else{return this._doc.createRange()}};Xinha.prototype.isKeyEvent=function(b){return b.type=="keypress"};Xinha.prototype.getKey=function(b){return String.fromCharCode(b.charCode)};Xinha.getOuterHTML=function(b){return(new XMLSerializer()).serializeToString(b)};Xinha.cc=String.fromCharCode(8286);Xinha.prototype.setCC=function(t){var r=Xinha.cc;try{if(t=="textarea"){var p=this._textArea;var o=p.selectionStart;var m=p.value.substring(0,o);var e=p.value.substring(o,p.value.length);if(e.match(/^[^<]*>/)){var l=e.indexOf(">")+1;p.value=m+e.substring(0,l)+r+e.substring(l,e.length)}else{p.value=m+r+e}p.value=p.value.replace(new RegExp("(&[^"+r+"]*?)("+r+")([^"+r+"]*?;)"),"$1$3$2");p.value=p.value.replace(new RegExp("(<script[^>]*>[^"+r+"]*?)("+r+")([^"+r+"]*?<\/script>)"),"$1$3$2");p.value=p.value.replace(new RegExp("^([^"+r+"]*)("+r+")([^"+r+"]*<body[^>]*>)(.*?)"),"$1$3$2$4");p.value=p.value.replace(r,'<span id="XinhaOperaCaretMarker">MARK</span>')}else{var s=this.getSelection();var q=this._doc.createElement("span");q.id="XinhaOperaCaretMarker";s.getRangeAt(0).insertNode(q)}}catch(n){}};Xinha.prototype.findCC=function(m){if(m=="textarea"){var r=this._textArea;var q=r.value.search(/(<span\s+id="XinhaOperaCaretMarker"\s*\/?>((\s|(MARK))*<\/span>)?)/);if(q==-1){return}var u=RegExp.$1;var s=q+u.length;var p=r.value.substring(0,q);var n=r.value.substring(s,r.value.length);r.value=p;r.scrollTop=r.scrollHeight;var v=r.scrollTop;r.value+=n;r.setSelectionRange(q,q);r.focus();r.scrollTop=v}else{var t=this._doc.getElementById("XinhaOperaCaretMarker");if(t){this.focusEditor();var o=this.createRange();o.selectNode(t);var l=this.getSelection();l.addRange(o);l.collapseToStart();this.scrollToElement(t);t.parentNode.removeChild(t);return}}};Xinha.getDoctype=function(d){var c="";if(d.doctype){c+="<!DOCTYPE "+d.doctype.name+" PUBLIC ";c+=d.doctype.publicId?'"'+d.doctype.publicId+'"':"";c+=d.doctype.systemId?' "'+d.doctype.systemId+'"':"";c+=">"}return c};Xinha.prototype._standardInitIframe=Xinha.prototype.initIframe;Xinha.prototype.initIframe=function(){if(!this._iframeLoadDone){if(this._iframe.contentWindow&&this._iframe.contentWindow.xinhaReadyToRoll){this._iframeLoadDone=true;this._standardInitIframe()}else{var b=this;setTimeout(function(){b.initIframe()},5)}}};Xinha._addEventOperaOrig=Xinha._addEvent;Xinha._addEvent=function(f,d,e){if(f.tagName&&f.tagName.toLowerCase()=="select"&&d=="change"){return Xinha.addDom0Event(f,d,e)}return Xinha._addEventOperaOrig(f,d,e)};