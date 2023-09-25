/* This compressed file is part of Xinha. For uncompressed sources, forum, and bug reports, go to xinha.org */
MootoolsFileManager.prototype.OpenFileManager=function(i){var j=this.editor;var m=null;var k=this;if(typeof i=="undefined"){i=this.editor.getParentElement();if(i){if(/^img$/i.test(i.tagName)){i=i.parentNode}if(!/^a$/i.test(i.tagName)){i=null}}}if(!i){var n=j.getSelection();var l=j.createRange(n);var h=0;if(Xinha.is_ie){if(n.type=="Control"){h=l.length}else{h=l.compareEndPoints("StartToEnd",l)}}else{h=l.compareBoundaryPoints(l.START_TO_END,l)}if(h==0){alert(Xinha._lc("You must select some text before making a new link.","MootoolsFileManager"));return}m={f_href:"",f_title:"",f_target:"",f_type:"",baseHref:j.config.baseHref}}else{m={f_href:Xinha.is_ie?i.href:i.getAttribute("href"),f_title:i.title,f_target:i.target,f_type:i.type?i.type:"",baseHref:j.config.baseHref}}this.current_link=i;this.current_attributes=m;if(!this.FileManagerWidget){this.FileManagerWidget=new FileManager({url:this.editor.config.MootoolsFileManager.backend+"__function=file-manager&",assetBasePath:Xinha.getPluginDir("MootoolsFileManager")+"/mootools-filemanager/Assets",language:_editor_lang,selectable:true,uploadAuthData:this.editor.config.MootoolsFileManager.backend_data,onComplete:function(a,b){k.FileManagerReturn(a,b)},onHide:function(){if(this.swf&&this.swf.box){this.swf.box.style.display="none"}},onShow:function(){if(this.swf&&this.swf.box){this.swf.box.style.display=""}},onDetails:function(a){this.info.adopt(k.FileManagerAttributes(a));return true},onHidePreview:function(){$(k.FileManagerAttributes().table).dispose();return true}})}this.FileManagerWidget.show()};MootoolsFileManager.prototype.FileManagerReturn=function(a,o){var q=this.editor;var e=this.current_link;var n=this.FileManagerAttributes();n.f_href=a;if(!e){try{q._doc.execCommand("createlink",false,n.f_href);e=q.getParentElement();var p=q.getSelection();var m=q.createRange(p);if(!Xinha.is_ie){e=m.startContainer;if(!/^a$/i.test(e.tagName)){e=e.nextSibling;if(e==null){e=m.startContainer.parentNode}}}}catch(l){}}else{var r=n.f_href.trim();q.selectNodeContents(e);if(r==""){q._doc.execCommand("unlink",false,null);q.updateToolbar();return false}else{e.href=r}}if(!(e&&/^a$/i.test(e.tagName))){return false}e.type=n.f_type.trim();e.target=n.f_target.trim();e.title=n.f_title.trim();q.selectNodeContents(e);q.updateToolbar()};MootoolsFileManager.prototype.FileManagerAttributes=function(g){var h=this;h._LastFileDetails=g;function e(a){var b=h._FileManagerAttributesTable.getElementsByTagName("input");for(var c=0;c<b.length;c++){if(b[c].name==a){return b[c]}}var b=h._FileManagerAttributesTable.getElementsByTagName("select");for(var c=0;c<b.length;c++){if(b[c].name==a){return b[c]}}return null}function f(a,b){for(var c=0;c<e(a).options.length;c++){if(e(a).options[c].value==b){e(a).selectedIndex=c;return true}}return false}if(!this._FileManagerAttributesTable){this._FileManagerAttributesTable=(function(){var r=document.createElement("div");var n=document.createElement("h2");n.appendChild(document.createTextNode("Link Attributes"));r.appendChild(n);var a=document.createElement("table");r.appendChild(a);a.className="filemanager-extended-options";var o=a.appendChild(document.createElement("tbody"));var d=o.appendChild(document.createElement("tr"));var q=d.appendChild(document.createElement("th"));var b=q.appendChild(document.createTextNode("Title:"));var p=d.appendChild(document.createElement("td"));var c=p.appendChild(document.createElement("input"));p.colSpan=6;c.name="f_title";c.type="text";q.className=p.className="filemanager-f_title";var d=o.appendChild(document.createElement("tr"));var q=d.appendChild(document.createElement("th"));var b=q.appendChild(document.createTextNode("Type:"));var p=d.appendChild(document.createElement("td"));var c=p.appendChild(document.createElement("input"));p.colSpan=6;c.name="f_type";c.type="text";q.className=p.className="filemanager-f_type";var d=o.appendChild(document.createElement("tr"));var q=d.appendChild(document.createElement("th"));var b=q.appendChild(document.createTextNode("Open In:"));var p=d.appendChild(document.createElement("td"));p.colSpan=2;var c=p.appendChild(document.createElement("select"));c.name="f_target";c.options[0]=new Option("");c.options[1]=new Option("New Window","_blank");c.options[2]=new Option("Top Frame","_top");c.options[3]=new Option("Other Frame:","");Xinha._addEvent(c,"change",function(){if(e("f_target").selectedIndex==3){e("f_otherTarget").style.visibility="visible"}else{e("f_otherTarget").style.visibility="hidden"}});var c=p.appendChild(document.createElement("input"));c.name="f_otherTarget";c.size=7;c.type="text";c.style.visibility="hidden";q.className=p.className="filemanager-f_target";return r})()}if(this.current_attributes){e("f_title").value=this.current_attributes.f_title;e("f_type").value=this.current_attributes.f_type;if(this.current_attributes.f_target){if(!f("f_target",this.current_attributes.f_target)){e("f_target").selectedIndex=3;e("f_otherTarget").value=this.current_attributes.f_target}else{e("f_otherTarget").value=""}}this.current_attributes=null}if(!g){var g={f_title:e("f_title").value,f_type:e("f_type").value,f_target:e("f_target").selectedIndex<3?e("f_target").options[e("f_target").selectedIndex].value:e("f_otherTarget").value,table:this._FileManagerAttributesTable};return g}if(g.mime){e("f_type").value=g.mime}e("f_target").style.visibility="";if(e("f_target").selectedIndex==3){e("f_otherTarget").style.visibility="visible"}else{e("f_otherTarget").style.visibility="hidden"}return this._FileManagerAttributesTable};