/**
* Ajax class
*
* @author sourcio.com
* 
*/
function Ajax() {
    
    /**
     * Ajax
     *
     * Ajax request
     */
    var request = '';
    
    /**
     * Options
     *
     * Ajax jquery form plugin options
     */
    var options = {};
    /**
     * Get
     *
     * Using jquery $.get method
     */
    this.get = function(url, success, func) {    	
    	//Showing mask
    	Mask.show();
    	//abort ajax request if exists
        Ajax.check();
        //get respons
    	Ajax.request = $.get(url)
    	.done(function(response){
    		success(response);
    		callback(func);
    	})
    	.fail(Ajax.error());           
    };
    /**
     * Submit
     *
     * Submit From
     * @param dest = controller/action (item/save)
     */
    this.submit = function(formId, destUrl, callback) {        
    	//Showing mask
    	Mask.show();
    	//sumbit form
    	submitForm(formId);
    };
    
	/**
     * Options
     *
     * Check previous ajax request and abort if exists
     */
    this.setOptions = function(success, destUrl, func, dataType){
    	if(dataType == undefined) {
    		dataType = null;
    	}    	
    	this.options = {
			dataType:dataType,
			success: function(response){					
	    		success(response, destUrl);
	    		callback(func);
	    	},
			error: function() {Ajax.error();}
		};           
    };    
    /**
     * Check
     *
     * Check previous ajax request and abort if exists
     */
    this.check = function() {
        //abort previous ajax request 
        if(Ajax.request && Ajax.request.readystate != 4){
            Ajax.request.abort();
        }            
    }
    /**
     * error
     *
     * handle ajax error
     */
    this.error = function(response) {     
        var href = (typeof response != 'undefined') ? ((response.status == 404) ? '/error404' : '/auth') : '/error404';
//        window.location= href;
    };
    
    function callback (func) {
    	Polygon.clean();
    	if(typeof func == 'function'){                
    		func.call(this);
        } 
    };
    function submitForm (formId) {
        $('#' + formId).ajaxSubmit(Ajax.options);            
    };
};