<?php
abstract class ControllerActionSupport extends Zend_Controller_Action {
    protected static $ALLOWED_IMAGES_TYPES = array('image/gif','image/x-png','image/x-citrix-png','image/pjpeg','image/x-citrix-jpeg', 'image/jpeg', 'image/png');
    public static $ALLOWED_IMAGES_SIZES = array('240x320', '320x480', '480x800', '600x1024', '720x1280', '800x1280', '640x960', '640x1136');
    protected $dateFormat;
    protected $LOG = null;
    const DEFAULT_ORDER = 'id';
    const DEFAULT_SORT = 'ASC';
    const DEFAULT_PAGE = 1;
    const DEFAULT_LIMIT = 20;
    
    public function init() {
    	$this->LOG = Zend_Registry::get('log');
    }
    
    public function preDispatch() {        
        // load request parameters
        $this->loadRequestParams();
    }
    public function postDispatch() {
        // make view aware of info
        $view = $this->view;
    }
    protected function loadRequestParams() {
        $methods = get_class_methods($this);
        $requestParams = $this->getRequest()->getParams();
        foreach ($requestParams as $key => $value) {
            $method = 'set' . ucfirst($key);
            if(in_array($method, $methods)) {
                $value = (is_string($value)) ? trim($value) : $value;
                $this->$method($value);
            }
        }
    }    
    protected function setNoRender() {
        $this->_helper->viewRenderer->setNoRender(true);
    }
    protected function disableLayout() {
        $this->_helper->layout->disableLayout(); 
    }
    protected function translate($key) {
        return $this->view->translate($key);
    }
    protected function basePath() {
        return $this->view->basePath();
    }
    protected function baseUrl() {
        return $this->view->baseUrl();
    }
    protected function htmlEscape($value) {
        return $this->view->htmlEscape($value);
    }
    protected function formatDateOutput($value) {
        return $this->view->formatDateOutput($value);
    }
    protected function javascript() {
        $jsHelper = $this->view->getHelper('Js');
        return $jsHelper;
    }
    protected function setPageTitle($key) {
        $this->javascript()->setPageTitle($key);        
    }
    protected function error404() {
        throw new Zend_Controller_Router_Exception('This page does not exist', 404);
    }
    protected function isXmlHttpRequest(){
       if($this->getRequest()->isXmlHttpRequest()) {
            return true;    
       }
       $conentType = $this->getRequest()->getHeader('Content-Type');
       if($conentType){
           if (strpos($conentType,'multipart/form-data') !== false) {
               return true; 
           }
       }       
       return false;   
    }
    protected function ensureAjaxCall(){
        if($this->isXmlHttpRequest()) {
            $this->disableLayout();          
        } 
    }
    public static function getUniqueString() {
        return md5(uniqid(rand(), true));
    }
    protected function coursePath() {
        return Zend_Registry::get('configuration')->upload->course;
    }
    protected function uploadPath() {
        return Zend_Registry::get('configuration')->upload->path;
    }
    protected function deleteFile($filePath) {
        if (file_exists($filePath)) {
            // yes the file does exist
            if (@unlink($filePath) === true) {
                // the file successfully removed
                return true;
            } else {
                // something is wrong, we may not have enough permission
                // to delete this file
                return false;
            }
        } else {
            // the file is not found, do something about it???
            return false;
        }
    } 
    protected function checkUplaodFileSize() {        
        if (isset($_SERVER["CONTENT_LENGTH"]) || isset($_SERVER['HTTP_CONTENT_LENGTH'])){
            if(isset($_SERVER['HTTP_CONTENT_LENGTH']))
                $serverLength = (int)$_SERVER["HTTP_CONTENT_LENGTH"];
            else
                $serverLength = (int)$_SERVER["CONTENT_LENGTH"];
        } else {
            throw new Exception('Getting content length is not supported.');
        }
        $postSize = ini_get('post_max_size');
        $postLimit = (int)$postSize  * 1024 * 1024;
        $uploadSize = ini_get('upload_max_filesize');
        $uploadLimit = (int)$uploadSize * 1024 * 1024;
        if ($serverLength >=  $postLimit  || $serverLength >=  $uploadLimit){
            $this->printJsonFail($this->translate('upload.file.size.should.less.then.post.max.size.and.file.upload.max.size').'('.$this->translate('post.max.size'). ' ' .$postSize.', ' . $this->translate('file.upload.max.size'). ' ' . $uploadSize.')');
            die();
        }        
    }
    
    protected function getCount($countsGroupByServer){
    	 $count=0;
    	 foreach($countsGroupByServer as $item){
    	 	$count += $item->getCount();
    	 }
    	 return $count;
    }
    
