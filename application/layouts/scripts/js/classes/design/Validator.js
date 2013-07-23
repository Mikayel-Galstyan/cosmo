/**
* Javascript object replicating php functions for notification handling
*
* @author sourcio.com
* 
*/
function Validator() {

    /**
    * Show: Show validation errors 
    */
    this.show = function(errors, formId) {
        this.remove();        
        $.each(errors, function (key, value) {
            var el = $("#"+formId +" [name='" + key + "']");
            if(el.length == 2){
                el = $("#"+formId +" div[name='" + key + "']")  
            }
            el.parent().find('.error-message').remove();
            el.addClass('error');    
            var regex = /{new_line}/gi;
            if ($.browser.msie) {						//To solve an issue with IE
            	value = value.replace(/>/g, "&gt;");
                value = value.replace(/</g, "&lt;");
            }           
            value = value.replace(regex, "<br />");
            var err = $('<div></div>').attr('class', 'error-message').html(value );
            el.parent().append(err);            
        });                  
    };
    /**
    * Remove: Remove validation messages
    */
    this.remove = function() {
        $('.error').removeClass('error');
        $('.error-message').remove();
    };
};