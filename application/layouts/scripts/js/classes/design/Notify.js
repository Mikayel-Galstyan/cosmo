/**
* Javascript object replicating php functions for notification handling
*
* @author sourcio.com
* 
*/
function Notify() {
    /**
    * Show: Show a new notification popup
    */
    function popup(title, type, autoclose) {        
        if(autoclose == undefined) {
            autoclose = true;
        }        
        $.pnotify.defaults.history = false;
        $.pnotify({
                title: type,
                text: title,
                type: type,
                history: false,                    
                hide: autoclose,
                sticker: false,
                closer: false,                
                delay: 4000
        });                    
    };
    /**
     * Info: Shortcut to add()
     */
    this.info = function(title, autoclose) {
        // Set default title
        if(title == undefined) {
            title = 'Notification';
        }
        // Add notify
        popup(title, 'info', autoclose);
    };
    /**
    * Success: Shortcut to add()
    */
    this.success = function(title, autoclose) {
        // Set default title
        if(title == undefined) {
            title = 'SUCCESS';
        }
        // Add notify
        popup(title, 'success', autoclose);
    };
    /**
    * Error: Shortcut to add()
    */
    this.error = function(title, autoclose) {
        // Set default title
        if(title == undefined) {
            title = 'ERROR';
        }
        // do not autoclose error box 
        if(autoclose == undefined) {
            autoclose = false;
        } 
        // Add notify
        popup(title, 'error', autoclose);        
    };
    /**
    * Show: Show a new notification
    */
    this.show = function(result, formId) {   
    	Notify.remove();      
        if (result.status == 'error'){
            Validator.show(result.errors, formId);
            if (result.msg != ''){
                Notify.error(result.msg);
            }                
        } else if (result.status == 'fail'){
            Validator.remove();        
            if (result.msg != ''){
                Notify.error(result.msg);
            }    
        } else if (result.status == 'success'){            
            Validator.remove();            
            if((destUrl = Form.destUrl) != null) {
                Url.push(destUrl);
                $(window).bind('pageChanged', function() {                	
                    if (result.msg != ''){
                        Notify.success(result.msg);
                    }
                    $(window).unbind('pageChanged');
                });
            } else if (result.msg != '') {
                Notify.success(result.msg);                
            }
            
            //Setting destination url null
            Form.destUrl = null;
            
            //return true
            return true;
        } else if (result.status == 'info'){  
            if (result.msg != ''){
                Notify.info(result.msg);
            }    
        }  
        //Setting destination url null
        Form.destUrl = null;
        
        return false;
    };    
    /**
     * Remove: Remove all notifications except info types
     */
    this.remove = function() {                
        $.pnotify_remove_all();
    }
};
$(function() {
	$(document).on('click', '.ui-pnotify', function(){
		$(this).fadeOut(function(){
            $(this).remove();
        }); 
	})
});