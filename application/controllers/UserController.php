<?php
require_once ('SecureController.php');

class UserController extends SecureController {
    
    const CONTROLLER_NAME = 'user';
    const DEFAULT_ORDER = 'id';
    const DEFAULT_SORT = 'ASC';

    private $id = null;
    private $email = null;
    private $company = null;
    private $lastName = null;
    private $firstName = null;
    private $password = null;
    private $passwordConfirm = null;
    private $status = null;
    private $gender = null;
    private $order = self::DEFAULT_ORDER;
    private $sort = self::DEFAULT_SORT;

    public function indexAction() {
    }

    public function listAction() {
        $filter = new Filter_User();
        $filter->setId(Service_User::ADMIN_ROLE);
        $filter->setOrder($this->order);
        $filter->setSort($this->sort);
        $filter->setCountryId($this->getCountryId());
        if ($this->status) {
            $filter->setStatusId($this->status);
        }else{ 
            $filter->setStatusIds($this->getUserDenyRoles());
        }
        $service = new Service_User();
        $this->view->items = $service->getAllByParams($filter);
    }

    public function editAction() {
        //$countryService = new Service_Country();
        //$this->view->countryList = $countryService->getAll();
        $id = $this->id;
        if ($id) {
            $service = new Service_User();
            $user = $service->getById($id);
            $this->view->item = $user;
        } else {
            //$this->LOG->info($this->getUserName().' : '.self::CONTROLLER_NAME.' Controller : add Action');
        }
    }

    public function publishereditAction(){
        
    }
    public function savepublisherAction(){
        $this->setNoRender();
        $authUser = $this->getAuthUser();
        $id = $authUser->getId();
        $service = new Service_User();
        $item = $service->getById($id);
       
        if ($this->password) {
        	$item->setPassword($this->password);
        	$item->setPasswordConfirm($this->passwordConfirm);
        	$item->setPasswordSalt(ControllerActionSupport::getUniqueString());
        	try {
        		$service->save($item);
        		$this->printJsonSuccess($this->translate('success.save'));
        	} catch ( Miqo_Util_Exception_Validation $vex ) {
        		 $errors = $this->translateValidationErrors($vex->getValidationErrors());
            	 $this->printJsonError($errors, $this->translate('validation.error'));
        	}
        } else {
        	$item->setPassword(null);
        	$item->setPasswordConfirm(null);
        	$errors = array("password"=>"Value is required and can't be empty");
        	$item->setPasswordSalt(ControllerActionSupport::getUniqueString());
        	$this->printJsonError($errors, $this->translate('validation.error'));
        }
        
       
    }


    public function deleteAction() {
        $this->disableLayout();
        $this->setNoRender();
        $id = $this->id;
        $service = new Service_User();
        try {
            $service->delete($id);
            $this->printJsonSuccess($this->translate('success.delete'));
        } catch ( Miqo_Util_Exception_Base $ex ) {
            $this->printJsonFail($this->translate('cant.delete.record'));
        }
    }

    public function confirmAction() {
        $this->view->id = $this->id;
    }

    public function saveAction() {
        $this->_helper->viewRenderer->setNoRender(true);
        $id = $this->id;
        $service = new Service_User();
        if ($id != null) {
            $item = $service->getById($id);
        } else {
            $item = new Domain_User();
        }
        $item->setEmail($this->email);
        $item->setStatus($this->status);
        $item->setFirstName($this->firstName);
        $item->setLastName($this->lastName);
        //$item->setCompany($this->company);
        //$item->setCountryId($this->userSession->get('countryId'));
        if ($this->password) {
            $item->setPassword($this->password);
            $item->setPasswordConfirm($this->passwordConfirm);
            $item->setPasswordSalt(ControllerActionSupport::getUniqueString());
        } else {
            $item->setPassword(null);
            $item->setPasswordConfirm(null);
        }
        try {
            $service->save($item);
            $userSession = $this->getAuthUser();
            if (!$userSession) {
                $userSession = new Miqo_Session_Base();
                $userSession->set('authUser', $item); 
            }
            $urlId = ($this->id)?'/'.$this->id:'';
            $this->printJsonSuccessRedirect($this->translate('success.save'),($this->status==1)?'publisher'.$urlId .'/edit':'index');
        } catch ( Miqo_Util_Exception_Validation $vex ) {
            $errors = $this->translateValidationErrors($vex->getValidationErrors());
            $this->printJsonError($errors, $this->translate('validation.error'));
        }
    }

    public function &setId($val) {
        $this->id = $val;
        return $this;
    }
    public function &setEmail($val) {
        $this->email = $val;
        return $this;
    }
    public function &setStatus($val) {
    	$this->status = $val;
    	return $this;
    }
    public function &setCompany($val) {
        $this->company = $val;
        return $this;
    }
    public function &setLastName($val) {
        $this->lastName = $val;
        return $this;
    }
    public function &setFirstName($val) {
        $this->firstName = $val;
        return $this;
    }
    public function &setPassword($val) {
        $this->password = $val;
        return $this;
    }
    public function &setPasswordConfirm($val) {
        $this->passwordConfirm = $val;
        return $this;
    }
    public function &setPublisherId($val) {
        $this->publisherId = $val;
        return $this;
    }
    public function &setOrder($val) {
        $this->order = $val;
        return $this;
    }
    public function &setSort($val) {
        $this->sort = $val;
        return $this;
    }
    public function &setGender($val) {
        $this->gender = $val;
        return $this;
    }
}