/* This compressed file is part of Xinha. For uncompressed sources, forum, and bug reports, go to xinha.org */
Xinha.loadStyle("CharacterMap.css","CharacterMap");function CharacterMap(e){this.editor=e;var d=e.config;var f=this;d.registerButton({id:"insertcharacter",tooltip:Xinha._lc("Insert special character","CharacterMap"),image:e.imgURL("images/tango/16x16/apps/accessories-character-map.png"),textMode:false,action:function(){f.show()}});d.addToolbarElement("insertcharacter","createlink",-1)}Xinha.Config.prototype.CharacterMap={mode:"popup"};CharacterMap._pluginInfo={name:"CharacterMap",version:"2.0",developer:"Laurent Vilday",developer_url:"http://www.mokhet.com/",c_owner:"Xinha community",sponsor:"",sponsor_url:"",license:"HTMLArea"};CharacterMap._isActive=false;CharacterMap.prototype.addEntity=function(h,g){var i=this.editor;var j=this;var a=document.createElement("a");Xinha._addClass(a,"entity");a.innerHTML=h;a.href="javascript:void(0)";Xinha._addClass(a,(g%2)?"light":"dark");a.onclick=function(){if(Xinha.is_ie){i.focusEditor()}i.insertHTML(h);return false};this.dialog.main.appendChild(a);a=null};CharacterMap.prototype.onGenerateOnce=function(){this._prepareDialog()};CharacterMap.prototype._prepareDialog=function(){var g=this;var h=this.editor;var j="<h1><l10n>Insert special character</l10n></h1>";this.dialog=new Xinha.Dialog(h,j,"CharacterMap",{width:300},{modal:false});Xinha._addClass(this.dialog.rootElem,"CharacterMap");if(h.config.CharacterMap&&h.config.CharacterMap.mode=="panel"){this.dialog.attachToPanel("right")}var i=["&Yuml;","&scaron;","&#064;","&quot;","&iexcl;","&cent;","&pound;","&curren;","&yen;","&brvbar;","&sect;","&uml;","&copy;","&ordf;","&laquo;","&not;","&macr;","&deg;","&plusmn;","&sup2;","&sup3;","&acute;","&micro;","&para;","&middot;","&cedil;","&sup1;","&ordm;","&raquo;","&frac14;","&frac12;","&frac34;","&iquest;","&times;","&Oslash;","&divide;","&oslash;","&fnof;","&circ;","&tilde;","&ndash;","&mdash;","&lsquo;","&rsquo;","&sbquo;","&ldquo;","&rdquo;","&bdquo;","&dagger;","&Dagger;","&bull;","&hellip;","&permil;","&lsaquo;","&rsaquo;","&euro;","&trade;","&Agrave;","&Aacute;","&Acirc;","&Atilde;","&Auml;","&Aring;","&AElig;","&Ccedil;","&Egrave;","&Eacute;","&Ecirc;","&Euml;","&Igrave;","&Iacute;","&Icirc;","&Iuml;","&ETH;","&Ntilde;","&Ograve;","&Oacute;","&Ocirc;","&Otilde;","&Ouml;","&reg;","&times;","&Ugrave;","&Uacute;","&Ucirc;","&Uuml;","&Yacute;","&THORN;","&szlig;","&agrave;","&aacute;","&acirc;","&atilde;","&auml;","&aring;","&aelig;","&ccedil;","&egrave;","&eacute;","&ecirc;","&euml;","&igrave;","&iacute;","&icirc;","&iuml;","&eth;","&ntilde;","&ograve;","&oacute;","&ocirc;","&otilde;","&ouml;","&divide;","&oslash;","&ugrave;","&uacute;","&ucirc;","&uuml;","&yacute;","&thorn;","&yuml;","&OElig;","&oelig;","&Scaron;"];for(var f=0;f<i.length;f++){this.addEntity(i[f],f)}this.ready=true};CharacterMap.prototype.show=function(){if(!this.ready){var b=this;window.setTimeout(function(){b.show()},100);return}this.dialog.toggle()};CharacterMap.prototype.hide=function(){this.dialog.hide()};