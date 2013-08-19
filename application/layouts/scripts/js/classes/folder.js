windowObject = function(){
    this.count = 0;
    this.create = function(obj){
        var id = 'window'+this.count+1;
        html  = '<div class="windowObject show normalWindow selected" id="'+id+'">'+
            '<div class="windowHeader">'+
                '<div class="fl m5">ico</div>'+
                '<div class="fl m5">'+$(obj).text()+'</div>'+
                '<div class="fr m5"><a class="link fl mr5 minimize" data-id="'+id+'"  onclick="windowObject.minimize(this);">-</a><a class="fullScreenButton fl mr5 link" data-id="'+id+'" onclick="windowObject.fullScreen(this);"></a><a  onclick="windowObject.close(this);" class="link fl mr5 close" data-id="'+id+'">X</a></div>'+
            '</div>'+
            '<div class="windowContent" >'+
                '<table style="position:absolute;top:0px;width:100%;height:100%;">'+
                    '<tr>'+
                        '<td class="mainContent panel">'+
                            '<div>content '+id+'</div>'+
                        '</td>'+
                    '</tr>'+
                '</table>'+
            '</div>'+
        '</div>';
        windowObject.count++;
        $('.content_container>div>div').append(html);
        $('#'+id).draggable({ handle: $('#'+id).children( ".windowHeader" )}).resizable({
              maxHeight: 400,
              maxWidth: 800,
              minHeight: 100,
              minWidth: 200
        });
        //$('#'+id).children( ".windowContent" ).height(parseInt($('#'+id).height())-25);
        $('#'+id).mousedown(function(){
			$('.windowObject').removeClass('selected');
			$(this).addClass('selected');
			selectedWindow = $(this).attr('id');
			ajaxContainer = '#'+selectedWindow+' .panel';
		});
		$('#'+id).resize(function(){
            //$(this).children( ".windowContent" ).height(parseInt($('#'+id).height())-25);
        });
        $('#'+id).css({'position':'fixed','top':150+(this.count*20)+'px','left':150+(this.count*20)+'px'});
        html='<div class="fl ml5 mr10 link" style="color:black;" id="ico'+id+'" data-id="'+id+'" onclick="windowObject.minimize(this);">'+$(obj).text()+'</div>';
        $('.page_wrapper').append(html);
        if(obj){
            var href = $(obj).data('href');
            console.log(href);
			if (href && href.length > 0){
				Url.push(href);    		    	
			}
        }	
    	$('.ui-icon-gripsmall-diagonal-se').remove();
		return id;
    };
	
	
    this.close = function(obj){
        $('#'+$(obj).data('id')).remove();
        $('#ico'+$(obj).data('id')).remove();
    };
	
    this.minimize = function(obj){
        if($('#'+$(obj).data('id')).hasClass('show')){
            $('#'+$(obj).data('id')).hide();
			$('#'+$(obj).data('id')).removeClass('show');
			$('#'+$(obj).data('id')).addClass('hide');
        }else{
            $('#'+$(obj).data('id')).show();
			$('#'+$(obj).data('id')).removeClass('hide');
			$('#'+$(obj).data('id')).addClass('show');
        }
    };
    
    this.fullScreen = function(obj){
		$obj = $('#'+$(obj).data('id'));
		if($obj.hasClass('normalWindow')){
			$obj.attr('class','windowObject show fullScreen');
		}else{
			$obj.attr('class','windowObject show normalWindow');
		}
    };
}