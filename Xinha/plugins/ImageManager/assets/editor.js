/* This compressed file is part of Xinha. For uncompressed sources, forum, and bug reports, go to xinha.org */
var current_action=null;var actions=["crop","scale","rotate","measure","save"];var orginal_width=null,orginal_height=null;function toggle(h){if(current_action!=h){for(var o in actions){if(actions[o]!=h){var k=document.getElementById("tools_"+actions[o]);k.style.display="none";var m=document.getElementById("icon_"+actions[o]);m.className=""}}current_action=h;var k=document.getElementById("tools_"+h);k.style.display="block";var m=document.getElementById("icon_"+h);m.className="iconActive";var l=document.getElementById("indicator_image");l.src="img/"+h+".gif";editor.setMode(current_action);if(h=="scale"){var i=editor.window.document.getElementById("theImage");orginal_width=i.width;orginal_height=i.height;var p=document.getElementById("sw");p.value=orginal_width;var n=document.getElementById("sh");n.value=orginal_height}}}function toggleMarker(){var b=document.getElementById("markerImg");if(b!=null&&b.src!=null){if(b.src.indexOf("t_black.gif")>=0){b.src="img/t_white.gif"}else{b.src="img/t_black.gif"}editor.toggleMarker()}}function toggleConstraints(){var d=document.getElementById("scaleConstImg");var c=document.getElementById("constProp");if(d!=null&&d.src!=null){if(d.src.indexOf("unlocked2.gif")>=0){d.src="img/islocked2.gif";c.checked=true;checkConstrains("width")}else{d.src="img/unlocked2.gif";c.checked=false}}}function checkConstrains(i){var g=document.getElementById("constProp");if(g.checked){var h=document.getElementById("sw");var k=h.value;var l=document.getElementById("sh");var j=l.value;if(orginal_width>0&&orginal_height>0){if(i=="width"&&k>0){l.value=parseInt((k/orginal_width)*orginal_height)}else{if(i=="height"&&j>0){h.value=parseInt((j/orginal_height)*orginal_width)}}}}updateMarker("scale")}function updateMarker(k){if(k=="crop"){var l=document.getElementById("cx");var m=document.getElementById("cy");var j=document.getElementById("cw");var h=document.getElementById("ch");editor.setMarker(parseInt(l.value),parseInt(m.value),parseInt(j.value),parseInt(h.value))}else{if(k=="scale"){var i=document.getElementById("sw");var n=document.getElementById("sh");editor.setMarker(0,0,parseInt(i.value),parseInt(n.value))}}}function rotatePreset(e){var d=e.options[e.selectedIndex].value;if(d.length>0&&parseInt(d)!=0){var f=document.getElementById("ra");f.value=parseInt(d)}}function updateFormat(e){var f=e.options[e.selectedIndex].value;var d=f.split(",");if(d.length>1){updateSlider(parseInt(d[1]))}}function addEvent(g,f,e){if(g.addEventListener){g.addEventListener(f,e,true);return true}else{if(g.attachEvent){var h=g.attachEvent("on"+f,e);return h}else{return false}}}init=function(){var b=document.getElementById("bottom");if(window.opener){__dlg_init(b);__dlg_translate("ImageManager")}};addEvent(window,"load",init);