/**
* Util class
*
* @author sourcio.com
* 
*/
function Util() {
		
    function trim(result) {
        return result.replace(/>\s+</g,'><');
    };
    /**
     * checking IE navigators 
     */
    function isIE() {
    	return (/MSIE (\d+\.\d+);/.test(navigator.userAgent));
    };
    /**
     * Append result into elements
     */
    this.append = function(elements, result) {
        // removed white spaces between </td> and <td> for fixing the issue in IE9
    	if (isIE()) {     		
			var ieversion=new Number(RegExp.$1);
			if (ieversion == 9) {
				elements.html(trim(result));
			} else {
	    		elements.html(result);
	    	}
    	} else {
    		elements.html(result);
    	}
        //Hide mask
    	Mask.hide();
    };
};