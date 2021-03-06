/**
* @fileoverview inline dialog support
*/

/**
* @class Dialog
*
* constructor
*/

HTMLArea.Dialog = function(editor, html, localizer)
	{
  this.id    = { };
  this.r_id  = { }; // reverse lookup id
  this.editor   = editor;
  this.document = document;

  this.rootElem = document.createElement('div');
  this.rootElem.className = 'dialog';
  this.rootElem.style.position = 'relative';
  this.rootElem.style.display  = 'none';

  this.width  = parseInt(this.rootElem.style.width  = this.editor._iframe.style.width);
  this.height = parseInt(this.rootElem.style.height = this.editor._iframe.style.height);

  var dialog = this;
  if(typeof localizer == 'function')
  	{
    this._lc = localizer;
	  }
  else if(localizer)
  	{
    this._lc = 
			function(string)
   			{
      	return HTMLArea._lc(string,localizer);
    		}
	  }
  else
  	{
    this._lc = function(string)
    	{
      return string;
	    }
  	}

	// ok, this is just bloody ugly. Four parameters, the last three
	// are in-line functions.

  html = html.replace(/\[([a-z0-9_]+)\]/ig,
						function(fullString, id)
							{
							if(typeof dialog.id[id] == 'undefined')
								{
								dialog.id[id] = HTMLArea.uniq('Dialog');
								dialog.r_id[dialog.id[id]] = id;
								}
							return dialog.id[id];
							} ).replace(/<l10n>(.*?)<\/l10n>/ig,
						function(fullString,translate)
							{
							return dialog._lc(translate) ;
							} ).replace(/="_\((.*?)\)"/g,
						function(fullString, translate)
							{
							return '="' + dialog._lc(translate) + '"';
							}); // end of html.replace() call.

  this.rootElem.innerHTML = html;

  this.editor.innerEditor.appendChild(this.rootElem);

  this.editor.notifyOn('resize',
      function(e, args)
      	{
        dialog.width  = parseInt(dialog.rootElem.style.width  = args.editorWidth  + 'px');
        dialog.height = parseInt(dialog.rootElem.style.height = args.editorHeight + 'px');
        dialog.onresize();
      	});

	}	// end of HTMLArea.Dialog()

// --------------------------------------------------------------------------------

/**
* onresize()
*/


HTMLArea.Dialog.prototype.onresize = function()
{
  return true;
}

// --------------------------------------------------------------------------------

/**
* show()
*/

HTMLArea.Dialog.prototype.show = function(values)
	{

  // We need to preserve the selection for IE

  if(HTMLArea.is_ie)
  	{
    this._lastRange = this.editor._createRange(this.editor._getSelection());
	  }

  if(typeof values != 'undefined')
  	{
    this.setValues(values);
	  }

  this._restoreTo = [this.editor._textArea.style.display, this.editor._iframe.style.visibility, this.editor.hidePanels()];

  this.editor._textArea.style.display = 'none';
  this.editor._iframe.style.visibility   = 'hidden';
  this.rootElem.style.display   = '';

	}	// end of show()

// --------------------------------------------------------------------------------

/**
* hide()
*/

HTMLArea.Dialog.prototype.hide = function()
	{

  this.rootElem.style.display         = 'none';
  this.editor._textArea.style.display = this._restoreTo[0];
  this.editor._iframe.style.visibility   = this._restoreTo[1];
  this.editor.showPanels(this._restoreTo[2]);

  // Restore the selection
  if(HTMLArea.is_ie)
  	{
    this._lastRange.select();
	  }

  return this.getValues();

	}	// end of hide()

// --------------------------------------------------------------------------------

/**
* toggle()
*/

HTMLArea.Dialog.prototype.toggle = function()
	{
  if(this.rootElem.style.display == 'none')
  	{
    this.show();
	  }
  else
  	{
    this.hide();
	  }
	}

// --------------------------------------------------------------------------------

/**
* setValues()
*/
	