    protected function uploadImage($attrName = 'image', $destPath = 'uploads'){
        if (isset($_FILES[$attrName])) {
            $file = $_FILES[$attrName];            
            if ($file['size'] > 0) {                            
                require_once APPLICATION_PATH . '../../library/Miqo/Util/Upload.php';                                        
                $fileType = $file['type']; //returns the mimetype
                $this->LOG->info($fileType);
                if(!in_array($fileType, self::$ALLOWED_IMAGES_TYPES)) {
                    throw new TF_Util_Exception_Upload('Files are not allowed.');            
                }        
                $uploadClass = new upload($file);
                $uniqueName = self::getUniqueString();
                if ($uploadClass->uploaded) {
                    $uploadClass->file_new_name_body = $uniqueName;                        
                    $uploadClass->Process($destPath);
                    $name = $uploadClass->file_dst_name;
                    if ($uploadClass->processed) {
                        $uploadClass->Clean();
                    } else {
                        echo 'error : ' . $uploadClass->error;
                    }
                }                
                return $name;
            }
        }    
    }
/**
     *
     * @param array $json
     */
    protected function printJson($json = array()) {
        if (sizeof($json) > 0) {
            echo Zend_Json::encode($json);
        }
    }
    /**
     * 
     * @param array $json
     */
     protected function printJsonSuccessRedirect($message = null, $url) {
        if ($message != null) {
            echo Zend_Json::encode(array('status' => 'success', 'msg' => $message, 'url' => $url));
        }
    }
    /**
     *
     * @param array $json
     */
    protected function printJsonFailRedirect($message = null, $url) {
        if ($message != null) {
            echo Zend_Json::encode(array('status' => 'fail', 'msg' => $message, 'url' => $url));
        }
    }
    /**
     *
     * @param string $message
     */
    protected function printJsonInfo($message = null) {
        if ($message != null) {
            echo Zend_Json::encode(array('status' => 'info', 'msg' => $message));
        }
    }
    /**
     *
     * @param string $message
     */
    protected function printJsonSuccess($message = null) {
        if ($message != null) {
            echo Zend_Json::encode(array('status' => 'success', 'msg' => $message));
        }
    }
    /**
     *
     * @param string $message
     */
    protected function printJsonFail($message = null) {
        if ($message != null) {
            echo Zend_Json::encode(array('status' => 'fail', 'msg' => $message));
        }
    }
    /**
     *
     * @param array $errors
     * @param string $message
     */
    protected function printJsonError($errors = null, $message = '') {
        if ($errors != null) {
            echo Zend_Json::encode(array('status' => 'error', 'errors' => $errors, 'msg' => $message));
        }
    }

    /**
     * undocumented function
     *
     * @return void
     **/
    protected function printError ($message = null) {
        echo 
            '<script type="text/javascript">
                parent.Notify.error ("' . $this->translate($message) . '", true);
            </script>';
    }

        /**
     * undocumented function
     *
     * @return void
     **/
    protected function printInfo ($message = null) {
        $this->setHTMLContentType();
        
        echo 
            '<script type="text/javascript">
                parent.Notify.info ("' . $this->translate($message) . '", true);
            </script>';
    }

    protected function setHTMLContentType ()
    {
        header ('Content-Type', 'text/html; charset=UTF-8');
    }
    protected function setJSONContentType () {
        header ('Content-Type: application/json; charset=UTF-8');
    }

    protected function translateValidationErrors($errors) {
        $translatedArray = array ();
        foreach ( $errors as $error ) {
            if ($error->getKey() != null) {
                $key = $error->getKey();
                $translation = $this->translate($key);
                if ($translation != $key) {
                    $translatedArray [$error->getFieldName()] = $translation;
                    continue;
                }
            }
            if ($error->getMessage() != null) {
                $errMessage = "";
                foreach ( $error->getMessage() as $message ) {
                    $errMessage .= $message . ' ';
                }
                $translatedArray [$error->getFieldName()] = $this->htmlEscape($errMessage);
            }
        }
        return $translatedArray;
    }
    protected function parseToDate($dateStr) {
        if (!isset($this->dateFormat)) {
            $dateFormattingHelper = $this->view->getHelper('FormatDateInput');
            $this->dateFormat = $dateFormattingHelper::FORMAT;
        }
        return ($dateStr) ? new Miqo_Util_Date($dateStr, $this->dateFormat) : '';
    }

    
    /**
     * Generates a unique filename
     *
     * @param $name string
     * @param $ext string
     *
     * @return string
     **/
    protected function generateFileName ($name, $ext) {
        return  $name . '_' . date('Y_m_d_H_i_s') . '.' . $ext;
    }
}
