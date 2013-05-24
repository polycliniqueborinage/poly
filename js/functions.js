function confirmLinkDropDB(theLink,theSqlQuery){if(confirmMsg==''||typeof(window.opera)!='undefined'){return true;}var is_confirmed=confirm(confirmMsgDropDB+'\n'+confirmMsg+' :\n'+theSqlQuery);if(is_confirmed){theLink.href+='&is_js_confirmed=1';}return is_confirmed;}function confirmLink(theLink,theSqlQuery){if(confirmMsg==''||typeof(window.opera)!='undefined'){return true;}var is_confirmed=confirm(confirmMsg);if(is_confirmed){theLink.href+='&is_js_confirmed=1';}return is_confirmed;}function confirmLinkCloture(theLink,theSqlQuery){if(confirmMsgCloture==''||typeof(window.opera)!='undefined'){return true;}var is_confirmed=confirm(confirmMsgCloture);if(is_confirmed){theLink.href+='&is_js_confirmed=1';}return is_confirmed;}function confirmQuery(theForm1,sqlQuery1){if(confirmMsg==''){return true;}else if(typeof(sqlQuery1.value.replace)=='undefined'){return true;}else{if(noDropDbMsg!=''){var drop_re=new RegExp('DROP\\s+(IF EXISTS\\s+)?DATABASE\\s','i');if(drop_re.test(sqlQuery1.value)){alert(noDropDbMsg);theForm1.reset();sqlQuery1.focus();return false;}}var do_confirm_re_0=new RegExp('^DROP\\s+(IF EXISTS\\s+)?(TABLE|DATABASE)\\s','i');var do_confirm_re_1=new RegExp('^ALTER\\s+TABLE\\s+((`[^`]+`)|([A-Za-z0-9_$]+))\\s+DROP\\s','i');var do_confirm_re_2=new RegExp('^DELETE\\s+FROM\\s','i');if(do_confirm_re_0.test(sqlQuery1.value)||do_confirm_re_1.test(sqlQuery1.value)||do_confirm_re_2.test(sqlQuery1.value)){var message=(sqlQuery1.value.length>100)?sqlQuery1.value.substr(0,100)+'\n    ...':sqlQuery1.value;var is_confirmed=confirm(confirmMsg+' :\n'+message);if(is_confirmed){theForm1.elements['is_js_confirmed'].value=1;return true;}else{window.focus();sqlQuery1.focus();return false;}}}return true;}function checkSqlQuery(theForm){var sqlQuery=theForm.elements['sql_query'];var isEmpty=1;if(typeof(sqlQuery.value.replace)=='undefined'){isEmpty=(sqlQuery.value=='')?1:0;if(isEmpty&&typeof(theForm.elements['sql_file'])!='undefined'){isEmpty=(theForm.elements['sql_file'].value=='')?1:0;}if(isEmpty&&typeof(theForm.elements['sql_localfile'])!='undefined'){isEmpty=(theForm.elements['sql_localfile'].value=='')?1:0;}if(isEmpty&&typeof(theForm.elements['id_bookmark'])!='undefined'){isEmpty=(theForm.elements['id_bookmark'].value==null||theForm.elements['id_bookmark'].value=='');}}else{var space_re=new RegExp('\\s+');if(typeof(theForm.elements['sql_file'])!='undefined'&&theForm.elements['sql_file'].value.replace(space_re,'')!=''){return true;}if(typeof(theForm.elements['sql_localfile'])!='undefined'&&theForm.elements['sql_localfile'].value.replace(space_re,'')!=''){return true;}if(isEmpty&&typeof(theForm.elements['id_bookmark'])!='undefined'&&(theForm.elements['id_bookmark'].value!=null||theForm.elements['id_bookmark'].value!='')&&theForm.elements['id_bookmark'].selectedIndex!=0){return true;}if(sqlQuery.value.replace(space_re,'')!=''){if(confirmQuery(theForm,sqlQuery)){return true;}else{return false;}}theForm.reset();isEmpty=1;}if(isEmpty){sqlQuery.select();alert(errorMsg0);sqlQuery.focus();return false;}return true;}function emptyFormElements(theForm,theFieldName){var isEmpty=1;var theField=theForm.elements[theFieldName];var isRegExp=(typeof(theField.value.replace)!='undefined');if(!isRegExp){isEmpty=(theField.value=='')?1:0;}else{var space_re=new RegExp('\\s+');isEmpty=(theField.value.replace(space_re,'')=='')?1:0;}if(isEmpty){theForm.reset();theField.select();alert(errorMsg0);theField.focus();return false;}return true;}function checkFormElementInRange(theForm,theFieldName,min,max){var theField=theForm.elements[theFieldName];var val=parseInt(theField.value);if(typeof(min)=='undefined'){min=0;}if(typeof(max)=='undefined'){max=Number.MAX_VALUE;}if(isNaN(val)){theField.select();alert(errorMsg1);theField.focus();return false;}else if(val<min||val>max){theField.select();alert(val+errorMsg2);theField.focus();return false;}else{theField.value=val;}return true;}function checkTableEditForm(theForm,fieldsCnt){for(i=0;i<fieldsCnt;i++){var id="field_"+i+"_2";var elm=getElement(id);if(elm.value=='VARCHAR'||elm.value=='CHAR'){elm2=getElement("field_"+i+"_3");val=parseInt(elm2.value);elm3=getElement("field_"+i+"_1");if(isNaN(val)&&elm3.value!=""){elm2.select();alert(errorMsg1);elm2.focus();return false;}}}return true;}function checkTransmitDump(theForm,theAction){var formElts=theForm.elements;if(theAction=='zip'&&formElts['zip'].checked){if(!formElts['asfile'].checked){theForm.elements['asfile'].checked=true;}if(typeof(formElts['gzip'])!='undefined'&&formElts['gzip'].checked){theForm.elements['gzip'].checked=false;}if(typeof(formElts['bzip'])!='undefined'&&formElts['bzip'].checked){theForm.elements['bzip'].checked=false;}}else if(theAction=='gzip'&&formElts['gzip'].checked){if(!formElts['asfile'].checked){theForm.elements['asfile'].checked=true;}if(typeof(formElts['zip'])!='undefined'&&formElts['zip'].checked){theForm.elements['zip'].checked=false;}if(typeof(formElts['bzip'])!='undefined'&&formElts['bzip'].checked){theForm.elements['bzip'].checked=false;}}else if(theAction=='bzip'&&formElts['bzip'].checked){if(!formElts['asfile'].checked){theForm.elements['asfile'].checked=true;}if(typeof(formElts['zip'])!='undefined'&&formElts['zip'].checked){theForm.elements['zip'].checked=false;}if(typeof(formElts['gzip'])!='undefined'&&formElts['gzip'].checked){theForm.elements['gzip'].checked=false;}}else if(theAction=='transmit'&&!formElts['asfile'].checked){if(typeof(formElts['zip'])!='undefined'&&formElts['zip'].checked){theForm.elements['zip'].checked=false;}if((typeof(formElts['gzip'])!='undefined'&&formElts['gzip'].checked)){theForm.elements['gzip'].checked=false;}if((typeof(formElts['bzip'])!='undefined'&&formElts['bzip'].checked)){theForm.elements['bzip'].checked=false;}}return true;}var marked_row=new Array;function setPointer(theRow,theRowNum,theActionInteger){var theDefaultColor="#D5D5D5";var thePointerColor="#f8e9c6";var theMarkColor="#FFCC99";if(theActionInteger==0){theAction="over";}if(theActionInteger==1){theAction="out";}if(theActionInteger==2){theAction="click";}var theCells=null;if((thePointerColor==''&&theMarkColor=='')||typeof(theRow.style)=='undefined'){return false;}if(typeof(document.getElementsByTagName)!='undefined'){theCells=theRow.getElementsByTagName('td');}else if(typeof(theRow.cells)!='undefined'){theCells=theRow.cells;}else{return false;}var rowCellsCnt=theCells.length;var domDetect=null;var currentColor=null;var newColor=null;if(typeof(window.opera)=='undefined'&&typeof(theCells[0].getAttribute)!='undefined'){currentColor=theCells[0].getAttribute('bgcolor');domDetect=true;}else{currentColor=theCells[0].style.backgroundColor;domDetect=false;}if(currentColor.indexOf("rgb")>=0){var rgbStr=currentColor.slice(currentColor.indexOf('(')+1,currentColor.indexOf(')'));var rgbValues=rgbStr.split(",");currentColor="#";var hexChars="0123456789ABCDEF";for(var i=0;i<3;i++){var v=rgbValues[i].valueOf();currentColor+=hexChars.charAt(v/16)+hexChars.charAt(v%16);}}if(currentColor==''||currentColor.toLowerCase()==theDefaultColor.toLowerCase()){if(theAction=='over'&&thePointerColor!=''){newColor=thePointerColor;}else if(theAction=='click'&&theMarkColor!=''){newColor=theMarkColor;marked_row[theRowNum]=true;}}else if(currentColor.toLowerCase()==thePointerColor.toLowerCase()&&(typeof(marked_row[theRowNum])=='undefined'||!marked_row[theRowNum])){if(theAction=='out'){newColor=theDefaultColor;}else if(theAction=='click'&&theMarkColor!=''){newColor=theMarkColor;marked_row[theRowNum]=true;}}else if(currentColor.toLowerCase()==theMarkColor.toLowerCase()){if(theAction=='click'){newColor=(thePointerColor!='')?thePointerColor:theDefaultColor;marked_row[theRowNum]=(typeof(marked_row[theRowNum])=='undefined'||!marked_row[theRowNum])?true:null;}}if(newColor){var c=null;if(domDetect){for(c=0;c<rowCellsCnt;c++){theCells[c].setAttribute('bgcolor',newColor,0);}}else{for(c=0;c<rowCellsCnt;c++){theCells[c].style.backgroundColor=newColor;}}}return true;}