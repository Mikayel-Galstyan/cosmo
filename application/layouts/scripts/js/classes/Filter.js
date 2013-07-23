/**
* Filter class
* 
* Version 1.0
* 
* @author sourcio.com 
* 
*/
var Filter = {
    /**
     * Show
     *
     * Show report
     * @param page = controller/action (ajax/report1)
     */
    submit: function(form, destination, callback)
    {
    	//Showing mask
    	Mask.show();
    	      
        //init options
        var options = { 
                success: function(result) {
                    //Append result in panel    
                    if(destination){
                        Util.append($('#' + destination), result);
                    }else{
                        Notify.remove();
                        panel = $('tr.panel>td');
                        Util.append(panel, result);
                        filterNotify = panel.find('#filter_notify');                        
                        if (filterNotify.length > 0) {
                            stat = filterNotify.attr('data-stat');
                            msg = filterNotify.attr('data-msg');                                                                                    
                            Notify.show({'status':stat,'msg':msg});                
                        }                                                
                    }                    
                    //call callback
                    if(typeof callback == 'function'){
                        callback.call(this);
                    }
      
                    // Return false
                    return false;
                },
                error: function() {Ajax.error();}
        }; 
        var formName;
        if(form){
            formName = '#' + form;             
        }else{
            formName = '#ajaxFilter';        
        }
        //serilezeing form 
        data = $(formName).serialize();
        
        //saveing current url
        Url.setHiddenUrl(Url.get() + '?' + data);        

        //submiting form
        $(formName).ajaxSubmit(options);
            
        // Return false
        return false;
    }
};
