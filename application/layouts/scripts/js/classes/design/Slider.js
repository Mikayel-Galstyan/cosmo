/**
* Slider class
* 
* Version 1.0
* 
* @author sourcio.com 
* 
*/

function Slider() {
	
	/**
     * buttonsWidth
     *
     * Defining the length of 'Move to Left' and 'Move to Right' buttons.
     */
	var buttonsWidth = 31;
	
	/**
     * $leftArrow
     *
     * The jQuery object of 'Move to Left' button.
     */
	var $leftArrow;
	
	/**
     * $rightArrow
     *
     * The jQuery object of 'Move to Right' button.
     */
	var $rightArrow;
	
	/**
     * $content
     *
     * The jQuery object of the list to be slided.
     */
	var $content;
	
	/**
     * $contentWrapper
     *
     * The jQuery object of div which shows the visible part of list.
     */
	var $contentWrapper;
	
	/**
     * marginLeft
     *
     * Left margin of the element to slide.
     */
	var marginLeft;
	
	/**
     * step
     *
     * Specifies the offset for one slide.
     */
	var step;
	
	/**
     * viewPortWidth
     *
     * The width of UL tag's part which must be visible.
     */
	var viewPortWidth;
		
	/**
     * offset
     *
     * The number of the most right element.
     */
	var offset;
	
	/**
     * elCount
     *
     * The total number of elements.
     */
	var elCount;
	
	/**
     * elCountPerStep
     *
     * The count elements to be moved (per slide).
     */
	var elCountPerStep;
	
	/**
     * offsetLeftLimit
     *
     * 
     */
	var offsetLeftLimit;
	
	
	/**
     * updateViewPortWidth
     *
     * Updates the width of viewport by the given parameter.
     */
	function updateViewPortWidth(offset) {
		viewPortWidth += offset;
		$contentWrapper.width(viewPortWidth);
	}
	
	/**
     * updateMarginLeft
     *
     * Updates the left margin of list.
     */
	function updateMarginLeft() {
		$content.css('marginLeft', marginLeft + 'px');
	}
	
	/**
     * initLeftArrow
     *
     * Initializes the 'Move to Left' button.
     */
	function initLeftArrow() {
		$leftArrow = $('<a id="slider_left_arrow" ></a>');
		$leftArrow.click(function() {
			if(offset - elCountPerStep > offsetLeftLimit) {
				marginLeft += step;
				offset -= elCountPerStep;
			} else {
				marginLeft = 0;
				offset = offsetLeftLimit;
				$leftArrow.hide();
				updateViewPortWidth(buttonsWidth);
			}
			updateMarginLeft();
			$rightArrow.show();
		});
		
		return $leftArrow;
	}
	
	/**
     * initRightArrow
     *
     * Initializes the 'Move to Right' button.
     */
	function initRightArrow() {
		var clicked = false;
		$rightArrow = $('<a id="slider_right_arrow" ></a>');
		$rightArrow.click(function() {
			if(clicked) {
				if(!$leftArrow.is(":visible")) {
					$leftArrow.show();
					updateViewPortWidth(-buttonsWidth);
					marginLeft -= buttonsWidth + 1;
				}
				if(offset<elCount) {
					if(elCount - offset < elCountPerStep) { 
						marginLeft -= (step/elCountPerStep)*(elCount - offset);
						$rightArrow.hide();
						offset = elCount;
					}
					else {
						marginLeft -= step;
						offset += elCountPerStep;
					}
					updateMarginLeft();
				}
				else {
					offset = elCount;
					$rightArrow.hide();
				}
			}
			else {
				clicked = true;
				if(offset<elCount) {
					offset += elCountPerStep;
					updateViewPortWidth(-buttonsWidth);
					$leftArrow.show();
					marginLeft -= step + buttonsWidth + 1;
					updateMarginLeft();
				}
			}
		});
		
		return $rightArrow;
	}
	
	/**
     * activate
     *
     * Activates the slider and creates all necessary elements.
     */
	this.activate = function(count, elLength) {
		// get Jquery Object's of elelemnts
		$wrapper = $('#slider_wrapper');
		$contentWrapper = $('<div id="slider_ul_wrapper"></div>');
		$content = $('#slider_content');
		
		elCountPerStep = count;
		step = count * elLength;
		marginLeft = parseInt($content.css('marginLeft'));
		viewPortWidth = $wrapper.width() - buttonsWidth;
		offsetLeftLimit = viewPortWidth/elLength;
		offset = offsetLeftLimit;
		elCount = $content.find('li').length;
		
		$contentWrapper.width(viewPortWidth);
		$wrapper.append(initLeftArrow());
		$contentWrapper.append($content);
		$wrapper.append($contentWrapper); 
		if(viewPortWidth < $content.find('li').length * elLength) {
			$wrapper.append(initRightArrow());
		}
	}
}