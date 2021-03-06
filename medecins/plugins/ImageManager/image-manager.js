
// tabs: 3

/**
* @fileoverview  The ImageManager plugin javascript.
*
* This plugin implements a client side image manager and editor.
*
* @version $Id: image-manager.js 26 2004-03-31 02:35:21Z Wei Zhuo $
* @package ImageManager
* @author $Author: Wei Zhuo $
* @author Yermo Lamers http://www.formvista.com (unified backend modifications)
*/

/**
* To Enable the plug-in add the following line before HTMLArea is initialised.
*
* HTMLArea.loadPlugin("ImageManager");
*
* Then configure the config.inc.php file, that is all.
* For up-to-date documentation, please visit http://www.zhuo.org/htmlarea/
*/

// -----------------------------------------------------------------

/**
* pluginInfo for about box.
*/

ImageManager._pluginInfo = 
	{
	name          : "ImageManager",
	version       : "1.0",
	developer     : "Xiang Wei Zhuo",
	developer_url : "http://www.zhuo.org/htmlarea/",
	license       : "htmlArea"
	};

/**
* ImageManager plugin configuration
*
* default Xinha layout. plugins are beneath the Xinha directory.
* all plugin requests are routed through a single entry point.
*
* Note the trailing &. Makes forming our URL's easier. 
*
* To change the backend, just set this config variable in the calling page.
* The images_url config option is used to strip out the directory info when
* images are selected from the document.
*/

HTMLArea.Config.prototype.ImageManager =
	{

	// the backend URL may already include variables.

	'backend' : _editor_backend + ( _editor_backend.match(/.*\?.*/) ? "&" : "?" ) + '__plugin=ImageManager&',
	'images_url' : _editor_url + 'examples/images'

	}

/**
* It is pretty simple, this file over rides the HTMLArea.prototype._insertImage
* function with our own, only difference is the popupDialog url
* point that to the php script.
*
* @class Image Manager Plugin.
*/

function ImageManager(editor)
	{

	this.editor = editor;

	// [STRIP
	// create a ddt debug trace object. There may be multiple editors on 
	// the page each with an ImageManager .. to distinguish which instance
	// is generating the message we tack on the name of the textarea.

	this.ddt = new DDT( editor._textArea + ":ImageManager Plugin" );

	// uncomment to turn on debugging messages.
 
	// this.ddt._ddtOn();

	this.ddt._ddt( "image-manager.js","86", "ImageManager(): constructor" );

	// STRIP]

	};

// ----------------------------------------------------------------

/**
* Override the _insertImage function in htmlarea.js.
*
* If no image is selected, the image parameter will be null. If 
* an image is selected (right click->image properties for instance)
* then image will contain the selected image.
*
* @todo check previousSibling issue. The fix here is probably covering up some other problem.
*/

