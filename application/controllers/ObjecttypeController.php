<?php
require_once ('SecureController.php');

class ObjectTypeController extends SecureController {
    private $id = null;
    private $name = null;
    public function indexAction() {
     
    }
    
    public function listAction() {
        /*$service = new Service_Objects();
        $this->view->items = $service->getAll();*/
    }
    
    public function editAction(){
		if($this->getAuthUser() && $this->getAuthUser()->getStatus()== Service_User::PUBLISHER_ROLE){
			if($this->id){
				$service = new Service_ObjectType();
				$this->view->item = $service->getById($this->id);
			}else{
				$this->view->item = null;
			}
			$this->view->isPublisher = true;
		}else{
            $this->view->isPublisher = false;
        }
    }
    
    
    public function saveAction(){
        $this->_helper->viewRenderer->setNoRender(true);
        $id = $this->id;
        $service = new Service_ObjectType();
        if ($id != null) {
            $item = $service->getById($id);
        } else {
            $item = new Domain_ObjectType();
        }
        $item->setName($this->name);
        try {
            $service->save($item);
            $this->printJsonSuccessRedirect($this->translate('success.save'),'objecttype');
        } catch ( Miqo_Util_Exception_Validation $vex ) {
            $errors = $this->translateValidationErrors($vex->getValidationErrors());
            $this->printJsonError($errors, $this->translate('validation.error'));
        }
    }
    
    public function setName($val){
        $this->name = $val;
    }
    
    public function setId($val){
        $this->id = $val;
    }
    
}
