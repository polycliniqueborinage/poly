
if(typeof Rico=='undefined')
throw("Cannot find the Rico object");if(typeof Prototype=='undefined')
throw("Rico requires the Prototype JavaScript framework");Rico.prototypeVersion=parseFloat(Prototype.Version.split(".")[0]+"."+Prototype.Version.split(".")[1]);if(Rico.prototypeVersion<1.3)
throw("Rico requires Prototype JavaScript framework version 1.3 or greater");var RicoUtil={getDirectChildrenByTag:function(e,tagName){var kids=new Array();var allKids=e.childNodes;tagName=tagName.toLowerCase();for(var i=0;i<allKids.length;i++)
if(allKids[i]&&allKids[i].tagName&&allKids[i].tagName.toLowerCase()==tagName)
kids.push(allKids[i]);return kids;},createXmlDocument:function(){if(document.implementation&&document.implementation.createDocument){var doc=document.implementation.createDocument("","",null);if(doc.readyState==null){doc.readyState=1;doc.addEventListener("load",function(){doc.readyState=4;if(typeof doc.onreadystatechange=="function")
doc.onreadystatechange();},false);}
return doc;}
if(window.ActiveXObject)
return Try.these(function(){return new ActiveXObject('MSXML2.DomDocument')},function(){return new ActiveXObject('Microsoft.DomDocument')},function(){return new ActiveXObject('MSXML.DomDocument')},function(){return new ActiveXObject('MSXML3.DomDocument')})||false;return null;},getInnerText:function(el){if(typeof el=="string")return el;if(typeof el=="undefined"){return el};var cs=el.childNodes;var l=cs.length;var str="";for(var i=0;i<l;i++){switch(cs[i].nodeType){case 1:if(Element.getStyle(cs[i],'display')=='none')continue;switch(cs[i].tagName.toLowerCase()){case'img':str+=cs[i].alt||cs[i].title||cs[i].src;break;case'input':if(cs[i].type=='hidden')continue;case'select':case'textarea':str+=$F(cs[i])||'';break;default:str+=this.getInnerText(cs[i]);break;}
break;case 3:str+=cs[i].nodeValue;break;}}
return str;},getContentAsString:function(parentNode,isEncoded){if(isEncoded)return this._getEncodedContent(parentNode);if(typeof parentNode.xml!='undefined')return this._getContentAsStringIE(parentNode);return this._getContentAsStringMozilla(parentNode);},_getEncodedContent:function(parentNode){if(parentNode.innerHTML)return parentNode.innerHTML;switch(parentNode.childNodes.length){case 0:return"";case 1:return parentNode.firstChild.nodeValue;default:return parentNode.childNodes[1].nodeValue;}},_getContentAsStringIE:function(parentNode){var contentStr="";for(var i=0;i<parentNode.childNodes.length;i++){var n=parentNode.childNodes[i];if(n.nodeType==4){contentStr+=n.nodeValue;}
else{contentStr+=n.xml;}}
return contentStr;},_getContentAsStringMozilla:function(parentNode){var xmlSerializer=new XMLSerializer();var contentStr="";for(var i=0;i<parentNode.childNodes.length;i++){var n=parentNode.childNodes[i];if(n.nodeType==4){contentStr+=n.nodeValue;}
else{contentStr+=xmlSerializer.serializeToString(n);}}
return contentStr;},docElement:function(){return(document.compatMode&&document.compatMode.indexOf("CSS")!=-1)?document.documentElement:document.getElementsByTagName("body")[0];},windowHeight:function(){return window.innerHeight?window.innerHeight:this.docElement().clientHeight;},windowWidth:function(){return this.docElement().clientWidth;},docScrollLeft:function(){if(window.pageXOffset)
return window.pageXOffset;else if(document.documentElement&&document.documentElement.scrollLeft)
return document.documentElement.scrollLeft;else if(document.body)
return document.body.scrollLeft;else
return 0;},docScrollTop:function(){if(window.pageYOffset)
return window.pageYOffset;else if(document.documentElement&&document.documentElement.scrollTop)
return document.documentElement.scrollTop;else if(document.body)
return document.body.scrollTop;else
return 0;},nan2zero:function(n){if(typeof(n)=='string')n=parseInt(n);return isNaN(n)||typeof(n)=='undefined'?0:n;},eventKey:function(e){if(typeof(e.keyCode)=='number'){return e.keyCode;}else if(typeof(e.which)=='number'){return e.which;}else if(typeof(e.charCode)=='number'){return e.charCode;}
return-1;},getPreviosSiblingByTagName:function(el,tagName){var sib=el.previousSibling;while(sib){if((sib.tagName==tagName)&&(sib.style.display!='none'))return sib;sib=sib.previousSibling;}
return null;},getParentByTagName:function(el,tagName,className){var par=el;tagName=tagName.toLowerCase();while(par){if(par.tagName&&par.tagName.toLowerCase()==tagName)
if(!className||par.className.indexOf(className)>=0)return par;par=par.parentNode;}
return null;},wrapChildren:function(el,cls,id,wrapperTag){var tag=wrapperTag||'div';var wrapper=document.createElement(tag);if(id)wrapper.id=id;if(cls)wrapper.className=cls;while(el.firstChild)
wrapper.appendChild(el.firstChild);el.appendChild(wrapper);return wrapper;},formatPosNumber:function(posnum,decPlaces,thouSep,decPoint){var a=posnum.toFixed(decPlaces).split(/\./);if(thouSep){var rgx=/(\d+)(\d{3})/;while(rgx.test(a[0]))
a[0]=a[0].replace(rgx,'$1'+thouSep+'$2');}
return a.join(decPoint);},DOMNode_insertAfter:function(newChild,refChild){var parentx=refChild.parentNode;if(parentx.lastChild==refChild){return parentx.appendChild(newChild);}
else{return parentx.insertBefore(newChild,refChild.nextSibling);}},positionCtlOverIcon:function(ctl,icon){if(ctl.style.display=='none')ctl.style.display='block';var offsets=Position.page(icon);var correction=Prototype.Browser.IE?1:2;var lpad=this.nan2zero(Element.getStyle(icon,'padding-left'))
ctl.style.left=(offsets[0]+lpad+correction)+'px';var scrTop=this.docScrollTop();var newTop=offsets[1]+correction+scrTop;var ctlht=ctl.offsetHeight;var iconht=icon.offsetHeight;if(newTop+iconht+ctlht<this.windowHeight()+scrTop)
newTop+=iconht;else
newTop=Math.max(newTop-ctlht,scrTop);ctl.style.top=newTop+'px';},createFormField:function(parent,elemTag,elemType,id,name){if(typeof name!='string')name=id;if(Prototype.Browser.IE){var s=elemTag+' id="'+id+'"';if(elemType)s+=' type="'+elemType+'"';if(elemTag.match(/^(form|input|select|textarea|object|button|img)$/))s+=' name="'+name+'"';var field=document.createElement('<'+s+' />');}else{var field=document.createElement(elemTag);if(elemType)field.type=elemType;field.id=id;if(typeof field.name=='string')field.name=name;}
parent.appendChild(field);return field;},getCookie:function(itemName){var arg=itemName+'=';var alen=arg.length;var clen=document.cookie.length;var i=0;while(i<clen){var j=i+alen;if(document.cookie.substring(i,j)==arg){var endstr=document.cookie.indexOf(';',j);if(endstr==-1)endstr=document.cookie.length;return unescape(document.cookie.substring(j,endstr));}
i=document.cookie.indexOf(' ',i)+1;if(i==0)break;}
return null;},setCookie:function(itemName,itemValue,daysToKeep,cookiePath,cookieDomain){var c=itemName+"="+escape(itemValue);if(typeof(daysToKeep)=='number'){var date=new Date();date.setTime(date.getTime()+(daysToKeep*24*60*60*1000));c+="; expires="+date.toGMTString();}
if(typeof(cookiePath)=='string')c+="; path="+cookiePath;if(typeof(cookieDomain)=='string')c+="; domain="+cookieDomain;document.cookie=c;}};var RicoTranslate={phrases:{},thouSep:",",decPoint:".",langCode:"en",re:/^(\W*)\b(.*)\b(\W*)$/,dateFmt:"mm/dd/yyyy",timeFmt:"hh:nn:ss a/pm",monthNames:['January','February','March','April','May','June','July','August','September','October','November','December'],dayNames:['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'],addPhrase:function(fromPhrase,toPhrase){this.phrases[fromPhrase]=toPhrase;},getPhrase:function(fromPhrase){var words=fromPhrase.split(/\t/);var transWord,translated='';for(var i=0;i<words.length;i++){if(this.re.exec(words[i])){transWord=this.phrases[RegExp.$2];translated+=(typeof transWord=='string')?RegExp.$1+transWord+RegExp.$3:words[i];}else{translated+=words[i];}}
return translated;}}
if(!Date.prototype.formatDate){Date.prototype.formatDate=function(fmt){var d=this;var datefmt=(typeof fmt=='string')?datefmt=fmt:'translateDate';switch(datefmt){case'locale':case'localeDateTime':return d.toLocaleString();case'localeDate':return d.toLocaleDateString();case'translate':case'translateDateTime':datefmt=RicoTranslate.dateFmt+' '+RicoTranslate.timeFmt;break;case'translateDate':datefmt=RicoTranslate.dateFmt;break;}
return datefmt.replace(/(yyyy|mmmm|mmm|mm|dddd|ddd|dd|hh|nn|ss|a\/p)/gi,function($1){switch($1.toLowerCase()){case'yyyy':return d.getFullYear();case'mmmm':return RicoTranslate.monthNames[d.getMonth()];case'mmm':return RicoTranslate.monthNames[d.getMonth()].substr(0,3);case'mm':return(d.getMonth()+1).toPaddedString(2);case'm':return(d.getMonth()+1);case'dddd':return RicoTranslate.dayNames[d.getDay()];case'ddd':return RicoTranslate.dayNames[d.getDay()].substr(0,3);case'dd':return d.getDate().toPaddedString(2);case'd':return d.getDate();case'hh':return((h=d.getHours()%12)?h:12).toPaddedString(2);case'h':return((h=d.getHours()%12)?h:12);case'HH':return d.getHours().toPaddedString(2);case'H':return d.getHours();case'nn':return d.getMinutes().toPaddedString(2);case'ss':return d.getSeconds().toPaddedString(2);case'a/p':return d.getHours()<12?'a':'p';}});}}
if(!Date.prototype.setISO8601){Date.prototype.setISO8601=function(string){if(!string)return false;var d=string.match(/(\d\d\d\d)(?:-?(\d\d)(?:-?(\d\d)(?:[T ](\d\d)(?::?(\d\d)(?::?(\d\d)(?:\.(\d+))?)?)?(Z|(?:([-+])(\d\d)(?::?(\d\d))?)?)?)?)?)?/);if(!d)return false;var offset=0;var date=new Date(d[1],0,1);if(d[2]){date.setMonth(d[2]-1);}
if(d[3]){date.setDate(d[3]);}
if(d[4]){date.setHours(d[4]);}
if(d[5]){date.setMinutes(d[5]);}
if(d[6]){date.setSeconds(d[6]);}
if(d[7]){date.setMilliseconds(Number("0."+d[7])*1000);}
if(d[8]){if(d[10]&&d[11])offset=(Number(d[10])*60)+Number(d[11]);offset*=((d[9]=='-')?1:-1);offset-=date.getTimezoneOffset();}
var time=(Number(date)+(offset*60*1000));this.setTime(Number(time));return true;}}
if(!Date.prototype.toISO8601String){Date.prototype.toISO8601String=function(format,offset){if(!format){var format=6;}
if(!offset){var offset='Z';var date=this;}else{var d=offset.match(/([-+])([0-9]{2}):([0-9]{2})/);var offsetnum=(Number(d[2])*60)+Number(d[3]);offsetnum*=((d[1]=='-')?-1:1);var date=new Date(Number(Number(this)+(offsetnum*60000)));}
var zeropad=function(num){return((num<10)?'0':'')+num;}
var str="";str+=date.getUTCFullYear();if(format>1){str+="-"+zeropad(date.getUTCMonth()+1);}
if(format>2){str+="-"+zeropad(date.getUTCDate());}
if(format>3){str+="T"+zeropad(date.getUTCHours())+":"+zeropad(date.getUTCMinutes());}
if(format>5){var secs=Number(date.getUTCSeconds()+"."+
((date.getUTCMilliseconds()<100)?'0':'')+
zeropad(date.getUTCMilliseconds()));str+=":"+zeropad(secs);}else if(format>4){str+=":"+zeropad(date.getUTCSeconds());}
if(format>3){str+=offset;}
return str;}}
if(!String.prototype.formatDate){String.prototype.formatDate=function(fmt){var s=this.replace(/-/g,'/');var d=new Date(s);return isNaN(d)?this:d.formatDate(fmt);}}
if(!Number.prototype.formatNumber){Number.prototype.formatNumber=function(fmt){if(isNaN(this))return'NaN';var n=this;if(typeof fmt.multiplier=='number')n*=fmt.multiplier;var decPlaces=typeof fmt.decPlaces=='number'?fmt.decPlaces:0;var thouSep=typeof fmt.thouSep=='string'?fmt.thouSep:RicoTranslate.thouSep;var decPoint=typeof fmt.decPoint=='string'?fmt.decPoint:RicoTranslate.decPoint;var prefix=fmt.prefix||"";var suffix=fmt.suffix||"";var negSign=typeof fmt.negSign=='string'?fmt.negSign:"L";negSign=negSign.toUpperCase();var s,cls;if(n<0.0){s=RicoUtil.formatPosNumber(-n,decPlaces,thouSep,decPoint);if(negSign=="P")s="("+s+")";s=prefix+s;if(negSign=="L")s="-"+s;if(negSign=="T")s+="-";cls='negNumber';}else{cls=n==0.0?'zeroNumber':'posNumber';s=prefix+RicoUtil.formatPosNumber(n,decPlaces,thouSep,decPoint);}
return"<span class='"+cls+"'>"+s+suffix+"</span>";}}
if(!String.prototype.formatNumber){String.prototype.formatNumber=function(fmt){var n=parseFloat(this);return isNaN(n)?this:n.formatNumber(fmt);}}
Rico.Shim=Class.create();if(Prototype.Browser.IE){Rico.Shim.prototype={initialize:function(DivRef){this.ifr=document.createElement('iframe');this.ifr.style.position="absolute";this.ifr.style.display="none";this.ifr.src="javascript:false;";DivRef.parentNode.appendChild(this.ifr);this.DivRef=DivRef;},hide:function(){this.ifr.style.display="none";},show:function(){this.ifr.style.width=this.DivRef.offsetWidth;this.ifr.style.height=this.DivRef.offsetHeight;this.ifr.style.top=this.DivRef.style.top;this.ifr.style.left=this.DivRef.style.left;this.ifr.style.zIndex=this.DivRef.currentStyle.zIndex-1;this.ifr.style.display="block";}}}else{Rico.Shim.prototype={initialize:function(){},hide:function(){},show:function(){}}}
Rico.Shadow=Class.create();Rico.Shadow.prototype={initialize:function(DivRef){this.div=document.createElement('div');this.div.style.position="absolute";if(typeof this.div.style.filter=='undefined'){new Image().src=Rico.imgDir+"shadow.png";new Image().src=Rico.imgDir+"shadow_ur.png";new Image().src=Rico.imgDir+"shadow_ll.png";this.createShadow();this.offset=5;}else{this.div.style.backgroundColor='#888';this.div.style.filter='progid:DXImageTransform.Microsoft.Blur(makeShadow=1, shadowOpacity=0.3, pixelRadius=3)';this.offset=0;}
this.div.style.display="none";DivRef.parentNode.appendChild(this.div);this.DivRef=DivRef;},createShadow:function(){var tab=document.createElement('table');tab.style.height='100%';tab.style.width='100%';tab.cellSpacing=0;tab.dir='ltr';var tr1=tab.insertRow(-1);tr1.style.height='8px';var td11=tr1.insertCell(-1);td11.style.width='8px';var td12=tr1.insertCell(-1);td12.style.background="transparent url("+Rico.imgDir+"shadow_ur.png"+") no-repeat right bottom"
var tr2=tab.insertRow(-1);var td21=tr2.insertCell(-1);td21.style.background="transparent url("+Rico.imgDir+"shadow_ll.png"+") no-repeat right bottom"
var td22=tr2.insertCell(-1);td22.style.background="transparent url("+Rico.imgDir+"shadow.png"+") no-repeat right bottom"
this.div.appendChild(tab);},hide:function(){this.div.style.display="none";},show:function(){this.div.style.width=this.DivRef.offsetWidth+'px';this.div.style.height=this.DivRef.offsetHeight+'px';this.div.style.top=(parseInt(this.DivRef.style.top)+this.offset)+'px';this.div.style.left=(parseInt(this.DivRef.style.left)+this.offset)+'px';this.div.style.zIndex=parseInt(Element.getStyle(this.DivRef,'z-index'))-1;this.div.style.display="block";}}
Rico.Popup=Class.create();Rico.Popup.prototype={initialize:function(options,DivRef){this.options={hideOnEscape:true,hideOnClick:true,ignoreClicks:false,position:'absolute',shadow:true}
Object.extend(this.options,options||{});if(DivRef)this.setDiv(DivRef);},setDiv:function(DivRef,closeFunc){this.divPopup=$(DivRef);var position=this.options.position=='auto'?Element.getStyle(this.divPopup,'position').toLowerCase():this.options.position;if(!this.divPopup||position!='absolute')return;this.closeFunc=closeFunc||this.closePopup.bindAsEventListener(this);this.shim=new Rico.Shim(this.divPopup);if(this.options.shadow)
this.shadow=new Rico.Shadow(this.divPopup);if(this.options.hideOnClick)
Event.observe(document,"click",this.closeFunc);if(this.options.hideOnEscape)
Event.observe(document,"keyup",this._checkKey.bindAsEventListener(this));if(this.options.ignoreClicks)this.ignoreClicks();},ignoreClicks:function(){Event.observe(this.divPopup,"click",this._ignoreClick.bindAsEventListener(this));},_ignoreClick:function(e){if(e.stopPropagation)
e.stopPropagation();else
e.cancelBubble=true;return true;},_checkKey:function(e){if(RicoUtil.eventKey(e)==27)this.closeFunc();return true;},openPopup:function(left,top){if(typeof left=='number')this.divPopup.style.left=left+'px';if(typeof top=='number')this.divPopup.style.top=top+'px';this.divPopup.style.display="block";if(this.shim)this.shim.show();if(this.shadow)this.shadow.show();},closePopup:function(){if(this.shim)this.shim.hide();if(this.shadow)this.shadow.hide();this.divPopup.style.display="none"}}
Rico.includeLoaded('ricoCommon.js');