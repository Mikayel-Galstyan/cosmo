function RemoveForm(){
    this.init = function(action,formParentId){
        str = "<form action='"+action+"' method=\"POST\" id=\"deleteForm\" onsubmit=\"Form.submit('deleteForm');return false;\" >"
        +"</form>";
        $("#"+formParentId).append(str);
        removeForm.selectedCounts = 0;
    };
    
    this.chekboxChange = function(obj){
        if($(obj).attr('checked')=='checked'){
            str = "<input type='hidden' name='ids[]' id='deleteObject_"+$(obj).attr('id')+"' value='"+$(obj).attr('id')+"'/>";
            $('#deleteForm').append(str);
            removeForm.selectedCounts++;
        }else{
            $('#deleteObject_'+$(obj).attr('id')).remove();
            removeForm.selectedCounts--;
        }
    };
    
    this.deleteFields = function(){
        if(removeForm.selectedCounts!=0){
            Form.submit('deleteForm');
        }
    };    
};