HTMLArea.prototype._insertImage = function(image) 
	{

	this.ddt._ddt( "image-manager.js","107", "_insertImage(): top" );

	var editor = this;	// for nested functions
	var outparam = null;
	var image_src = null;

	if (typeof image == "undefined") 
		{
		this.ddt._ddt( "image-manager.js","115", "_insertImage(): no image." );
		image = this.getParentElement();

		if (image && !/^img$/i.test(image.tagName))
			{
			this.ddt._ddt( "image-manager.js","120", "_insertImage(): setting image to null" );
			image = null;
			}
		}

	// the selection will have the absolute url to the image. 
	// coerce it to be relative to the images directory.
	//
	// FIXME: we have the correct URL, but how to get it to select?
	// FIXME: need to do the same for MSIE.

	if ( image )
		{
		if ( HTMLArea.is_ie )
			{
			image_src = image.src;
			}
		else
			{
			// gecko

			image_src = image.getAttribute("src");

			// strip off any http://blah prefix

			var images_url = editor.config.ImageManager.images_url.replace( /https?:\/\/[^\/]*/, "" );
			var image_regex = new RegExp( images_url );
			image_src = image_src.replace( image_regex, "" );

			this.ddt._ddt( "image-manager.js","149", "_insertImage(): new source is " + image_src );
			}
	
		outparam = 
			{
			f_url    : HTMLArea.is_ie ? image.src : image_src,
			f_alt    : image.alt,
			f_border : image.border,
			f_align  : image.align,
			f_vert   : image.vspace,
			f_horiz  : image.hspace,
			f_width  : image.width,
			f_height  : image.height
			};

      // TODO - somehow highlight and focus the currently selected image.

		} // end of if we selected an image before raising the dialog.

	// the "manager" var is legacy code. Should probably reference the
	// actual config variable in each place .. for now this is good enough.

	this.ddt._ddt( "image-manager.js","171", "_insertImage(): backend is '" + editor.config.ImageManager.backend + "'" );

	var manager = editor.config.ImageManager.backend + '__function=manager';

	// NOTE the extremely long function as parameter #2 to Dialog() here.
	// javascript scoping rules seem really messy. editor is available within
	// this function .. 

	Dialog( manager, 
		function(param) 
			{

      // [STRIP
			//
      // we want to use the ImageManager DDT instance to output these
			// debug messages (so we can turn off all ImageManager plugin debug messages
			// from one spot). To get that object we need to go through the
			// editor object to the plugins array (see htlarea.js HTMLArea() constructor line
			//  ~2559 as of this writing) to the named plugin (ImageManager), to the plugin
			// instance to the ddt instance.

			var ddt = editor.plugins[ 'ImageManager'].instance.ddt;

			// STRIP]

			ddt._ddt( "image-manager.js","196", "Dialog() parm: top" );

			if (!param) 
				{	 // user must have pressed Cancel
				return false;
				}

			// pulled in as a result of the closure above.

			var img = image;

			if (!img) 
				{
				var sel = editor._getSelection();
				var range = editor._createRange(sel);			

				// this is the browser built-in execCommand, not the HTMLArea execCommand
				// method. The assumption here is that it will interact with the range
				// created above so we can pull out the just inserted image from it.

				ddt._ddt( "image-manager.js","216", "_insertImage(): no image. invoking browser insertImage execCommand" );

				editor._doc.execCommand("insertimage", false, param.f_url);

				if (HTMLArea.is_ie) 
					{
					img = range.parentElement();

					// wonder if this works...

					if (img.tagName.toLowerCase() != "img") 
						{
						img = img.previousSibling;
						}
					} 
				else 
					{

					// If the editor window does not have focus or we are positioned immediately 
					// adjacent to another image and do not have a selection this returns a null 
					// object, not an img object. 
					// 
					// FIXME: The current Xinha commit, #156, does not exibit this behavior and it does
					// not have the logic below. This implies there is some other problem elsewhere. 
					// Why does it return null here under the same circumstances?

					img = range.startContainer.previousSibling;

					if ( img == null ) 
						{

						// we are probably at the beginning or end of the document. By trial and 
						// error it looks like the IMG tag is most likely our first child in the
						// beginning of document case and under nextSibling in the end of document
						// case. We'll need to verify this for future releases of Gecko.

						ddt._ddt( "image-manager.js","252", "_insertImage(): previousSibling is NULL. Checking firstChild" );

						if (( range.startContainer.firstChild != null ) && ( range.startContainer.firstChild.nodeName == "IMG" ))
							{
							ddt._ddt( "image-manager.js","256", "_insertImage(): Found image under firstChild. Beginning of document?" );

							img = range.startContainer.firstChild;
							}
						else if (( range.startContainer.nextSibling != null ) && ( range.startContainer.nextSibling.nodeName == "IMG" ))
							{
							ddt._ddt( "image-manager.js","262", "_insertImage(): Found image under nextSibling. end of document?" );
							img = range.startContainer.nextSibling;
							}
						else
							{
							alert( "INTERNAL ERROR - was unable to locate the newly inserted image object. The HTML in the document may be out of whack." );
							return false
							}
						}
					}
				} 
			else 
				{			
				img.src = param.f_url;
				}

			ddt._ddt( "image-manager.js","278", "_insertImage(): before switch type of img is '" + typeof img + "'" );
					
			for (field in param) 
				{
				var value = param[field];

				switch (field) 
					{
					case "f_alt"    : img.alt	 = value; break;
					case "f_border" : img.border = parseInt(value || "0"); break;
					case "f_align"  : img.align	 = value; break;
					case "f_vert"   : img.vspace = parseInt(value || "0"); break;
					case "f_horiz"  : img.hspace = parseInt(value || "0"); break;
					case "f_width"  : img.width = parseInt(value || "0"); break;
					case "f_height"  : img.height = parseInt(value || "0"); break;
					}
				}

      ddt._ddt( "image-manager.js","296", "end of Dialog() parm function" );
			
			return true;
					
			}, outparam, editor);	// end of Dialog() parm.

	};	// end of _insertImage();

// END
