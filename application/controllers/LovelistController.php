<?php
require_once ('SecureController.php');

class LovelistController extends SecureController {
    
    private $id = null;
	private $ids = null;
    

    public function indexAction() {
        
    }
    
    public function listAction() {
        $this->view->isAuth = false;
        if($this->getAuthUser()){
            $service = new Service_LoveList();
            $items = $service->getByUserId($this->getAuthUser()->getId());
            $this->view->items = $items;
            $this->view->isAuth = true;
        }
    }
	
    public function deleteAction() {
        $this->setNoRender();
        if(!is_null($this->ids)){
            $service = new Service_LoveList();
            try{
                $service->__t_deleteList($this->ids);
                $this->printJsonSuccessRedirect($this->translate('success.delete'),'lovelist');
            } catch ( TF_Util_Exception_Service $ex ) {
                $this->printJsonFailRedirect($this->translate('cant.delete.record'),'lovelist');
            }
        }    
    }
	
    public function editAction(){
        $id = $this->id;
        $user = $this->getAuthUser();
        if($this->getAuthUser() && $this->getAuthUser()->getStatus()== Service_User::PUBLISHER_ROLE){
            $this->view->isPublisher = true;
            if($id){
                $service = new Service_ShopList();
                $shop = $service->getById($id);
                $this->view->item = $shop;
            }else{
                //$this->LOG->info($this->getUserName().' : '.self::CONTROLLER_NAME.' Controller : add Action');
            }
        }else{
            $this->view->isPublisher = false;
        }
       
    }
    
    public function saveAction(){
        $this->_helper->viewRenderer->setNoRender(true);
        $userId = $this->getAuthUser()->getId();
        $service = new Service_LoveList();
		$mainCollumn = ($this->objectsIds)?$this->objectsIds:$this->publisherIds;
		try {
			for($i=0;$i<count($mainCollumn); $i++){
				$item = new Domain_LoveList();
				if(!$this->objectsIds){
					$item->setPublisherId($mainCollumn[$i]);
				}else{
					$item->setObjectId($mainCollumn[$i]);
				}
				$item->setUserId($userId);
				$service->save($item);
				
			}
			$this->printJsonSuccessRedirect($this->translate('success.save'),'objects');
		} catch ( Miqo_Util_Exception_Validation $vex ) {
			$errors = $this->translateValidationErrors($vex->getValidationErrors());
			$this->printJsonError($errors, $this->translate('validation.error'));
		}
    }
    
	public function overviewAction(){
		$id = $this->id;
		if($id){
			$service = new Service_ShopList();
			$this->view->item = $service->getById($id);
		}else{
			
		}
	}
	
    public function &setObjectsIds($val) {
        $this->objectsIds = $val;
        return $this;
    }
    public function &setObjectsId($val) {
        $this->objectsId = $val;
        return $this;
    }
	public function &setIds($val) {
        $this->ids = $val;
        return $this;
    }
	
	 public function &setPublisherIds($val) {
        $this->publisherIds = $val;
        return $this;
    }
    public function &setPublisherId($val) {
        $this->publisherId = $val;
        return $this;
    }
	public function &setId($val) {
        $this->id = $val;
        return $this;
    }
    
}
