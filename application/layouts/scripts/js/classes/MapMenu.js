/**
* Map right click context menu class
*
* @author sourcio.com
* 
*/
Cosmo_object = {
    selected_element: null,
    zoomPixel: 2,
    init: function(){
        $('#objectList img').click(function(){
            //$('#templateDress').remove();
            $(this).clone().attr('id', 'templateDress').appendTo($('#ImageDiv span'));
            //$('#templateDress').css({'position':'absolute','top':'100px','left':'100px'});
            $('#templateDress').mousedown(Cosmo_object.handle_mousedown);
        });
        /*$('#heir img').click(function(){
            //$('#templateheir').remove();
            $(this).clone().attr('id', 'templateheir').appendTo($('#ImageDiv span'));
            $('#templateheir').css({'position':'absolute','top':'10px','left':'10px'});
            $('#templateheir').mousedown(Cosmo_object.handle_mousedown);
        });
        $('#gold img').click(function(){
            $('#goldTemplate').remove();
            $(this).clone().attr('id', 'goldTemplate').appendTo($('#ImageDiv span'));
            $('#goldTemplate').css({'position':'absolute','top':'10px','left':'10px'});
            $('#goldTemplate').mousedown(Cosmo_object.handle_mousedown);
        });
        $('#header img').click(function(){
            $('#headerTemplate').remove();
            $(this).clone().attr('id', 'headerTemplate').appendTo($('#ImageDiv span'));
            $('#headerTemplate').css({'position':'absolute','top':'10px','left':'10px'});
            $('#headerTemplate').mousedown(Cosmo_object.handle_mousedown);
        });*/
        window.onkeydown=function(e){console.log(e.keyCode);
            if(e.keyCode == 109){//up
                Cosmo_object.zoomOut(Cosmo_object.selected_element,2);
            }
            if(e.keyCode == 107){//down
                Cosmo_object.zoomIn(Cosmo_object.selected_element,2);
            }  
        }
    },
    rotateY: function(elem,rad){
       
    },
    rotateZ: function(elem,rad){
       
    },
    rotateX: function(elem,rad){
        
    },
    zoomIn : function(elem,pixel){
        $(elem).height((parseInt($(elem).height())+pixel));
    },
    zoomOut : function(elem,pixel){
        $(elem).height((parseInt($(elem).height())-pixel));
    },
    handle_mousedown : function (e){
        window.my_dragging = {};
        my_dragging.pageX0 = e.pageX;
        my_dragging.pageY0 = e.pageY;
        my_dragging.elem = this;
        Cosmo_object.selected_element = this;
        my_dragging.offset0 = $(this).offset();
        function handle_dragging(e){
            var left = my_dragging.offset0.left + (e.pageX - my_dragging.pageX0);
            var top = my_dragging.offset0.top + (e.pageY - my_dragging.pageY0);
            if(left)
            $(my_dragging.elem)
            .offset({top: top, left: left});
        }
        function handle_mouseup(e){
            $('body')
            .off('mousemove', handle_dragging)
            .off('mouseup', handle_mouseup);
        }
        $('body')
        .on('mouseup', handle_mouseup)
        .on('mousemove', handle_dragging);
    }
 }