/* This compressed file is part of Xinha. For uncompressed sources, forum, and bug reports, go to xinha.org */
function GetHtmlImplementation(b){this.editor=b}GetHtmlImplementation._pluginInfo={name:"GetHtmlImplementation DOMwalk",origin:"Xinha Core",version:"$LastChangedRevision: 1185 $".replace(/^[^:]*:\s*(.*)\s*\$$/,"$1"),developer:"The Xinha Core Developer Team",developer_url:"$HeadURL: http://svn.xinha.org/trunk/modules/GetHtml/DOMwalk.js $".replace(/^[^:]*:\s*(.*)\s*\$$/,"$1"),sponsor:"",sponsor_url:"",license:"htmlArea"};Xinha.getHTML=function(d,e,f){return Xinha.getHTMLWrapper(d,e,f)};Xinha.emptyAttributes=" checked disabled ismap readonly nowrap compact declare selected defer multiple noresize noshade ";Xinha.getHTMLWrapper=function(v,w,F,x){var z="";if(!x){x=""}switch(v.nodeType){case 10:case 6:case 12:break;case 2:break;case 4:z+=(Xinha.is_ie?("\n"+x):"")+"<![CDATA["+v.data+"]]>";break;case 5:z+="&"+v.nodeValue+";";break;case 7:z+=(Xinha.is_ie?("\n"+x):"")+"<?"+v.target+" "+v.data+" ?>";break;case 1:case 11:case 9:var E;var C;var B=(v.nodeType==1)?v.tagName.toLowerCase():"";if((B=="script"||B=="noscript")&&F.config.stripScripts){break}if(w){w=!(F.config.htmlRemoveTags&&F.config.htmlRemoveTags.test(B))}if(Xinha.is_ie&&B=="head"){if(w){z+=(Xinha.is_ie?("\n"+x):"")+"<head>"}var y=RegExp.multiline;RegExp.multiline=true;var D=v.innerHTML.replace(Xinha.RE_tagName,function(c,d,b){return d+b.toLowerCase()}).replace(/\s*=\s*(([^'"][^>\s]*)([>\s])|"([^"]+)"|'([^']+)')/g,'="$2$4$5"$3').replace(/<(link|meta)((\s*\S*="[^"]*")*)>([\n\r]*)/g,"<$1$2 />\n");RegExp.multiline=y;z+=D+"\n";if(w){z+=(Xinha.is_ie?("\n"+x):"")+"</head>"}break}else{if(w){E=(!(v.hasChildNodes()||Xinha.needsClosingTag(v)));z+=((Xinha.isBlockElement(v))?("\n"+x):"")+"<"+v.tagName.toLowerCase();var a=v.attributes;for(C=0;C<a.length;++C){var u=a.item(C);if(Xinha.is_real_gecko&&(v.tagName.toLowerCase()=="img")&&((u.nodeName.toLowerCase()=="height")||(u.nodeName.toLowerCase()=="width"))){if(!v.complete||v.naturalWidth===0){continue}}if(typeof u.nodeValue=="object"){continue}if(v.tagName.toLowerCase()=="input"&&v.type.toLowerCase()=="checkbox"&&u.nodeName.toLowerCase()=="value"&&u.nodeValue.toLowerCase()=="on"){continue}if(!u.specified&&!(v.tagName.toLowerCase().match(/input|option/)&&u.nodeName=="value")&&!(v.tagName.toLowerCase().match(/area/)&&u.nodeName.match(/shape|coords/i))){continue}var s=u.nodeName.toLowerCase();if(/_moz_editor_bogus_node/.test(s)||(s=="class"&&u.nodeValue=="webkit-block-placeholder")){z="";break}if(/(_moz)|(contenteditable)|(_msh)/.test(s)){continue}var t;if(Xinha.emptyAttributes.indexOf(" "+s+" ")!=-1){t=s}else{if(s!="style"){if(typeof v[u.nodeName]!="undefined"&&s!="href"&&s!="src"&&!(/^on/.test(s))){t=v[u.nodeName]}else{t=u.nodeValue;if(s=="class"){t=t.replace(/Apple-style-span/,"");if(!t){continue}}if(Xinha.is_ie&&(s=="href"||s=="src")){t=F.stripBaseURL(t)}if(F.config.only7BitPrintablesInURLs&&(s=="href"||s=="src")){t=t.replace(/([^!-~]+)/g,function(b){return escape(b)})}}}else{if(!Xinha.is_ie){t=v.style.cssText.replace(/rgb\(.*?\)/ig,function(b){return Xinha._colorToRgb(b)})}else{if(!t){continue}}}}if(/^(_moz)?$/.test(t)){continue}z+=" "+s+'="'+Xinha.htmlEncode(t)+'"'}if(Xinha.is_ie&&v.style.cssText){z+=' style="'+v.style.cssText.replace(/(^)?([^:]*):(.*?)(;|$)/g,function(c,f,e,d,b){return e.toLowerCase()+":"+d+b})+'"'}if(Xinha.is_ie&&v.tagName.toLowerCase()=="option"&&v.selected){z+=' selected="selected"'}if(z!==""){if(E&&B=="p"){z+=">&nbsp;</p>"}else{if(E){z+=" />"}else{z+=">"}}}}}var A=false;if(B=="script"||B=="noscript"){if(!F.config.stripScripts){if(Xinha.is_ie){var i="\n"+v.innerHTML.replace(/^[\n\r]*/,"").replace(/\s+$/,"")+"\n"+x}else{var i=(v.hasChildNodes())?v.firstChild.nodeValue:""}z+=i+"</"+B+">"+((Xinha.is_ie)?"\n":"")}}else{if(B=="pre"){z+=((Xinha.is_ie)?"\n":"")+v.innerHTML.replace(/<br>/g,"\n")+"</"+B+">"}else{for(C=v.firstChild;C;C=C.nextSibling){if(!A&&C.nodeType==1&&Xinha.isBlockElement(C)){A=true}z+=Xinha.getHTMLWrapper(C,true,F,x+"  ")}if(w&&!E){z+=(((Xinha.isBlockElement(v)&&A)||B=="head"||B=="html")?("\n"+x):"")+"</"+v.tagName.toLowerCase()+">"}}}break;case 3:if(/^script|noscript|style$/i.test(v.parentNode.tagName)){z=v.data}else{if(v.data.trim()==""){if(v.data){z=" "}else{z=""}}else{z=Xinha.htmlEncode(v.data)}}break;case 8:z="<!--"+v.data+"-->";break}return z};