
<?php

class Zend_View_Helper_JsRedirect extends Zend_View_Helper_Abstract {

    public $view;

    public function setView(Zend_View_Interface $view) {
        $this->view = $view;
    }

    function jsRedirect($url) {
        $script = <<<EOD
        <script>
            window.location = '$url'        
        </script>
EOD;
        echo $script;
    }
}

?>
