/**
* Grid class
* 
* Version 1.0
* 
* @author sourcio.com 
* 
*/
function Grid() {
    /**
     * Url
     *
     * Url 
     */    
    var sourceUrl = null;
    /**
     * pageNum
     *
     * Page number
     */    
    var pageNumber = 1;
    /**
     * sort
     *
     * Sort field param
     */    
    var sortFilter = "ASC";
    /**
     * order
     *
     * Order field param
     */    
    var orderFilter = "id";
    /**
     * Init
     *
     * Init url     
     */    
    this.init = function(url){
        //init url 
    	setSourceUrl(url);
    };
    
    function success(result) {
    	Util.append($('tr.panel>td'), result);        
    };
    
    /**
     * Show
     *
     * Show items
     * @param url = controller/action (ajax/report1)
     */
    function showPage (callback) {
    	//Showing mask
    	Mask.show();
        //abort ajax request if exists
        Ajax.check();
        //create param for page
        page = '?page=' + getPageNumber();
        //create param for sort
        sort = '&' + 'sort=' + getSortFilter();
        //create param for order
        order = '&' + 'order=' + getOrderFilter();
        //serilize forms
        forms = "";
        $('.panel form').each(function(){
            //create params for form
            forms += '&'+ $(this).serialize();
        });
        //generate url
        url = getSourceUrl() + page + sort + order + forms;
        //saving last viewed url
        Url.setHiddenUrl(url);
        
        // Get page            
        Ajax.get(url, success, callback);        
    };
    /**
     * Page
     *
     * page items
     */
    this.page = function(number){
        setPageNumber(number);
        showPage();
    };
    /**
     * Icon Sort
     *
     * Icon Sort items
     * 
     */
    this.iconSort = function(columnName){            	
        elem = $('#' + columnName);        
        if (elem.hasClass('headerSortUp')){ 
            sort = 'headerSortDown';
        } else{
            sort = 'headerSortUp';
        }        
        if(elem.hasClass('headerSortUp') || elem.hasClass('headerSortDown') || elem.hasClass('header')){
            $(elem.closest('tr').children('th.header')).removeClass('headerSortUp').removeClass('headerSortDown').addClass('header'); 
            $(elem.closest('tr').children('th.headerSortDown')).removeClass('headerSortUp').removeClass('headerSortDown').addClass('header');
            $(elem.closest('tr').children('th.headerSortUp')).removeClass('headerSortUp').removeClass('headerSortDown').addClass('header');
            elem.removeClass('header').addClass(sort);
        }
    };
    /**
     * Sort
     *
     * Sort items
     * 
     */
    this.sort = function(columnName) {        	
        Grid.iconSort(columnName);
        if (elem.hasClass('headerSortUp')){ 
            sort = 'ASC';
        } else{
            sort = 'DESC';
        }
        setSortFilter(sort);
        setOrderFilter(columnName);
        showPage();
    };
    /**
     * Reload
     *
     * Realoding grid
     * 
     */
    this.reload = function(callback) {        
    	//Showing mask
    	Mask.show();
        //abort ajax request if exists
        Ajax.check();                                                
        // Get page            
        if (!Url.getHiddenUrl()){
            Url.setHiddenUrl(getSourceUrl());
        }
        Ajax.get(Url.getHiddenUrl(), success, callback);
    };
    
    //setters and getters
    function getSourceUrl(){
    	return sourceUrl; 
    };
    function setSourceUrl(url){
    	sourceUrl= url;
    	return this;
    };
    function getPageNumber(){
    	return pageNumber; 
    };
    function setPageNumber(number){
    	pageNumber = number;
    	return this;
    };
    function getSortFilter(){
    	return sortFilter; 
    };
    function setSortFilter(sort){
    	sortFilter = sort;
    	return this;
    };
    function getOrderFilter(){
    	return orderFilter; 
    };
    function setOrderFilter(order){
    	orderFilter = order;
    	return this;
    };
};