/**
* CustomForm class
* 
* Version 1.0
* 
* @author sourcio.com 
* 
*/
function CustomForm(){
		
    var btn = {save:'Save', cancel:'Cancel'};    
    /**
     * Page Response 
     *
     * Calling ajax response
     */
    this.init = function (tSave, tCancel) {
    	CustomForm.btn = {save:tSave, cancel:tCancel};    	
    };
    this.editClub = function(obj,action){
        id=$(obj).attr('id');
        id=id.replace('club_','');
        $('#editField').parent().children().show();
        $('#editField').remove();
        var str = '<form action="'+action+'" method="POST" id="editField" onsubmit="Form.submit(\'editField\');return false;" >'
        +'<input type="hidden" name="id" value="'+id+'" />'
        +'<input type="text" class="textInput w460" name="name" value="'+$(obj).text()+'"/>'
        +'<input type="button" class="green mr10 ml10" onclick="Form.submit(\'editField\');" value="'+btn.save+'">'
        +'<input type="button" class="gray mr10" onclick="$(\'#club_'+id+'\').show();$(\'#editField\').remove();" value="'+btn.cancel+'">'
        +'</form>';
        $(obj).hide();
        $(obj).parent().append(str)
    };
    this.editCourse = function(url){               
        Ajax.get(url, success);        
    };
    function success(response) {    	
    	$('#editPop').html(response);
    	$('.pop').show();
    	//Hiding mask
		Mask.hide();
    };   
};