var MERCATOR_RANGE = 256;

function bound(value, opt_min, opt_max) {
  if (opt_min != null) value = Math.max(value, opt_min);
  if (opt_max != null) value = Math.min(value, opt_max);
  return value;
}

function degreesToRadians(deg) {
  return deg * (Math.PI / 180);
}

function radiansToDegrees(rad) {
  return rad / (Math.PI / 180);
}

function MercatorProjection() {
  this.pixelOrigin_ = new google.maps.Point( MERCATOR_RANGE / 2, MERCATOR_RANGE / 2);
  this.pixelsPerLonDegree_ = MERCATOR_RANGE / 360;
  this.pixelsPerLonRadian_ = MERCATOR_RANGE / (2 * Math.PI);
};

MercatorProjection.prototype.fromLatLngToPoint = function(latLng, opt_point) {
  var me = this;

  var point = opt_point || new google.maps.Point(0, 0);

  var origin = me.pixelOrigin_;
  point.x = origin.x + latLng.lng() * me.pixelsPerLonDegree_;
  // NOTE(appleton): Truncating to 0.9999 effectively limits latitude to
  // 89.189.  This is about a third of a tile past the edge of the world tile.
  var siny = bound(Math.sin(degreesToRadians(latLng.lat())), -0.9999, 0.9999);
  point.y = origin.y + 0.5 * Math.log((1 + siny) / (1 - siny)) * -me.pixelsPerLonRadian_;
  return point;
};

MercatorProjection.prototype.fromPointToLatLng = function(point) {
  var me = this;

  var origin = me.pixelOrigin_;
  var lng = (point.x - origin.x) / me.pixelsPerLonDegree_;
  var latRadians = (point.y - origin.y) / -me.pixelsPerLonRadian_;
  var lat = radiansToDegrees(2 * Math.atan(Math.exp(latRadians)) - Math.PI / 2);
  return new google.maps.LatLng(lat, lng);
};
var proj = new MercatorProjection();    	
var GMap = google.maps;

