/**
* Right context menu class
*
* @author sourcio.com
* 
*/
function Polygon() {
	/**
     * areaCoords
     *
     * storing areaCoords
     */
    this.areaCoords = {};
    /**
     * Upload boxes
     *
     * Defining upload image sizes
     */
    this.imageSizes = [];
    /**
     * holes
     *
     * defining holes related with course
     */
    this.holes = [];    
	/**
     * state
     *
     * storing state
     */
    this.state = {'point':0,'poi':0,'hole':0};
	/**
     * poiIndex
     *
     * 
     */
    this.poiIndex = 0;
	/**
     * pointIndex
     *
     * 
     */
    this.pointIndex = 0;
    /**
     * zoomMin
     *
     * defining zooming minimum value	
     */
    var zoomMin = 0.4;
    /**
     * zoomMax
     *
     * defining zooming maximum value	
     */
    var zoomMax = 3;    
    /**
     * zoom
     *
     * defining zooming value	
     */
    var zoom = 1;
    var zoomLast = 1;
    /**
     * shiftZoom
     *
     * defining shiftZooming value
     */
    var shiftZoom = 0.2;    
    /**
     * shiftPosition
     *
     * defining shiftPosition value
     */
    var shiftPosition = 10;
	/**
     * selector
     *
     * element identifier
     */
    var selector = '.polygon_temp';
    /**
     * holeTemplate
     *
     * Define poi template
     */
    var holeTemplate =
    	'<div class="hole">\
			<label>Hole lat</label>\
			<input class="lat" type="text"/>\
			<label>Hole long</label>\
			<input class="long" type="text"/>\
			<a href="" onclick="Polygon.deleteHole(this)" title="delete">Delete</a>\
		</div>';
    /**
     * poiTemplate
     *
     * Define poi template
     */
    var poiTemplate =
    	'<div class="poi">\
			<label>POI name</label>\
			<input class="name" type="text" />\
			<label>Lat</label>\
			<input class="lat" type="text" />\
			<label>Long</label>\
			<input class="long" type="text" />\
			<a href="" onclick="Polygon.deletePOI(this)" title="delete">Delete</a>\
		</div>';
    /**
     * pointTemplate
     *
     * Define coordinates template
     */
    var pointTemplate =
		'<div class="point">\
			<label>Lat</label>\
			<input class="lat" type="text" />\
			<label>Long</label>\
			<input class="long" type="text"/>\
			<a href="" onclick="Polygon.deletePoint(this)" title="delete">Delete</a>\
		</div>';
    /**
     * holeListTemplate
     *
     * Define hole list template
     */
    var holeListTemplate = '';    	
    /**
     * polygonTemplate
     *
     * Define polygon template
     */
    var polygonTemplate =
    	'<tr><td>\
    	    <div class="polygon">\
	    		<label>Polygon name</label>\
				<input class="name" type="text" />\
				<label>Polygon type</label>\
				<select class="type">\
	    			<option value="0">Tee-off-sector</option>\
	    			<option value="1">Fairway-sector</option>\
	    			<option value="2">Green-sector</option>\
    			</select>\
    			<br/>\
		    	<label>Order</label>\
				<input class="order w20" type="text" value="0"/>\
		    	<label>Min Time</label>\
				<input class="minTime w50" type="text" value="0"/>\
		    	<label>Max Time</label>\
				<input class="maxTime w50" type="text" value="0"/>\
	    		<a class="button w100 fl" onclick="Polygon.addPoint(this); return false;">Add point</a>\
	    		<a class="button deletePolygon w100 fl" onclick="Polygon.delete(this); return false;">Delete Polygon</a>\
    		</div>\
			<div class="pois">\
    			<a class="button w100 fl addPoi" onclick="Polygon.addPOI(this); return false;">Add POI</a>\
    			<a class="button w100 fl addHole" onclick="Polygon.addHole(this); return false;">Add Hole</a>\
    		</div>\
		</td></tr>';
    /**
     * init
     *
     * Initializing polygon behavior
     */
    this.init = function(){
    	prepareHoleListTemplate();
		/*
		MapMenu.getMapImg().bind('mousewheel',function(e, delta){
    		e.preventDefault();
            if (delta > 0) {
            	Polygon.zoom('in');            	
            } else {
            	Polygon.zoom('out');                        
            }                                
    	});
    	*/
    };
    /**
     * Add
     *
     * Adding polygon point
     */
    this.add = function(name){
    	elemPos = {'x':Coordinates.mouseX,'y':Coordinates.mouseY};
    	$this = $('<div class="polygon_temp polygon_' + name + '">' + ++Polygon.state[name] +'</div>');    	
    	styles = {'left':elemPos.x-10,'top':elemPos.y-10};
    	$.each( styles, function( prop, value ) {
    		$this.css(prop, value);
    	});    	
    	MapMenu.getMapImg().before($this);
    	MapMenu.hide();
    	if(name == 'hole'){    		
    		MapMenu.disable(name);
    	}
    	var position = getElementPossition($this);
    	$this.data({'position': position});
    	draggablePoint($this);
    };
    /**
     * reorderPoints
     *
     * Reordering points after zooming
     */
    function reorderPoints(){
    	$points = $('.polygon_temp');
    	if($points.length > 0 ){
    		$.each( $points, function() {
        		$this = $(this);        		
        		var position = $this.position();
        		var left = position.left / zoomLast * zoom;
        		var top = position.top / zoomLast * zoom;
        		$this.css({'left':left, 'top':top});        		
        	});	
    	}    	    	    	
    };
    /**
     * Delete
     *
     * Adding polygon point
     */    
    this.delete = function(elem){
    	var $this = $(elem);    	
    	callback = function(){    		
    		//removing polygon
    		$this.closest('tr').fadeOut(300, function() { $(this).remove(); });
        	//hiding popup box and mask
            Mask.hide();            
        }; 
        init = {buttons:[{name:'yes',callback: callback}]};
        confirm = new Popup(init);
        confirm.show('polygon/confirm');
    };
    /**
     * AddPoint
     *
     * Adding polygon point
     */
    /*this.addPoint = function(elem){
    	$this = $(elem);
    	var pointsArr = [];
    	$polygon = $this.closest('.polygon');
    	$points =  $polygon.find('.point');    	    	
    	$points.each(function() {
    		$this = $(this);    		
    		pointsArr.push($this.data('id'));			
		});
    	pointId = 1;
    	if ($points.length > 0){
    		pointId = Array.max(pointsArr) + 1;	
    	}
    	polygonId = $polygon.data('id');      	
    	$pointTemplate = $(pointTemplate);
    	$pointTemplate.attr('data-id', pointId);
    	$pointTemplate.find('input.lat').attr('name', 'lat[' + polygonId + '][' + pointId + ']');
		$pointTemplate.find('input.long').attr('name', 'long[' + polygonId + '][' + pointId + ']');
		$polygon.find('.button:first').before($pointTemplate.clone());
    };*/
    /**
     * DeletePoint
     *
     * Delete polygon point
     */
    /*this.deletePoint = function(elem){
    	$this = $(elem);
    	if ($this.closest('.polygon').find('.point').length > 3){
    		$this.closest('.point').fadeOut(300, function() { $(this).remove(); });	
    	}    	
    };*/
    /**
     * AddPOI
     *
     * Adding polygon POI
     */
    /*this.addPOI = function(elem){
    	$this = $(elem);
    	var poisArr = [];
    	$pois = $this.closest('.pois');
    	$poi = $pois.find('.poi');    	
    	$poi.each(function() {
    		$this = $(this);    		
    		poisArr.push($this.data('id'));			
		});
    	poiId = 1;
    	if ($poi.length > 0){
    		poiId = Array.max(poisArr) + 1;	
    	}      	
    	polygonId = $pois.data('id');    	
    	$poiTemplate = $(poiTemplate);
    	$poiTemplate.attr('data-id', poiId);
    	$poiTemplate.find('input.name').attr('name', 'pname[' + polygonId + '][' + poiId + ']');
		$poiTemplate.find('input.lat').attr('name', 'plat[' + polygonId + '][' + poiId + ']');
		$poiTemplate.find('input.long').attr('name', 'plong[' + polygonId + '][' + poiId + ']');
		$pois.find('.button:first').before($poiTemplate.clone());
    };*/
    /**
     * DeletePoint
     *
     * Delete polygon point
     */
    /*this.deletePOI = function(elem){
    	$this = $(elem);    	
    	$this.closest('.poi').fadeOut(300, function() { $(this).remove(); });
    };*/
    /**
     * addHole
     *
     * Adding polygon Hole
     */
    /*this.addHole = function(elem){
    	$this = $(elem); 
    	$pois = $this.closest('.pois');
    	polygonId = $pois.data('id');    	
    	$holeTemplate = $(holeTemplate);    	
    	$holeTemplate.find('input.lat').attr('name', 'hole[' + polygonId + '][lat]');
		$holeTemplate.find('input.long').attr('name', 'hole[' + polygonId + '][long]');
		$pois.prepend($holeTemplate.clone());
		$this.fadeOut(300);
    };*/
    /**
     * DeleteHole
     *
     * Delete polygon hole
     */
    /*this.deleteHole = function(elem){
    	$this = $(elem);    	
    	$this.closest('.hole').fadeOut(300, function() { $(this).remove(); });
    	$this.closest('.pois').find('.addHole').fadeIn(300);    	
    };*/
    /**
     * Build
     *
     * Build polygon point
     */
    this.build = function(){
    	resetAddPolygon();
    	$('[name="name"]').val('New Ploygon');
    	$polygonPoint = $('.polygon_point');    	
    	$polygonPoint.each(function(i) {
        	$this = $(this);
        	if(i>=3) {
        		addPoint();
        	}
        	$('[name="lat['+(i+1)+']"]').val($this.data('position').lat);
        	$('[name="long['+(i+1)+']"]').val($this.data('position').long);
    	});	
    	$hole = $('.polygon_hole');  	
    	if ($hole.length > 0){    	
    		addCourseHole();
    		$('[name="hole[lat]"]').val($hole.data('position').lat);
    		$('[name="hole[long]"]').val($hole.data('position').long);
    	}
    	$polygonPOI = $('.polygon_poi');    	
    	if ($polygonPOI.length > 0) {
    		$polygonPOI.each(function(i) {
    			$this = $(this);
    			addPoi();
    			$('[name="pname['+(i+1)+']"]').val('poi_'+(i+1)+'');
    			$('[name="plat['+(i+1)+']"]').val($this.data('position').lat);
    			$('[name="plong['+(i+1)+']"]').val($this.data('position').long);
    		});	
    	}
    	//prepare drawing
    	Polygon.clean();
    };
    /**
     * Edit
     *
     * Edit polygon
     */
    this.getUploadBoxes = function(id){
    	var html = '';
    	$.each(Polygon.imageSizes, function(i, size) {
    		name = 'image_' + size + '_' + id;
    		html += '<br/><label for="' + name + '">Image ' + size + '</label>';    		
			html += '<input class="file" type="file" id="' + name + '"  name="' + name + '">';
		});
    	return html;
    };
    /**
     * Edit
     *
     * Edit polygon
     */
    this.edit = function(id){    	
    	$(".polygon_container td").css('background-color', '');		
		$parent = $('.polygon[data-id=' + id +']').closest('td');		
		$parent.css({'background-color': '#ceedc1'});
		$("html, body").animate({ scrollTop: $parent.find('.polygon').offset().top }, 1000);
    };
    /**
     * Create
     *
     * Create polygon area in UI
     */
    this.create = function(){
    	Polygon.build();
    	MapMenu.hide();
    };
    /**
     * Disable
     *
     * Disabling right click for defined element
     */
    this.remove = function(){
    	$.each( Polygon.state, function( key, value ) {
    		Polygon.state[key] = 0;
		});
    	$(selector).remove();    	
    };
    /**
     * Clean
     *
     * Reamoving all polygons from course
     */
    this.clean = function(){
    	Polygon.remove();
    	MapMenu.hide();
    	MapMenu.activate('hole');
    };
    /**
     * Clean
     *
     * Reamoving all polygons from course
     */
    this.cleanAll = function(){
    	Polygon.clean();
    };
    /**
     * zoom
     *
     * Polygon Zooming
     */
    this.zoom = function(event){
    	zoomLast = zoom;
    	switch(event) {
	    	case 'in':	    		
	    		zoom = parseFloat(zoom) + parseFloat(shiftZoom);
	            if (zoom >= zoomMax){
	            	zoom = zoomMax;
	            }	            
	    		break;
	    	case 'out':	    		
	    		zoom = parseFloat(zoom) - parseFloat(shiftZoom);    	
	            if (zoom <= zoomMin){
	            	zoom = zoomMin;
	            }	            
	    		break;
    	}
    	zoom = zoom.toFixed(1);
    	if(zoom >= zoomMin && zoom <= zoomMax){    		
    		changeMapSize();	
    	}    	
    };
    /**
     * move
     *
     * Change polygon position
     */
    this.move = function(event){
    	var $mapImg = MapMenu.getMapContainer().find('.map_image');
    	switch(event) {
	    	case 'up':
	    		$mapImg.css('top', '-=' + shiftPosition );
	    		break;
	    	case 'down':
	    		$mapImg.css('top', '+=' + shiftPosition );
	    		break;
	    	case 'left':
	    		$mapImg.css('left', '-=' + shiftPosition );
	    		break;
	    	case 'right':
	    		$mapImg.css('left', '+=' + shiftPosition );
	    		break;
	    	default:
	    		break;
    	}
    	Coordinates.reset();
    };
    /**
     * drawMapArea
     *
     * Drawing on polygon map area
     */
    this.drawMapArea = function(){
		MapMenu.getMapContainer().find('map').remove();
		mapHtml = '<map name="polygonsMap">';
    	var i = 1; 
    	$.each( Polygon.areaCoords, function( key, value ) {
    		var coords = value.split(',');
    		$.each( coords, function(index) {
    			coords[index] = (coords[index] * zoom).toFixed(MapMenu.fixCount);
    		});
    		coords = coords.join(',');
    		mapHtml += '<area onclick="Polygon.edit(' + i +') ; return false;" alt="'+ key +'" title="' + key + '" shape="poly" coords="' + coords + '" />';    		
    		i++;
		});
    	mapHtml += '</map>';
    	MapMenu.getMapContainer().prepend(mapHtml);
    };
    
    this.getPoiIndex = function() {
        if(!this.poiIndex) {
        	var poiArray = $('input').filter(function() {return /^pname\[/.test(this.name)});
           	if(poiArray.length>0) {
            	var theLast = poiArray[poiArray.length-1];
            	var theLastname = theLast.name;
            	this.poiIndex = parseInt(theLastname.substr(6, theLastname.length-7)) + 1;
           	}
           	else {
           		this.poiIndex = 1;
            }
        }
        else {
        	this.poiIndex += 1;
        }
    	
        return this.poiIndex;
    }
        
    this.getPointIndex = function() {
    	if(!this.pointIndex) {
    		var pointArray = $('input').filter(function() {return /^lat\[/.test(this.name)});
            if(pointArray.length>0) {
            	var theLast = pointArray[pointArray.length-1]; 
                var theLastname = theLast.name;
                this.pointIndex = parseInt(theLastname.substr(4, theLastname.length-5)) + 1;
            }
            else {
            	this.pointIndex = 1;
            }
        }
        else {
        	this.pointIndex += 1;
        }

            return this.pointIndex;
    }
           
        
    /**
     * prepareHoleTemplate
     *
     * preparing hole template
     */ 
    function prepareHoleListTemplate(){    	
    	holeListTemplate =
    		'<div class="holeList">\
    			<label>Course Hole</label>\
				<select class="holeId">\
					<option value="">-- choose --</option>';    	    
    	$.each(Polygon.holes, function(k, v){
    		holeListTemplate += '<option value="' + k + '">' + v + '</otpion>';
    	});
    	holeListTemplate +=
    			'</select>\
    		</div>';
    };
    /**
     * changeMapSize
     *
     * Changeing map size regarding zooming attribute
     */ 
    function changeMapSize(){
    	MapMenu.getMapImg().width(Coordinates.imgOrigSize.width * zoom);
    	MapMenu.getMapImg().height(Coordinates.imgOrigSize.height * zoom);
    	Coordinates.reset();
    	Polygon.drawMapArea();
    	reorderPoints();
    };
    /**
     * getElementPossition
     *
     * Getting element position
     */ 
    function getElementPossition($element){
    	//define point sizes
    	var width = 20;
    	var height = 20;
    	var position = $element.position();
    	var x = parseInt(position.left + width/2);
    	var y = parseInt(Coordinates.imgSize.height - (position.top + height/2));
    	lat = parseFloat(Coordinates.loc.bottom.lat) + parseFloat(y * Coordinates.shift.lat);
    	long = parseFloat(Coordinates.loc.bottom.long) + parseFloat(x * Coordinates.shift.long);
    	return {'lat':lat.toFixed(MapMenu.fixCount), 'long':long.toFixed(MapMenu.fixCount)};
    };
    /**
     * getPolygonCount
     *
     * Getting polygon count in current view
     */ 
    function getPolygonCount(){
    	var polygonsArr = [];
    	$polygons = $('.polygon');
    	if ($polygons.length > 0){
    		$polygons.each(function() {
        		$this = $(this);
        		polygonsArr.push($this.data('id'));			
    		});
    		return Array.max(polygonsArr);
    	}
    	return false;
    };    
    /**
     * draggablePoint
     *
     * Initialization to provide points dragging
     */ 
    function draggablePoint($element){
    	$element.draggable({
	        stop: function() {
	        	var position = getElementPossition($element);
	        	$(this).data({ 'position': position});
	        }
    	});
    };
};