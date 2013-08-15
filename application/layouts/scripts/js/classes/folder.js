windowObject = function(){
    this.count = 0;
    this.create = function(obj){
        id = 'window'+this.count+1;
        html  = '<div class="windowObject show" id="'+id+'">'+
            '<div class="windowHeader">'+
                '<div class="fl m5">ico</div>'+
                '<div class="fl m5">'+$(obj).text()+'</div>'+
                '<div class="fr m5"><a class="link fl mr5 minimize" data-id="'+id+'"  onclick="windowObject.minimize(this);">-</a><a class="fullScreen fl mr5 link" data-id="'+id+'"></a><a  onclick="windowObject.close(this);" class="link fl mr5 close" data-id="'+id+'">X</a></div>'+
            '</div>'+
            '<div class="windowContent" >'+
                '<table style="position:absolute;top:0px;width:100%;height:100%;">'+
                    '<colgroup>'+
                        '<col style="width:30%;">'+
                        '<col >'+
                    '</colgroup>'+
                    '<tr>'+
                        '<td class="leftMenu">'+
                            '<div>search '+id+'</div>'+
                        '</td>'+
                        '<td class="mainContent panel">'+
                            '<div>content '+id+'</div>'+
                        '</td>'+
                    '</tr>'+
                '</table>'+
            '</div>'+
        '</div>';
        windowObject.count++;
        $('body').append(html);
        $('#'+id).draggable({ handle: $('#'+id).children( ".windowHeader" )}).resizable({
              maxHeight: 400,
              maxWidth: 800,
              minHeight: 100,
              minWidth: 200
        });
        $('#'+id).children( ".windowContent" ).height(parseInt($('#'+id).height())-25);
        $('#'+id).resize(function(){
            $(this).children( ".windowContent" ).height(parseInt($('#'+id).height())-25);
        });
        $('#'+id).css({'position':'absolute','top':150+(this.count*20)+'px','left':150+(this.count*20)+'px'});
        html='<div class="fl ml5 mr10 link" style="color:black;" id="ico'+id+'" data-id="'+id+'" onclick="windowObject.minimize(this);">'+$(obj).text()+'</div>';
        $('.page_wrapper').append(html);
        if(obj){
            var href = $(obj).data('href');
            console.log(href);
        }
        
    };
    this.close = function(obj){
        $('#'+$(obj).data('id')).remove();
        $('#ico'+$(obj).data('id')).remove();
    };
    this.minimize = function(obj){
        if($('#'+$(obj).data('id')).hasClass('show')){
            $('#'+$(obj).data('id')).hide();
            $('#'+$(obj).data('id')).attr('class','windowObject hide');
        }else{
            $('#'+$(obj).data('id')).show();
            $('#'+$(obj).data('id')).attr('class','windowObject show');
        }
    }
    
    this.fullScreen = function(obj){
       
    }
}