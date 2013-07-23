/**
* Navigation Menu class
* 
* Version 1.0
* 
* @author sourcio.com  
* 
*/
function Menu() {
    /**
     * SubMenu
     *
     * Display SubMenu
     */
    this.showSubMenu = function(){
        //Show SubMenu        
        $('#nav_menu>li>a.active').siblings().show();
    };
    /**
     * Activate
     *
     * Activate Sub 
     */
    this.acitvate = function(href){
    	elem = $('#nav_menu a[href="'+ href +'"]');        
        if (elem.length){
            $('#nav_menu ul').hide();
            navParentElem = $('#nav_menu>li>a'); 
            navParentElem.removeClass('active');
            navChildElem = $('#nav_menu>li>ul>li>a');
            navChildElem.removeClass('active');        
            elemSibilings = $(elem).closest('ul').siblings();
            elemSibilings.addClass('active');        	
            elem.parents('ul').show();            
            elem.addClass('active');
        } else {
            navMenu = $('#nav_menu');
            navMenu.find('a').removeClass('active'); 
            navMenu.find('ul').hide();
        }
    };
};
$(function(){  
	$(document).on('mouseenter', '#nav_menu>li', function() {
		$this = $(this).children('a');
        $('#nav_menu>li>ul').hide();
        $this.siblings().show();
	});
	$(document).on('mouseleave', '#nav_menu>li', function() {
		$this = $(this).children('a');
        if(!$this.hasClass('active')){
            $this.siblings().hide();
            Menu.showSubMenu();          
        }
	});
});
