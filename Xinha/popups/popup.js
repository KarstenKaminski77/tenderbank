/* This compressed file is part of Xinha. For uncompressed sources, forum, and bug reports, go to xinha.org */
if(typeof Xinha=="undefined"){Xinha=window.opener.Xinha}HTMLArea=Xinha;function getAbsolutePos(d){var f={x:d.offsetLeft,y:d.offsetTop};if(d.offsetParent){var e=getAbsolutePos(d.offsetParent);f.x+=e.x;f.y+=e.y}return f}function comboSelectValue(h,j){var c=h.getElementsByTagName("option");for(var g=c.length;--g>=0;){var i=c[g];i.selected=(i.value==j)}h.value=j}function __dlg_onclose(){opener.Dialog._return(null)}function __dlg_init(c,d){__xinha_dlg_init(d)}function __xinha_dlg_init(h){if(window.__dlg_init_done){return true}if(window.opener._editor_skin){var n=document.getElementsByTagName("head")[0];var m=document.createElement("link");m.type="text/css";m.href=window.opener._editor_url+"skins/"+window.opener._editor_skin+"/skin.css";m.rel="stylesheet";n.appendChild(m)}if(!window.dialogArguments&&opener.Dialog._arguments){window.dialogArguments=opener.Dialog._arguments}var l=Xinha.pageSize(window);if(!h){h={width:l.x,height:l.y}}window.resizeTo(h.width,h.height);var k=Xinha.viewportSize(window);window.resizeBy(0,l.y-k.y);if(h.top&&h.left){window.moveTo(h.left,h.top)}else{if(!Xinha.is_ie){var i=opener.screenX+(opener.outerWidth-h.width)/2;var j=opener.screenY+(opener.outerHeight-h.height)/2}else{var i=(self.screen.availWidth-h.width)/2;var j=(self.screen.availHeight-h.height)/2}window.moveTo(i,j)}Xinha.addDom0Event(document.body,"keypress",__dlg_close_on_esc);window.__dlg_init_done=true}function __dlg_translate(l){var m=["input","select","legend","span","option","td","th","button","div","label","a","img"];for(var j=0;j<m.length;++j){var n=document.getElementsByTagName(m[j]);for(var h=n.length;--h>=0;){var k=n[h];if(k.firstChild&&k.firstChild.data){var i=Xinha._lc(k.firstChild.data,l);if(i){k.firstChild.data=i}}if(k.title){var i=Xinha._lc(k.title,l);if(i){k.title=i}}if(k.tagName.toLowerCase()=="input"&&(/^(button|submit|reset)$/i.test(k.type))){var i=Xinha._lc(k.value,l);if(i){k.value=i}}}}document.title=Xinha._lc(document.title,l)}function __dlg_close(b){opener.Dialog._return(b);window.close()}function __dlg_close_on_esc(b){b||(b=window.event);if(b.keyCode==27){__dlg_close(null);return false}return true};