<?php
require_once('SecureController.php');
require_once (APPLICATION_PATH.'/../library/Miqo/Util/JSMin.php');
class JsminController extends SecureController {

    public function preDispatch(){    
        $this->_helper->layout()->disableLayout();    
        $this->setNoRender();
    }
    
    public function indexAction() {
       echo '<script type="text/javascript">'; 
       if (APPLICATION_ENV=="development"){            
            echo file_get_contents(APPLICATION_PATH.'/layouts/scripts/js/classes/Menu.js');
            echo file_get_contents(APPLICATION_PATH.'/layouts/scripts/js/classes/Page.js');
            echo file_get_contents(APPLICATION_PATH.'/layouts/scripts/js/classes/Form.js');
            echo file_get_contents(APPLICATION_PATH.'/layouts/scripts/js/classes/Filter.js');
            echo file_get_contents(APPLICATION_PATH.'/layouts/scripts/js/classes/Ajax.js');
            echo file_get_contents(APPLICATION_PATH.'/layouts/scripts/js/classes/Url.js');
            echo file_get_contents(APPLICATION_PATH.'/layouts/scripts/js/classes/Util.js');
            echo file_get_contents(APPLICATION_PATH.'/layouts/scripts/js/classes/Coordinates.js');
            echo file_get_contents(APPLICATION_PATH.'/layouts/scripts/js/classes/MapMenu.js');
            echo file_get_contents(APPLICATION_PATH.'/layouts/scripts/js/classes/Polygon.js');
            echo file_get_contents(APPLICATION_PATH.'/layouts/scripts/js/classes/StaticMap.js');
            echo file_get_contents(APPLICATION_PATH.'/layouts/scripts/js/classes/Grid.js');
            echo file_get_contents(APPLICATION_PATH.'/layouts/scripts/js/classes/CustomForm.js');
            echo file_get_contents(APPLICATION_PATH.'/layouts/scripts/js/classes/RemoveForm.js');
            echo file_get_contents(APPLICATION_PATH.'/layouts/scripts/js/classes/PolygonMenu.js');
            echo file_get_contents(APPLICATION_PATH.'/layouts/scripts/js/classes/design/Popup.js');
            echo file_get_contents(APPLICATION_PATH.'/layouts/scripts/js/classes/design/Mask.js');
            echo file_get_contents(APPLICATION_PATH.'/layouts/scripts/js/classes/design/Notify.js');
            echo file_get_contents(APPLICATION_PATH.'/layouts/scripts/js/classes/design/Validator.js');
            echo file_get_contents(APPLICATION_PATH.'/layouts/scripts/js/classes/design/Slider.js');
            echo file_get_contents(APPLICATION_PATH.'/layouts/scripts/js/Init.js');            
         }else{                        
            echo TF_Util_JSMin::minify(APPLICATION_PATH.'/layouts/scripts/js/classes/Menu.js');
            echo TF_Util_JSMin::minify(APPLICATION_PATH.'/layouts/scripts/js/classes/Page.js');
            echo TF_Util_JSMin::minify(APPLICATION_PATH.'/layouts/scripts/js/classes/Form.js');
            echo TF_Util_JSMin::minify(APPLICATION_PATH.'/layouts/scripts/js/classes/Filter.js');
            echo TF_Util_JSMin::minify(APPLICATION_PATH.'/layouts/scripts/js/classes/Ajax.js');
            echo TF_Util_JSMin::minify(APPLICATION_PATH.'/layouts/scripts/js/classes/Url.js');
            echo TF_Util_JSMin::minify(APPLICATION_PATH.'/layouts/scripts/js/classes/Util.js');
            echo TF_Util_JSMin::minify(APPLICATION_PATH.'/layouts/scripts/js/classes/Coordinates.js');
            echo TF_Util_JSMin::minify(APPLICATION_PATH.'/layouts/scripts/js/classes/MapMenu.js');
            echo TF_Util_JSMin::minify(APPLICATION_PATH.'/layouts/scripts/js/classes/Polygon.js');
            echo TF_Util_JSMin::minify(APPLICATION_PATH.'/layouts/scripts/js/classes/StaticMap.js');
            echo TF_Util_JSMin::minify(APPLICATION_PATH.'/layouts/scripts/js/classes/Grid.js');
            echo TF_Util_JSMin::minify(APPLICATION_PATH.'/layouts/scripts/js/classes/CustomForm.js');
            echo TF_Util_JSMin::minify(APPLICATION_PATH.'/layouts/scripts/js/classes/RemoveForm.js');
            echo TF_Util_JSMin::minify(APPLICATION_PATH.'/layouts/scripts/js/classes/PolygonMenu.js');
            echo TF_Util_JSMin::minify(APPLICATION_PATH.'/layouts/scripts/js/classes/design/Popup.js');
            echo TF_Util_JSMin::minify(APPLICATION_PATH.'/layouts/scripts/js/classes/design/Mask.js');
            echo TF_Util_JSMin::minify(APPLICATION_PATH.'/layouts/scripts/js/classes/design/Notify.js');
            echo TF_Util_JSMin::minify(APPLICATION_PATH.'/layouts/scripts/js/classes/design/Validator.js');
            echo TF_Util_JSMin::minify(APPLICATION_PATH.'/layouts/scripts/js/classes/design/Slider.js');
            echo TF_Util_JSMin::minify(APPLICATION_PATH.'/layouts/scripts/js/Init.js');
        }
        echo '</script>';
    }          
}