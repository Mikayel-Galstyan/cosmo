<?php
require_once ('SecureController.php');
class CssminController extends SecureController {

    public function indexAction() {
        $this->disableLayout();
        $this->setNoRender();
        $css = array(
                'css/style.css',
                'css/button.css',
                'css/confirm.css',
                'css/const.css',
                'css/custom.form.element.css',                                
                'css/datepicker.css',
                'css/icon.css',
                'css/notifications.css',
                'css/pagination.css',                
                'css/reset.css',
                'css/table.css',
                'css/nanoscroller.css',
        );
        $fp = fopen('css/style.min.css', 'w');
        fwrite($fp, '');
        fclose($fp);
        $content="";
        // Loop the css Array
        foreach ($css as $css_file) {
        
            // Load the content of the css file 
            $css_content = file_get_contents($css_file);
            $css_content = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css_content);
            // remove tabs, spaces, new lines
            $css_content = str_replace(array("
                    ", "\r", "\n", "\t", '  ', '    ', '    '), '', $css_content);
            $css_content = str_replace('{ ', '{', $css_content);
            $css_content = str_replace(' }', '}', $css_content);
            $css_content = str_replace('; ', ';', $css_content);
            $css_content = str_replace(', ', ',', $css_content);
            $css_content = str_replace(' {', '{', $css_content);
            $css_content = str_replace('} ', '}', $css_content);
            $css_content = str_replace(': ', ':', $css_content);
            $css_content = str_replace(' ,', ',', $css_content);
            $css_content = str_replace(' ;', ';', $css_content);
            
            
            $content .=$css_content;
            
        }
        echo $content;
         $fp = fopen('css/style.min.css', 'w');
        fwrite($fp, $content);
        fclose($fp); 
    }
    
}