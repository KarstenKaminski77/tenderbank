/* This compressed file is part of Xinha. For uncompressed sources, forum, and bug reports, go to xinha.org */
function MM_findObj(k,d){var h,i,j;if(!d){d=document}if((h=k.indexOf("?"))>0&&parent.frames.length){d=parent.frames[k.substring(h+1)].document;k=k.substring(0,h)}if(!(j=d[k])&&d.all){j=d.all[k]}for(i=0;!j&&i<d.forms.length;i++){j=d.forms[i][k]}for(i=0;!j&&d.layers&&i<d.layers.length;i++){j=MM_findObj(k,d.layers[i].document)}if(!j&&d.getElementById){j=d.getElementById(k)}return j}var pic_x,pic_y;function P7_Snap(){var x,y,ox,bx,oy,p,tx,a,b,k,d,da,e,el,args=P7_Snap.arguments;a=parseInt(a);for(k=0;k<(args.length-3);k+=4){if((g=MM_findObj(args[k]))!=null){el=eval(MM_findObj(args[k+1]));a=parseInt(args[k+2]);b=parseInt(args[k+3]);x=0;y=0;ox=0;oy=0;p="";tx=1;da="document.all['"+args[k]+"']";if(document.getElementById){d="document.getElementsByName('"+args[k]+"')[0]";if(!eval(d)){d="document.getElementById('"+args[k]+"')";if(!eval(d)){d=da}}}else{if(document.all){d=da}}if(document.all||document.getElementById){while(tx==1){p+=".offsetParent";if(eval(d+p)){x+=parseInt(eval(d+p+".offsetLeft"));y+=parseInt(eval(d+p+".offsetTop"))}else{tx=0}}ox=parseInt(g.offsetLeft);oy=parseInt(g.offsetTop);var tw=x+ox+y+oy;if(tw==0||(navigator.appVersion.indexOf("MSIE 4")>-1&&navigator.appVersion.indexOf("Mac")>-1)){ox=0;oy=0;if(g.style.left){x=parseInt(g.style.left);y=parseInt(g.style.top)}else{var w1=parseInt(el.style.width);bx=(a<0)?-5-w1:-10;a=(Math.abs(a)<1000)?0:a;b=(Math.abs(b)<1000)?0:b;if(event==null){x=document.body.scrollLeft+bx}else{x=document.body.scrollLeft+event.clientX+bx}if(event==null){y=document.body.scrollTop}else{y=document.body.scrollTop+event.clientY}}}}else{if(document.layers){x=g.x;y=g.y;var q0=document.layers,dd="";for(var s=0;s<q0.length;s++){dd="document."+q0[s].name;if(eval(dd+".document."+args[k])){x+=eval(dd+".left");y+=eval(dd+".top");break}}}}if(el){e=(document.layers)?el:el.style;var xx=parseInt(x+ox+a),yy=parseInt(y+oy+b);if(navigator.appName=="Netscape"&&parseInt(navigator.appVersion)>4){xx+="px";yy+="px"}if(navigator.appVersion.indexOf("MSIE 5")>-1&&navigator.appVersion.indexOf("Mac")>-1){xx+=parseInt(document.body.leftMargin);yy+=parseInt(document.body.topMargin);xx+="px";yy+="px"}e.left=xx;e.top=yy}pic_x=parseInt(xx);pic_y=parseInt(yy)}}}var ie=document.all;var ns6=document.getElementById&&!document.all;var dragapproved=false;var z,x,y,status,ant,canvas,content,pic_width,pic_height,image,resizeHandle,oa_w,oa_h,oa_x,oa_y,mx2,my2;function init_resize(){if(mode=="scale"){P7_Snap("theImage","ant",0,0);if(canvas==null){canvas=MM_findObj("imgCanvas")}if(pic_width==null||pic_height==null){image=MM_findObj("theImage");pic_width=image.width;pic_height=image.height}if(ant==null){ant=MM_findObj("ant")}ant.style.left=pic_x;ant.style.top=pic_y;ant.style.width=pic_width;ant.style.height=pic_height;ant.style.visibility="visible";drawBoundHandle();jg_doc.paint()}}initEditor=function(){init_crop();init_resize();var b=MM_findObj("markerImg",window.top.document);if(b.src.indexOf("img/t_white.gif")>0){toggleMarker()}};function init_crop(){P7_Snap("theImage","ant",0,0)}function setMode(b){mode=b;reset()}function reset(){if(ant==null){ant=MM_findObj("ant")}ant.style.visibility="hidden";ant.style.left=0;ant.style.top=0;ant.style.width=0;ant.style.height=0;mx2=null;my2=null;jg_doc.clear();if(mode!="measure"){showStatus()}if(mode=="scale"){init_resize()}P7_Snap("theImage","ant",0,0)}function toggleMarker(){if(ant==null){ant=MM_findObj("ant")}if(ant.className=="selection"){ant.className="selectionWhite"}else{ant.className="selection"}if(jg_doc.getColor()=="#000000"){jg_doc.setColor("#FFFFFF")}else{jg_doc.setColor("#000000")}drawBoundHandle;jg_doc.paint()}function move(e){if(dragapproved){var d=ns6?temp1+e.clientX-x:temp1+event.clientX-x;var f=ns6?temp2+e.clientY-y:temp2+event.clientY-y;if(ant!=null){if(d>=0){ant.style.left=x;ant.style.width=d}else{ant.style.left=x+d;ant.style.width=-1*d}if(f>=0){ant.style.top=y;ant.style.height=f}else{ant.style.top=y+f;ant.style.height=-1*f}}showStatus();return false}}function moveContent(e){if(dragapproved){var f=ns6?oa_x+e.clientX-x:oa_x+event.clientX-x;var d=ns6?oa_y+e.clientY-y:oa_y+event.clientY-y;ant.style.left=f;ant.style.top=d;showStatus();return false}}function moveHandle(l){if(dragapproved){var j=ns6?l.clientX-x:event.clientX-x;var e=ns6?l.clientY-y:event.clientY-y;var k=MM_findObj("constProp",window.top.document);var h=document.theImage.height;var m=document.theImage.width;rapp=m/h;rapp_inv=h/m;switch(resizeHandle){case"s-resize":if(oa_h+e>=0){ant.style.height=oa_h+e;if(k.checked){ant.style.width=rapp*(oa_h+e);ant.style.left=oa_x-rapp*e/2}}break;case"e-resize":if(oa_w+j>=0){ant.style.width=oa_w+j;if(k.checked){ant.style.height=rapp_inv*(oa_w+j);ant.style.top=oa_y-rapp_inv*j/2}}break;case"n-resize":if(oa_h-e>=0){ant.style.top=oa_y+e;ant.style.height=oa_h-e;if(k.checked){ant.style.width=rapp*(oa_h-e);ant.style.left=oa_x+rapp*e/2}}break;case"w-resize":if(oa_w-j>=0){ant.style.left=oa_x+j;ant.style.width=oa_w-j;if(k.checked){ant.style.height=rapp_inv*(oa_w-j);ant.style.top=oa_y+rapp_inv*j/2}}break;case"nw-resize":if(oa_h-e>=0&&oa_w-j>=0){ant.style.left=oa_x+j;ant.style.width=oa_w-j;ant.style.top=oa_y+e;if(k.checked){ant.style.height=rapp_inv*(oa_w-j)}else{ant.style.height=oa_h-e}}break;case"ne-resize":if(oa_h-e>=0&&oa_w+j>=0){ant.style.top=oa_y+e;ant.style.width=oa_w+j;if(k.checked){ant.style.height=rapp_inv*(oa_w+j)}else{ant.style.height=oa_h-e}}break;case"se-resize":if(oa_h+e>=0&&oa_w+j>=0){ant.style.width=oa_w+j;if(k.checked){ant.style.height=rapp_inv*(oa_w+j)}else{ant.style.height=oa_h+e}}break;case"sw-resize":if(oa_h+e>=0&&oa_w-j>=0){ant.style.left=oa_x+j;ant.style.width=oa_w-j;if(k.checked){ant.style.height=rapp_inv*(oa_w-j)}else{ant.style.height=oa_h+e}}}showStatus();return false}}function drags(f){if(!ie&&!ns6){return}var e=ns6?f.target:event.srcElement;var d=ns6?"HTML":"BODY";while(e.tagName!=d&&!(e.className=="crop"||e.className=="handleBox"||e.className=="selection"||e.className=="selectionWhite")){e=ns6?e.parentNode:e.parentElement}if(e.className=="handleBox"){if(content!=null){if(content.width!=null&&content.height!=null){content.width=0;content.height=0}}resizeHandle=e.id;x=ns6?f.clientX:event.clientX;y=ns6?f.clientY:event.clientY;oa_w=parseInt(ant.style.width);oa_h=parseInt(ant.style.height);oa_x=parseInt(ant.style.left);oa_y=parseInt(ant.style.top);dragapproved=true;document.onmousemove=moveHandle;return false}else{if((e.className=="selection"||e.className=="selectionWhite")&&mode=="crop"){x=ns6?f.clientX:event.clientX;y=ns6?f.clientY:event.clientY;oa_x=parseInt(ant.style.left);oa_y=parseInt(ant.style.top);dragapproved=true;document.onmousemove=moveContent;return false}else{if(e.className=="crop"&&mode=="crop"){if(content!=null){if(content.width!=null&&content.height!=null){content.width=0;content.height=0}}if(status==null){status=MM_findObj("status")}if(ant==null){ant=MM_findObj("ant")}if(canvas==null){canvas=MM_findObj("imgCanvas")}if(content==null){content=MM_findObj("cropContent")}if(pic_width==null||pic_height==null){image=MM_findObj("theImage");pic_width=image.width;pic_height=image.height}ant.style.visibility="visible";obj=e;dragapproved=true;z=e;temp1=parseInt(z.style.left+0);temp2=parseInt(z.style.top+0);x=ns6?f.clientX:event.clientX;y=ns6?f.clientY:event.clientY;document.onmousemove=move;return false}else{if(e.className=="crop"&&mode=="measure"){if(ant==null){ant=MM_findObj("ant")}if(canvas==null){canvas=MM_findObj("imgCanvas")}x=ns6?f.clientX:event.clientX;y=ns6?f.clientY:event.clientY;dragapproved=true;document.onmousemove=measure;return false}}}}}function measure(b){if(dragapproved){mx2=ns6?b.clientX:event.clientX;my2=ns6?b.clientY:event.clientY;jg_doc.clear();jg_doc.setStroke(Stroke.DOTTED);jg_doc.drawLine(x,y,mx2,my2);jg_doc.paint();showStatus();return false}}function setMarker(i,e,h,f){if(isNaN(i)){i=0}if(isNaN(e)){e=0}if(isNaN(h)){h=0}if(isNaN(f)){f=0}if(ant==null){ant=MM_findObj("ant")}if(canvas==null){canvas=MM_findObj("imgCanvas")}if(content==null){content=MM_findObj("cropContent")}if(pic_width==null||pic_height==null){image=MM_findObj("theImage");pic_width=image.width;pic_height=image.height}ant.style.visibility="visible";i=pic_x+i;e=pic_y+e;if(h>=0){ant.style.left=i;ant.style.width=h}else{ant.style.left=i+h;ant.style.width=-1*h}if(f>=0){ant.style.top=e;ant.style.height=f}else{ant.style.top=e+f;ant.style.height=-1*f}}function max(d,c){if(c>d){return d}else{return c}}function drawBoundHandle(){if(ant==null||ant.style==null){return false}var i=parseInt(ant.style.height);var e=parseInt(ant.style.width);var f=parseInt(ant.style.left);var h=parseInt(ant.style.top);jg_doc.drawHandle(f-15,h-15,30,30,"nw-resize");jg_doc.drawHandle(f-15,h+i-15,30,30,"sw-resize");jg_doc.drawHandle(f+e-15,h-15,30,30,"ne-resize");jg_doc.drawHandle(f+e-15,h+i-15,30,30,"se-resize");jg_doc.drawHandle(f+max(15,e/10),h-8,e-2*max(15,e/10),8,"n-resize");jg_doc.drawHandle(f+max(15,e/10),h+i,e-2*max(15,e/10),8,"s-resize");jg_doc.drawHandle(f-8,h+max(15,i/10),8,i-2*max(15,i/10),"w-resize");jg_doc.drawHandle(f+e,h+max(15,i/10),8,i-2*max(15,i/10),"e-resize");jg_doc.drawHandleBox(f-4,h-4,8,8,"nw-resize");jg_doc.drawHandleBox(f-4,h+i-4,8,8,"sw-resize");jg_doc.drawHandleBox(f+e-4,h-4,8,8,"ne-resize");jg_doc.drawHandleBox(f+e-4,h+i-4,8,8,"se-resize");jg_doc.drawHandleBox(f+e/2-4,h-4,8,8,"n-resize");jg_doc.drawHandleBox(f+e/2-4,h+i-4,8,8,"s-resize");jg_doc.drawHandleBox(f-4,h+i/2-4,8,8,"w-resize");jg_doc.drawHandleBox(f+e-4,h+i/2-4,8,8,"e-resize")}function showStatus(){if(ant==null||ant.style==null){return false}if(mode=="measure"){mx1=x-pic_x;my1=y-pic_y;mw=mx2-x;mh=my2-y;md=parseInt(Math.sqrt(mw*mw+mh*mh)*100)/100;ma=(Math.atan(-1*mh/mw)/Math.PI)*180;if(mw<0&&mh<0){ma=ma+180}if(mw<0&&mh>0){ma=ma-180}ma=parseInt(ma*100)/100;if(m_sx!=null&&!isNaN(mx1)){m_sx.value=mx1+"px"}if(m_sy!=null&&!isNaN(my1)){m_sy.value=my1+"px"}if(m_w!=null&&!isNaN(mw)){m_w.value=mw+"px"}if(m_h!=null&&!isNaN(mh)){m_h.value=mh+"px"}if(m_d!=null&&!isNaN(md)){m_d.value=md+"px"}if(m_a!=null&&!isNaN(ma)){m_a.value=ma+""}if(r_ra!=null&&!isNaN(ma)){r_ra.value=ma}return false}var q=parseInt(ant.style.height);var l=parseInt(ant.style.width);var m=parseInt(ant.style.left);var o=parseInt(ant.style.top);var t=m-pic_x<0?0:m-pic_x;var u=o-pic_y<0?0:o-pic_y;t=t>pic_width?pic_width:t;u=u>pic_height?pic_height:u;var s=m-pic_x>0?l:l-(pic_x-m);var n=o-pic_y>0?q:q-(pic_y-o);n=o+q<pic_y+pic_height?n:n-(o+q-pic_y-pic_height);s=m+l<pic_x+pic_width?s:s-(m+l-pic_x-pic_width);n=n<0?0:n;s=s<0?0:s;if(ant.style.visibility=="hidden"){t="";u="";s="";n=""}if(mode=="crop"){if(t_cx!=null){t_cx.value=t}if(t_cy!=null){t_cy.value=u}if(t_cw!=null){t_cw.value=s}if(t_ch!=null){t_ch.value=n}}else{if(mode=="scale"){var p=l,r=q;if(s_sw.value.indexOf("%")>0&&s_sh.value.indexOf("%")>0){p=s/pic_width;r=n/pic_height}if(s_sw!=null){s_sw.value=p}if(s_sh!=null){s_sh.value=r}}}}function dragStopped(){dragapproved=false;if(ant==null||ant.style==null){return false}if(mode=="measure"){jg_doc.drawLine(x-4,y,x+4,y);jg_doc.drawLine(x,y-4,x,y+4);jg_doc.drawLine(mx2-4,my2,mx2+4,my2);jg_doc.drawLine(mx2,my2-4,mx2,my2+4);jg_doc.paint();showStatus();return false}var k=parseInt(ant.style.height);var l=parseInt(ant.style.width);var m=parseInt(ant.style.left);var h=parseInt(ant.style.top);jg_doc.clear();if(content!=null){if(content.width!=null&&content.height!=null){content.width=l-1;content.height=k-1}}if(mode=="crop"){jg_doc.fillRectPattern(pic_x,pic_y,pic_width,h-pic_y,pattern);var j=k;var i=h;if(k+h>=pic_height+pic_y){j=pic_height+pic_y-h}else{if(h<=pic_y){j=h+k-pic_y;i=pic_y}}jg_doc.fillRectPattern(pic_x,i,m-pic_x,j,pattern);jg_doc.fillRectPattern(m+l,i,pic_x+pic_width-m-l,j,pattern);jg_doc.fillRectPattern(pic_x,h+k,pic_width,pic_height+pic_y-h-k,pattern)}else{if(mode=="scale"){document.theImage.height=k;document.theImage.width=l;document.theImage.style.height=k+" px";document.theImage.style.width=l+" px";P7_Snap("theImage","ant",0,0)}}drawBoundHandle();jg_doc.paint();showStatus();return false}document.onmousedown=drags;document.onmouseup=dragStopped;