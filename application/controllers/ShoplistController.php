<?php
require_once ('SecureController.php');

class ShoplistController extends SecureController {
    
    private $id = null;
    private $name = null;
    private $address = null;
    private $phone = null;
    private $description = null;
    private $publisherId = null;
    private $order = null;

    public function indexAction() {
        $publisherService = new Service_Publisher();
		$items = $publisherService->getAll();
		$this->view->items = $items;
        if($this->getAuthUser() && $this->getAuthUser()->getStatus()== Service_User::PUBLISHER_ROLE){
            $this->view->isPublisher = true;
        }else{
            $this->view->isPublisher = false;
        }
    }
    
    public function listAction() {
        $servie=new Service_ShopList();
		$filter = new Filter_ShopList();
		$filter->setPublisherId($this->publisherId);
		$items = $servie->getByParams($filter);
		$this->view->items = $items; 
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
        /*$userId = $this->userId;*/
        $id = $this->id;
        $service = new Service_ShopList();
        if ($id != null) {
            $item = $service->getById($id);
        } else {
            $item = new Domain_ShopList();
           // $item->setOrder(1);
        }
		$sevicePublisher = new Service_Publisher();
		$filterPublisher = new Filter_Publisher();
		$filterPublisher->setUserId($this->getAuthUser()->getId());
		$publisher = $sevicePublisher->getByParams($filterPublisher);
        $publisherId = $publisher[0]->getId();
        $item->setName($this->name);
        $item->setPublisherId($publisherId);
        $item->setAddress($this->address);
        $item->setPhone($this->phone);
        $item->setDescription($this->description);
        try {
            $service->save($item);
            $this->printJsonSuccessRedirect($this->translate('success.save'),'objecttype');
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
	
    public function &setId($val) {
        $this->id = $val;
        return $this;
    }
    public function &setDescription($val) {
        $this->description = $val;
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
    public function &setPublisherId($val) {
        $this->publisherId = $val;
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
    
}
