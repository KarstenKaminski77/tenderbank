/* This compressed file is part of Xinha. For uncompressed sources, forum, and bug reports, go to xinha.org */
function i18n(b){return Xinha._lc(b,"ImageManager")}function setAlign(e){var d=document.getElementById("f_align");for(var f=0;f<d.length;f++){if(d.options[f].value==e){d.selectedIndex=f;break}}}doneinit=0;init=function(){if(doneinit++){return}__dlg_init(null,{width:600,height:460});__dlg_translate("ImageManager");document.getElementById("f_align").selectedIndex=1;document.getElementById("f_align").selectedIndex=0;var k=document.getElementById("uploadForm");if(k){k.target="imgManager"}var o=window.dialogArguments;if(o){var p=new RegExp("(https?://[^/]*)?"+base_url.replace(/\/$/,""));o.f_url=o.f_url.replace(p,"");var i=(_resized_dir)?_resized_dir.replace(Xinha.RE_Specials,"\\$1")+"/":"";var m=_resized_prefix.replace(Xinha.RE_Specials,"\\$1");var r=new RegExp("^(.*/)"+i+m+"_([0-9]+)x([0-9]+)_([^/]+)$");if(r.test(o.f_url)){o.f_url=RegExp.$1+RegExp.$4;o.f_width=RegExp.$2;o.f_height=RegExp.$3}for(var q in o){if(q=="f_align"){continue}if(document.getElementById(q)){document.getElementById(q).value=o[q]}}document.getElementById("orginal_width").value=o.f_width;document.getElementById("orginal_height").value=o.f_height;setAlign(o.f_align);var r=new RegExp("^(.*/)([^/]+)$");if(r.test(o.f_url)&&!(new RegExp("^https?://","i")).test(o.f_url)){changeDir(RegExp.$1);var l=document.getElementById("dirPath");for(var n=0;n<l.options.length;n++){if(l.options[n].value==encodeURIComponent(RegExp.$1)){l.options[n].selected=true;break}}}document.getElementById("f_preview").src=_backend_url+"__function=thumbs&img="+encodeURIComponent(o.f_url)}new Xinha.colorPicker.InputBinding(document.getElementById("f_backgroundColor"));new Xinha.colorPicker.InputBinding(document.getElementById("f_borderColor"));document.getElementById("f_alt").focus()};function onCancel(){__dlg_close(null);return false}function onOK(){var fields=["f_url","f_alt","f_align","f_width","f_height","f_padding","f_margin","f_border","f_borderColor","f_backgroundColor","f_hspace","f_vspace"];var param=new Object();for(var i in fields){var id=fields[i];var el=document.getElementById(id);if(id=="f_url"&&el.value.indexOf("://")<0){if(el.value==""){alert(i18n("No Image selected."));return(false)}param[id]=makeURL(base_url,el.value)}else{if(el){param[id]=el.value}}}var origsize={w:document.getElementById("orginal_width").value,h:document.getElementById("orginal_height").value};if((origsize.w!=param.f_width)||(origsize.h!=param.f_height)){var resized=Xinha._geturlcontent(_backend_url+"&__function=resizer&img="+encodeURIComponent(document.getElementById("f_url").value)+"&width="+param.f_width+"&height="+param.f_height);resized=eval(resized);if(resized){param.f_url=makeURL(base_url,resized)}}__dlg_close(param);return false}function makeURL(c,d){if(c.substring(c.length-1)!="/"){c+="/"}if(d.charAt(0)=="/"){}d=d.substring(1);return c+d}function updateDir(d){var c=d.options[d.selectedIndex].value;changeDir(c)}function goUpDir(){var l=document.getElementById("dirPath");var m=l.options[l.selectedIndex].text;if(m.length<2){return false}var h=m.split("/");var j="";for(var i=0;i<h.length-2;i++){j+=h[i]+"/"}for(var i=0;i<l.length;i++){var k=l.options[i].text;if(k==j){l.selectedIndex=i;var n=l.options[i].value;changeDir(n);break}}}function changeDir(b){if(typeof imgManager!="undefined"){imgManager.changeDir(b)}}function toggleConstrains(c){var d=document.getElementById("imgLock");var c=document.getElementById("constrain_prop");if(c.checked){d.src="img/locked.gif";checkConstrains("width")}else{d.src="img/unlocked.gif"}}function checkConstrains(m){var l=document.getElementById("constrain_prop");if(l.checked){var n=document.getElementById("orginal_width");var k=parseInt(n.value);var n=document.getElementById("orginal_height");var o=parseInt(n.value);var p=document.getElementById("f_width");var r=document.getElementById("f_height");var q=parseInt(p.value);var j=parseInt(r.value);if(k>0&&o>0){if(m=="width"&&q>0){r.value=parseInt((q/k)*o)}if(m=="height"&&j>0){p.value=parseInt((j/o)*k)}}}}function showMessage(f){var e=document.getElementById("message");var d=document.getElementById("messages");if(e.firstChild){e.removeChild(e.firstChild)}e.appendChild(document.createTextNode(i18n(f)));d.style.display=""}function addEvent(e,h,g){if(e.addEventListener){e.addEventListener(h,g,true);return true}else{if(e.attachEvent){var f=e.attachEvent("on"+h,g);return f}else{return false}}}function doUpload(){var b=document.getElementById("uploadForm");if(b){showMessage("Uploading")}}function refresh(){var b=document.getElementById("dirPath");updateDir(b)}function newFolder(){function c(a){var f=document.getElementById("dirPath");var b=f.options[f.selectedIndex].value;if(a==thumbdir){alert(i18n("Invalid folder name, please choose another folder name."));return false}if(a&&a!=""&&typeof imgManager!="undefined"){imgManager.newFolder(b,encodeURI(a))}}if(Xinha.ie_version>6){Dialog("newFolder.html",function(a){if(!a){return false}else{var b=a.f_foldername;c(b)}},null)}else{var d=prompt(i18n("Please enter name for new folder..."),i18n("Untitled"));c(d)}}addEvent(window,"load",init);