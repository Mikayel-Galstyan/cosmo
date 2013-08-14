//initializing ajax container class
var ajaxContainer = '.panel';

//page title
var title = $('title').text();

//initializing javascript classes
var Mask = new Mask();
var Notify = new Notify();
var Validator = new Validator();
var Ajax = new Ajax();
var Form = new Form();
var Menu = new Menu();
var Page = new Page();
var Url = new Url();
var Util = new Util();
var Coordinates = new Coordinates();
var Grid = new Grid();
var CustomForm = new CustomForm();

var removeForm = new RemoveForm();
var Slider = new Slider();
var PolygonMenu = new PolygonMenu();
$(function(){
	// Function to get the Max value in Array
    Array.max = function( array ){
        return Math.max.apply( Math, array );
    };

    // Function to get the Min value in Array
    Array.min = function( array ){
       return Math.min.apply( Math, array );
    };
	$( window ).bind( 'popstate', function( e ) {
		href = Url.get();
    	if (href && href.length > 0){
    		Url.load(href);    		    	
    	}        
    });
	$(document).on('click', 'a:not(.noAjax)', function(){
		$this = $(this);
    	href = $this.attr('href');    	
    	if (href && href.length > 0){
    		Url.push(href);    		    	
    	}        
        return false;
	});
    
    $(document).on('keydown', '.disabled', function(event){	
        if(event.keyCode == 8){
            return false;
        }
    });
	$.tablesorter.addParser({
	    id: "monetaryValue",
	    is: function (s) {
	        var sp = s.replace(/,/, '.');
	        var test = (/([£$€%] ?\d+\.?\d*|\d+\.?\d* ?)/.test(sp)); //check currency with symbol
	        return test;
	    }, format: function (s) {
	        s = (s == ' - ')?(' - 999 999 999 999 '):s;                
	        return $.tablesorter.formatFloat(s.replace(new RegExp(/[^-?\d\d.]/g), ""));
	    }, type: "numeric"
	});
	$.tablesorter.addParser({
        id: "specialDigit",
        is: function (s) {
            return false;
        }, format: function (s) {
            if(s == ' - '){
                s = ' - 999 999 999 999';
            }else if($.trim(s).length == 0){
                s = ' - 1 000 000 000 000';
            }
            return $.tablesorter.formatFloat(s.replace(new RegExp(/[^-?\d\d.]/g), ""));
        }, type: "numeric"
    });
	$.tablesorter.addParser({
	    id: "specialPercent",
	    is: function (s) {
	        var sp = s.replace(/,/, '.');
	        var test = (/([%] ?\d+\.?\d*|\d+\.?\d* ?)/.test(sp)); //check currency with symbol
	        return test;
	    }, format: function (s) {
	        s = (s == ' - ')?(' - 999 999 999 999 '):s;                
	        return $.tablesorter.formatFloat(s.replace(new RegExp(/[^-?\d\d.]/g), ""));
	    }, type: "numeric"
	});

	$.tablesorter.addWidget({
		id: "scrollWidget",
		format: function(table){
			if ($(table).hasClass('hasStickyHeaders')) { return; }
			var $table = $(table).addClass('hasStickyHeaders'),
				c = table.config,
				wo = c.widgetOptions,
				win = $(window),
				header = $(table).children('thead:first'), //.add( $(table).find('caption') ),
				hdrCells = header.children('tr:not(.sticky-false)').children(),
				css = wo.stickyHeaders || 'tablesorter-stickyHeader',
				innr = '.tablesorter-header-inner',
				firstRow = hdrCells.eq(0).parent(),
				tfoot = $table.find('tfoot'),
				t2 = wo.$sticky = $table.clone(), // clone table, but don't remove id... the table might be styled by css
				// clone the entire thead - seems to work in IE8+
				stkyHdr = t2.children('thead:first')
					.addClass(css)
					.css({
						margin     : 0,
						top        : 0,
						zIndex     : 1
					}),
				stkyCells = stkyHdr.children('tr:not(.sticky-false)').children(), // issue #172
				laststate = '',
				spacing = 0,
				resizeHdr = function(){
					var bwsr = navigator.userAgent;
					spacing = 0;
					// yes, I dislike browser sniffing, but it really is needed here :(
					// webkit automatically compensates for border spacing
					if ($table.css('border-collapse') !== 'collapse' && !/(webkit|msie)/i.test(bwsr)) {
						// Firefox & Opera use the border-spacing
						// update border-spacing here because of demos that switch themes
						//spacing = parseInt(hdrCells.eq(0).css('border-left-width'), 10) * 2;
					}

				};
			// clear out cloned table, except for sticky header
			t2.find('thead:gt(0),tr.sticky-false,tbody,tfoot,caption').remove();
			t2.css({ height:0, padding:0, margin:0, border:0 });
			// remove rows you don't want to be sticky
			stkyHdr.find('tr.sticky-false').remove();
			// remove resizable block
			stkyCells.find('.tablesorter-resizer').remove();
			// update sticky header class names to match real header after sorting
			$table
			.bind('sortEnd.tsSticky', function(){
				hdrCells.each(function(i){
					var t = stkyCells.eq(i);
					t.attr('class', $(this).attr('class'));
					if (c.cssIcon){
						t
						.find('.' + c.cssIcon)
						.attr('class', $(this).find('.' + c.cssIcon).attr('class'));
					}
				});
			})
			.bind('pagerComplete.tsSticky', function(){
				resizeHdr();
			});
			// set sticky header cell width and link clicks to real header
			hdrCells.each(function(i){
				var t = $(this),
				s = stkyCells.eq(i)
				// clicking on sticky will trigger sort
				.bind('click', function(e){
					t.trigger(e);
				})
				// prevent sticky header text selection
				.bind('mousedown', function(){
					this.onselectstart = function(){ return false; };
					return false;
				});
			});
			// add stickyheaders AFTER the table. If the table is selected by ID, the original one (first) will be returned.
	        uniqId = $table.attr('id').replace('table','div');
	        var object = $('#'+uniqId);
	        object.before(t2);
	        t2.addClass('nonTabOut');
	        $table.addClass('original');
	        var height = parseInt(object.css('height'))-parseInt($('#'+$table.attr('id')+" thead").css('height'));
	        $('.original thead').hide();
	        object.css('height',height+'px');
			// make it sticky!
			win
			.bind('resize.tsSticky', function(){
	            resizeHdr();
			});
		},
		remove: function(table, c, wo){
			var $t = $(table),
			css = wo.stickyHeaders || 'tablesorter-stickyHeader';
			$t.removeClass('hasStickyHeaders')
			  .unbind('sortEnd.tsSticky pagerComplete.tsSticky')
			  .find('.' + css).remove();
			if (wo.$sticky) { wo.$sticky.remove(); } // remove cloned thead
			$(window).unbind('scroll.tsSticky resize.tsSticky');
		}
	});
	//activate menus  
	Menu.acitvate(Url.get());
    $('#loginIsHere').draggable();
    $('#loginIsHere').resizable();
});


