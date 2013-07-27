<?php
require_once ('SecureController.php');

class ObjectsController extends SecureController {
    
    private $id = null;
    private $name = null;
    private $description = null;
    private $objectTypeId = null;
    private $publisherId = null;
    private $shopListId = null;
    private $path = null;
    private $cost = null;
    private $costMin = null;
    private $costMax = null;
    
    public function indexAction() {
        $serviceType = new Service_ObjectType();
        $this->view->types = $serviceType->getAll();
		$servicePublisher = new Service_Publisher();
        $this->view->publishers = $servicePublisher->getAll();
		$serviceShops = new Service_ShopList();
        $this->view->shopList = $serviceShops->getAll();
		$service = new Service_ObjectType();
        $this->view->items = $service->getAll();
    }
    
    public function listAction() {
        $filter = new Filter_Objects();
       // $filter->setId($this->id);
        $filter->setObjectTypeId($this->objectTypeId);
        $filter->setPublisherId($this->publisherId);
        $filter->setShopListId($this->shopListId);
        $filter->setCostMin($this->costMin);
        $filter->setCostMax($this->costMax);
        $service = new Service_Objects();
        $items = $service->getByParams($filter);
        $this->view->items = $items;
    }
    
    public function editAction(){
        $id = $this->id;
        if($this->getAuthUser() && $this->getAuthUser()->getStatus()== Service_User::PUBLISHER_ROLE){
            $this->view->isPublisher = true;
            $service = new Service_ObjectType();
            $this->view->types = $service->getAll();
            $filterPublisher = new Filter_Publisher();
            $filterShop = new Filter_ShopList();
            $sevicePublisher = new Service_Publisher();
            $seviceShopList = new Service_ShopList();
            $filterPublisher->setUserId($this->getAuthUser()->getId());
            $publisher = $sevicePublisher->getByParams($filterPublisher);
            $publisherId = $publisher[0]->getId();
            $filterShop->setPublisherId($publisherId);
            
            $this->view->publisherId = $publisherId;
            $this->view->shopList = $seviceShopList->getByParams($filterShop);
            if($id){
                $service = new Service_Objects();
                $item = $service->getById($id);
                $this->view->item = $item;
            }else{
                //$this->LOG->info($this->getUserName().' : '.self::CONTROLLER_NAME.' Controller : add Action');
            }
        }else{
            $this->view->isPublisher = false;
        }
       
    }
	
	public function overviewAction(){
		$id = $this->id;
		if($id){
			$service = new Service_Objects();
			$this->view->item = $service->getById($id);
		}else{
			
		}
	}
    
    public function saveAction(){
        $this->_helper->viewRenderer->setNoRender(true);
        //$userId = $this->userId;
        $id = $this->id;
        $service = new Service_Objects();
        if ($id != null) {
            $item = $service->getById($id);
        } else {
            $item = new Domain_Objects();
        }   
        $item->setName($this->name);
        $item->setPublisherId($this->publisherId);
        $item->setCost($this->cost);
        $item->setObjectTypeId($this->objectTypeId);
		$item->setDescription($this->description);
        $item->setShopListId($this->shopListId);
        
        $path = $_FILES['path'];
        $email = $this->getAuthUser()->getEmail();
        $type = $item->getObjectTypeId();
        if(!is_dir ("users/".$email.'/'.$type)){
            mkdir("users/".$email.'/'.$type);
        }
        $userfile_extn = explode(".", strtolower($path['name']));
        do{
            $new_name = md5(rand ( -100000 , 100000 )).'.'.$userfile_extn[1];
            $fullPath = "users/".$email.'/'.$type."/".$new_name;
        }while(file_exists($fullPath));
        @rename ($path['name'],$new_name);
        move_uploaded_file ($path['tmp_name'],$fullPath);
        $item->setPath($fullPath);
        try {
            $service->save($item);
            $this->printJsonSuccessRedirect($this->translate('success.save'),'objects');
        } catch ( Miqo_Util_Exception_Validation $vex ) {
            $errors = $this->translateValidationErrors($vex->getValidationErrors());
            $this->printJsonError($errors, $this->translate('validation.error'));
        }
    }
    
    public function &setId($val) {
        $this->id = $val;
        return $this;
    }
    public function &setObjectTypeId($val) {
        $this->objectTypeId = $val;
        return $this;
    }
    public function &setPublisherId($val) {
        $this->publisherId = $val;
        return $this;
    }
    public function &setCostMin($val) {
        $this->costMin = $val;
        return $this;
    }
    public function &setCostMax($val) {
        $this->costMax = $val;
        return $this;
    }
    public function &setDescription($val) {
        $this->description = $val;
        return $this;
    }
    public function &setName($val) {
        $this->name = $val;
        return $this;
    }
    public function &setPath($val) {
        $this->path = $val;
        return $this;
    }
    public function &setCost($val) {
        $this->cost = $val;
        return $this;
    }
    
}
