/* This compressed file is part of Xinha. For uncompressed sources, forum, and bug reports, go to xinha.org */
Xinha.InlineStyler=function(f,h,g,e){this.element=f;this.editor=h;this.dialog=g;this.doc=e?e:document;this.inputs={styles:{},aux:{}};this.styles={};this.auxData={}};Xinha.InlineStyler.getLength=function(c){var d=parseInt(c);if(isNaN(d)){d=""}return d};Xinha.InlineStyler.prototype.applyStyle=function(k){var j=this.element;var g=j.style;for(var i in k){if(typeof k[i]=="function"){continue}if(k[i]!=null){var l=k[i].value||k[i]}switch(i){case"backgroundImage":if(/\S/.test(l)){g.backgroundImage="url("+l+")"}else{g.backgroundImage="none"}break;case"borderCollapse":g.borderCollapse=k[i]=="on"?"collapse":"separate";break;case"width":if(/\S/.test(l)){g.width=l+this.inputs.aux.widthUnit.value}else{g.width=""}break;case"height":if(/\S/.test(l)){g.height=l+this.inputs.aux.heightUnit.value}else{g.height=""}break;case"textAlign":if(l=="char"){var h=this.inputs.aux.textAlignChar.value;if(h=='"'){h='\\"'}g.textAlign='"'+h+'"'}else{if(l=="-"){g.textAlign=""}else{g.textAlign=l}}break;case"verticalAlign":j.vAlign="";if(l=="-"){g.verticalAlign=""}else{g.verticalAlign=l}break;case"float":if(Xinha.is_ie){g.styleFloat=l}else{g.cssFloat=l}break;case"borderWidth":g[i]=l?l+"px":"0px";break;default:g[i]=l;break}}};Xinha.InlineStyler.prototype.createStyleLayoutFieldset=function(){var y=this;var F=this.editor;var i=this.doc;var J=this.element;var E=i.createElement("fieldset");var A=i.createElement("legend");E.appendChild(A);A.innerHTML=Xinha._lc("Layout","TableOperations");var K=i.createElement("table");E.appendChild(K);K.style.width="100%";var M=i.createElement("tbody");K.appendChild(M);var x=J.tagName.toLowerCase();var L,D,z,G,N,B,w;if(x!="td"&&x!="tr"&&x!="th"){L=i.createElement("tr");M.appendChild(L);D=i.createElement("td");D.className="label";L.appendChild(D);D.innerHTML=Xinha._lc("Float","TableOperations")+":";D=i.createElement("td");L.appendChild(D);G=i.createElement("select");G.name=this.dialog.createId("float");D.appendChild(G);this.inputs.styles["float"]=G;B=["None","Left","Right"];for(var w=0;w<B.length;++w){var H=B[w];var C=B[w].toLowerCase();N=i.createElement("option");N.innerHTML=Xinha._lc(H,"TableOperations");N.value=C;if(Xinha.is_ie){N.selected=((""+J.style.styleFloat).toLowerCase()==C)}else{N.selected=((""+J.style.cssFloat).toLowerCase()==C)}G.appendChild(N)}}L=i.createElement("tr");M.appendChild(L);D=i.createElement("td");D.className="label";L.appendChild(D);D.innerHTML=Xinha._lc("Width","TableOperations")+":";D=i.createElement("td");L.appendChild(D);z=i.createElement("input");z.name=this.dialog.createId("width");z.type="text";z.value=Xinha.InlineStyler.getLength(J.style.width);z.size="5";this.inputs.styles.width=z;z.style.marginRight="0.5em";D.appendChild(z);G=i.createElement("select");G.name=this.dialog.createId("widthUnit");this.inputs.aux.widthUnit=G;N=i.createElement("option");N.innerHTML=Xinha._lc("percent","TableOperations");N.value="%";N.selected=/%/.test(J.style.width);G.appendChild(N);N=i.createElement("option");N.innerHTML=Xinha._lc("pixels","TableOperations");N.value="px";N.selected=/px/.test(J.style.width);G.appendChild(N);D.appendChild(G);G.style.marginRight="0.5em";D.appendChild(i.createTextNode(Xinha._lc("Text align","TableOperations")+":"));G=i.createElement("select");G.name=this.dialog.createId("textAlign");G.style.marginLeft=G.style.marginRight="0.5em";D.appendChild(G);this.inputs.styles.textAlign=G;B=["Left","Center","Right","Justify","-"];if(x=="td"){B.push("Char")}z=i.createElement("input");this.inputs.aux.textAlignChar=z;z.name=this.dialog.createId("textAlignChar");z.size="1";z.style.fontFamily="monospace";D.appendChild(z);for(var w=0;w<B.length;++w){var H=B[w];var C=H.toLowerCase();N=i.createElement("option");N.value=C;N.innerHTML=Xinha._lc(H,"TableOperations");N.selected=((J.style.textAlign.toLowerCase()==C)||(J.style.textAlign==""&&H=="-"));G.appendChild(N)}var v=z;function I(a){v.style.visibility=a?"visible":"hidden";if(a){v.focus();v.select()}}G.onchange=function(){I(this.value=="char")};I(G.value=="char");L=i.createElement("tr");M.appendChild(L);D=i.createElement("td");D.className="label";L.appendChild(D);D.innerHTML=Xinha._lc("Height","TableOperations")+":";D=i.createElement("td");L.appendChild(D);z=i.createElement("input");z.name=this.dialog.createId("height");z.type="text";z.value=Xinha.InlineStyler.getLength(J.style.height);z.size="5";this.inputs.styles.height=z;z.style.marginRight="0.5em";D.appendChild(z);G=i.createElement("select");G.name=this.dialog.createId("heightUnit");this.inputs.aux.heightUnit=G;N=i.createElement("option");N.innerHTML=Xinha._lc("percent","TableOperations");N.value="%";N.selected=/%/.test(J.style.height);G.appendChild(N);N=i.createElement("option");N.innerHTML=Xinha._lc("pixels","TableOperations");N.value="px";N.selected=/px/.test(J.style.height);G.appendChild(N);D.appendChild(G);G.style.marginRight="0.5em";D.appendChild(i.createTextNode(Xinha._lc("Vertical align","TableOperations")+":"));G=i.createElement("select");G.name=this.dialog.createId("verticalAlign");this.inputs.styles.verticalAlign=G;G.style.marginLeft="0.5em";D.appendChild(G);B=["Top","Middle","Bottom","Baseline","-"];for(var w=0;w<B.length;++w){var H=B[w];var C=H.toLowerCase();N=i.createElement("option");N.value=C;N.innerHTML=Xinha._lc(H,"TableOperations");N.selected=((J.style.verticalAlign.toLowerCase()==C)||(J.style.verticalAlign==""&&H=="-"));G.appendChild(N)}return E};Xinha.InlineStyler.prototype.createStyleFieldset=function(){var F=this.editor;var i=this.doc;var H=this.element;var E=i.createElement("fieldset");var z=i.createElement("legend");E.appendChild(z);z.innerHTML=Xinha._lc("CSS Style","TableOperations");var I=i.createElement("table");E.appendChild(I);I.style.width="100%";var M=i.createElement("tbody");I.appendChild(M);var J,D,y,G,N,B,K;J=i.createElement("tr");M.appendChild(J);D=i.createElement("td");J.appendChild(D);D.className="label";D.innerHTML=Xinha._lc("Background","TableOperations")+":";D=i.createElement("td");J.appendChild(D);y=i.createElement("input");y.name=this.dialog.createId("backgroundColor");y.value=Xinha._colorToRgb(H.style.backgroundColor);y.type="hidden";this.inputs.styles.backgroundColor=y;y.style.marginRight="0.5em";D.appendChild(y);new Xinha.colorPicker.InputBinding(y);D.appendChild(i.createTextNode(" "+Xinha._lc("Image URL","TableOperations")+": "));y=i.createElement("input");y.name=this.dialog.createId("backgroundImage");y.type="text";this.inputs.styles.backgroundImage=y;if(H.style.backgroundImage.match(/url\(\s*(.*?)\s*\)/)){y.value=RegExp.$1}D.appendChild(y);J=i.createElement("tr");M.appendChild(J);D=i.createElement("td");J.appendChild(D);D.className="label";D.innerHTML=Xinha._lc("FG Color","TableOperations")+":";D=i.createElement("td");J.appendChild(D);y=i.createElement("input");y.name=this.dialog.createId("color");y.value=Xinha._colorToRgb(H.style.color);y.type="hidden";this.inputs.styles.color=y;y.style.marginRight="0.5em";D.appendChild(y);new Xinha.colorPicker.InputBinding(y);y=i.createElement("input");y.style.visibility="hidden";y.type="text";D.appendChild(y);J=i.createElement("tr");M.appendChild(J);D=i.createElement("td");J.appendChild(D);D.className="label";D.innerHTML=Xinha._lc("Border","TableOperations")+":";D=i.createElement("td");J.appendChild(D);y=i.createElement("input");y.name=this.dialog.createId("borderColor");y.value=Xinha._colorToRgb(H.style.borderColor);y.type="hidden";this.inputs.styles.borderColor=y;y.style.marginRight="0.5em";D.appendChild(y);new Xinha.colorPicker.InputBinding(y);G=i.createElement("select");G.name=this.dialog.createId("borderStyle");var w=[];D.appendChild(G);this.inputs.styles.borderStyle=G;B=["none","dotted","dashed","solid","double","groove","ridge","inset","outset"];var x=H.style.borderStyle;if(x.match(/([^\s]*)\s/)){x=RegExp.$1}for(var K=0;K<B.length;K++){var C=B[K];N=i.createElement("option");N.value=C;N.innerHTML=C;if(C==x){N.selected=true}G.appendChild(N)}G.style.marginRight="0.5em";function L(b){for(var a=0;a<w.length;++a){var c=w[a];c.style.visibility=b?"hidden":"visible";if(!b&&(c.tagName.toLowerCase()=="input")){c.focus();c.select()}}}G.onchange=function(){L(this.value=="none")};y=i.createElement("input");y.name=this.dialog.createId("borderWidth");w.push(y);y.type="text";this.inputs.styles.borderWidth=y;y.value=Xinha.InlineStyler.getLength(H.style.borderWidth);y.size="5";D.appendChild(y);y.style.marginRight="0.5em";var v=i.createElement("span");v.innerHTML=Xinha._lc("pixels","TableOperations");D.appendChild(v);w.push(v);L(G.value=="none");if(H.tagName.toLowerCase()=="table"){J=i.createElement("tr");M.appendChild(J);D=i.createElement("td");D.className="label";J.appendChild(D);y=i.createElement("input");y.name=this.dialog.createId("borderCollapse");y.type="checkbox";y.value="on";this.inputs.styles.borderCollapse=y;y.id="f_st_borderCollapse";var C=(/collapse/i.test(H.style.borderCollapse));y.checked=C?1:0;D.appendChild(y);D=i.createElement("td");J.appendChild(D);var A=i.createElement("label");A.htmlFor="f_st_borderCollapse";A.innerHTML=Xinha._lc("Collapsed borders","TableOperations");D.appendChild(A)}return E};