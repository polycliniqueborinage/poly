DDT.agt=navigator.userAgent.toLowerCase();DDT.is_ie=((DDT.agt.indexOf("msie")!=-1)&&(DDT.agt.indexOf("opera")==-1));DDT.is_opera=(DDT.agt.indexOf("opera")!=-1);DDT.is_mac=(DDT.agt.indexOf("mac")!=-1);DDT.is_mac_ie=(DDT.is_ie&&DDT.is_mac);DDT.is_win_ie=(DDT.is_ie&&!DDT.is_mac);DDT.is_gecko=(navigator.product=="Gecko");function DDT(name)
{if(name!=undefined)
{this.name=name;}
else
{this.name="DDT";}
this.state="off";this.popup=null;}
DDT.prototype._ddtOn=function()
{if(this.popup==null)
{var window_name="ddt_popup_"+location.hostname.replace(/[.]/g,"_");if(DDT.is_gecko)
{this.popup=window.open("","ddt_popup_"+location.host,"toolbar=no,menubar=no,personalbar=no,width=800,height=450,"+"scrollbars=no,resizable=yes,modal=yes,dependable=yes");}
else
{this.popup=window.open("",window_name,"toolbar=no,location=no,directories=no,status=no,menubar=no,"+"scrollbars=no,resizable=yes,width=800,height=450");}
if((typeof this.popup=='undefined')||(this.popup==null))
{alert("FAILED TO OPEN DEBUGGING TRACE WINDOW");return false;}
if((this.popup!=null)&&(typeof this.popup.DDT_STATUS=='undefined'))
{var content="<html><head><title>Trace Messages for '"+location.host+"'</title></head><body><p>DDT</p><p><a href=\"javascript:document.write( '<hr>');\">ADD SEPARATOR</a></p></body></html>";this.popup.document.write(content);var header=this.popup.document.createElement("h3");var message=this.popup.document.createTextNode("_ddt Trace Messages");header.appendChild(message);this.popup.document.body.appendChild(header);this.popup.DDT_STATUS="ok";}}
this.state="on";return true;};DDT.prototype._ddtOff=function()
{this.state="off";return true;}
DDT.prototype._ddtToggle=function()
{if(this.state=="on")
this._ddtOff();else
this._ddtOn();return true;}
DDT.prototype._ddt=function(file,line,msg)
{if(this.state=="on")
{try
{this.popup.document.write("("+this.name+") "+file+":"+line+" - "+msg+"<br>\n");}
catch(e)
{}}
return true;}
DDT.prototype._ddtDumpNode=function(file,line,msg,node)
{if(typeof node=='undefined')
{this._ddt(file,line,msg+" -- Node is undefined!");return;}
if(node==null)
{this._ddt(file,line,msg+" -- Node is null!");}
this._ddt(file,line,msg+"<br>"+this.FragmentToString(node,0));}
DDT.prototype._ddtDumpObject=function(file,line,msg,obj)
{this._ddt(file,line,msg);if(typeof obj=='undefined')
{this._ddt(file,line,"Object is undefined!");}
for(var x in obj)
{if(typeof obj[x]=='string')
{this._ddt(file,line,"member - '"+x+"' = '"+obj[x].substr(0,40)+"'");}
else
{this._ddt(file,line,"member - '"+x+"'");}}
return true;}
DDT.prototype.FragmentToString=function(root,level)
{var retval="";if(typeof root=='undefined')
return" root undefined ";if(root==null)
return" root is null ";if(typeof root.cloneRange!='undefined')
{retval="RANGE OBJECT - start offset '"+root.startOffset+"' end offset '"+root.endOffset+"'<br>";retval+="RANGE START:<br>"+this.FragmentToString(root.startContainer,level);retval+="RANGE END:<br>"+this.FragmentToString(root.endContainer,level);return retval;}
if(typeof root.childNodes=='undefined')
return" root is not a node";var childretval="";var i=0;for(i=0;i<root.childNodes.length;i++)
{childretval+=this.FragmentToString(root.childNodes[i],level+2);}
retval=this.indent(level)+this._ddtGetNodeType(root)+" - "+root.childNodes.length+" children <br>"+childretval;return retval;};DDT.prototype.indent=function(level)
{var retval="";for(i=0;i<level;i++)
{retval+="&nbsp;&nbsp;";}
return retval;}
DDT.prototype._ddtGetNodeType=function(node)
{var retval="";if(typeof node=='undefined')
{return"TYPE_IS_UNDEFINED";}
if(node==null)
{return"TYPE_IS_NULL!";}
if(typeof node.nodeType=='undefined')
{return"NOT_A_NODE_OBJECT - type is '"+typeof node+"'";}
switch(node.nodeType)
{case 1:retval="ELEMENT_NODE - tag '"+node.nodeName+"'";return retval;break;case 2:return"ATTRIBUTE_NODE";break;case 3:retval="TEXT_NODE";retval=retval+" contents '"+node.nodeValue+"'";return retval;break;case 4:return"CDATA_SECTION_NODE";break;case 5:return"ENTITY_REFERENCE_NODE";break;case 6:return"ENTITY_NODE";break;case 7:return"PROCESSING_INSTRUCTION_NODE";break;case 8:return"COMMENT_NODE";break;case 9:return"DOCUMENT_NODE";break;case 10:return"DOCUMENT_TYPE_NODE";break;case 11:retval="DOCUMENT_FRAGMENT_NODE";return retval;break;case 12:return"NOTATION_NODE";break;default:return"UNKNOWN_NODE!";break;}
return"UNKNOWN_NODE!";};DDT.prototype.getHTMLSource=function(html)
{html=html.replace(/</ig,"&lt;");html=html.replace(/>/ig,"&gt;");html=html.replace(/&/ig,"&amp;");html=html.replace(/\xA0/g,"&nbsp;");html=html.replace(/\x22/g,"&quot;");return html;}
if(typeof _editor_url=="string")
{_editor_url=_editor_url.replace(/\x2f*$/,'/');}
else
{alert("WARNING: _editor_url is not set!  You should set this variable to the editor files path; it should preferably be an absolute path, like in '/htmlarea/', but it can be relative if you prefer.  Further we will try to load the editor files correctly but we'll probably fail.");_editor_url='';}
if(typeof _editor_lang=="string")
{_editor_lang=_editor_lang.toLowerCase();}
else
{_editor_lang="en";}
if(typeof _editor_backend!="string")
{var _editor_backend=_editor_url+"/backends/backend.php";}
var __htmlareas=[];HTMLArea._object=null;HTMLArea.uniq_count=0;HTMLArea._blockTags=" body form textarea fieldset ul ol dl li div "+"p h1 h2 h3 h4 h5 h6 quote pre table thead "+"tbody tfoot tr td th iframe address blockquote";HTMLArea._paraContainerTags=" body td th caption fieldset div";HTMLArea._closingTags=" head script style div span tr td tbody table em strong b i code cite dfn abbr acronym font a title ";HTMLArea.agt=navigator.userAgent.toLowerCase();HTMLArea.is_ie=((HTMLArea.agt.indexOf("msie")!=-1)&&(HTMLArea.agt.indexOf("opera")==-1));HTMLArea.is_opera=(HTMLArea.agt.indexOf("opera")!=-1);HTMLArea.is_mac=(HTMLArea.agt.indexOf("mac")!=-1);HTMLArea.is_mac_ie=(HTMLArea.is_ie&&HTMLArea.is_mac);HTMLArea.is_win_ie=(HTMLArea.is_ie&&!HTMLArea.is_mac);HTMLArea.is_gecko=(navigator.product=="Gecko");HTMLArea.RE_tagName=/(<\/|<)\s*([^ \t\n>]+)/ig;HTMLArea.RE_doctype=/(<!doctype((.|\n)*?)>)\n?/i;HTMLArea.RE_head=/<head>((.|\n)*?)<\/head>/i;HTMLArea.RE_body=/<body[^>]*>((.|\n)*?)<\/body>/i;HTMLArea.RE_Specials=/([\/\^$*+?.()|{}[\]])/g;HTMLArea.RE_email=/[a-z0-9_]{3,}@[a-z0-9_-]{2,}(\.[a-z0-9_-]{2,})+/i;HTMLArea.RE_url=/(https?:\/\/)?(([a-z0-9_]+:[a-z0-9_]+@)?[a-z0-9_-]{2,}(\.[a-z0-9_-]{2,}){2,}(:[0-9]+)?(\/\S+)*)/i;HTMLArea.onload=function(){};HTMLArea._scripts=[];HTMLArea.plugin_loadattempts=[];HTMLArea.maxloadattempts=10;HTMLArea._ddt=function(file,line,msg)
{if(typeof startupDDT!='undefined')
startupDDT._ddt(file,line,msg);}
HTMLArea.Config=function()
{var cfg=this;this.version="3.0";this.width="toolbar";this.height="auto";this.lang="en";this.lcBackend="lcbackend.php?lang=$lang&context=$context";this.statusBar=true;this.htmlareaPaste=false;this.mozParaHandler='best';this.undoSteps=20;this.undoTimeout=500;this.sizeIncludesToolbar=true;this.fullPage=false;this.pageStyle="";this.pageStyleSheets=[];this.linkReplacementMode='absolute';this.baseHref=null;this.stripBaseHref=true;this.stripSelfNamedAnchors=true;this.specialReplacements={};this.killWordOnPaste=true;this.makeLinkShowsTarget=true;this.baseURL=document.baseURI||document.URL;if(this.baseURL&&this.baseURL.match(/(.*)\/([^\/]+)/))
this.baseURL=RegExp.$1+"/";this.charSet=HTMLArea.is_gecko?document.characterSet:document.charset;this.imgURL="images/";this.popupURL="popups/";this.helpURL=_editor_url+"reference.html";this.htmlRemoveTags=null;this.toolbar=[["formatblock","fontname","fontsize","bold","italic","underline","strikethrough","separator"],["forecolor","hilitecolor","textindicator","separator"],["subscript","superscript"],["linebreak","justifyleft","justifycenter","justifyright","justifyfull","separator"],["insertorderedlist","insertunorderedlist","outdent","indent","separator"],["inserthorizontalrule","createlink","insertimage","inserttable","separator"],["undo","redo"],(HTMLArea.is_gecko?[]:["cut","copy","paste"]),["separator"],["killword","removeformat","toggleborders","lefttoright","righttoleft","separator","htmlmode","about"]];this.panel_dimensions={left:'200px',right:'200px',top:'100px',bottom:'100px'};this.fontname={"&mdash; font &mdash;":'',"Arial":'arial,helvetica,sans-serif',"Courier New":'courier new,courier,monospace',"Georgia":'georgia,times new roman,times,serif',"Tahoma":'tahoma,arial,helvetica,sans-serif',"Times New Roman":'times new roman,times,serif',"Verdana":'verdana,arial,helvetica,sans-serif',"impact":'impact',"WingDings":'wingdings'};this.fontsize={"&mdash; size &mdash;":"","1 (8 pt)":"1","2 (10 pt)":"2","3 (12 pt)":"3","4 (14 pt)":"4","5 (18 pt)":"5","6 (24 pt)":"6","7 (36 pt)":"7"};this.formatblock={"&mdash; format &mdash;":"","Heading 1":"h1","Heading 2":"h2","Heading 3":"h3","Heading 4":"h4","Heading 5":"h5","Heading 6":"h6","Normal":"p","Address":"address","Formatted":"pre"};this.customSelects={};function cut_copy_paste(e,cmd,obj)
{e.execCommand(cmd);};this.debug=true;this.URIs={"blank":"popups/blank.html","link":"link.html","insert_image":"insert_image.html","insert_table":"insert_table.html","select_color":"select_color.html","fullscreen":"fullscreen.html","about":"about.html","mozilla_security":"http://mozilla.org/editor/midasdemo/securityprefs.html"};this.btnList={bold:["Bold",["ed_buttons_main.gif",3,2],false,function(e){e.execCommand("bold");}],italic:["Italic",["ed_buttons_main.gif",2,2],false,function(e){e.execCommand("italic");}],underline:["Underline",["ed_buttons_main.gif",2,0],false,function(e){e.execCommand("underline");}],strikethrough:["Strikethrough",["ed_buttons_main.gif",3,0],false,function(e){e.execCommand("strikethrough");}],subscript:["Subscript",["ed_buttons_main.gif",3,1],false,function(e){e.execCommand("subscript");}],superscript:["Superscript",["ed_buttons_main.gif",2,1],false,function(e){e.execCommand("superscript");}],justifyleft:["Justify Left",["ed_buttons_main.gif",0,0],false,function(e){e.execCommand("justifyleft");}],justifycenter:["Justify Center",["ed_buttons_main.gif",1,1],false,function(e){e.execCommand("justifycenter");}],justifyright:["Justify Right",["ed_buttons_main.gif",1,0],false,function(e){e.execCommand("justifyright");}],justifyfull:["Justify Full",["ed_buttons_main.gif",0,1],false,function(e){e.execCommand("justifyfull");}],orderedlist:["Ordered List",["ed_buttons_main.gif",0,3],false,function(e){e.execCommand("insertorderedlist");}],unorderedlist:["Bulleted List",["ed_buttons_main.gif",1,3],false,function(e){e.execCommand("insertunorderedlist");}],insertorderedlist:["Ordered List",["ed_buttons_main.gif",0,3],false,function(e){e.execCommand("insertorderedlist");}],insertunorderedlist:["Bulleted List",["ed_buttons_main.gif",1,3],false,function(e){e.execCommand("insertunorderedlist");}],outdent:["Decrease Indent",["ed_buttons_main.gif",1,2],false,function(e){e.execCommand("outdent");}],indent:["Increase Indent",["ed_buttons_main.gif",0,2],false,function(e){e.execCommand("indent");}],forecolor:["Font Color",["ed_buttons_main.gif",3,3],false,function(e){e.execCommand("forecolor");}],hilitecolor:["Background Color",["ed_buttons_main.gif",2,3],false,function(e){e.execCommand("hilitecolor");}],undo:["Undoes your last action",["ed_buttons_main.gif",4,2],false,function(e){e.execCommand("undo");}],redo:["Redoes your last action",["ed_buttons_main.gif",5,2],false,function(e){e.execCommand("redo");}],cut:["Cut selection",["ed_buttons_main.gif",5,0],false,cut_copy_paste],copy:["Copy selection",["ed_buttons_main.gif",4,0],false,cut_copy_paste],paste:["Paste from clipboard",["ed_buttons_main.gif",4,1],false,cut_copy_paste],inserthorizontalrule:["Horizontal Rule",["ed_buttons_main.gif",6,0],false,function(e){e.execCommand("inserthorizontalrule");}],createlink:["Insert Web Link",["ed_buttons_main.gif",6,1],false,function(e){e._createLink();}],insertimage:["Insert/Modify Image",["ed_buttons_main.gif",6,3],false,function(e){e.execCommand("insertimage");}],inserttable:["Insert Table",["ed_buttons_main.gif",6,2],false,function(e){e.execCommand("inserttable");}],htmlmode:["Toggle HTML Source",["ed_buttons_main.gif",7,0],true,function(e){e.execCommand("htmlmode");}],toggleborders:["Toggle Borders",["ed_buttons_main.gif",7,2],false,function(e){e._toggleBorders()}],print:["Print document",["ed_buttons_main.gif",8,1],false,function(e){e._iframe.contentWindow.print();}],popupeditor:["Enlarge Editor","fullscreen_maximize.gif",true,function(e,objname,obj)
{e.execCommand("popupeditor");}],about:["About this editor",["ed_buttons_main.gif",8,2],true,function(e){e.execCommand("about");}],showhelp:["Help using editor",["ed_buttons_main.gif",9,2],true,function(e){e.execCommand("showhelp");}],splitblock:["Split Block","ed_splitblock.gif",false,function(e){e._splitBlock();}],lefttoright:["Direction left to right",["ed_buttons_main.gif",0,4],false,function(e){e.execCommand("lefttoright");}],righttoleft:["Direction right to left",["ed_buttons_main.gif",1,4],false,function(e){e.execCommand("righttoleft");}],wordclean:["MS Word Cleaner",["ed_buttons_main.gif",5,3],false,function(e){e._wordClean();}],clearfonts:["Clear Inline Font Specifications",["ed_buttons_main.gif",5,4],false,function(e){e._clearFonts();}],removeformat:["Remove formatting",["ed_buttons_main.gif",4,4],false,function(e){e.execCommand("removeformat");}],killword:["Clear MSOffice tags",["ed_buttons_main.gif",4,3],false,function(e){e.execCommand("killword");}]};for(var i in this.btnList)
{var btn=this.btnList[i];if(typeof btn[1]!='string')
{btn[1][0]=_editor_url+this.imgURL+btn[1][0];}
else
{btn[1]=_editor_url+this.imgURL+btn[1];}
btn[0]=HTMLArea._lc(btn[0]);}};HTMLArea.Config.prototype.registerButton=function(id,tooltip,image,textMode,action,context)
{var the_id;if(typeof id=="string")
{the_id=id;}
else if(typeof id=="object")
{the_id=id.id;}
else
{alert("ERROR [HTMLArea.Config::registerButton]:\ninvalid arguments");return false;}
if(typeof this.customSelects[the_id]!="undefined")
{HTMLArea._ddt("htmlarea.js","772","registerButton(): WARNING [HTMLArea.Config::registerDropdown]: A dropdown with the same ID already exists.");}
if(typeof this.btnList[the_id]!="undefined")
{HTMLArea._ddt("htmlarea.js","778","registerbutton(): WARNING [HTMLArea.Config::registerDropdown]:A button with the same ID already exists.");}
switch(typeof id)
{case"string":this.btnList[id]=[tooltip,image,textMode,action,context];break;case"object":this.btnList[id.id]=[id.tooltip,id.image,id.textMode,id.action,id.context];break;}
return true;};HTMLArea.Config.prototype.registerDropdown=function(object)
{if(typeof this.customSelects[object.id]!="undefined")
{HTMLArea._ddt("htmlarea.js","810","registerDropdown(): WARNING [HTMLArea.Config::registerDropdown]:\nA dropdown with the same ID already exists.");}
if(typeof this.btnList[object.id]!="undefined")
{HTMLArea._ddt("htmlarea.js","816","registerDropdown(): WARNING [HTMLArea.Config::registerDropdown]:\nA button with the same ID already exists.");}
this.customSelects[object.id]=object;};HTMLArea.Config.prototype.hideSomeButtons=function(remove)
{var toolbar=this.toolbar;for(var i=toolbar.length;--i>=0;)
{var line=toolbar[i];for(var j=line.length;--j>=0;)
{if(remove.indexOf(" "+line[j]+" ")>=0)
{var len=1;if(/separator|space/.test(line[j+1]))
{len=2;}
line.splice(j,len);}}}};HTMLArea.loadScript=function(url,plugin)
{HTMLArea._ddt("htmlarea.js","876","loadScript(): Top with url '"+url+"' and plugin '"+plugin+"'");if(plugin)
{url=HTMLArea.getPluginDir(plugin)+'/'+url;}
this._scripts.push(url);};if(typeof DDT=='undefined')
HTMLArea.loadScript(_editor_url+"ddt.js");HTMLArea.loadScript(_editor_url+"dialog.js");HTMLArea.loadScript(_editor_url+"inline-dialog.js");HTMLArea.loadScript(_editor_url+"popupwin.js");HTMLArea.init=function()
{HTMLArea._ddt("htmlarea.js","920","init(): top");var head=document.getElementsByTagName("head")[0];var current=0;var savetitle=document.title;var evt=HTMLArea.is_ie?"onreadystatechange":"onload";function loadNextScript()
{if(current>0&&HTMLArea.is_ie&&!/loaded|complete/.test(window.event.srcElement.readyState))
{HTMLArea._ddt("htmlarea.js","946","init(): MSIE ready state not ready '"+window.event.srcElement.readyState+"'");return;}
if(current<HTMLArea._scripts.length)
{var url=HTMLArea._scripts[current++];document.title="[HTMLArea: loading script "+current+"/"+HTMLArea._scripts.length+"]";var script=document.createElement("script");script.type="text/javascript";script.src=url;HTMLArea._ddt("htmlarea.js","964","loadNextScript(): loading '"+url+"'");script[evt]=loadNextScript;head.appendChild(script);}
else
{document.title=savetitle;HTMLArea._ddt("htmlarea.js","975","loadNextScript(): end of list reached. Firing HTMLAreaonLoad handler");HTMLArea.onload();}};HTMLArea._ddt("htmlarea.js","985","init(): calling first loadNextScript()");loadNextScript();};HTMLArea.replaceAll=function(config)
{HTMLArea._ddt("htmlarea.js","1002","replaceAll(): top");var tas=document.getElementsByTagName("textarea");for(var i=tas.length;i>0;(new HTMLArea(tas[--i],config)).generate());};HTMLArea.replace=function(id,config)
{HTMLArea._ddt("htmlarea.js","1017","replace(): top with id '"+id+"'");var ta=HTMLArea.getElementById("textarea",id);if(ta)
{var taobj=new HTMLArea(ta,config);taobj.generate();return taobj;}
return null;};var use_clone_img=false;HTMLArea.makeBtnImg=function(imgDef,doc)
{HTMLArea._ddt("htmlarea.js","1046","makeBtnImg(): top");if(!doc)doc=document;if(!doc._htmlareaImgCache)
{doc._htmlareaImgCache={};}
var i_contain=null;if(HTMLArea.is_ie&&((!doc.compatMode)||(doc.compatMode&&doc.compatMode=="BackCompat")))
{i_contain=doc.createElement('span');}
else
{i_contain=doc.createElement('div');i_contain.style.position='relative';}
i_contain.style.overflow='hidden';i_contain.style.width="18px";i_contain.style.height="18px";var img=null;if(typeof imgDef=='string')
{if(doc._htmlareaImgCache[imgDef])
{img=doc._htmlareaImgCache[imgDef].cloneNode();}
else
{img=doc.createElement("img");img.src=imgDef;img.style.width="18px";img.style.height="18px";if(use_clone_img)
doc._htmlareaImgCache[imgDef]=img.cloneNode();}}
else
{if(doc._htmlareaImgCache[imgDef[0]])
{img=doc._htmlareaImgCache[imgDef[0]].cloneNode();}
else
{img=doc.createElement("img");img.src=imgDef[0];img.style.position='relative';if(use_clone_img)
doc._htmlareaImgCache[imgDef[0]]=img.cloneNode();}
img.style.top=imgDef[2]?('-'+(18*(imgDef[2]+1))+'px'):'-18px';img.style.left=imgDef[1]?('-'+(18*(imgDef[1]+1))+'px'):'-18px';}
i_contain.appendChild(img);HTMLArea._ddt("htmlarea.js","1114","makeBtnImg(): bottom");return i_contain;}
HTMLArea.getPluginDir=function(pluginName)
{return _editor_url+"plugins/"+pluginName;};HTMLArea.loadPlugin=function(pluginName,callback)
{HTMLArea._ddt("htmlarea.js","1148","loadPlugin(): loading plugin '"+pluginName+"'");if(eval('typeof '+pluginName)!='undefined')
{HTMLArea._ddt("htmlarea.js","1155","loadPlugin(): plugin '"+pluginName+"' already loaded");if(callback)
{HTMLArea._ddt("htmlarea.js","1160","loadPlugin(): calling plugin '"+pluginName+"' callback");callback();}
return;}
var dir=this.getPluginDir(pluginName);var plugin=pluginName.replace(/([a-z])([A-Z])([a-z])/g,function(str,l1,l2,l3)
{return l1+"-"+l2.toLowerCase()+l3;}).toLowerCase()+".js";var plugin_file=dir+"/"+plugin;if(typeof HTMLArea.plugin_loadattempts[pluginName]=='undefined')
{HTMLArea.plugin_loadattempts[pluginName]=1;}
else
{HTMLArea.plugin_loadattempts[pluginName]++;}
HTMLArea._ddt("htmlarea.js","1197","loadPlugin(): Attempt #"+HTMLArea.plugin_loadattempts[pluginName]+" for plugin '"+pluginName+"'");if(HTMLArea.plugin_loadattempts[pluginName]>HTMLArea.maxloadattempts)
{alert("ERROR unsuccessfully attempted to load plugin '"+pluginName+"' '"+HTMLArea.maxloadattempts+"' times. It probably contains an error. Please check your javascript console for details");return false;}
if(callback)
{HTMLArea._ddt("htmlarea.js","1207","loadPlugin(): callback defined. Using _loadback() to load plugin");HTMLArea._loadback(plugin_file,callback);}
else
{HTMLArea._ddt("htmlarea.js","1213","loadPlugin(): callback not defined. writing javascript include line to document.");document.write("<script type='text/javascript' src='"+plugin_file+"'></script>");}
return true;}
HTMLArea.loadPlugins=function(plugins,callbackIfNotReady)
{HTMLArea._ddt("htmlarea.js","1237","loadPlugins(): top - cloning plugins array.");var nuPlugins=HTMLArea.cloneObject(plugins);while(nuPlugins.length)
{if(eval('typeof '+nuPlugins[nuPlugins.length-1])!='undefined')
{var poppedPlugin=nuPlugins.pop();HTMLArea._ddt("htmlarea.js","1254","loadPlugins(): plugin '"+poppedPlugin+"' was already loaded");}
else
{break;}}
if(!nuPlugins.length)
{HTMLArea._ddt("htmlarea.js","1269","loadPlugins(): no plugins left to load");return true;}
HTMLArea.loadPlugin(nuPlugins.pop(),function()
{if(HTMLArea.loadPlugins(nuPlugins,callbackIfNotReady))
{if(typeof callbackIfNotReady=='function')
{callbackIfNotReady();}}});HTMLArea._ddt("htmlarea.js","1298","loadPlugins(): end");return false;}
HTMLArea.refreshPlugin=function(plugin)
{HTMLArea._ddt("htmlarea.js","1313","refreshPlugin(): top");if(typeof plugin.onGenerate=="function")
{HTMLArea._ddt("htmlarea.js","1317","refreshPlugin(): onGenerate is a function. calling onGenerate for '"+plugin+"'");plugin.onGenerate();}
if(typeof plugin.onGenerateOnce=="function")
{HTMLArea._ddt("htmlarea.js","1323","refreshPlugin(): onGenerateOnce is a function. calling onGenerateOnce for '"+plugin+"'");plugin.onGenerateOnce();plugin.onGenerateOnce=null;}};HTMLArea.loadStyle=function(style,plugin)
{var url=_editor_url||'';HTMLArea._ddt("htmlarea.js","1340","loadStyle(): top with style '"+style+"' and plugin '"+plugin+"'");if(typeof plugin!="undefined")
{url+="plugins/"+plugin+"/";}
url+=style;if(/^\//.test(style))
url=style;var head=document.getElementsByTagName("head")[0];var link=document.createElement("link");link.rel="stylesheet";link.href=url;head.appendChild(link);HTMLArea._ddt("htmlarea.js","1358","loadStyle(): appending '"+link.href+"' to document");};HTMLArea.loadStyle(typeof _editor_css=="string"?_editor_css:"htmlarea.css");HTMLArea.objectProperties=function(obj)
{var props=[];for(var x in obj)
{props[props.length]=x;}
return props;}
HTMLArea.getInnerText=function(el)
{HTMLArea._ddt("htmlarea.js","1391","getInnerText(): top");var txt='',i;for(i=el.firstChild;i;i=i.nextSibling)
{if(i.nodeType==3)
txt+=i.data;else if(i.nodeType==1)
txt+=HTMLArea.getInnerText(i);}
return txt;};HTMLArea.cloneObject=function(obj)
{HTMLArea._ddt("htmlarea.js","1419","cloneObject(): top");if(!obj)return null;var newObj=new Object;if(obj.constructor.toString().indexOf("function Array(")!=-1)
{HTMLArea._ddt("htmlarea.js","1432","cloneObject(): contructing an array object.");newObj=obj.constructor();}
if(obj.constructor.toString().indexOf("function Function(")!=-1)
{HTMLArea._ddt("htmlarea.js","1441","cloneObject(): cloning an function object.");newObj=obj;}
else
{HTMLArea._ddt("htmlarea.js","1448","cloneObject(): copying object members.");for(var n in obj)
{var node=obj[n];if(typeof node=='object')
{newObj[n]=HTMLArea.cloneObject(node);}
else
{newObj[n]=node;}}}
return newObj;};HTMLArea.checkSupportedBrowser=function()
{HTMLArea._ddt("htmlarea.js","1481","checkSupportedBrowser(): top");if(HTMLArea.is_gecko)
{if(navigator.productSub<20021201)
{alert("You need at least Mozilla-1.3 Alpha.\n"+"Sorry, your Gecko is not supported.");return false;}
if(navigator.productSub<20030210)
{alert("Mozilla < 1.3 Beta is not supported!\n"+"I'll try, though, but it might not work.");}}
return HTMLArea.is_gecko||HTMLArea.is_ie;};HTMLArea.getElementById=function(tag,id)
{HTMLArea._ddt("htmlarea.js","1517","getElementById(): top with tag '"+tag+"' id '"+id+"'");var el,i,objs=document.getElementsByTagName(tag);for(i=objs.length;--i>=0&&(el=objs[i]);)
if(el.id==id)
return el;return null;};HTMLArea._postback=function(url,data,handler)
{HTMLArea._ddt("htmlarea.js","1539","_postback() : top with url '"+url+"'");var req=null;if(HTMLArea.is_ie)
{req=new ActiveXObject("Microsoft.XMLHTTP");}
else
{req=new XMLHttpRequest();}
var content='';for(var i in data)
{content+=(content.length?'&':'')+i+'='+encodeURIComponent(data[i]);}
function callBack()
{if(req.readyState==4)
{if(req.status==200)
{if(typeof handler=='function')
handler(req.responseText,req);}
else
{alert('An error has occurred: '+req.statusText);}}}
req.onreadystatechange=callBack;req.open('POST',url,true);req.setRequestHeader('Content-Type','application/x-www-form-urlencoded; charset=UTF-8');req.send(content);}
HTMLArea._getback=function(url,handler)
{HTMLArea._ddt("htmlarea.js","1591","_getback(): top");var req=null;if(HTMLArea.is_ie)
{req=new ActiveXObject("Microsoft.XMLHTTP");}
else
{req=new XMLHttpRequest();}
function callBack()
{try
{if(req.readyState==4)
{if(req.status==200)
{handler(req.responseText,req);}
else
{alert('An error has occurred: '+req.statusText);}}}
catch(e)
{}}
req.onreadystatechange=callBack;req.open('GET',url,true);req.send(null);}
HTMLArea._geturlcontent=function(url)
{HTMLArea._ddt("htmlarea.js","1651","_geturlcontent(): top with url '"+url+"'");var req=null;if(HTMLArea.is_ie)
{req=new ActiveXObject("Microsoft.XMLHTTP");}
else
{req=new XMLHttpRequest();}
req.open('GET',url,false);req.send(null);if(req.status==200)
{return req.responseText;}
else
{return'';}}
HTMLArea.arrayContainsArray=function(a1,a2)
{HTMLArea._ddt("htmlarea.js","1686","arrayContainsArray(): top");var all_found=true;for(var x=0;x<a2.length;x++)
{var found=false;for(var i=0;i<a1.length;i++)
{if(a1[i]==a2[x])
{found=true;break;}}
if(!found)
{all_found=false;break;}}
return all_found;}
HTMLArea.arrayFilter=function(a1,filterfn)
{HTMLArea._ddt("htmlarea.js","1721","arrayFilter(): top");var new_a=[];for(var x=0;x<a1.length;x++)
{if(filterfn(a1[x]))
new_a[new_a.length]=a1[x];}
return new_a;}
HTMLArea.uniq=function(prefix)
{return prefix+HTMLArea.uniq_count++;}
HTMLArea._loadlang=function(context)
{HTMLArea._ddt("htmlarea.js","1758","_loadlang(): top");var url;if(typeof _editor_lcbackend=="string")
{url=_editor_lcbackend;url=url.replace(/%lang%/,_editor_lang);url=url.replace(/%context%/,context);}
else
{if(context!='HTMLArea')
{url=_editor_url+"/plugins/"+context+"/lang/"+_editor_lang+".js";}
else
{url=_editor_url+"/lang/"+_editor_lang+".js";}}
var lang;var langData=HTMLArea._geturlcontent(url);if(langData!="")
{try
{eval('lang = '+langData);}
catch(Error)
{alert('Error reading Language-File ('+url+'):\n'+Error.toString());lang={}}}
else
{lang={};}
return lang;}
HTMLArea._lc=function(string,context)
{HTMLArea._ddt("htmlarea.js","1817","_lc: top with string '"+string+"'");if(_editor_lang=="en")
{return string;}
if(typeof HTMLArea._lc_catalog=='undefined')
{HTMLArea._lc_catalog=[];}
if(typeof context=='undefined')
{context='HTMLArea';}
if(typeof HTMLArea._lc_catalog[context]=='undefined')
{HTMLArea._lc_catalog[context]=HTMLArea._loadlang(context);}
if(typeof HTMLArea._lc_catalog[context][string]=='undefined')
{return string;}
else
{return HTMLArea._lc_catalog[context][string];}}
HTMLArea.hasDisplayedChildren=function(el)
{HTMLArea._ddt("htmlarea.js","1859","hasDisplayedChildren(): top");var children=el.childNodes;for(var i=0;i<children.length;i++)
{if(children[i].tagName)
{if(children[i].style.display!='none')
{return true;}}}
return false;}
HTMLArea._loadback=function(src,callback)
{HTMLArea._ddt("htmlarea.js","1889","_loadback(): top with src '"+src+"'");var head=document.getElementsByTagName("head")[0];var evt=HTMLArea.is_ie?"onreadystatechange":"onload";var script=document.createElement("script");script.type="text/javascript";script.src=src;script[evt]=function()
{if(HTMLArea.is_ie&&!/loaded|complete/.test(window.event.srcElement.readyState))return;callback();}
head.appendChild(script);HTMLArea._ddt("htmlarea.js","1911","_loadback(): script tag to load javascript file appended to head section.");};HTMLArea.collectionToArray=function(collection)
{HTMLArea._ddt("htmlarea.js","1924","collectionToArray(): top");var array=[];for(var i=0;i<collection.length;i++)
{array.push(collection.item(i));}
return array;}
HTMLArea.makeEditors=function(editor_names,default_config,plugin_names)
{HTMLArea._ddt("htmlarea.js","1944","makeEditors(): top");if(typeof default_config=='function')
{HTMLArea._ddt("htmlarea.js","1949","makeEditors(): default config is a function");default_config=default_config();}
var editors={};for(var x=0;x<editor_names.length;x++)
{HTMLArea._ddt("htmlarea.js","1957","makeEditors(): making editor '"+editor_names[x]+"' and copying in cloned default_config");editors[editor_names[x]]=new HTMLArea(editor_names[x],HTMLArea.cloneObject(default_config));if(plugin_names)
{for(var i=0;i<plugin_names.length;i++)
{HTMLArea._ddt("htmlarea.js","1966","makeEditors(): registering plugin '"+plugin_names[i]+"' for editor '"+editor_names[x]+"'");editors[editor_names[x]].registerPlugin(eval(plugin_names[i]));}}}
return editors;}
HTMLArea.startEditors=function(editors)
{HTMLArea._ddt("htmlarea.js","1988","startEditors(): top");for(var i in editors)
{if(editors[i].generate)editors[i].generate();}}
HTMLArea._makeColor=function(v)
{HTMLArea._ddt("htmlarea.js","2007","_makeColor(): top");if(typeof v!="number")
{return v;}
var r=v&0xFF;var g=(v>>8)&0xFF;var b=(v>>16)&0xFF;return"rgb("+r+","+g+","+b+")";};HTMLArea._colorToRgb=function(v)
{if(!v)
return'';var r;var g;var b;function hex(d)
{return(d<16)?("0"+d.toString(16)):d.toString(16);};if(typeof v=="number")
{r=v&0xFF;g=(v>>8)&0xFF;b=(v>>16)&0xFF;return"#"+hex(r)+hex(g)+hex(b);}
if(v.substr(0,3)=="rgb")
{var re=/rgb\s*\(\s*([0-9]+)\s*,\s*([0-9]+)\s*,\s*([0-9]+)\s*\)/;if(v.match(re))
{r=parseInt(RegExp.$1);g=parseInt(RegExp.$2);b=parseInt(RegExp.$3);return"#"+hex(r)+hex(g)+hex(b);}
return null;}
if(v.substr(0,1)=="#")
{return v;}
return null;};HTMLArea.isBlockElement=function(el)
{return el&&el.nodeType==1&&(HTMLArea._blockTags.indexOf(" "+el.tagName.toLowerCase()+" ")!=-1);};HTMLArea.isParaContainer=function(el)
{return el&&el.nodeType==1&&(HTMLArea._paraContainerTags.indexOf(" "+el.tagName.toLowerCase()+" ")!=-1);}
HTMLArea.needsClosingTag=function(el)
{return el&&el.nodeType==1&&(HTMLArea._closingTags.indexOf(" "+el.tagName.toLowerCase()+" ")!=-1);};HTMLArea.htmlEncode=function(str)
{if(typeof str.replace=='undefined')str=str.toString();str=str.replace(/&/ig,"&amp;");str=str.replace(/</ig,"&lt;");str=str.replace(/>/ig,"&gt;");str=str.replace(/\xA0/g,"&nbsp;");str=str.replace(/\x22/g,"&quot;");return str;};HTMLArea.getHTML=function(root,outputRoot,editor)
{HTMLArea._ddt("htmlarea.js","2157","getHTML(): top");try
{return HTMLArea.getHTMLWrapper(root,outputRoot,editor);}
catch(e)
{alert('Your Document is not well formed. Check JavaScript console for details.');return editor._iframe.contentWindow.document.body.innerHTML;}}
HTMLArea.getHTMLWrapper=function(root,outputRoot,editor)
{HTMLArea._ddt("htmlarea.js","2182","getHTMLWrapper(): top");var html="";switch(root.nodeType)
{case 10:case 6:case 12:break;case 2:break;case 4:html+='<![CDATA['+root.data+']]>';break;case 5:html+='&'+root.nodeValue+';';break;case 7:html+='<?'+root.target+' '+root.data+' ?>';break;case 1:case 11:case 9:{var closed;var i;var root_tag=(root.nodeType==1)?root.tagName.toLowerCase():'';if(outputRoot)
{outputRoot=!(editor.config.htmlRemoveTags&&editor.config.htmlRemoveTags.test(root_tag));}
if(HTMLArea.is_ie&&root_tag=="head")
{if(outputRoot)
{html+="<head>";}
var save_multiline=RegExp.multiline;RegExp.multiline=true;var txt=root.innerHTML.replace(HTMLArea.RE_tagName,function(str,p1,p2)
{return p1+p2.toLowerCase();});RegExp.multiline=save_multiline;html+=txt;if(outputRoot)
{html+="</head>";}
break;}
else if(outputRoot)
{closed=(!(root.hasChildNodes()||HTMLArea.needsClosingTag(root)));html="<"+root.tagName.toLowerCase();var attrs=root.attributes;for(i=0;i<attrs.length;++i)
{var a=attrs.item(i);if(!a.specified)
{continue;}
var name=a.nodeName.toLowerCase();if(/_moz_editor_bogus_node/.test(name))
{html="";break;}
if(/(_moz)|(contenteditable)|(_msh)/.test(name))
{continue;}
var value;if(name!="style")
{if(typeof root[a.nodeName]!="undefined"&&name!="href"&&name!="src"&&!/^on/.test(name))
{value=root[a.nodeName];}
else
{value=a.nodeValue;if(HTMLArea.is_ie&&(name=="href"||name=="src"))
{HTMLArea._ddt("htmlarea.js","2329","getHTMLWrapper(): because we are ie and have an href or src attribute we are calling stripBaseUrl");value=editor.stripBaseURL(value);}}}
else
{value=root.style.cssText;}
if(/^(_moz)?$/.test(value))
{continue;}
html+=" "+name+'="'+HTMLArea.htmlEncode(value)+'"';}
if(html!="")
{html+=closed?" />":">";}}
for(i=root.firstChild;i;i=i.nextSibling)
{html+=HTMLArea.getHTMLWrapper(i,true,editor);}
if(outputRoot&&!closed)
{html+="</"+root.tagName.toLowerCase()+">";}
break;}
case 3:html=/^script|style$/i.test(root.parentNode.tagName)?root.data:HTMLArea.htmlEncode(root.data);break;case 8:html="<!--"+root.data+"-->";break;}
return html;};HTMLArea.addClasses=function(el,classes)
{HTMLArea._ddt("htmlarea.js","2403","addClasses(): top");if(el!=null)
{var thiers=el.className.trim().split(' ');var ours=classes.split(' ');for(var x=0;x<ours.length;x++)
{var exists=false;for(var i=0;exists==false&&i<thiers.length;i++)
{if(thiers[i]==ours[x])
{exists=true;}}
if(exists==false)
{thiers[thiers.length]=ours[x];}}
el.className=thiers.join(' ').trim();}}
HTMLArea.removeClasses=function(el,classes)
{HTMLArea._ddt("htmlarea.js","2437","removeClasses(): top");var existing=el.className.trim().split();var new_classes=[];var remove=classes.trim().split();for(var i=0;i<existing.length;i++)
{var found=false;for(var x=0;x<remove.length&&!found;x++)
{if(existing[i]==remove[x])
{found=true;}}
if(!found)
{new_classes[new_classes.length]=existing[i];}}
return new_classes.join(' ');}
HTMLArea._addClass=function(el,className)
{HTMLArea._removeClass(el,className);el.className+=" "+className;};HTMLArea._hasClass=function(el,className)
{if(!(el&&el.className))
{return false;}
var cls=el.className.split(" ");for(var i=cls.length;i>0;)
{if(cls[--i]==className)
{return true;}}
return false;};HTMLArea._removeClass=function(el,className)
{if(!(el&&el.className))
{return;}
var cls=el.className.split(" ");var ar=new Array();for(var i=cls.length;i>0;)
{if(cls[--i]!=className)
{ar[ar.length]=cls[i];}}
el.className=ar.join(" ");};HTMLArea.addClass=HTMLArea._addClass;HTMLArea.removeClass=HTMLArea._removeClass;HTMLArea._addClasses=HTMLArea.addClasses;HTMLArea._removeClasses=HTMLArea.removeClasses;HTMLArea._addEvent=function(el,evname,func)
{HTMLArea._ddt("htmlarea.js","2550","_addEvent(): adding event for '"+evname+"' func '"+func.toString().substring(0,100)+"'");if(HTMLArea.is_ie)
{el.attachEvent("on"+evname,func);}
else
{el.addEventListener(evname,func,true);}};HTMLArea._addEvents=function(el,evs,func)
{for(var i=evs.length;--i>=0;)
{HTMLArea._addEvent(el,evs[i],func);}};HTMLArea._removeEvent=function(el,evname,func)
{if(HTMLArea.is_ie)
{el.detachEvent("on"+evname,func);}
else
{el.removeEventListener(evname,func,true);}};HTMLArea._removeEvents=function(el,evs,func)
{for(var i=evs.length;--i>=0;)
{HTMLArea._removeEvent(el,evs[i],func);}};HTMLArea._stopEvent=function(ev)
{if(HTMLArea.is_ie)
{ev.cancelBubble=true;ev.returnValue=false;}
else
{ev.preventDefault();ev.stopPropagation();}};function HTMLArea(textarea,config)
{if(HTMLArea.checkSupportedBrowser())
{if(typeof config=="undefined")
{this.config=new HTMLArea.Config();}
else
{this.config=config;}
this.ddt=new DDT(textarea);this.ddt._ddt("htmlarea.js","2675","HTMLArea(): DDT Trace System Initialized.");this._htmlArea=null;this._textArea=textarea;this._editMode="wysiwyg";this.plugins={};this._timerToolbar=null;this._timerUndo=null;this._undoQueue=new Array(this.config.undoSteps);this._undoPos=-1;this._customUndo=true;this._mdoc=document;this.doctype='';this.__htmlarea_id_num=__htmlareas.length;__htmlareas[this.__htmlarea_id_num]=this;this._notifyListeners={};var panels=this._panels={right:{on:true,div:document.createElement('div'),panels:[]},left:{on:true,div:document.createElement('div'),panels:[]},top:{on:true,div:document.createElement('div'),panels:[]},bottom:{on:true,div:document.createElement('div'),panels:[]}};for(var i in panels)
{panels[i].div.className='panels '+i;}}
this.ddt._ddt("htmlarea.js","2729","HTMLArea(): end");};HTMLArea.prototype._createToolbar=function()
{this.ddt._ddt("htmlarea.js","2742","_createToolbar(): top");var editor=this;var toolbar=document.createElement("div");this._toolbar=toolbar;toolbar.className="toolbar";toolbar.unselectable="1";var tb_row=null;var tb_objects=new Object();this._toolbarObjects=tb_objects;this._createToolbar1(editor,toolbar,tb_objects);this._htmlArea.appendChild(toolbar);}
HTMLArea.prototype.registerPanel=function(side,object)
{this.ddt._ddt("htmlarea.js","2769","registerPanel(): top with side '"+side+"'");if(!side)side='right';var panel=this.addPanel(side);if(object)
{object.drawPanelIn(panel);}}
HTMLArea.prototype._setConfig=function(config)
{this.config=config;}
HTMLArea.prototype._addToolbar=function()
{this._createToolbar1(this,this._toolbar,this._toolbarObjects);}
var tb_row;HTMLArea.prototype._createToolbar1=function(editor,toolbar,tb_objects)
{this.ddt._ddt("htmlarea.js","2814","_createToolbar1(): top");function newLine(editor)
{editor.ddt._ddt("htmlarea.js","2821","newLine(): top");var table=document.createElement("table");table.border="0px";table.cellSpacing="0px";table.cellPadding="0px";toolbar.appendChild(table);var tb_body=document.createElement("tbody");table.appendChild(tb_body);tb_row=document.createElement("tr");tb_body.appendChild(tb_row);};newLine(this);function setButtonStatus(id,newval)
{HTMLArea._ddt("htmlarea.js","2857","setButtonStatus() : top with id '"+id+"' value '"+newval+'"');var oldval=this[id];var el=this.element;if(oldval!=newval)
{switch(id)
{case"enabled":if(newval)
{HTMLArea._removeClass(el,"buttonDisabled");el.disabled=false;}
else
{HTMLArea._addClass(el,"buttonDisabled");el.disabled=true;}
break;case"active":if(newval)
{HTMLArea._addClass(el,"buttonPressed");}
else
{HTMLArea._removeClass(el,"buttonPressed");}
break;}
this[id]=newval;}};function createSelect(txt)
{HTMLArea._ddt("htmlarea.js","2913","createSelect(): top with text '"+txt+"'");var options=null;var el=null;var cmd=null;var customSelects=editor.config.customSelects;var context=null;var tooltip="";switch(txt)
{case"fontsize":case"fontname":case"formatblock":options=editor.config[txt];cmd=txt;break;default:cmd=txt;var dropdown=customSelects[cmd];if(typeof dropdown!="undefined")
{options=dropdown.options;context=dropdown.context;if(typeof dropdown.tooltip!="undefined")
{tooltip=dropdown.tooltip;}}
else
{alert("ERROR [createSelect]:\nCan't find the requested dropdown definition");}
break;}
if(options)
{el=document.createElement("select");el.title=tooltip;var obj={name:txt,element:el,enabled:true,text:false,cmd:cmd,state:setButtonStatus,context:context};tb_objects[txt]=obj;for(var i in options)
{var op=document.createElement("option");op.innerHTML=i;op.value=options[i];el.appendChild(op);}
HTMLArea._addEvent(el,"change",function()
{editor._comboSelected(el,txt);});}
HTMLArea._ddt("htmlarea.js","2997","createSelect(): end");return el;};function createButton(txt,editor)
{editor.ddt._ddt("htmlarea.js","3012","createButton(): top with text '"+txt+"'");var el=null;var btn=null;var obj=null;switch(txt)
{case"separator":el=document.createElement("div");el.className="separator";break;case"space":el=document.createElement("div");el.className="space";break;case"linebreak":newLine(editor);return false;case"textindicator":el=document.createElement("div");el.appendChild(document.createTextNode("A"));el.className="indicator";el.title=HTMLArea._lc("Current style");obj={name:txt,element:el,enabled:true,active:false,text:false,cmd:"textindicator",state:setButtonStatus};tb_objects[txt]=obj;break;default:btn=editor.config.btnList[txt];}
if(!el&&btn)
{el=document.createElement("a");el.style.display='block';el.href='javascript:void(0)';el.style.textDecoration='none';el.title=btn[0];el.className="button";obj={name:txt,element:el,enabled:true,active:false,text:btn[2],cmd:btn[3],state:setButtonStatus,context:btn[4]||null};tb_objects[txt]=obj;HTMLArea._addEvent(el,"mouseout",function()
{if(obj.enabled)
{HTMLArea._ddt("htmlarea.js","3095","mouseout event: top");HTMLArea._removeClass(el,"buttonActive");(obj.active)&&HTMLArea._addClass(el,"buttonPressed");}});HTMLArea._addEvent(el,"mousedown",function(ev)
{if(obj.enabled)
{HTMLArea._ddt("htmlarea.js","3109","mousedown event top");HTMLArea._addClass(el,"buttonActive");HTMLArea._removeClass(el,"buttonPressed");HTMLArea._stopEvent(HTMLArea.is_ie?window.event:ev);}});HTMLArea._addEvent(el,"click",function(ev)
{if(obj.enabled)
{HTMLArea._ddt("htmlarea.js","3125","click event top");HTMLArea._removeClass(el,"buttonActive");if(HTMLArea.is_gecko)
{editor.activateEditor();}
obj.cmd(editor,obj.name,obj);HTMLArea._stopEvent(HTMLArea.is_ie?window.event:ev);}});var i_contain=HTMLArea.makeBtnImg(btn[1]);var img=i_contain.firstChild;el.appendChild(i_contain);obj.imgel=img;obj.swapImage=function(newimg)
{if(typeof newimg!='string')
{img.src=newimg[0];img.style.position='relative';img.style.top=newimg[2]?('-'+(18*(newimg[2]+1))+'px'):'-18px';img.style.left=newimg[1]?('-'+(18*(newimg[1]+1))+'px'):'-18px';}
else
{obj.imgel.src=newimg;img.style.top='0px';img.style.left='0px';}}}
else if(!el)
{el=createSelect(txt);}
if(el)
{var tb_cell=document.createElement("td");tb_row.appendChild(tb_cell);tb_cell.appendChild(el);}
else
{alert("FIXME: Unknown toolbar item: "+txt);}
return el;};var first=true;for(var i=0;i<this.config.toolbar.length;++i)
{if(!first)
{}
else
{first=false;}
if(this.config.toolbar[i]==null)
this.config.toolbar[i]=['separator'];var group=this.config.toolbar[i];for(var j=0;j<group.length;++j)
{var code=group[j];if(/^([IT])\[(.*?)\]/.test(code))
{var l7ed=RegExp.$1=="I";var label=RegExp.$2;if(l7ed)
{label=HTMLArea._lc(label);}
var tb_cell=document.createElement("td");tb_row.appendChild(tb_cell);tb_cell.className="label";tb_cell.innerHTML=label;}
else if(typeof code!='function')
{createButton(code,this);}}}};HTMLArea.prototype._createStatusBar=function()
{this.ddt._ddt("htmlarea.js","3242","_createStatusBar(): top");var statusbar=document.createElement("div");statusbar.className="statusBar";this._htmlArea.appendChild(statusbar);this._statusBar=statusbar;var div=document.createElement("span");div.className="statusBarTree";div.innerHTML=HTMLArea._lc("Path")+": ";this._statusBarTree=div;this._statusBar.appendChild(div);if(!this.config.statusBar)
{statusbar.style.display="none";}};HTMLArea.prototype.generate=function()
{this.ddt._ddt("htmlarea.js","3276","generate(): top");var editor=this;if(HTMLArea.is_gecko)
{switch(editor.config.mozParaHandler)
{case'best':{if(typeof EnterParagraphs=='undefined')
{this.ddt._ddt("htmlarea.js","3295","generate(): mozParaHandler config set to 'best'. Loading EnterParagraphs");HTMLArea._loadback(_editor_url+'plugins/EnterParagraphs/enter-paragraphs.js',function()
{editor.generate();return true;});return false;}
editor.registerPlugin(eval('EnterParagraphs'));}
break;case'dirty':case'built-in':default:{}
break;}}
var textarea=this._textArea;if(typeof textarea=="string")
{this._textArea=textarea=HTMLArea.getElementById("textarea",textarea);}
this._ta_size={w:textarea.offsetWidth,h:textarea.offsetHeight};var htmlarea=document.createElement("div");htmlarea.className="htmlarea";this._htmlArea=htmlarea;if(this.config.width!='auto'&&this.config.width!='toolbar')
{htmlarea.style.width=this.config.width;}
textarea.parentNode.insertBefore(htmlarea,textarea);this.ddt._ddt("htmlarea.js","3360","generate(): creating toolbar");this._createToolbar();var innerEditor=document.createElement('div');htmlarea.appendChild(innerEditor);innerEditor.style.position='relative';this.innerEditor=innerEditor;textarea.parentNode.removeChild(textarea);innerEditor.appendChild(textarea);var iframe=document.createElement("iframe");innerEditor.appendChild(iframe);iframe.src=_editor_url+editor.config.URIs["blank"];this._iframe=iframe;this.ddt._ddt("htmlarea.js","3402","generate(): adding panels");for(var i in this._panels)
{innerEditor.appendChild(this._panels[i].div);}
this.ddt._ddt("htmlarea.js","3410","generate(): creating Status Bar");this._createStatusBar();if(textarea.form)
{var f=textarea.form;if(typeof f.__msh_prevOnSubmit=="undefined")
{f.__msh_prevOnSubmit=[];if(typeof f.onsubmit=="function")
{var funcref=f.onsubmit;f.__msh_prevOnSubmit.push(funcref);f.onsubmit=null;}
f.onsubmit=function()
{var a=this.__msh_prevOnSubmit;editor.ddt._ddt("htmlarea.js","3439","generate(): f.onsubmit(): top with "+a.length+" previous submit handlers");var allOK=true;for(var i=a.length;--i>=0;)
{this.__msh_tempEventHandler=a[i];editor.ddt._ddt("htmlarea.js","3451","generate(): f.onsubmit(): calling event handler '"+this.__msh_tempEventHandler+"'");if(this.__msh_tempEventHandler()==false)
{editor.ddt._ddt("htmlarea.js","3456","generate(): f.onsubmit(): previous submit handlers '"+i+" returned false");allOK=false;break;}}
editor.ddt._ddt("htmlarea.js","3463","generate(): f.onsubmit(): bottom before return");return allOK;}}
f.__msh_prevOnSubmit.push(function()
{editor.ddt._ddt("htmlarea.js","3472","generate(): msh_prevOnSubmit.push: top. calling outwardHtml");editor._textArea.value=editor.outwardHtml(editor.getHTML());editor.ddt._ddt("htmlarea.js","3476","generate(): msh_prevOnSubmit.push: bottom. value is "+editor._textArea.value+"'");});if(typeof f.__msh_prevOnReset=="undefined")
{f.__msh_prevOnReset=[];if(typeof f.onreset=="function")
{var funcref_tmp=f.onreset;f.__msh_prevOnReset.push(funcref_tmp);f.onreset=null;}
f.onreset=function()
{editor.ddt._ddt("htmlarea.js","3494","generate(): f.onreset(): top");var a=this.__msh_prevOnReset;var allOK=true;for(var i=a.length;--i>=0;)
{if(a[i]()==false)
{allOK=false;break;}}
return allOK;}}
f.__msh_prevOnReset.push(function(){editor.setHTML(editor._textArea.value);editor.updateToolbar();});}
try
{HTMLArea._addEvent(window,'unload',function()
{HTMLArea._ddt("htmlarea.js","3525","unload event top");textarea.value=editor.outwardHtml(editor.getHTML());});}catch(e){};textarea.style.display="none";this.ddt._ddt("htmlarea.js","3534","generate(): calculating starting size");var height=null;var width=null;switch(this.config.height)
{case'auto':{height=parseInt(this._ta_size.h);break;}
default:{height=parseInt(this.config.height);break;}}
switch(this.config.width)
{case'toolbar':{width=parseInt(this._toolbar.offsetWidth);break;}
case'auto':{width=parseInt(this._ta_size.w);break;}
default:{width=parseInt(this.config.width);break;}}
if(this.config.sizeIncludesToolbar)
{height-=this._toolbar.offsetHeight;height-=this._statusBar.offsetHeight;}
width=Math.max(width,100);height=Math.max(height,100);this.setInnerSize(width,height);this.notifyOn('panel_change',function(){editor.setInnerSize();});this.ddt._ddt("htmlarea.js","3572","generate(): bottom before event call to initIframe()");if(HTMLArea.is_gecko)
{editor.isGenerated=false;this._iframe.addEventListener("load",function(e)
{if(!editor.isGenerated)
{editor.isGenerated=true;editor.initIframe();}
return true;},false);}
else
{this._iframe.attachEvent("onload",function(e)
{if(!editor.isGenerated)
{editor.isGenerated=true;editor.initIframe();}
return true;});}
return true;};HTMLArea.prototype.initIframe=function()
{var doc=null;var editor=this;var html=null;this.ddt._ddt("htmlarea.js","3653","initFrame(): top");try
{doc=editor._iframe.contentWindow.document;if(!doc)
{if(HTMLArea.is_gecko)
{setTimeout(function(){editor.initIframe()},50);return false;}
else
{alert("ERROR: IFRAME can't be initialized.");}}}
catch(e)
{alert("EXCEPTION: couldn't get doc in initFrame - delaying and returning.");setTimeout(function(){editor.initIframe()},50);return false;}
if(!editor.config.fullPage)
{doc.open();html="<html>\n";html+="<head>\n";html+="<meta http-equiv=\"Content-Type\" content=\"text/html; charset="+editor.config.charSet+"\">\n";if(typeof editor.config.baseHref!='undefined'&&editor.config.baseHref!=null)
{html+="<base href=\""+editor.config.baseHref+"\"/>\n";}
html+="<style title=\"table borders\">"
+".htmtableborders, .htmtableborders td, .htmtableborders th {border : 1px dashed lightgrey ! important;} \n"
+"</style>\n";html+="<style>"
+editor.config.pageStyle+"\n"
+"html, body { border: 0px; } \n"
+"span.macro, span.macro ul, span.macro div, span.macro p {background : #CCCCCC;}\n"
+"</style>\n";if(typeof editor.config.pageStyleSheets!=='undefined')
{for(style_i=0;style_i<editor.config.pageStyleSheets.length;style_i++)
{if(editor.config.pageStyleSheets[style_i].length>0)
html+="<link rel=\"stylesheet\" type=\"text/css\" href=\""+editor.config.pageStyleSheets[style_i]+"\">";}}
html+="</head>\n";html+="<body>\n";html+=editor.inwardHtml(editor._textArea.value);html+="</body>\n";html+="</html>";doc.write(html);doc.close();}
else
{html=editor.inwardHtml(editor._textArea.value);if(html.match(HTMLArea.RE_doctype))
{editor.setDoctype(RegExp.$1);html=html.replace(HTMLArea.RE_doctype,"");}
doc.open();doc.write(html);doc.close();}
this._doc=doc;if(HTMLArea.is_gecko)
{HTMLArea._addEvents(editor._iframe.contentWindow,["mousedown"],function()
{editor.ddt._ddt("htmlarea.js","3769","_iframe.contentWindow mouse down event. activating editor");editor.activateEditor();});}
else
{editor.activateEditor();}
HTMLArea._addEvents(doc,["keydown","keypress","mousedown","mouseup","drag"],function(event)
{HTMLArea._ddt("htmlarea.js","3786","event '"+event+"' top");return editor._editorEvent(HTMLArea.is_ie?editor._iframe.contentWindow.event:event);});for(var i in editor.plugins)
{var plugin=editor.plugins[i].instance;HTMLArea.refreshPlugin(plugin);}
if(typeof editor._onGenerate=="function")
{editor._onGenerate();}
if(typeof editor.onGenerate=="function")
{editor.onGenerate();}
return true;}
HTMLArea.prototype.getInnerSize=function()
{return this._innerSize;}
HTMLArea.prototype.setInnerSize=function(width,height)
{this.ddt._ddt("htmlarea.js","3845","setInnerSize(): top with width '"+width+"' height '"+height+"'");if(typeof width=='undefined'||width==null)
{width=this._innerSize.width;}
if(typeof height=='undefined'||height==null)
{height=this._innerSize.height;}
this._innerSize={'width':width,'height':height};var editorWidth=width;var editorHeight=height;var editorLeft=0;var editorTop=0;var panels=this._panels;var panel=panels.right;if(panel.on&&panel.panels.length&&HTMLArea.hasDisplayedChildren(panel.div))
{panel.div.style.position='absolute';panel.div.style.width=parseInt(this.config.panel_dimensions.right)+(HTMLArea.ie_ie?-1:-2)+'px';panel.div.style.height=height+(HTMLArea.is_ie?-1:-1)+'px';panel.div.style.top='0px';panel.div.style.right=(HTMLArea.is_ie?1:2)+'px';panel.div.style.padding="0px";panel.div.style.overflow="auto";panel.div.style.display='block';editorWidth-=parseInt(this.config.panel_dimensions.right)+(HTMLArea.is_ie?2:0);}
else
{panel.div.style.display='none';}
panel=panels.left;if(panel.on&&panel.panels.length&&HTMLArea.hasDisplayedChildren(panel.div))
{panel.div.style.position='absolute';panel.div.style.width=parseInt(this.config.panel_dimensions.left)+(HTMLArea.ie_ie?-1:-1)+'px';panel.div.style.height=height+(HTMLArea.is_ie?-1:-1)+'px';panel.div.style.top='0px';panel.div.style.left=(HTMLArea.is_ie?0:0)+'px';panel.div.style.padding="0px";panel.div.style.overflow="auto";panel.div.style.display="block";editorWidth-=parseInt(this.config.panel_dimensions.left)+(HTMLArea.is_ie?2:0);editorLeft=parseInt(this.config.panel_dimensions.left)+(HTMLArea.is_ie?2:0)+'px';}
else
{panel.div.style.display='none';}
panel=panels.top;if(panel.on&&panel.panels.length&&HTMLArea.hasDisplayedChildren(panel.div))
{panel.div.style.position='absolute';panel.div.style.top='0px';panel.div.style.left='0px';panel.div.style.width=width+'px';panel.div.style.height=parseInt(this.config.panel_dimensions.top)+'px';panel.div.style.padding="0px";panel.div.style.overflow="auto";panel.div.style.display="block";editorHeight-=parseInt(this.config.panel_dimensions.top);editorTop=parseInt(this.config.panel_dimensions.top)+'px';}
else
{panel.div.style.display='none';}
panel=panels.bottom;if(panel.on&&panel.panels.length&&HTMLArea.hasDisplayedChildren(panel.div))
{panel.div.style.position='absolute';panel.div.style.bottom='0px';panel.div.style.left='0px';panel.div.style.width=width+'px';panel.div.style.height=parseInt(this.config.panel_dimensions.bottom)+'px';panel.div.style.padding="0px";panel.div.style.overflow="auto";panel.div.style.display="block";editorHeight-=parseInt(this.config.panel_dimensions.bottom);}
else
{panel.div.style.display='none';}
this.innerEditor.style.width=width+'px';this.innerEditor.style.height=height+'px';this.innerEditor.style.position='relative';this._iframe.style.width=editorWidth+'px';this._iframe.style.height=editorHeight+'px';this._iframe.style.position='absolute';this._iframe.style.left=editorLeft;this._iframe.style.top=editorTop;this._textArea.style.width=editorWidth+'px';this._textArea.style.height=editorHeight+'px';this._textArea.style.position='absolute';this._textArea.style.left=editorLeft;this._textArea.style.top=editorTop;this.notifyOf('resize',{'width':width,'height':height,'editorWidth':editorWidth,'editorHeight':editorHeight,'editorTop':editorTop,'editorLeft':editorLeft});}
HTMLArea.prototype.addPanel=function(side)
{this.ddt._ddt("htmlarea.js","3974","addPanel() : top with side '"+side+"'");var div=document.createElement('div');div.side=side;HTMLArea.addClasses(div,'panel');this._panels[side].panels.push(div);this._panels[side].div.appendChild(div);this.notifyOf('panel_change',{'action':'add','panel':div});return div;}
HTMLArea.prototype.removePanel=function(panel)
{this.ddt._ddt("htmlarea.js","3994","removePanel() : top");this._panels[panel.side].div.removeChild(panel);var clean=[];for(var i=0;i<this._panels[panel.side].panels.length;i++)
{if(this._panels[panel.side].panels[i]!=panel)
{clean.push(this._panels[panel.side].panels[i]);}}
this._panels[panel.side].panels=clean;this.notifyOf('panel_change',{'action':'remove','panel':panel});}
HTMLArea.prototype.hidePanel=function(panel)
{this.ddt._ddt("htmlarea.js","4018","hidePanel() : top");if(panel)
{panel.style.display='none';this.notifyOf('panel_change',{'action':'hide','panel':panel});}}
HTMLArea.prototype.showPanel=function(panel)
{this.ddt._ddt("htmlarea.js","4034","showPanel() : top");if(panel)
{panel.style.display='';this.notifyOf('panel_change',{'action':'show','panel':panel});}}
HTMLArea.prototype.hidePanels=function(sides)
{this.ddt._ddt("htmlarea.js","4050","hidePanels() : top");if(typeof sides=='undefined')
{sides=['left','right','top','bottom'];}
var reShow=[];for(var i=0;i<sides.length;i++)
{if(this._panels[sides[i]].on)
{reShow.push(sides[i]);this._panels[sides[i]].on=false;}}
this.notifyOf('panel_change',{'action':'multi_hide','sides':sides});}
HTMLArea.prototype.showPanels=function(sides)
{this.ddt._ddt("htmlarea.js","4077","showPanels() : top");if(typeof sides=='undefined')
{sides=['left','right','top','bottom'];}
var reHide=[];for(var i=0;i<sides.length;i++)
{if(!this._panels[sides[i]].on)
{reHide.push(sides[i]);this._panels[sides[i]].on=true;}}
this.notifyOf('panel_change',{'action':'multi_show','sides':sides});}
HTMLArea.prototype.activateEditor=function()
{this.ddt._ddt("htmlarea.js","4105","activateEditor(): top - called by '"+HTMLArea.prototype.activateEditor.caller.toString().substring(0,100)+"'");if(HTMLArea.is_gecko&&this._doc.designMode!='on')
{try
{HTMLArea.last_on.designMode='off';}
catch(e)
{this.ddt._ddt("htmlarea.js","4119","activateEditor(): exception trying to set last_on.designMode to off. First time here?");}
this.ddt._ddt("htmlarea.js","4122","activateEditor(): _iframe.style.display is '"+this._iframe.style.display+"'");if(this._iframe.style.display=='none')
{this._iframe.style.display='';this._doc.designMode='on';this._iframe.style.display='none';}
else
{this.ddt._ddt("htmlarea.js","4132","activateEditor(): setting designMode to on");try
{this._doc.designMode='on';}
catch(e)
{alert("EXCEPTION - failed to turn design mode on in activateEditor() - "+e+"'");}}}
else if(HTMLArea.is_ie)
{this.ddt._ddt("htmlarea.js","4149","activateEditor(): Setting contentEditable to true");this._doc.body.contentEditable=true;}
else
{this.ddt._ddt("htmlarea.js","4155","activateEditor(): UNHANDLED CASE.");}
HTMLArea.last_on=this._doc;this.ddt._ddt("htmlarea.js","4162","activateEditor(): end");}
HTMLArea.prototype.deactivateEditor=function()
{this.ddt._ddt("htmlarea.js","4175","deactivateEditor(): top");if(HTMLArea.is_gecko&&this._doc.designMode=='on')
{this._doc.designMode='off';HTMLArea.last_on=null;}
else
{this._doc.body.contentEditable=false;}}
HTMLArea.prototype.setMode=function(mode)
{var html=null;if(typeof mode=="undefined")
{mode=((this._editMode=="textmode")?"wysiwyg":"textmode");}
this.ddt._ddt("htmlarea.js","4207","setMode(): setting mode to '"+mode+"'");switch(mode)
{case"textmode":{html=this.outwardHtml(this.getHTML());this._textArea.value=html;this.ddt._ddt("htmlarea.js","4217","setMode(): textmode. called getHTML composed into outwardHTML and set the textarea value. html set was '"+this.ddt.getHTMLSource(html)+"'");this.deactivateEditor();this._iframe.style.display='none';this._textArea.style.display="block";if(this.config.statusBar)
{this._statusBar.innerHTML=HTMLArea._lc("You are in TEXT MODE.  Use the [<>] button to switch back to WYSIWYG.");}
this.notifyOf('modechange',{'mode':'text'});break;}
case"wysiwyg":{this.ddt._ddt("htmlarea.js","4235","setMode(): textmode. calling getHTML composed into inwardHTML and setting the innerHTML or fullpage value.");html=this.inwardHtml(this.getHTML());this.deactivateEditor();if(!this.config.fullPage)
{this._doc.body.innerHTML=html;this.ddt._ddtDumpNode("htmlarea.js","3986","setMode(): wysiwyg. after setting innerHTML body contents are:",this._doc.body);}
else
{this.setFullHTML(html);}
this._iframe.style.display='';this._textArea.style.display="none";this.activateEditor();if(this.config.statusBar)
{this._statusBar.innerHTML='';this._statusBar.appendChild(this._statusBarTree);}
this.notifyOf('modechange',{'mode':'wysiwyg'});break;}
default:{alert("Mode <"+mode+"> not defined!");return false;}}
this._editMode=mode;this.ddt._ddt("htmlarea.js","4275","setMode(): informing any plugins that interested of the mode change");for(var i in this.plugins)
{var plugin=this.plugins[i].instance;if(typeof plugin.onMode=="function")
{this.ddt._ddt("htmlarea.js","4282","setMode(): calling onMode in plugin '"+plugin.name+"'");plugin.onMode(mode);}}
return true;}
HTMLArea.prototype.setFullHTML=function(html)
{this.ddt._ddt("htmlarea.js","4300","setFullHTML(): top");var save_multiline=RegExp.multiline;RegExp.multiline=true;if(html.match(HTMLArea.RE_doctype))
{this.setDoctype(RegExp.$1);html=html.replace(HTMLArea.RE_doctype,"");}
RegExp.multiline=save_multiline;if(!HTMLArea.is_ie)
{if(html.match(HTMLArea.RE_head))
this._doc.getElementsByTagName("head")[0].innerHTML=RegExp.$1;if(html.match(HTMLArea.RE_body))
this._doc.getElementsByTagName("body")[0].innerHTML=RegExp.$1;}
else
{var html_re=/<html>((.|\n)*?)<\/html>/i;html=html.replace(html_re,"$1");this._doc.open();this._doc.write(html);this._doc.close();this.activateEditor();return true;}
return true;}
HTMLArea.prototype.registerPlugin=function()
{var plugin=arguments[0];this.ddt._ddt("htmlarea.js","4352","registerPlugin(): top with plugin '"+plugin+"'");var args=[];for(var i=1;i<arguments.length;++i)
args.push(arguments[i]);return this.registerPlugin2(plugin,args);};HTMLArea.prototype.registerPlugin2=function(plugin,args)
{this.ddt._ddt("htmlarea.js","4375","registerPlugin2(): top");if(typeof plugin=="string")
{this.ddt._ddt("htmlarea.js","4379","registerPlugin2(): plugin '"+plugin+"' is a string.");plugin=eval(plugin);}
if((typeof plugin=="undefined")||(plugin==null))
{this.ddt._ddt("htmlarea.js","4386","registerPlugin2(): INTERNAL ERROR: plugin is undefined. ");return false;}
try
{var obj=new plugin(this,args);this.ddt._ddt("htmlarea.js","4399","registerPlugin2(): after successfully creating the plugin. ");}
catch(e)
{this.ddt._ddt("htmlarea.js","4404","registerPlugin2(): unable to create the plugin. '"+e+"'");alert("INTERNAL ERROR - registerPlugin2(): UNABLE TO CONSTRUCT PLUGIN '"+plugin+"' - '"+e+"'");return false;}
if(obj)
{var clone={};var info=plugin._pluginInfo;for(var i in info)
clone[i]=info[i];clone.instance=obj;clone.args=args;this.plugins[plugin._pluginInfo.name]=clone;return obj;}
else
{alert("Can't register plugin "+plugin.toString()+".");}
return true;}
HTMLArea.prototype.debugTree=function()
{var ta=document.createElement("textarea");ta.style.width="100%";ta.style.height="20em";ta.value="";function debug(indent,str)
{for(;--indent>=0;)
ta.value+=" ";ta.value+=str+"\n";};function _dt(root,level)
{var tag=root.tagName.toLowerCase(),i;var ns=HTMLArea.is_ie?root.scopeName:root.prefix;debug(level,"- "+tag+" ["+ns+"]");for(i=root.firstChild;i;i=i.nextSibling)
if(i.nodeType==1)
_dt(i,level+2);};_dt(this._doc.body,0);document.body.appendChild(ta);};HTMLArea.prototype._wordClean=function()
{var editor=this;this.ddt._ddt("htmlarea.js","4481","_wordClean(): top");var stats={empty_tags:0,mso_class:0,mso_style:0,mso_xmlel:0,orig_len:this._doc.body.innerHTML.length,T:(new Date()).getTime()};var stats_txt={empty_tags:"Empty tags removed: ",mso_class:"MSO class names removed: ",mso_style:"MSO inline style removed: ",mso_xmlel:"MSO XML elements stripped: "};function showStats()
{var txt="HTMLArea word cleaner stats: \n\n";for(var i in stats)
if(stats_txt[i])
txt+=stats_txt[i]+stats[i]+"\n";txt+="\nInitial document length: "+stats.orig_len+"\n";txt+="Final document length: "+editor._doc.body.innerHTML.length+"\n";txt+="Clean-up took "+(((new Date()).getTime()-stats.T)/1000)+" seconds";alert(txt);};function clearClass(node)
{var newc=node.className.replace(/(^|\s)mso.*?(\s|$)/ig,' ');if(newc!=node.className)
{node.className=newc;if(!/\S/.test(node.className))
{node.removeAttribute("className");++stats.mso_class;}}};function clearStyle(node)
{var declarations=node.style.cssText.split(/\s*;\s*/);for(var i=declarations.length;--i>=0;)
if(/^mso|^tab-stops/i.test(declarations[i])||/^margin\s*:\s*0..\s+0..\s+0../i.test(declarations[i]))
{++stats.mso_style;declarations.splice(i,1);}
node.style.cssText=declarations.join("; ");};function stripTag(el)
{if(HTMLArea.is_ie)
el.outerHTML=HTMLArea.htmlEncode(el.innerText);else
{var txt=document.createTextNode(HTMLArea.getInnerText(el));el.parentNode.insertBefore(txt,el);el.parentNode.removeChild(el);}
++stats.mso_xmlel;};function checkEmpty(el)
{if(/^(a|span|b|strong|i|em|font)$/i.test(el.tagName)&&!el.firstChild)
{el.parentNode.removeChild(el);++stats.empty_tags;}};function parseTree(root)
{var tag=root.tagName.toLowerCase(),i,next;if((HTMLArea.is_ie&&root.scopeName!='HTML')||(!HTMLArea.is_ie&&/:/.test(tag)))
{stripTag(root);return false;}
else
{clearClass(root);clearStyle(root);for(i=root.firstChild;i;i=next)
{next=i.nextSibling;if(i.nodeType==1&&parseTree(i))
checkEmpty(i);}}
return true;};parseTree(this._doc.body);this.ddt._ddt("htmlarea.js","4598","_wordClean(): bottom");this.updateToolbar();};HTMLArea.prototype._clearFonts=function()
{this.ddt._ddt("htmlarea.js","4613","_clearFonts(): top");var D=this.getInnerHTML();if(confirm('Would you like to clear font typefaces?'))
{D=D.replace(/face="[^"]*"/gi,'');D=D.replace(/font-family:[^;}"']+;?/gi,'');}
if(confirm('Would you like to clear font sizes?'))
{D=D.replace(/size="[^"]*"/gi,'');D=D.replace(/font-size:[^;}"']+;?/gi,'');}
if(confirm('Would you like to clear font colours?'))
{D=D.replace(/color="[^"]*"/gi,'');D=D.replace(/([^-])color:[^;}"']+;?/gi,'$1');}
D=D.replace(/(style|class)="\s*"/gi,'');D=D.replace(/<(font|span)\s*>/gi,'');this.setHTML(D);this.updateToolbar();}
HTMLArea.prototype._splitBlock=function()
{this.ddt._ddt("htmlarea.js","4651","_splitBlock(): top");this._doc.execCommand('formatblock',false,'<div>');}
HTMLArea.prototype.forceRedraw=function()
{this.ddt._ddt("htmlarea.js","4665","forceRedraw(): top");this._doc.body.style.visibility="hidden";this._doc.body.style.visibility="visible";};HTMLArea.prototype.focusEditor=function()
{this.ddt._ddt("htmlarea.js","4683","focusEditor(): top _editMode is '"+this._editMode+"'");switch(this._editMode)
{case"wysiwyg":try
{if(HTMLArea.last_on)
{this.activateEditor();this._iframe.contentWindow.focus();}}catch(e){}break;case"textmode":try
{this._textArea.focus()}catch(e){}break;default:alert("ERROR: mode "+this._editMode+" is not defined");}
return this._doc;};HTMLArea.prototype._undoTakeSnapshot=function()
{this.ddt._ddt("htmlarea.js","4731","_undoTakeSnapshot(): top");++this._undoPos;if(this._undoPos>=this.config.undoSteps)
{this._undoQueue.shift();--this._undoPos;}
var take=true;var txt=this.getInnerHTML();if(this._undoPos>0)
take=(this._undoQueue[this._undoPos-1]!=txt);if(take)
{this._undoQueue[this._undoPos]=txt;}
else
{this._undoPos--;}};HTMLArea.prototype.undo=function()
{this.ddt._ddt("htmlarea.js","4768","undo(): top");if(this._undoPos>0)
{var txt=this._undoQueue[--this._undoPos];if(txt)this.setHTML(txt);else++this._undoPos;}};HTMLArea.prototype.redo=function()
{this.ddt._ddt("htmlarea.js","4787","redo(): top");if(this._undoPos<this._undoQueue.length-1)
{var txt=this._undoQueue[++this._undoPos];if(txt)this.setHTML(txt);else--this._undoPos;}};HTMLArea.prototype.disableToolbar=function(except)
{this.ddt._ddt("htmlarea.js","4806","disableToolbar(): top");if(typeof except=='undefined')
{except=[];}
else if(typeof except!='object')
{except=[except];}
for(var i in this._toolbarObjects)
{var btn=this._toolbarObjects[i];if(except.contains(i))
{continue;}
btn.state("enabled",false);}}
HTMLArea.prototype.enableToolbar=function()
{this.ddt._ddt("htmlarea.js","4838","enableToolbar(): top");this.updateToolbar();}
HTMLArea.prototype.updateToolbar=function(noStatus)
{var doc=this._doc;var text=(this._editMode=="textmode");var ancestors=null;var i=null;var k=null;var el=null;this.ddt._ddt("htmlarea.js","4858","updateToolbar(): top");if(!text)
{ancestors=this.getAllAncestors();if(this.config.statusBar&&!noStatus)
{this._statusBarTree.innerHTML=HTMLArea._lc("Path")+": ";for(i=ancestors.length;--i>=0;)
{el=ancestors[i];if(!el)
{this.ddt._ddt("htmlarea.js","4872","updateToolbar(): INTERNAL ERROR");continue;}
var a=document.createElement("a");a.href="javascript:void(0)";a.el=el;a.editor=this;a.onclick=function()
{this.blur();this.editor.selectNodeContents(this.el);this.editor.updateToolbar(true);return false;};a.oncontextmenu=function()
{this.blur();var info="Inline style:\n\n";info+=this.el.style.cssText.split(/;\s*/).join(";\n");alert(info);return false;};var txt=el.tagName.toLowerCase();a.title=el.style.cssText;if(el.id)
{txt+="#"+el.id;}
if(el.className)
{txt+="."+el.className;}
a.appendChild(document.createTextNode(txt));this._statusBarTree.appendChild(a);if(i!=0)
{this._statusBarTree.appendChild(document.createTextNode(String.fromCharCode(0xbb)));}}}}
for(i in this._toolbarObjects)
{var btn=this._toolbarObjects[i];var cmd=i;var inContext=true;if(btn.context&&!text)
{inContext=false;var context=btn.context;var attrs=[];if(/(.*)\[(.*?)\]/.test(context))
{context=RegExp.$1;attrs=RegExp.$2.split(",");}
context=context.toLowerCase();var match=(context=="*");for(k=0;k<ancestors.length;++k)
{if(!ancestors[k])
{this.ddt._ddt("htmlarea.js","4954","updateToolbar(): INTERNAL ERROR");continue;}
if(match||(ancestors[k].tagName.toLowerCase()==context))
{inContext=true;for(var ka=0;ka<attrs.length;++ka)
{if(!eval("ancestors[k]."+attrs[ka]))
{inContext=false;break;}}
if(inContext)
{break;}}}}
btn.state("enabled",(!text||btn.text)&&inContext);if(typeof cmd=="function")
{continue;}
var dropdown=this.config.customSelects[cmd];if((!text||btn.text)&&(typeof dropdown!="undefined"))
{dropdown.refresh(this);continue;}
switch(cmd)
{case"fontname":case"fontsize":{if(!text)try
{var value=(""+doc.queryCommandValue(cmd)).toLowerCase();if(!value)
{btn.element.selectedIndex=0;break;}
var options=this.config[cmd];k=0;for(var j in options)
{if((j.toLowerCase()==value)||(options[j].substr(0,value.length).toLowerCase()==value))
{btn.element.selectedIndex=k;throw"ok";}
++k;}
btn.element.selectedIndex=0;}
catch(e)
{};}
break;case"formatblock":{var blocks=[];for(i in this.config['formatblock'])
{blocks[blocks.length]=this.config['formatblock'][i];}
var deepestAncestor=this._getFirstAncestor(this._getSelection(),blocks);if(deepestAncestor)
{for(var x=0;x<blocks.length;x++)
{if(blocks[x].toLowerCase()==deepestAncestor.tagName.toLowerCase())
{btn.element.selectedIndex=x;}}}
else
{btn.element.selectedIndex=0;}}
break;case"textindicator":if(!text)
{try
{btn.element.style.backgroundColor=HTMLArea._makeColor(doc.queryCommandValue(HTMLArea.is_ie?"backcolor":"hilitecolor"));if(/transparent/i.test(btn.element.style.backgroundColor))
{btn.element.style.backgroundColor=HTMLArea._makeColor(doc.queryCommandValue("backcolor"));}
btn.element.style.color=HTMLArea._makeColor(doc.queryCommandValue("forecolor"));btn.element.style.fontFamily=doc.queryCommandValue("fontname");btn.element.style.fontWeight=doc.queryCommandState("bold")?"bold":"normal";btn.element.style.fontStyle=doc.queryCommandState("italic")?"italic":"normal";}
catch(e)
{}}
break;case"htmlmode":btn.state("active",text);break;case"lefttoright":case"righttoleft":el=this.getParentElement();while(el&&!HTMLArea.isBlockElement(el))
el=el.parentNode;if(el)
btn.state("active",(el.style.direction==((cmd=="righttoleft")?"rtl":"ltr")));break;default:cmd=cmd.replace(/(un)?orderedlist/i,"insert$1orderedlist");try
{btn.state("active",(!text&&doc.queryCommandState(cmd)));}
catch(e)
{}
break;}}
if(this._customUndo&&!this._timerUndo)
{this._undoTakeSnapshot();var editor=this;this._timerUndo=setTimeout(function()
{editor._timerUndo=null;},this.config.undoTimeout);}
if(0&&HTMLArea.is_gecko)
{var s=this._getSelection();if(s&&s.isCollapsed&&s.anchorNode&&s.anchorNode.parentNode.tagName.toLowerCase()!='body'&&s.anchorNode.nodeType==3&&s.anchorOffset==s.anchorNode.length&&!(s.anchorNode.parentNode.nextSibling&&s.anchorNode.parentNode.nextSibling.nodeType==3)&&!HTMLArea.isBlockElement(s.anchorNode.parentNode))
{try
{s.anchorNode.parentNode.parentNode.insertBefore
(this._doc.createTextNode('\t'),s.anchorNode.parentNode.nextSibling);}
catch(e)
{}}}
for(i in this.plugins)
{var plugin=this.plugins[i].instance;if(typeof plugin.onUpdateToolbar=="function")
plugin.onUpdateToolbar();}
this.ddt._ddt("htmlarea.js","5186","updateToolbar(): end");}
HTMLArea.prototype.insertNodeAtSelection=function(toBeInserted)
{this.ddt._ddt("htmlarea.js","5202","insertNodeAtSelection(): top");var selnode=null;if(!HTMLArea.is_ie)
{var sel=this._getSelection();var range=this._createRange(sel);sel.removeAllRanges();range.deleteContents();var node=range.startContainer;var pos=range.startOffset;switch(node.nodeType)
{case 3:if(toBeInserted.nodeType==3)
{node.insertData(pos,toBeInserted.data);range=this._createRange();range.setEnd(node,pos+toBeInserted.length);range.setStart(node,pos+toBeInserted.length);sel.addRange(range);}
else
{node=node.splitText(pos);selnode=toBeInserted;if(toBeInserted.nodeType==11)
{selnode=selnode.firstChild;}
node.parentNode.insertBefore(toBeInserted,node);this.selectNodeContents(selnode);this.updateToolbar();}
break;case 1:selnode=toBeInserted;if(toBeInserted.nodeType==11)
{selnode=selnode.firstChild;}
node.insertBefore(toBeInserted,node.childNodes[pos]);this.selectNodeContents(selnode);this.updateToolbar();break;}}
else
{return null;}
return null;}
HTMLArea.prototype.getParentElement=function(sel)
{this.ddt._ddt("htmlarea.js","5279","getParentElement(): top");if(typeof sel=='undefined')
{sel=this._getSelection();}
var range=this._createRange(sel);if(HTMLArea.is_ie)
{switch(sel.type)
{case"Text":case"None":return range.parentElement();case"Control":return range.item(0);default:return this._doc.body;}}
else try
{var p=range.commonAncestorContainer;if(!range.collapsed&&range.startContainer==range.endContainer&&range.startOffset-range.endOffset<=1&&range.startContainer.hasChildNodes())
p=range.startContainer.childNodes[range.startOffset];while(p.nodeType==3)
{p=p.parentNode;}
return p;}
catch(e)
{return null;}};HTMLArea.prototype.getAllAncestors=function()
{this.ddt._ddt("htmlarea.js","5346","getAllAncestors(): top");var p=this.getParentElement();var a=[];while(p&&(p.nodeType==1)&&(p.tagName.toLowerCase()!='body'))
{a.push(p);p=p.parentNode;}
a.push(this._doc.body);return a;};HTMLArea.prototype._getFirstAncestor=function(sel,types)
{this.ddt._ddt("htmlarea.js","5372","_getFirstAncestor(): top");var prnt=this._activeElement(sel);if(prnt==null)
{try
{prnt=(HTMLArea.is_ie?this._createRange(sel).parentElement():this._createRange(sel).commonAncestorContainer);}
catch(e)
{return null;}}
if(typeof types=='string')
{types=[types];}
while(prnt)
{if(prnt.nodeType==1)
{if(types==null)return prnt;if(types.contains(prnt.tagName.toLowerCase()))
{return prnt;}
if(prnt.tagName.toLowerCase()=='body')break;if(prnt.tagName.toLowerCase()=='table')break;}
prnt=prnt.parentNode;}
return null;}
HTMLArea.prototype._activeElement=function(sel)
{this.ddt._ddt("htmlarea.js","5427","_activeElement(): top");if(sel==null)return null;if(this._selectionEmpty(sel))
{this.ddt._ddt("htmlarea.js","5432","_activeElement(): _selectionEmpty returned true. Returning null");return null;}
if(HTMLArea.is_ie)
{if(sel.type.toLowerCase()=="control")
{return sel.createRange().item(0);}
else
{var range=sel.createRange();var p_elm=this.getParentElement(sel);if(p_elm.innerHTML==range.htmlText)
{return p_elm;}
return null;}}
else
{if(!sel.isCollapsed)
{this.ddt._ddt("htmlarea.js","5490","_activeElement(): selection is not collapsed");if(sel.anchorNode.nodeType==1)
{this.ddt._ddt("htmlarea.js","5494","_activeElement(): nodeType is 1. Returning sel.anchorNode");return sel.anchorNode;}}
this.ddt._ddt("htmlarea.js","5500","_activeElement(): bottom");return null;}}
HTMLArea.prototype._selectionEmpty=function(sel)
{this.ddt._ddt("htmlarea.js","5516","_selectionEmpty(): top");if(!sel)
{this.ddt._ddt("htmlarea.js","5520","_selectionEmpty(): no selection");return true;}
if(HTMLArea.is_ie)
{return this._createRange(sel).htmlText=='';}
else if(typeof sel.isCollapsed!='undefined')
{this.ddt._ddt("htmlarea.js","5530","_selectionEmpty(): isCollapsed");return sel.isCollapsed;}
this.ddt._ddt("htmlarea.js","5534","_selectionEmpty(): bottom. returning true.");return true;}
HTMLArea.prototype._getAncestorBlock=function(sel)
{this.ddt._ddt("htmlarea.js","5549","_getAncestorBlock(): top");var prnt=(HTMLArea.is_ie?this._createRange(sel).parentElement:this._createRange(sel).commonAncestorContainer);while(prnt&&(prnt.nodeType==1))
{switch(prnt.tagName.toLowerCase())
{case'div':case'p':case'address':case'blockquote':case'center':case'del':case'ins':case'pre':case'h1':case'h2':case'h3':case'h4':case'h5':case'h6':case'h7':return prnt;case'body':case'noframes':case'dd':case'li':case'th':case'td':case'noscript':return null;default:break;}}
return null;}
HTMLArea.prototype._createImplicitBlock=function(type)
{this.ddt._ddt("htmlarea.js","5606","_createImplicitBlock(): top");var sel=this._getSelection();if(HTMLArea.is_ie)
{sel.empty();}
else
{sel.collapseToStart();}
var rng=this._createRange(sel);}
HTMLArea.prototype._formatBlock=function(block_format)
{var ancestors=this.getAllAncestors();var apply_to=null;var x=null;var target_tag=null;var target_classNames=[];if(block_format.indexOf('.')>=0)
{target_tag=block_format.substr(0,block_format.indexOf('.')).toLowerCase();;target_classNames=block_format.substr(block_format.indexOf('.'),block_format.length-block_format.indexOf('.')).replace(/\./g,'').replace(/^\s*/,'').replace(/\s*$/,'').split(' ');}
else
{target_tag=block_format.toLowerCase();}
var sel=this._getSelection();var rng=this._createRange(sel);if(HTMLArea.is_gecko)
{if(sel.isCollapsed)
{apply_to=this._getAncestorBlock(sel);if(apply_to==null)
{apply_to=this._createImplicitBlock(sel,target_tag);}}
else
{switch(target_tag)
{case'h1':case'h2':case'h3':case'h4':case'h5':case'h6':case'h7':apply_to=[];var search_tags=['h1','h2','h3','h4','h5','h6','h7'];for(var y=0;y<search_tags.length;y++)
{var headers=this._doc.getElementsByTagName(search_tag[y]);for(x=0;x<headers.length;x++)
{if(sel.containsNode(headers[x]))
{apply_to[apply_to.length]=headers[x];}}}
if(apply_to.length>0)break;case'div':apply_to=this._doc.createElement(target_tag);apply_to.appendChild(rng.extractContents());rng.insertNode(apply_to);break;case'p':case'center':case'pre':case'ins':case'del':case'blockquote':case'address':apply_to=[];var paras=this._doc.getElementsByTagName(target_tag);for(x=0;x<paras.length;x++)
{if(sel.containsNode(paras[x]))
{apply_to[apply_to.length]=paras[x];}}
if(apply_to.length==0)
{sel.collapseToStart();return this._formatBlock(block_format);}
break;}}}
return true;}
HTMLArea.prototype.selectNodeContents=function(node,pos)
{this.ddt._ddt("htmlarea.js","5754","selectNodeContents(): top");this.focusEditor();this.forceRedraw();var range;var collapsed=(typeof pos!="undefined");if(HTMLArea.is_ie)
{if(!collapsed&&node.tagName&&node.tagName.toLowerCase().match(/table|img/))
{range=this._doc.body.createControlRange();range.add(node);}
else
{range=this._doc.body.createTextRange();range.moveToElementText(node);(collapsed)&&range.collapse(pos);}
range.select();}
else
{var sel=this._getSelection();range=this._doc.createRange();if(!collapsed&&node.tagName&&node.tagName.toLowerCase().match(/table|img/))
{range.selectNode(node);(collapsed)&&range.collapse(pos);}
else
{range.selectNodeContents(node);(collapsed)&&range.collapse(pos);}
sel.removeAllRanges();sel.addRange(range);}};HTMLArea.prototype.insertHTML=function(html)
{this.ddt._ddt("htmlarea.js","5815","insertHTML(): top");var sel=this._getSelection();var range=this._createRange(sel);if(HTMLArea.is_ie)
{range.pasteHTML(html);}
else
{var fragment=this._doc.createDocumentFragment();var div=this._doc.createElement("div");div.innerHTML=html;while(div.firstChild)
{fragment.appendChild(div.firstChild);}
var node=this.insertNodeAtSelection(fragment);}};HTMLArea.prototype.surroundHTML=function(startTag,endTag)
{this.ddt._ddt("htmlarea.js","5852","surroundHTML(): top");var html=this.getSelectedHTML();this.insertHTML(startTag+html+endTag);};HTMLArea.prototype.getSelectedHTML=function()
{this.ddt._ddt("htmlarea.js","5869","getSelectedHTML(): top");var sel=this._getSelection();var range=this._createRange(sel);var existing=null;if(HTMLArea.is_ie)
{existing=range.htmlText;}
else
{existing=HTMLArea.getHTML(range.cloneContents(),false,this);}
return existing;};HTMLArea.prototype.hasSelectedText=function()
{return this.getSelectedHTML()!='';};HTMLArea.prototype._createLink=function(link)
{var editor=this;var outparam=null;if(typeof link=="undefined")
{link=this.getParentElement();if(link)
{if(/^img$/i.test(link.tagName))
link=link.parentNode;if(!/^a$/i.test(link.tagName))
link=null;}}
if(!link)
{var sel=editor._getSelection();var range=editor._createRange(sel);var compare=0;if(HTMLArea.is_ie)
{compare=range.compareEndPoints("StartToEnd",range);}
else
{compare=range.compareBoundaryPoints(range.START_TO_END,range);}
if(compare==0)
{alert("You need to select some text before creating a link");return;}
outparam={f_href:'',f_title:'',f_target:'',f_usetarget:editor.config.makeLinkShowsTarget};}
else
outparam={f_href:HTMLArea.is_ie?editor.stripBaseURL(link.href):link.getAttribute("href"),f_title:link.title,f_target:link.target,f_usetarget:editor.config.makeLinkShowsTarget};this._popupDialog(editor.config.URIs["link"],function(param)
{if(!param)
return false;var a=link;if(!a)try
{editor._doc.execCommand("createlink",false,param.f_href);a=editor.getParentElement();var sel=editor._getSelection();var range=editor._createRange(sel);if(!HTMLArea.is_ie)
{a=range.startContainer;if(!/^a$/i.test(a.tagName))
{a=a.nextSibling;if(a==null)
a=range.startContainer.parentNode;}}}catch(e){}
else
{var href=param.f_href.trim();editor.selectNodeContents(a);if(href=="")
{editor._doc.execCommand("unlink",false,null);editor.updateToolbar();return false;}
else
{a.href=href;}}
if(!(a&&/^a$/i.test(a.tagName)))
return false;a.target=param.f_target.trim();a.title=param.f_title.trim();editor.selectNodeContents(a);editor.updateToolbar();return true;},outparam);};HTMLArea.prototype._insertImage=function(image)
{this.ddt._ddt("htmlarea.js","6032","_insertImage(): top");var editor=this;var outparam=null;if(typeof image=="undefined")
{image=this.getParentElement();if(image&&!/^img$/i.test(image.tagName))
image=null;}
if(image)outparam={f_base:editor.config.baseURL,f_url:HTMLArea.is_ie?editor.stripBaseURL(image.src):image.getAttribute("src"),f_alt:image.alt,f_border:image.border,f_align:image.align,f_vert:image.vspace,f_horiz:image.hspace};this._popupDialog(editor.config.URIs["insert_image"],function(param)
{if(!param)
{return false;}
var img=image;if(!img)
{var sel=editor._getSelection();var range=editor._createRange(sel);editor._doc.execCommand("insertimage",false,param.f_url);if(HTMLArea.is_ie)
{img=range.parentElement();if(img.tagName.toLowerCase()!="img")
{img=img.previousSibling;}}
else
{img=range.startContainer.previousSibling;}}
else
{img.src=param.f_url;}
for(var field in param)
{var value=param[field];switch(field)
{case"f_alt":img.alt=value;break;case"f_border":img.border=parseInt(value||"0");break;case"f_align":img.align=value;break;case"f_vert":img.vspace=parseInt(value||"0");break;case"f_horiz":img.hspace=parseInt(value||"0");break;}}
return true;},outparam);};HTMLArea.prototype._insertTable=function()
{this.ddt._ddt("htmlarea.js","6123","_insertTable(): top");var sel=this._getSelection();var range=this._createRange(sel);var editor=this;this._popupDialog(editor.config.URIs["insert_table"],function(param)
{if(!param)
{return false;}
var doc=editor._doc;var table=doc.createElement("table");for(var field in param)
{var value=param[field];if(!value)
{continue;}
switch(field)
{case"f_width":table.style.width=value+param["f_unit"];break;case"f_align":table.align=value;break;case"f_border":table.border=parseInt(value);break;case"f_spacing":table.cellSpacing=parseInt(value);break;case"f_padding":table.cellPadding=parseInt(value);break;}}
var cellwidth=0;if(param.f_fixed)
cellwidth=Math.floor(100/parseInt(param.f_cols));var tbody=doc.createElement("tbody");table.appendChild(tbody);for(var i=0;i<param["f_rows"];++i)
{var tr=doc.createElement("tr");tbody.appendChild(tr);for(var j=0;j<param["f_cols"];++j)
{var td=doc.createElement("td");if(cellwidth)
td.style.width=cellwidth+"%";tr.appendChild(td);(HTMLArea.is_gecko)&&td.appendChild(doc.createElement("br"));}}
if(HTMLArea.is_ie)
{range.pasteHTML(table.outerHTML);}
else
{editor.insertNodeAtSelection(table);}
return true;},null);};HTMLArea.prototype._comboSelected=function(el,txt)
{this.ddt._ddt("htmlarea.js","6215","_comboSelected(): top");this.focusEditor();var value=el.options[el.selectedIndex].value;switch(txt)
{case"fontname":case"fontsize":this.execCommand(txt,false,value);break;case"formatblock":value="<"+value+">"
this.execCommand(txt,false,value);break;default:var dropdown=this.config.customSelects[txt];if(typeof dropdown!="undefined")
{dropdown.action(this);}
else
{alert("FIXME: combo box "+txt+" not implemented");}}};HTMLArea.prototype.execCommand=function(cmdID,UI,param)
{this.ddt._ddt("htmlarea.js","6255","execCommand(): top with cmdId '"+cmdID+"'");var editor=this;this.focusEditor();cmdID=cmdID.toLowerCase();if(HTMLArea.is_gecko)
{try
{this._doc.execCommand('useCSS',false,true);}
catch(e){};}
switch(cmdID)
{case"htmlmode":this.ddt._ddtDumpNode("htmlarea.js","5978","execCommand(): htmlmode command. Switching modes. Current document is:",this._doc.body);this.setMode();this.ddt._ddtDumpNode("htmlarea.js","5978","execCommand(): htmlmode command. after switch. Document is:",this._doc.body);break;case"hilitecolor":(HTMLArea.is_ie)&&(cmdID="backcolor");case"forecolor":this._popupDialog(editor.config.URIs["select_color"],function(color)
{if(color)
{editor._doc.execCommand(cmdID,false,"#"+color);}},HTMLArea._colorToRgb(this._doc.queryCommandValue(cmdID)));break;case"createlink":this._createLink();break;case"popupeditor":HTMLArea._object=this;var win;if(HTMLArea.is_ie)
{{win=window.open(this.popupURL(editor.config.URIs["fullscreen"]),"ha_fullscreen","toolbar=no,location=no,directories=no,status=no,menubar=no,"+"scrollbars=no,resizable=yes,width=640,height=480");}}
else
{win=window.open(this.popupURL(editor.config.URIs["fullscreen"]),"ha_fullscreen","toolbar=no,menubar=no,personalbar=no,width=640,height=480,"+"scrollbars=no,resizable=yes");}
win.focus()
break;case"undo":case"redo":if(this._customUndo)
this[cmdID]();else
this._doc.execCommand(cmdID,UI,param);break;case"inserttable":this._insertTable();break;case"insertimage":this._insertImage();break;case"about":this._popupDialog(editor.config.URIs["about"],null,this);break;case"showhelp":window.open(this.config.helpURL,"ha_help");break;case"killword":this._wordClean();break;case"cut":case"copy":case"paste":try
{this._doc.execCommand(cmdID,UI,param);if(this.config.killWordOnPaste)
this._wordClean();}
catch(e)
{if(HTMLArea.is_gecko)
{alert(HTMLArea._lc("The Paste button does not work in Mozilla based web browsers (technical security reasons). Press CTRL-V on your keyboard to paste directly."));}}
break;case"lefttoright":case"righttoleft":var dir=(cmdID=="righttoleft")?"rtl":"ltr";el=this.getParentElement();while(el&&!HTMLArea.isBlockElement(el))
el=el.parentNode;if(el)
{if(el.style.direction==dir)
el.style.direction="";else
el.style.direction=dir;}
break;default:this.ddt._ddt("htmlarea.js","6374","execCommand(): passing '"+cmdID+"' to internal browser command handler.");try
{this._doc.execCommand(cmdID,UI,param);}
catch(e)
{if(this.config.debug){alert(e+"\n\nby execCommand("+cmdID+");");}}}
this.updateToolbar();return false;};HTMLArea.prototype._editorEvent=function(ev)
{this.ddt._ddt("htmlarea.js","6405","_editorEvent(): top with event type '"+ev.type+"'");var editor=this;var keyEvent=(HTMLArea.is_ie&&ev.type=="keydown")||(!HTMLArea.is_ie&&ev.type=="keypress");var m=null;var leftText=null;var rightText=null;var midText=null;var textNode=null;var fn=null;if(typeof editor._textArea['on'+ev.type]=="function")
{editor._textArea['on'+ev.type]();}
if(HTMLArea.is_gecko&&keyEvent&&ev.ctrlKey&&this._unLink&&this._unlinkOnUndo)
{if(String.fromCharCode(ev.charCode).toLowerCase()=='z')
{HTMLArea._stopEvent(ev);this._unLink();editor.updateToolbar();return;}}
if(keyEvent)
{this.ddt._ddt("htmlarea.js","6436","_editorEvent(): keyEvent");for(var i in editor.plugins)
{var plugin=editor.plugins[i].instance;this.ddt._ddt("htmlarea.js","6451","_editorEvent(): plugin '"+(plugin.name?plugin.name:"unknown")+"'");if(typeof plugin.onKeyPress=="function")
{this.ddt._ddt("htmlarea.js","6456","_editorEvent(): keyEvent - invoking onKeyPress method in plugin '"+(plugin.name?plugin.name:"unknown")+"'");if(plugin.onKeyPress(ev))
{this.ddt._ddt("htmlarea.js","6461","_editorEvent(): keyEvent - onKeyPress() returned false. Returning false");return false;}}}}
if(keyEvent&&ev.ctrlKey&&!ev.altKey)
{this.ddt._ddt("htmlarea.js","6472","_editorEvent(): control key key event");var sel=null;var range=null;var key=String.fromCharCode(HTMLArea.is_ie?ev.keyCode:ev.charCode).toLowerCase();var cmd=null;var value=null;switch(key)
{case'a':this.ddt._ddt("htmlarea.js","6484","_editorEvent(): cntrl-a select all");if(!HTMLArea.is_ie)
{sel=this._getSelection();sel.removeAllRanges();range=this._createRange();range.selectNodeContents(this._doc.body);sel.addRange(range);HTMLArea._stopEvent(ev);}
break;case'b':this.ddt._ddt("htmlarea.js","6503","_editorEvent(): cntrl-b bold");cmd="bold";break;case'i':this.ddt._ddt("htmlarea.js","6509","_editorEvent(): cntrl-i italics");cmd="italic";break;case'u':this.ddt._ddt("htmlarea.js","6515","_editorEvent(): cntrl-u underline");cmd="underline";break;case's':this.ddt._ddt("htmlarea.js","6521","_editorEvent(): cntrl-s strikethrough");cmd="strikethrough";break;case'l':this.ddt._ddt("htmlarea.js","6527","_editorEvent(): cntrl-l justify left");cmd="justifyleft";break;case'e':this.ddt._ddt("htmlarea.js","6533","_editorEvent(): cntrl-e justify center");cmd="justifycenter";break;case'r':this.ddt._ddt("htmlarea.js","6539","_editorEvent(): cntrl-r justify right");cmd="justifyright";break;case'j':this.ddt._ddt("htmlarea.js","6545","_editorEvent(): cntrl-j justify full");cmd="justifyfull";break;case'z':this.ddt._ddt("htmlarea.js","6551","_editorEvent(): cntrl-z undo");cmd="undo";break;case'y':this.ddt._ddt("htmlarea.js","6557","_editorEvent(): cntrl-y redo");cmd="redo";break;case'v':this.ddt._ddt("htmlarea.js","6563","_editorEvent(): cntrl-v paste");if(HTMLArea.is_ie||editor.config.htmlareaPaste)
{cmd="paste";}
break;case'n':this.ddt._ddt("htmlarea.js","6572","_editorEvent(): cntrl-n format block");cmd="formatblock";value=HTMLArea.is_ie?"<p>":"p";break;case'0':this.ddt._ddt("htmlarea.js","6579","_editorEvent(): cntrl-O kill word");cmd="killword";break;case'1':case'2':case'3':case'4':case'5':case'6':this.ddt._ddt("htmlarea.js","6591","_editorEvent(): cntrl-[1-6] heading");cmd="formatblock";value="h"+key;if(HTMLArea.is_ie)
value="<"+value+">";break;}
if(cmd)
{this.ddt._ddt("htmlarea.js","6602","_editorEvent(): executing simple command '"+cmd+"'");this.execCommand(cmd,false,value);HTMLArea._stopEvent(ev);}}
else if(keyEvent)
{if(HTMLArea.is_gecko)
{var s=editor._getSelection()
var autoWrap=function(textNode,tag)
{rightText=textNode.nextSibling;if(typeof tag=='string')tag=editor._doc.createElement(tag);var a=textNode.parentNode.insertBefore(tag,rightText);textNode.parentNode.removeChild(textNode);a.appendChild(textNode);rightText.data=' '+rightText.data;if(HTMLArea.is_ie)
{var r=editor._createRange(s);s.moveToElementText(rightText);s.move('character',1);}
else
{s.collapse(rightText,1);}
HTMLArea._stopEvent(ev);editor._unLink=function()
{var t=a.firstChild;a.removeChild(t);a.parentNode.insertBefore(t,a);a.parentNode.removeChild(a);editor._unLink=null;editor._unlinkOnUndo=false;}
editor._unlinkOnUndo=true;return a;}
switch(ev.which)
{case 32:{this.ddt._ddt("htmlarea.js","6668","_editorEvent(): entered a space");if(s&&s.isCollapsed&&s.anchorNode.nodeType==3&&s.anchorNode.data.length>3&&s.anchorNode.data.indexOf('.')>=0)
{var midStart=s.anchorNode.data.substring(0,s.anchorOffset).search(/\S{4,}$/);if(midStart==-1)break;if(this._getFirstAncestor(s,'a'))
{break;}
var matchData=s.anchorNode.data.substring(0,s.anchorOffset).replace(/^.*?(\S*)$/,'$1');m=matchData.match(HTMLArea.RE_email);if(m)
{leftText=s.anchorNode;rightText=leftText.splitText(s.anchorOffset);midText=leftText.splitText(midStart);autoWrap(midText,'a').href='mailto:'+m[0];break;}
m=matchData.match(HTMLArea.RE_url);if(m)
{leftText=s.anchorNode;rightText=leftText.splitText(s.anchorOffset);midText=leftText.splitText(midStart);autoWrap(midText,'a').href=(m[1]?m[1]:'http://')+m[2];break;}}}
break;default:{this.ddt._ddt("htmlarea.js","6711","_editorEvent(): keycode is '"+ev.keyCode+"' which (normal key) is '"+ev.which+"'");if(ev.keyCode==27||(this._unlinkOnUndo&&ev.ctrlKey&&ev.which==122))
{if(this._unLink)
{this._unLink();HTMLArea._stopEvent(ev);}
break;}
else if(ev.which||ev.keyCode==8||ev.keyCode==46)
{this.ddt._ddt("htmlarea.js","6729","_editorEvent(): normal key or backspace or period");this._unlinkOnUndo=false;if(s.anchorNode&&s.anchorNode.nodeType==3)
{var a=this._getFirstAncestor(s,'a');if(!a)
{this.ddt._ddt("htmlarea.js","6741","_editorEvent(): not an anchor");break;}
if(!a._updateAnchTimeout)
{if(s.anchorNode.data.match(HTMLArea.RE_email)&&(a.href.match('mailto:'+s.anchorNode.data.trim())))
{textNode=s.anchorNode;fn=function()
{a.href='mailto:'+textNode.data.trim();a._updateAnchTimeout=setTimeout(fn,250);}
a._updateAnchTimeout=setTimeout(fn,250);break;}
m=s.anchorNode.data.match(HTMLArea.RE_url);if(m&&a.href.match(s.anchorNode.data.trim()))
{textNode=s.anchorNode;fn=function()
{m=textNode.data.match(HTMLArea.RE_url);a.href=(m[1]?m[1]:'http://')+m[2];a._updateAnchTimeout=setTimeout(fn,250);}
a._updateAnchTimeout=setTimeout(fn,250);}}}}}
break;}}
switch(ev.keyCode)
{case 13:this.ddt._ddt("htmlarea.js","6792","_editorEvent(): enter key handling");if(HTMLArea.is_gecko&&!ev.shiftKey&&this.config.mozParaHandler=='dirty')
{this.dom_checkInsertP();HTMLArea._stopEvent(ev);}
break;case 8:case 46:this.ddt._ddt("htmlarea.js","6804","_editorEvent(): delete or backspace handling");if(HTMLArea.is_gecko&&!ev.shiftKey)
{if(this.dom_checkBackspace())
HTMLArea._stopEvent(ev);}
else if(HTMLArea.is_ie)
{if(this.ie_checkBackspace())
HTMLArea._stopEvent(ev);}
break;}}
if(editor._timerToolbar)
{clearTimeout(editor._timerToolbar);}
editor._timerToolbar=setTimeout(function()
{editor.updateToolbar();editor._timerToolbar=null;},100);this.ddt._ddt("htmlarea.js","6835","_editorEvent(): bottom");return true;}
HTMLArea.prototype.convertNode=function(el,newTagName)
{this.ddt._ddt("htmlarea.js","6849","convertNode(): top");var newel=this._doc.createElement(newTagName);while(el.firstChild)
newel.appendChild(el.firstChild);return newel;};HTMLArea.prototype.ie_checkBackspace=function()
{var sel=this._getSelection();var range=this._createRange(sel);if(range.text=="undefined")return true;var r2=range.duplicate();r2.moveStart("character",-1);var a=r2.parentElement();if(a!=range.parentElement()&&/^a$/i.test(a.tagName))
{r2.collapse(true);r2.moveEnd("character",1);r2.pasteHTML('');r2.select();return true;}};HTMLArea.prototype.dom_checkBackspace=function()
{this.ddt._ddt("htmlarea.js","6895","dom_checkBackspace(): top");var self=this;setTimeout(function()
{var sel=self._getSelection();var range=self._createRange(sel);var SC=range.startContainer;var SO=range.startOffset;var EC=range.endContainer;var EO=range.endOffset;var newr=SC.nextSibling;if(SC.nodeType==3)
SC=SC.parentNode;if(!/\S/.test(SC.tagName))
{var p=document.createElement("p");while(SC.firstChild)
p.appendChild(SC.firstChild);SC.parentNode.insertBefore(p,SC);SC.parentNode.removeChild(SC);var r=range.cloneRange();r.setStartBefore(newr);r.setEndAfter(newr);r.extractContents();sel.removeAllRanges();sel.addRange(r);}},10);};HTMLArea.prototype.dom_checkInsertP=function()
{this.ddt._ddt("dom_checkInsertP(): top")
var sel=this._getSelection();var range=this._createRange(sel);if(!range.collapsed)
{range.deleteContents();}
this.deactivateEditor();var SC=range.startContainer;var SO=range.startOffset;var EC=range.endContainer;var EO=range.endOffset;if(SC==EC&&SC==body&&!SO&&!EO)
{p=this._doc.createTextNode(" ");body.insertBefore(p,body.firstChild);range.selectNodeContents(p);SC=range.startContainer;SO=range.startOffset;EC=range.endContainer;EO=range.endOffset;}
var p=this.getAllAncestors();var block=null;var body=this._doc.body;for(var i=0;i<p.length;++i)
{if(HTMLArea.isParaContainer(p[i]))
{break;}
else if(HTMLArea.isBlockElement(p[i])&&!/body|html/i.test(p[i].tagName))
{block=p[i];break;}}
if(!block)
{var wrap=range.startContainer;while(wrap.parentNode&&!HTMLArea.isParaContainer(wrap.parentNode))
{wrap=wrap.parentNode;}
var start=wrap;var end=wrap;while(start.previousSibling)
{if(start.previousSibling.tagName)
{if(!HTMLArea.isBlockElement(start.previousSibling))
{start=start.previousSibling;}
else
{break;}}
else
{start=start.previousSibling;}}
while(end.nextSibling)
{if(end.nextSibling.tagName)
{if(!HTMLArea.isBlockElement(end.nextSibling))
{end=end.nextSibling;}
else
{break;}}
else
{end=end.nextSibling;}}
range.setStartBefore(start);range.setEndAfter(end);range.surroundContents(this._doc.createElement('p'));block=range.startContainer.firstChild;range.setStart(SC,SO);}
range.setEndAfter(block);var r2=range.cloneRange();sel.removeRange(range);var df=r2.extractContents();if(df.childNodes.length==0)
{df.appendChild(this._doc.createElement('p'));df.firstChild.appendChild(this._doc.createElement('br'));}
if(df.childNodes.length>1)
{var nb=this._doc.createElement('p');while(df.firstChild)
{var s=df.firstChild;df.removeChild(s);nb.appendChild(s);}
df.appendChild(nb);}
if(!/\S/.test(block.innerHTML))
block.innerHTML="&nbsp;";p=df.firstChild;if(!/\S/.test(p.innerHTML))
p.innerHTML="<br />";if(/^\s*<br\s*\/?>\s*$/.test(p.innerHTML)&&/^h[1-6]$/i.test(p.tagName))
{df.appendChild(this.convertNode(p,"p"));df.removeChild(p);}
var newblock=block.parentNode.insertBefore(df.firstChild,block.nextSibling);this.activateEditor();sel=this._getSelection();sel.removeAllRanges();sel.collapse(newblock,0);this.scrollToElement(newblock);};HTMLArea.prototype.scrollToElement=function(e)
{this.ddt._ddt("htmlarea.js","7162","scrollToElement(): top");if(HTMLArea.is_gecko)
{var top=0;var left=0;while(e)
{top+=e.offsetTop;left+=e.offsetLeft;if(e.offsetParent&&e.offsetParent.tagName.toLowerCase()!='body')
{e=e.offsetParent;}
else
{e=null;}}
this._iframe.contentWindow.scrollTo(left,top);}}
HTMLArea.prototype.getHTML=function()
{this.ddt._ddt("htmlarea.js","7198","getHTML() - prototype version - top");var html='';switch(this._editMode)
{case"wysiwyg":{if(!this.config.fullPage)
{this.ddt._ddt("htmlarea.js","7209","getHTML() - not full page, in wysiwyg mode.");html=HTMLArea.getHTML(this._doc.body,false,this);}
else
{html=this.doctype+"\n"+HTMLArea.getHTML(this._doc.documentElement,true,this);}
break;}
case"textmode":{this.ddt._ddt("htmlarea.js","7224","getHTML() - text mode.");html=this._textArea.value;break;}
default:{alert("Mode <"+mode+"> not defined!");return false;}}
this.ddt._ddt("htmlarea.js","7237","getHTML() - prototype version - end with html '"+html+"'");return html;};HTMLArea.prototype.outwardHtml=function(html)
{this.ddt._ddt("htmlarea.js","7254","outwardHtml(): top - html is "+html);var serverBase=null;html=html.replace(/<(\/?)b(\s|>|\/)/ig,"<$1strong$2");html=html.replace(/<(\/?)i(\s|>|\/)/ig,"<$1em$2");if(this.config.linkReplacementMode=='fullyqualified')
{serverBase=location.href.replace(/(https?:\/\/[^\/]*)\/.*/,'$1')+'/';this.ddt._ddt("htmlarea.js","7269","outwardHtml(): replacing links with fully qualified versions - serverBase is '"+serverBase+"'.");html=html.replace(/https?:\/\/null\//g,serverBase);html=html.replace(/((href|src|background)=[\'\"])\/+/ig,'$1'+serverBase);}
else
{serverBase=location.href.replace(/(https?:\/\/[^\/]*)\/.*/,'$1');this.ddt._ddt("htmlarea.js","7287","outwardHtml(): stripping serverBase from links '"+serverBase+"'.");var linkBackRE=new RegExp("((href|src|background)=['\"])"+serverBase,"ig");this.ddt._ddt("htmlarea.js","7297","outwardHtml(): regex is '"+linkBackRE+"'");html=html.replace(linkBackRE,'$1');html=html.replace(/https?:\/\/null/g,"");}
html=this.outwardSpecialReplacements(html);html=this.fixRelativeLinks(html);return html;}
HTMLArea.prototype.inwardHtml=function(html)
{this.ddt._ddt("htmlarea.js","7328","inwardHtml(): top");if(HTMLArea.is_gecko)
{html=html.replace(/<(\/?)strong(\s|>|\/)/ig,"<$1b$2");html=html.replace(/<(\/?)em(\s|>|\/)/ig,"<$1i$2");}
html=this.inwardSpecialReplacements(html);var nullRE=new RegExp('((href|src|background)=[\'"])/+','gi');html=html.replace(nullRE,'$1'+location.href.replace(/(https?:\/\/[^\/]*)\/.*/,'$1')+'/');html=this.fixRelativeLinks(html);return html;}
HTMLArea.prototype.outwardSpecialReplacements=function(html)
{this.ddt._ddt("htmlarea.js","7373","outwardSpecialReplacements(): top");for(var i in this.config.specialReplacements)
{var from=this.config.specialReplacements[i];var to=i;var reg=new RegExp(from.replace(HTMLArea.RE_Specials,'\\$1'),'g');html=html.replace(reg,to.replace(/\$/g,'$$$$'));}
return html;}
HTMLArea.prototype.inwardSpecialReplacements=function(html)
{this.ddt._ddt("htmlarea.js","7397","inwardSpecialReplacements(): top");for(var i in this.config.specialReplacements)
{var from=i;var to=this.config.specialReplacements[i];var reg=new RegExp(from.replace(HTMLArea.RE_Specials,'\\$1'),'g');html=html.replace(reg,to.replace(/\$/g,'$$$$'));}
return html;}
HTMLArea.prototype.fixRelativeLinks=function(html)
{this.ddt._ddt("htmlarea.js","7429","fixRelativeLinks(): top");if(typeof this.config.stripSelfNamedAnchors!='undefined'&&this.config.stripSelfNamedAnchors)
{this.ddt._ddt("htmlarea.js","7434","fixRelativeLinks(): handling stripSelfNamedAnchors()");var stripRe=new RegExp(document.location.href.replace(HTMLArea.RE_Specials,'\\$1')+'(#.*)','g');html=html.replace(stripRe,'$1');}
if(typeof this.config.stripBaseHref!='undefined'&&this.config.stripBaseHref)
{this.ddt._ddt("htmlarea.js","7443","fixRelativeLinks(): handling stripBaseHref()");var baseRe=null
if(typeof this.config.baseHref!='undefined'&&this.config.baseHref!=null)
{baseRe=new RegExp(this.config.baseHref.replace(HTMLArea.RE_Specials,'\\$1'),'g');}
else
{baseRe=new RegExp(document.location.href.replace(/([^\/]*\/?)$/,'').replace(HTMLArea.RE_Specials,'\\$1'),'g');}
html=html.replace(baseRe,'');}
if(HTMLArea.is_ie)
{}
this.ddt._ddt("htmlarea.js","7468","fixRelativeLinks(): returning html "+html);return html;}
HTMLArea.prototype.stripBaseURL=function(string)
{this.ddt._ddt("htmlarea.js","7483","stripBaseURL(): top");var baseurl=this.config.baseURL;baseurl=baseurl.replace(/[^\/]+$/,'');var basere=new RegExp(baseurl);string=string.replace(basere,"");baseurl=baseurl.replace(/^(https?:\/\/[^\/]+)(.*)$/,'$1');basere=new RegExp(baseurl);return string.replace(basere,"");};HTMLArea.prototype.getInnerHTML=function()
{this.ddt._ddt("htmlarea.js","7511","getInnerHTML(): top");if(!this._doc.body)return'';var html=null;switch(this._editMode)
{case"wysiwyg":if(!this.config.fullPage)
html=this._doc.body.innerHTML;else
html=this.doctype+"\n"+this._doc.documentElement.innerHTML;break;case"textmode":html=this._textArea.value;break;default:alert("Mode <"+mode+"> not defined!");return false;}
return html;};HTMLArea.prototype.setHTML=function(html)
{this.ddt._ddt("htmlarea.js","7550","setHTML(): top");switch(this._editMode)
{case"wysiwyg":if(!this.config.fullPage)
{this._doc.body.innerHTML=html;}
else
{this._doc.body.innerHTML=html;}
break;case"textmode":this._textArea.value=html;break;default:alert("Mode <"+mode+"> not defined!");}
return false;};HTMLArea.prototype.setDoctype=function(doctype)
{this.doctype=doctype;};HTMLArea.prototype._getSelection=function()
{this.ddt._ddt("htmlarea.js","7602","_getSelection(): top");if(HTMLArea.is_ie)
{return this._doc.selection;}
else
{return this._iframe.contentWindow.getSelection();}};HTMLArea.prototype._createRange=function(sel)
{this.ddt._ddt("htmlarea.js","7625","_createRange(): top");if(HTMLArea.is_ie)
{return sel.createRange();}
else
{this.activateEditor();if(typeof sel!="undefined")
{try
{this.ddt._ddt("htmlarea.js","7641","_createRange(): attempting to create a range using getRangeAt(0) on current selection.");return sel.getRangeAt(0);}
catch(e)
{this.ddt._ddt("htmlarea.js","7646","_createRange(): getRangeAt(0) failed, using createRange");return this._doc.createRange();}}
else
{this.ddt._ddt("htmlarea.js","7652","_createRange(): creating a new range.");return this._doc.createRange();}}};HTMLArea.prototype.notifyOn=function(ev,fn)
{this.ddt._ddt("htmlarea.js","7668","notifyOn(): top");if(typeof this._notifyListeners[ev]=='undefined')
{this._notifyListeners[ev]=[];}
this._notifyListeners[ev].push(fn);}
HTMLArea.prototype.notifyOf=function(ev,args)
{this.ddt._ddt("htmlarea.js","7688","notifyOf(): top");if(this._notifyListeners[ev])
{for(var i=0;i<this._notifyListeners[ev].length;i++)
{this._notifyListeners[ev][i](ev,args);}}}
HTMLArea.prototype._popupDialog=function(url,action,init)
{this.ddt._ddt("htmlarea.js","7715","_popupDialog(): top with url '"+url+"' action '"+action+"'");Dialog(this.popupURL(url),action,init);};HTMLArea.prototype.imgURL=function(file,plugin)
{if(typeof plugin=="undefined")
return _editor_url+file;else
return _editor_url+"plugins/"+plugin+"/img/"+file;};HTMLArea.prototype.popupURL=function(file)
{var url="";if(file.match(/^plugin:\/\/(.*?)\/(.*)/))
{var plugin=RegExp.$1;var popup=RegExp.$2;if(!/\.html$/.test(popup))
popup+=".html";url=_editor_url+"plugins/"+plugin+"/popups/"+popup;}
else if(file.match(/^\/.*?/))
url=file;else
url=_editor_url+this.config.popupURL+file;return url;};HTMLArea.prototype._toggleBorders=function()
{tables=this._doc.getElementsByTagName('TABLE');if(tables.length!=0)
{if(!this.borders)
{name="bordered";this.borders=true;}
else
{name="";this.borders=false;}
for(var ix=0;ix<tables.length;ix++)
{if(this.borders)
{HTMLArea._addClass(tables[ix],'htmtableborders');}
else
{HTMLArea._removeClass(tables[ix],'htmtableborders');}}}
return true;}
HTMLArea.prototype.registerPlugins=function(plugin_names)
{this.ddt._ddt("htmlarea.js","7808","registerPlugins(): top");if(plugin_names)
{for(var i=0;i<plugin_names.length;i++)
{this.registerPlugin(eval(plugin_names[i]));}}}
if(!Array.prototype.contains)
{Array.prototype.contains=function(needle)
{var haystack=this;for(var i=0;i<haystack.length;i++)
{if(needle==haystack[i])return true;}
return false;}}
if(!Array.prototype.indexOf)
{Array.prototype.indexOf=function(needle)
{var haystack=this;for(var i=0;i<haystack.length;i++)
{if(needle==haystack[i])return i;}
return null;}}
if(!Array.prototype.append)
{Array.prototype.append=function(a)
{for(var i=0;i<a.length;i++)
{this.push(a[i]);}
return this;}}
String.prototype.trim=function()
{return this.replace(/^\s+/,'').replace(/\s+$/,'');};if(typeof dump=='undefined')
{function dump(o){var s='';for(var prop in o){s+=prop+' = '+o[prop]+'\n';}
x=window.open("","debugger");x.document.write('<pre>'+s+'</pre>');}}