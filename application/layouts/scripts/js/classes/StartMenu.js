StartMenu = function(){
    
    var show = false;
    
    this.init = function(){
        /*$('*:not(.page_wrapper)').click(function(){console.log('hide');
            if(show){
                show = false;
                $('#startMenuBar').hide(); 
            }
        });*/
        $('#startMenu').click(function(){
            if(!show){
                show = true;
                $('#startMenuBar').show(); 
            }else{
                show = false;
                $('#startMenuBar').hide(); 
            }
        });
        $('.startWindow>a').click(function(){
            var id = windowObject.create(this);
            ajaxContainer = '#' + id + ' .panel';
            $('#startMenuBar').hide();
        });
        $('.content_wrapper').click(function(){
            $('#startMenuBar').hide();
            show = false;
        });
    }
}