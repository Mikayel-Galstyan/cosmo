/**
* Mouse class
*
* @author sourcio.com
* 
*/
function Coordinates() {	
	/**
     * elem box
     *
     * defining position element identifier
     */
    var elem_pos = '#cord';
    /**
     * Coordinates.imgSize
     *
     * defining map image size
     */
    this.imgSize = {};
    /**
     * imgOrigSize
     *
     * defining map image original size
     */
    this.imgOrigSize = {};
    /**
     * imgOffset
     *
     * defining image position
     */
    this.imgOffset = {};
    /**
     * Coordinates.shift
     *
     * defining Coordinates.shift
     */
    this.shift = {};
    /**
     * x
     *
     * Mouse position x
     */
    this.mouseX = 0;
    
    /**
     * y
     *
     * Mouse position y
     */
    this.mouseY = 0;
    /**
     * lastMouseX
     *
     *  Mouse last position x
     */
    this.lastMouseX = 0;
    /**
     * lastMouseY
     *
     * Mouse last position y
     */
    this.lastMouseY = 0;
    /**
     * Coordinates.loc
     *
     * map Coordinates.loc (lat,long)
     */
    Coordinates.loc = {};
    /**
     * Prepare
     *
     * Preparing course coordinates
     */
	this.prepare = function(){				
		var $img = MapMenu.getMapImg();		
		$('<img/>') 
	    .attr("src", $img.attr("src"))
	    .load(function() {
	    	Coordinates.reset($img);
	    	Coordinates.imgOrigSize = {'width':Coordinates.imgSize.width, 'height':Coordinates.imgSize.height };
	    });
	};
	/**
     * Reset
     *
     * Reset course coordinates
     */
	this.reset = function($img){		
		if ($img != 'undefined') {
			var $img = MapMenu.getMapImg();
		}		
		Coordinates.imgOffset = $img.offset();	    	
		var width = parseInt($img.css('width'));   // Note: $(this).width() will not
    	var height = parseInt($img.css('height')); // work for in memory images.		
    	Coordinates.imgSize = {'width':width, 'height':height };
    	var scale = {};
    	scale.lat = parseFloat(Coordinates.loc.top.lat) - parseFloat(Coordinates.loc.bottom.lat);
		scale.long = parseFloat(Coordinates.loc.top.long) - parseFloat(Coordinates.loc.bottom.long);						
		Coordinates.shift.lat = parseFloat(scale.lat / height);
		Coordinates.shift.long = parseFloat(scale.long / width);		
	};
    /**
     * Init
     *
     * Initializing coordinates
     */
	this.init = function(){
		Coordinates.prepare();
		Coordinates.show();
		MapMenu.getMapImg().on('mouseleave' ,function() {
			Coordinates.hide();
		});
	};
    /**
     * getCoords
     *
     * Getting mouse coordinates 
     */
    this.getCoords = function(event){    	
    	event = event || window.event;    	
		if (event.pageX || event.pageY) {
			var mouseX = event.pageX - Coordinates.imgOffset.left;
			var mouseY = event.pageY - Coordinates.imgOffset.top;
		} else if (event.clientX || event.clientY) {
			var mouseX = event.clientX - Coordinates.imgOffset.left;
			var mouseY = event.clientY - Coordinates.imgOffset.top;
		}
		Coordinates.mouseX = parseInt(mouseX);
		Coordinates.mouseY = parseInt(mouseY);
	};
	/**
     * Show
     *
     * Showing info box about latitude and longitude on graph image
     */
	this.show = function(elem){				
		MapMenu.getMapImg().on('mousemove', function(event) {
			$this = $(elem_pos);
			Coordinates.getCoords(event);
			if ($('#contextMenu').css('display') == 'none'){
		    	$this.find('#cord_x').html(Coordinates.getLat());
		    	$this.find('#cord_y').html(Coordinates.getLong());
		    	styles = {'left':Coordinates.mouseX,'top':Coordinates.mouseY-30, 'display':'block'};
		    	$.each( styles, function( prop, value ) {
		    		$this.css( prop, value );
		    	});	
			}
		});
	};
	/**
     * Hide
     *
     * Hiding info box
     */
	this.hide = function(){
		$this = $(elem_pos);
		$this.hide();
	};
	/**
     * getLat
     *
     * Returning prepared latitude
     */
	this.getLat = function(){
		try {
			var zeroY = parseInt(Coordinates.imgSize.height - Coordinates.mouseY);
			var locLat = parseFloat(Coordinates.loc.bottom.lat);
			var lat = parseFloat( locLat + (zeroY*Coordinates.shift.lat));
			return lat.toFixed(MapMenu.fixCount);
		} catch (err) {
			return 0;
		}		
	};
	/**
	 * getLong
	 * 
	 * Returning prepared longitude
	 */
	this.getLong = function(){
		try {
			var zeroX = parseFloat(Coordinates.mouseX);
			var locLong = parseFloat(Coordinates.loc.bottom.long);
			var long = parseFloat(locLong) + parseFloat(zeroX*Coordinates.shift.long);
			return long.toFixed(MapMenu.fixCount);
		} catch (err) {
			return 0;
		}
	};	
};