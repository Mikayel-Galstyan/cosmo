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
            if(!show){console.log('show');
                show = true;
                $('#startMenuBar').show(); 
            }else{console.log('hide1');
                show = false;
                $('#startMenuBar').hide(); 
            }
        });
    }
}