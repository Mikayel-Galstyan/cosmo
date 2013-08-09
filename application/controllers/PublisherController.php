<?php
require_once ('SecureController.php');

class PublisherController extends SecureController {
    
    private $id = null;
    private $name = null;
    private $address = null;
    private $phone = null;
    private $site = null;
    private $clicks = null;
    private $userId = null;
    private $order = null;
	private $status = null;

    public function indexAction() {
        if (!isset($userSession)) {
            $userSession = new Miqo_Session_Base();
        }
    }
    
    public function listAction() {
        $servie=new Service_Publisher();
		$filter = new Filter_Publisher();
		$items = $servie->getByParams($filter);
		$this->view->items = $items; 
    }
    
    public function editAction(){
        $id = $this->id;
        $user = $this->getAuthUser();
        if($this->getAuthUser() && $this->getAuthUser()->getStatus()== Service_User::PUBLISHER_ROLE){
            $this->view->isPublisher = true;
            if($id){
                $service = new Service_Publisher();
                $publisher = $service->getById($id);
                $this->view->item = $publisher;
            }else{
                //$this->LOG->info($this->getUserName().' : '.self::CONTROLLER_NAME.' Controller : add Action');
            }
        }else{
            $this->view->isPublisher = false;
        }
       
    }
    
    public function saveAction(){
        $this->_helper->viewRenderer->setNoRender(true);
        $userId = $this->userId;
        $id = $this->id;
        $service = new Service_Publisher();
        if ($id != null) {
            $item = $service->getById($id);
        } else {
            $item = new Domain_Publisher();
            $item->setOrder(1);
        }
        $item->setName($this->name);
        $item->setUserId($this->getAuthUser()->getId());
        $item->setAddress($this->address);
        $item->setPhone($this->phone);
        $item->setSite($this->site);
        try {
            $service->save($item);
            if (!isset($userSession)) {
                $userSession = new Miqo_Session_Base();
            }
            $userSession->set('publisher', $item);
            $this->printJsonSuccessRedirect($this->translate('success.save'),'objects');
        } catch ( Miqo_Util_Exception_Validation $vex ) {
            $errors = $this->translateValidationErrors($vex->getValidationErrors());
            $this->printJsonError($errors, $this->translate('validation.error'));
        }
    }
    
	public function overviewAction(){
		$id = $this->id;
		if($id){
			$service = new Service_Publisher();
			$this->view->item = $service->getById($id);
		}else{
			
		}
	}
	
    public function &setId($val) {
        $this->id = $val;
        return $this;
    }
    public function &setUserId($val) {
        $this->userId = $val;
        return $this;
    }
    public function &setAddress($val) {
        $this->address = $val;
        return $this;
    }
    public function &setPhone($val) {
        $this->phone = $val;
        return $this;
    }
    public function &setSite($val) {
        $this->site = $val;
        return $this;
    }
    public function &setClicks($val) {
        $this->clicks = $val;
        return $this;
    }
    public function &setName($val) {
        $this->name = $val;
        return $this;
    }
    public function &setOrder($val) {
        $this->order = $val;
        return $this;
    }
	public function &setStatus($val) {
        $this->order = $val;
        return $this;
    }
    
}
