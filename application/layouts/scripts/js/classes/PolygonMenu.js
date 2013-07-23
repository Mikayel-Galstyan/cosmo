/**
* PolygonMenu class
* 
* Styles for menu.
*
* @author sourcio.com
* 
*/

function PolygonMenu() {
	
	this.activate = function(menuId, selectFirstEl) {
		var $menu = $('#'+menuId);
		var liArray = $menu.find('li');
		if(selectFirstEl) {
			liArray.first().addClass('active');
		}
		liArray.each(function() {
			$(this).click(function() {
				$menu.find('li').removeClass('active');
				$(this).addClass('active');
			});
		});
		
	}
}