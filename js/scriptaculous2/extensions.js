/*
  Extensions to the scriptaculous functions and classes.
*/

/*
 * InPlaceEditor extension that adds a 'click to edit' text when the field is 
 * empty and autocomplete options.
 */

Ajax.InPlaceEditor.defaultHighlightColor = "#CAFFBF";

Ajax.InPlaceEditor.prototype.__initialize = Ajax.InPlaceEditor.prototype.initialize;
Ajax.InPlaceEditor.prototype.__getText = Ajax.InPlaceEditor.prototype.getText;
Ajax.InPlaceEditor.prototype.__onComplete = Ajax.InPlaceEditor.prototype.onComplete;
Ajax.InPlaceEditor.prototype.__enterEditMode = Ajax.InPlaceEditor.prototype.enterEditMode;
Ajax.InPlaceEditor.prototype = Object.extend(Ajax.InPlaceEditor.prototype, {
    
    initialize: function(element, url, options){
        this.__initialize(element,url,options)
        this.setOptions(options);
        this._checkEmpty();
    },
    
    setOptions: function(options){
        this.options = Object.extend(Object.extend(this.options,{
            emptyText: 'click to edit...',
            emptyClassName: 'inplaceeditor-empty',
            onEnterEditMode: Prototype.emptyFunction,
            autocomplete: null /* ex. [url, {regularOptions}] to enable*/
        }),options||{});
    },
    
    _checkEmpty: function(){
        if( this.element.innerHTML.length == 0 ){
            this.element.appendChild(
                Builder.node('span',{className:this.options.emptyClassName},this.options.emptyText));
        }
    },
    
    getText: function(){
        document.getElementsByClassName(this.options.emptyClassName,this.element).each(function(child){
            this.element.removeChild(child);
        }.bind(this));
        return this.__getText();
    },
    
    onComplete: function(transport){
        this._checkEmpty();
        this.__onComplete(transport);
    },
    
    enterEditMode: function(){
        this.__enterEditMode();
        if( this.options.autocomplete != null ){
            this._addAutocomplete(this.options.autocomplete[0],this.options.autocomplete[1]);
        }
        this.options.onEnterEditMode();
    },
    
    _addAutocomplete: function(url,options){
        var choicesClass = options.choicesClass || 'autocomplete';
        var choices = Builder.node('div',{id:this.form.id+'_choices',className:choicesClass},'');
        this.form.insertBefore(choices, this.form.firstChild.nextSibling)
        new Ajax.Autocompleter(this.form.firstChild, choices, url, options);
    }
});


/*
 * Form extensions to show error messages in a json errors object
 * @see json_extensions.rb
 */

Form.showErrorsHeader = function(form, errors){
    var header = Builder.node('div',{id:'ErrorExplanation',className:'ErrorExplanation'},[
        Builder.node('h2',{},
            "Houston, we have a problem...")]);
    var form = $(form);
    form.insertBefore(header, form.firstChild);
}

Form.showErrorsOn = function(formElem, errors, method){
    formElem = $(formElem);
    if(!formElem){return;}
    var prependText;var appendText;
    if(arguments[3]){prependText = arguments[3];}else{prependText="";}
    if(arguments[4]){appendText = arguments[4];}else{appendText="";}
    var errorMsg = Builder.node('div',{className:'formError'}, 
        prependText + errors.all[method] + appendText);
    var errorMarker = Builder.node('div',{className:"fieldWithErrors"});
    var next = formElem.nextSibling;
    var parent = formElem.parentNode;
    parent.removeChild(formElem);
    errorMarker.appendChild(formElem);
    if(next){
        parent.insertBefore(errorMarker, next);
    }else{
        parent.appendChild(errorMarker);
    }
    parent.insertBefore(errorMsg, errorMarker);
}

Form.clearErrors = function(form){
    document.getElementsByClassName('ErrorExplanation', form).each(function(item){
        item.parentNode.removeChild(item);
    });
    document.getElementsByClassName('formError', form).each(function(item){
        item.parentNode.removeChild(item);
    });
    document.getElementsByClassName('fieldWithErrors', form).each(function(item){
        var element = item.firstChild;
        var parent = item.parentNode;
        var next = item.nextSibling;
        parent.removeChild(item);
        if(next){
            parent.insertBefore(element,next);
        }else{
            parent.appendChild(element);
        }
    });
}