/**
* Static google map class
*
* @author sourcio.com
* 
*/
function StaticMap() {
	/**
     * areaCoords
     *
     * storing areaCoords
     */
	this.options = {'center':'52.521653,13.40596','width':640,'height':640,'zoom':12,'scale':1,'sizeScale':10,'maptype':'satellite' };
	/**
     * scale
     *
     * Defining location scale
     */
	this.scale = 0.00001;	
    /**
     * init
     *
     * Initializing polygon behavior
     */
    this.init = function(){
    	bindEventEnter();
    	calculateMoveScale(StaticMap.options.zoom);
    	var url = getPrepareUrl();
    	$('#staticMap').find('img')
    	  .load(function() {    		  
    		  changeFormValues();
    		  Mask.hide();
    	  })
    	  .attr('src', url);
    };
    /**
     * Get
     *
     * Getting static map from google
     */
    function change(){
    	Mask.show();
    	var url = getPrepareUrl();
    	$('#staticMap').find('img').attr('src', '');
    	$('#staticMap').find('img')
    	  .load(function() {    		  
    		  Mask.hide();
    		  changeFormValues();
		  })
    	  .attr('src', url);    	
    };
    /**
     * getpreparedUrl
     *
     * Preparing url to get image from google maps 
     */ 
    function getPrepareUrl(){
    	var url = 'http://maps.googleapis.com/maps/api/staticmap?sensor=false';
    	url += '&center=' + StaticMap.options.center;
    	url += '&maptype=' + StaticMap.options.maptype;
    	url += '&scale=' + StaticMap.options.scale;
    	url += '&zoom=' + StaticMap.options.zoom;
    	url += '&size=' + StaticMap.options.width + 'x' + StaticMap.options.height;
    	$('form').find('input[name*="gmapUrl"]').val(url);
    	return url;
    };
    /**
     * changeFormValues
     *
     * Preparing url to get image from google maps 
     */ 
    function changeFormValues(){
		var latLng = StaticMap.options.center.split(',');		
    	var centerPoint = new GMap.LatLng(latLng[0], latLng[1]);    	
    	$loacation = getCorners(centerPoint,StaticMap.options.zoom,StaticMap.options.width,StaticMap.options.height);
    	$('form').find('input[name*="location"]').val(JSON.stringify($loacation));
    	$('form').find('input[name*="zoom"]').val(StaticMap.options.zoom);
    	$('form').find('input[name*="center"]').val(StaticMap.options.center);
    	$('form').find('input[name*="width"]').val(StaticMap.options.width);
    	$('form').find('input[name*="height"]').val(StaticMap.options.height);
    };
    /**
     * new
     *
     * Generating new map for course
     */
    this.new = function(){    	
    	$('form').find('input[name*="center"]').prop('disabled', false);
    	$('form').find('input[name*="width"]').prop('disabled', false);
    	$('form').find('input[name*="height"]').prop('disabled', false);
    	$('form .map-control').show();    	
    	$('form').find('input[name*="newMap"]').val(true);
    	StaticMap.init();
    };
    /**
     * zoom
     *
     * Polygon Zooming
     */
    this.zoom = function(event){
    	switch(event) {
	    	case 'in':	    		
	    		StaticMap.options.zoom ++;	            	           
	    		break;
	    	case 'out':	    		
	    		StaticMap.options.zoom --;    		            
	    		break;
    	}    	
    	if(StaticMap.options.zoom > 20){
    		StaticMap.options.zoom = 20;    		
    	} else if (StaticMap.options.zoom < 8) {
    		StaticMap.options.zoom = 8;
    	}
    	calculateMoveScale(StaticMap.options.zoom);
    	change();
    };
    /**
     * move
     *
     * Change static map position
     */
    this.move = function(event){
    	var center = StaticMap.options.center.split(',');
    	switch(event) {
	    	case 'up':	    		
	    		center[0] = (parseFloat(center[0]) - parseFloat(StaticMap.scale)).toFixed(6); 
	    		break;
	    	case 'down':
	    		center[0] = (parseFloat(center[0]) + parseFloat(StaticMap.scale)).toFixed(6);
	    		break;
	    	case 'left':
	    		center[1] = (parseFloat(center[1]) + parseFloat(StaticMap.scale)).toFixed(6);
	    		break;
	    	case 'right':
	    		center[1] = (parseFloat(center[1]) - parseFloat(StaticMap.scale)).toFixed(6);
	    		break;
	    	default:
	    		break;
    	}    	
    	StaticMap.options.center = center.join(',');    	
    	change();
    };
    /**
     * size
     *
     * Change static map size
     */
    this.size = function(event){
    	switch(event) {
	    	case 'width-in':	    		
	    		StaticMap.options.width = parseInt(StaticMap.options.width) - parseInt(StaticMap.options.sizeScale); 
	    		break;
	    	case 'width-out':
	    		StaticMap.options.width = parseInt(StaticMap.options.width) + parseInt(StaticMap.options.sizeScale);
	    		break;
	    	case 'height-in':
	    		StaticMap.options.height = parseInt(StaticMap.options.height) - parseInt(StaticMap.options.sizeScale);
	    		break;
	    	case 'height-out':
	    		StaticMap.options.height = parseInt(StaticMap.options.height) + parseInt(StaticMap.options.sizeScale);
	    		break;
	    	default:
	    		break;
    	}
    	if(StaticMap.options.width > 640){
    		StaticMap.options.width = 640;    		
    	} else if(StaticMap.options.width < 50){
    		StaticMap.options.width = 50;
    	}
    	if(StaticMap.options.height > 640){
    		StaticMap.options.height = 640;    		
    	} else if(StaticMap.options.height < 50){
    		StaticMap.options.height = 50;
    	}    	
    	change();
    };
    /**
     * calculateMoveScale
     *
     * Change static map position
     */
    function calculateMoveScale(zoomLevel){
    	switch(zoomLevel) {
	    	case 21:	    		
	    		StaticMap.scale = 0.000001;  
	    		break;
	    	case 20:
	    		StaticMap.scale = 0.000001;
	    		break;
	    	case 19:    		
				StaticMap.scale = 0.000001;
				break;
	    	case 18:
	    		StaticMap.scale = 0.00001;
	    		break;
	    	case 17:
	    		StaticMap.scale = 0.00001;
	    		break;
	    	case 16:
	    		StaticMap.scale = 0.0001;
	    		break;
	    	case 15:
	    		StaticMap.scale = 0.0001;
	    		break;
	    	case 14:
	    		StaticMap.scale = 0.0001;
	    		break;
	    	case 13:
	    		StaticMap.scale = 0.0001;
	    		break;
	    	case 12:
	    		StaticMap.scale = 0.001;
	    		break;
	    	default:
	    		break;
    	}
    }
    /**
     * bindEventEnter
     *
     * Change static map position
     */
    function bindEventEnter(){
    	$('form input[name*="center"]').keyup(function(event){
    	    if(event.keyCode == 13){    	    	
    	    	StaticMap.options.center = $(this).val();
    	    	change();
    	    }
    	});
    	$('form input[name*="width"]').keyup(function(event){
    	    if(event.keyCode == 13){    	    	
    	    	StaticMap.options.width = $(this).val();
    	    	change();
    	    }
    	});
    	$('form input[name*="height"]').keyup(function(event){
    	    if(event.keyCode == 13){    	    	
    	    	StaticMap.options.height = $(this).val();
    	    	change();
    	    }
    	});
    }
    /**
	 * getCorners
	 *
	 * Calculating image corner coordinates
	 */
	function getCorners(center,zoom,mapWidth,mapHeight){
	    var scale = Math.pow(2,zoom);
	    var centerPx = proj.fromLatLngToPoint(center);
	    var SWPoint = {x: (centerPx.x -(mapWidth/2)/ scale) , y: (centerPx.y + (mapHeight/2)/ scale)};
	    var bottomLatLon = proj.fromPointToLatLng(SWPoint);
	    var NEPoint = {x: (centerPx.x +(mapWidth/2)/ scale) , y: (centerPx.y - (mapHeight/2)/ scale)};
	    var topLatLon = proj.fromPointToLatLng(NEPoint);
	    return {'bottom':{'lat':bottomLatLon.jb,'long':bottomLatLon.kb},'top':{'lat':topLatLon.jb,"long":topLatLon.kb}};
	}
};