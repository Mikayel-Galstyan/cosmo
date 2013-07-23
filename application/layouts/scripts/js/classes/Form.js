/**
* Form class
* 
* Version 1.0
* 
* @author sourcio.com 
* 
*/
function Form(){

    /**
     * Destination
     *
     * Destination url
     */
    this.destUrl = null;
    
    /**
     * Form Id
     *
     * We need to declare this with 'var' as it must be visible not only in member functions,
     * but in functions which are declared in this scope as well (e.g success).
     */
    var submittedFormId = null;
        
    /**
     * Sucess
     *
     * Success Function
     */
    function success(response, destUrl, callback) {
	    //prepare destination url                	    
	    if(response.url) {
            destUrl = response.url;
        }
        if (destUrl){
            Form.destUrl = destUrl;
        } else {
        	Form.destUrl = null;
        }
	    //Hiding mask
		Mask.hide();
		//Show validation errors or notify message
	    Notify.show(response, submittedFormId);
    };
    /**
     * Sucess Filter
     *
     * Submit From 
     */
    function successFilter(response, destUrl, callback) {    	
	   
    };

    /**
     * Submit
     *
     * Submit From
     * @param dest = controller/action (item/save)
     */
    this.submitInputs = function(formId, destUrl, callback) {
    	Ajax.setOptions(success, destUrl, callback, 'json');
    	Ajax.submit(formId);
    };
    
    /**
     * Submit
     *
     * Submit From
     * @param dest = controller/action (item/save)
     */
    this.submit = function(formId, destUrl, callback) {
    	Ajax.setOptions(success, destUrl, callback, 'json');
    	Ajax.submit(formId);
    	submittedFormId = formId;
    };
    /**
     * Standart Submit
     *
     * Submit From
     * @param dest = controller/action (item/save)
     */
    this.standardSubmit = function(formId) {        
        //Showing mask
        $('#ajaxForm').submit();
    };

    /**
     * Change Action 
     *
     * Changing From action  
     */
    this.changeAction = function(formId, action) {
        $('#' + formId).attr('action', action);
    };    
};
