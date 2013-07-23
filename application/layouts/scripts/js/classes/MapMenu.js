/**
* Map right click context menu class
*
* @author sourcio.com
* 
*/
function MapMenu() {
	
	/**
     * element
     *
     * Defining contextMenu selector
     */
    var contextMenu = '#contextMenu';
	
	/**
     * element
     *
     * Right menu for element
     */
    var map_container = '#map_container';
    
    /**
     * fix
     *
     * count of numbers after point
     */
    this.fixCount = 6;
    /**
     * Init
     *
     * Initializing context menu
     */
    this.init = function(option){
    	Coordinates.loc = option.mapLocation;
    	Polygon.areaCoords = option.areaCoords;
    	Polygon.imageSizes = option.imageSizes;
    	Polygon.holes = option.holes;
    	$(function(){
    		//make map image dragable
    		draggable();
    		//Polygon initialize 
    		Polygon.init();
    		//Coordinates initialize
		    Coordinates.init();
	    	$img = MapMenu.getMapImg();	    	
	    	$img.bind('contextmenu', function(event) {
		    	event.preventDefault();
		    	//hideing position box
		    	Coordinates.hide();
		    	//init coordinates
		    	Coordinates.getCoords(event);
		    	//getting mouse position
		    	coords = {'left':Coordinates.mouseX,'top':Coordinates.mouseY};	    	
		    	show(coords);
		    });
	    	$img.on('click',function() {
		    	MapMenu.hide();
		    });		    
		    //disabling right click on element
		    activate(contextMenu);
		    //draw map poly
		    Polygon.drawMapArea();
    	});
    };
    /**
     * Hide
     * 
     * Hiding menu 
     */
    this.hide = function() {
    	$(contextMenu).hide();
    };
    /**
     * getMapContainer
     * 
     * getting map container 
     */
    this.getMapContainer = function() {
    	return $(map_container);
    };
    /**
     * getMapImg
     * 
     * getting image in map container  
     */
    this.getMapImg = function() {
    	return $(map_container).find('img');
    };
    /**
     * Disable
     *
     * Disabling menu item
     */
    this.disable = function(item) {
    	$(contextMenu + ' li.' + item).removeClass('active').addClass('disable');
    };
    /**
     * Activate
     *
     * activate menu item
     */
    this.activate = function(item) {
    	$(contextMenu + ' li.' + item).removeClass('disable').addClass('active');
    };
    /**
     * Activate
     *
     * Activate right click for defined element
     */
    function activate(elem){
	    $(elem).bind('contextmenu', function(event) {
	    	event.preventDefault();	    
	    });
    };
    /**
     * Show
     *
     * Preparing to show right menu
     */
    function show(coords) {
    	styles = {'left':coords.left,'top':coords.top, 'display':'block'};
    	$(contextMenu).find('.coord_lat i').text(Coordinates.getLat());
    	$(contextMenu).find('.coord_long i').text(Coordinates.getLong());
    	$.each( styles, function( prop, value ) {
    		$(contextMenu).css( prop, value );
    	});
    };
    /**
     * draggable
     *
     * Initialization to provide map dragging
     */ 
    function draggable(){
    	var $mapImg = MapMenu.getMapContainer().find('.map_image');
    	$mapImg.draggable({
			drag: function() {
				Coordinates.reset();
	        },
			stop: function() {
				Coordinates.reset();
			}
        });
    };
};