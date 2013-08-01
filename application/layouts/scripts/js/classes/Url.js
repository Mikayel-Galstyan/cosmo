/**
* Url class
*
* @author sourcio.com
* 
*/
function Url() {       
    /**
     * Url
     *
     * Hidden Url 
     */    
    this.hiddenUrl = null;
    /**
     * Get
     *
     * Get string after hash 
     */
    this.get = function(){
    	value = false;
        if(window.location.hash) {
        	value = window.location.hash.substring(1);                     
        } else if (window.location.pathname.substring(1).length > 0) {        	
        	value = window.location.pathname.substring(1);                       
        }
        return value;
    },
    /**
     * Get
     *
     * Get previous href
     */
    this.getHiddenUrl = function(){        
        return this.hiddenUrl;            
    };
    /**
     * Set
     *
     * Set  href 
     */
    this.setHiddenUrl = function(href){        
        this._hiddenUrl = href; 
        return this;
    };
    /**
     * Loading 
     *
     * Loading page 
     */
    this.load = function(href, callback) {          
    	//if href is not setted simulate page refresh
		if(!href){        
			var href = Url.get();
		}
		//loading page
		if(href == 'auth/login'){
			href="objects";
		}
        if (href.length > 0) {
            //activate menus
            Menu.acitvate(href);
            //load page
            Page.load(href, callback);
            //return false
            return false;
    	}        
        //return false
        return false;
    };
    /**
     * Push 
     *
     * Pushing href and title
     */
    this.push = function(href, callback) {
    	if(href !== 'undefined'){
    		var state = (window.history.state)?window.history.state+1:2;
    		history.pushState(state, title, href );
    		Url.load(href, callback);
    	}    	    	    	
    };
    /**
     * Go Back
     *
     * Browser history back method
     */
    this.goBack = function() {
    	var state = window.history.state;
    	if(state>1){
	    	window.history.back();
	    	state = window.history.state - 1;
    	} else {
    		Url.push($("base").attr("href") + 'index');
    	}    	
    };
    /**
     * Go Back
     *
     * Browser history forward method 
     */
    this.goForward = function() {
        //browser history forward
        window.history.forward();        
    };
};