HTMLArea.Dialog.prototype.setValues = function(values)
	{

	var j = null;

  for(var i in values)
  	{


    var elems = this.getElementsByName(i);

		// loop over all the elements in the current dialog. 
		// (essentially this is a client-side html template consisting of a form
		// that has it's values set using the values array passed to us.

    for(var x = 0; x < elems.length; x++)
    	{
      var e = elems[x];

			// for the current element, if it's a select list, input, or textarea set
			// it's value ... 

      switch(e.tagName.toLowerCase())
    	  {

        case 'select'  :
        	{
          for( j = 0; j < e.options.length; j++)
          	{
            if(typeof values[i] == 'object')
            	{
              for(var k = 0; k < values[i].length; k++)
              	{
                if(values[i][k] == e.options[j].value)
                	{
                  e.options[j].selected = true;
	                }
  	            }
    	        }
            else if(values[i] == e.options[j].value)
      	      {
              e.options[j].selected = true;
        	    }
          	}
          break;

	        }	// end of select case


        case 'textarea':
        case 'input'   :
	        {
          switch(e.getAttribute('type'))
  	        {

            case 'radio'   :
            	{
              if(e.value == values[i])
              	{
                e.checked = true;
	              }
              break;
  	          }

            case 'checkbox':
    	        {
              if(typeof values[i] == 'object')
      	        {
                for( j in values[i])
        	        {
                  if(values[i][j] == e.value)
          	        {
                    e.checked = true;
            	      }
	                }
  	            }
              else
    	          {
                if(values[i] == e.value)
      	          {
                  e.checked = true;
        	        }
            	  }
							break;
  	          }	// end of checkbox case.

            default    :
	            {
              e.value = values[i];
  	          }
    	      }
          break;
      	  }	// end of textarea/input case.

        default        :
	        break;
  	    }
	    }
	  }

	}	// end of setValues()

// ------------------------------------------------------------------

/**
* getValues()
*
* return the values of all named inputs, textareas and select lists in the dialog.
*/

HTMLArea.Dialog.prototype.getValues = function()
	{
  var values = [ ];

  var inputs = HTMLArea.collectionToArray(this.rootElem.getElementsByTagName('input'))
              .append(HTMLArea.collectionToArray(this.rootElem.getElementsByTagName('textarea')))
              .append(HTMLArea.collectionToArray(this.rootElem.getElementsByTagName('select')));

  for(var x = 0; x < inputs.length; x++)
	  {
    var i = inputs[x];

    if(!(i.name && this.r_id[i.name])) 
			continue;

    if(typeof values[this.r_id[i.name]] == 'undefined')
	    {
      values[this.r_id[i.name]] = null;
  	  }

    var v = values[this.r_id[i.name]];

    switch(i.tagName.toLowerCase())
	    {
      case 'select':
  	    {
        if(i.multiple)
    	    {
          if(!v.push)
      	    {
            if(v != null)
        	    {
              v = [v];
          	  }
            else
            	{
              v = new Array();
	            }
  	        }

          for(var j = 0; j < i.options.length; j++)
	          {
            if(i.options[j].selected)
  	          {
              v.push(i.options[j].value);
    	        }
      	    }
        	}
        else
	        {
          if(i.selectedIndex)
  	        {
            v = i.options[i.selectedIndex];
    	      }
      	  }
        break;
	      }

      case 'textarea':
      case 'input'   :
      default        :
	      {
        switch(i.type.toLowerCase())
  	      {
          case  'radio':
    	      {
            if(i.checked)
      	      {
              v = i.value;
              break;
        	    }
          	}

          case 'checkbox':
	          {
            if(v == null)
	            {
 	            if(this.getElementsByName(this.r_id[i.name]).length > 1)
  	            {
                v = new Array();
    	          }
      	      }

            if(i.checked)
	            {
              if(v.push)
  	            {
                v.push(i.value);
    	          }
              else
      	        {
                v = i.value;
        	      }
          	  }
            break;
	          }

          default   :
  	        {
            v = i.value;
            break;
    	      }
	        }
  	    }

    	}

    values[this.r_id[i.name]] = v;
	  }

  return values;

	}	// end of getValues()

// ---------------------------------------------------------------------------

/**
* getElementById()
*/

HTMLArea.Dialog.prototype.getElementById = function(id)
	{
  return this.document.getElementById(this.id[id] ? this.id[id] : id);
	}

// ---------------------------------------------------------------------------

/**
* getElementsByName()
*/

HTMLArea.Dialog.prototype.getElementsByName = function(name)
	{
  return this.document.getElementsByName(this.id[name] ? this.id[name] : name);
	}
