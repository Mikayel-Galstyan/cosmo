/**
* Page class
* 
* Version 1.0
* 
* @author sourcio.com 
* 
*/
function Page() {  
    /**
     * Page Response 
     *
     * Calling ajax response
     */
	function success(response) {console.log(ajaxContainer);
        //Append result in panel
		Util.append($(ajaxContainer), response);               
        //remove notfications
        Notify.remove();
        //fireing event
        $(window).trigger('pageChanged');
    };
    /**
     * Show
     *
     * Show report
     * @param page = controller/action (ajax/report1)
     */
    this.load = function(url, callback) {    	
        // Get page     
        Ajax.get(url, success, callback);                                                                  
    };       
};
