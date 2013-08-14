<?php
require_once('SecureController.php');

class IndexController extends SecureController{

   public function  indexAction() {
        if(!$this->getUserName()){
            $this->_redirect('objecttype');
        }else if($this->getAuthUser()->getStatus()==1){
            if($this->getPublisher()){
                $this->_redirect('objects');
            }else{
                $this->_redirect('publisher/add');
            }
        }else if($this->getAuthUser()->getStatus()==2){
            $this->_redirect('objecttype');
        }
   }       
}