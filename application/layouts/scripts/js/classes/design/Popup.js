/**
* Popup class
* 
* Version 1.0
* 
* @author sourcio.com 
* 
*/
function Popup(option){
    
    //create empty option object, if it isn't setted
    if(!option){
        var option = {};        
    }
    
    /**
     * width
     *
     * init width
     */
    var width = option.width || '100%';
    
    /**
     * height
     *
     * init height
     */
    var height = option.height || '100%';
    
    
    /**
     * buttons
     *
     * init buttons
     */
    var buttons = option.buttons || null;
    
    /**
     * cancel
     *
     * button cancel
     */
    var cancel = (option.cancel===false || option.cancel==='false')?false:true;
    
    /**
     * create popup
     *
     * Show loader
     */            
    var _create = function() {
    	if ($('#popupOverlay').length == 0) {
    		popupHTML ='<div id="popupOverlay">\
				            <img src="images/loader.gif" alt="loader" title="Loading content">\
				       </div>';
			$('body').append(popupHTML);

			//set popup to center
			_center();
    	}
    };    
    /**
     * Show
     *
     * Show loader
     */            
    var _show = function() {                    
        //Hide siblings
        $('div#popupBox .loader').siblings().hide();
        // Fade in
        $('div#popupBox .loader').fadeIn();
        
        //set popup to center
        _center();        
    };
    /**
     * Center
     *
     * Set popup to center
     */
    var _center = function () {
    	var popup = $('#popupBox');
        var popupOverlay = $('#popupOverlay');
        popWidth = (popup.width())?popup.width():0;
        popHeight = (popup.height())?popup.height():0;
        maxHeight = popupOverlay.height();
        maxWidth = popupOverlay.width();
        popup.css("position","fixed");
        popup.css("top",  (maxHeight-popHeight)/2);
        popup.css("left", (maxWidth-popWidth)/2);
    };
    /**
     * Hide
     *
     * Hide loader
     */            
    var _hide = function() {    
        //Hide siblings
        $('div#popupBox div#popupContent').siblings().hide();
        // Fade in
        $('div#popupBox div#popupContent').fadeIn();
        //set popup to center
        _center();   
    };
    /**
     * Sucess
     *
     * Success Function
     */
    function success(response, destUrl, callback) {    	
    	contentHtml =	'<div id="popupBox">\
							<div id="popupContent" style="width:' + _getWidth() + ';height:' + _getHeight() + '">\
								<div id="content">' + response + '</div>\
								<div class="popupButtons">' + _getButtons() +  '</div>\
							</div>\
						</div>';                        
        //appending content
        $('#popupOverlay').html(contentHtml);
        //set ot center
        _center();

        //hide loader
        _hide();
    };
    /**
     * Show 
     *
     * Show popup box
     */
    this.show = function(url, callback) {
		Mask.hideScrollBar();
        if ($("#popupOverlay").length == 0){
            _create();    
        } else {
            _show();
        }    
        Ajax.get(url, success, callback);        
    };
    
    /**
     * Width 
     *
     * Return width
     */
    var _getWidth = function() {
    	return width;
    };
    
    /**
     * Height 
     *
     * Return height
     */
    var _getHeight = function() {
    	return height;
    };
    /**
     * Buttons 
     *
     * Return buttons
     */
    var _getButtons = function() {
    	buttonsHTML = '';
        if(buttons != null){
            $.each(buttons, function() {            
                buttonsHTML += '<a href="" class="green mr10 pt4 pb4" onclick="Popup.callback(\'' + escape(this.callback) + '\'); return false">' + this.name + '</a>';            
            });    
        }   
        if (cancel == true || cancel == 'true'){
            buttonsHTML += '<a href="" class="gray mr10" onclick="Mask.hide(); return false">Cancel</a>';
        }
        return buttonsHTML;  
    };
    /**
     * callback
     *
     * Calling callback
     */
    Popup.callback = function(callback) {        
        eval("tmpFunc = "+ unescape(callback));
        tmpFunc.call(this);
    };
    /**
     * Hide
     *
     * Hide popup box
     */
    Popup.hide = function() {     	
        $('#popupBox').fadeOut(function(){
            $(this).remove();
        });
        //return false 
        return false;
    };
    $(function(){
        $(window).resize(function() {
            _center();
        });
        $(window).keyup(function(e) {
        	// esc
            if (e.keyCode == 27 && $("#popupBox").length > 0) {
            	//hiding popup
            	Mask.hide(); 
            }   
        });
    });
};