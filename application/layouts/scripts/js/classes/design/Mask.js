/**
* Page class
* 
* Version 1.0
* 
* @author sourcio.com 
* 
*/
function Mask() {
	/**
     * Center mask
     *
     * Setting mask to center  
     */
    function center() {
        mask = $('#popupOverlay img');
        mask.css('position','fixed');
        mask.css("top",  "50%");
        mask.css("left", "50%");        
    };
    /**
     * CheckScrollBar
     *
     * Show scroll bar if exists
     */   
    function checkScrollBar() {    	
        var body = $('body');
        var hContent = body.height(); // get the height of your content
        var hWindow = $(window).height(); // get the height of the visitor's browser window        
        if(hContent > hWindow) { // if the height of your content is bigger than the height of the browser window, we have a scroll bar              
            showScrollBar();
        }
    };
    /**
     * Show ScrollBar
     *
     * Changing browser scroll bar overflow to visible 
     */
    function showScrollBar() {
		$('body').css('overflow','visible');	
    };
    /**
     * Enable ScrollBar
     *
     * Get and Set scrollBar value
     */
    this.hideScrollBar = function() {
    	$('body').css('overflow','hidden');
    };
    /**
     * Show mask
     *
     * Show the mask  
     */
    this.show = function(){
    	if ($('#popupOverlay').length == 0) {    		
    		maskHTML =  '<div id="popupOverlay">' + 
							'<img src="images/loader.gif" alt="loader" title="Loading ...">' +                                       
						'</div>';
			$('body').append(maskHTML);
			//set mask to center		
			center();
			$(window).resize(function() {				
				center();
	        });
    	}    	
    }; 
    /**
     * Hide mask
     *
     * Hide the mask  
     */
    this.hide = function(){
    	//removing mask
    	$('#popupOverlay').remove();
    	//check scroll bar
        checkScrollBar();        	        	
        //return false 
        return false;
    };  
    /**
     * Show mask loader
     *
     * Show the mask  loader
     */
    this.showLoader = function(){
    	loaderHTML =  '<img src="/images/loader.gif" alt="loader" title="Loading ...">';
		$('#popupOverlay').append(loaderHTML);
		//set mask to center
		center();   	
    };
};