<?php
require_once ('SecureController.php');

class AuthController extends SecureController {
    
    private $email = null;
    private $password = null;
    private $id = null;

    public function init() {
        parent::init();    
        $this->_helper->layout()->setLayout('layout');
        $this->LOG = Zend_Registry::get('log');
    }
    
    public function indexAction() {
        $this->_forward('login');
    }
    
	public function isloginAction(){
		$background = 'background: rgb(242,249,254); /* Old browsers */
        background: -moz-linear-gradient(top,  rgba(242,249,254,1) 0%, rgba(214,240,253,1) 100%); /* FF3.6+ */
        background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(242,249,254,1)), color-stop(100%,rgba(214,240,253,1))); /* Chrome,Safari4+ */
        background: -webkit-linear-gradient(top,  rgba(242,249,254,1) 0%,rgba(214,240,253,1) 100%); /* Chrome10+,Safari5.1+ */
        background: -o-linear-gradient(top,  rgba(242,249,254,1) 0%,rgba(214,240,253,1) 100%); /* Opera 11.10+ */
        background: -ms-linear-gradient(top,  rgba(242,249,254,1) 0%,rgba(214,240,253,1) 100%); /* IE10+ */
        background: linear-gradient(to bottom,  rgba(242,249,254,1) 0%,rgba(214,240,253,1) 100%); /* W3C */
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr="#f2f9fe", endColorstr="#d6f0fd",GradientType=0 ); /* IE6-9 */
        ';
		if (!isset($userSession)) {
            $userSession = new Miqo_Session_Base();
        }
        $user = $userSession->get('authUser');
		if($user){
			$background = $user->getBackground();
		}
		$this->view->background = $background;
	}
	
    public function loginAction() {
        if($this->_request->isXmlHttpRequest()) {
            //$this->javascript()->redirect('index');
        }
        if($this->id){
            
        }
        $userSession = new Miqo_Session_Base();
        if ($userSession->get('authUser')) {
            $this->view->name = $userSession->get('authUser')->getFirstName();
            $this->view->img = $userSession->get('authUser')->getPath();
        }else{
            
        }
        $request = $this->getRequest();        
        if ($request->isPost()) {
            $email = $this->email;
            $password = $this->password;
            if (! empty($email) && ! empty($password)) {
                $userService = new Service_User();
                $user = $userService->authenticate($email, $password);              
                if ($user != null) {                    
                    $this->loginSuccess($user, $userSession);
                }
            }            
            $this->view->loginfailed = true;
            $this->LOG->info('Failed login with Username  "' . $email . '"');
        }
    }

    private function loginSuccess($user, $userSession = null) {
        if (!$userSession) {
            $userSession = new Miqo_Session_Base();
        }
        $userSession->set('authUser', $user);
        if($user->getStatus()==1){
            $publisherService = new Service_Publisher();
            $filter = new Filter_Publisher();
            $filter->setUserId($user->getId());    
            $publisher = $publisherService->getByUserId($filter);
            if($publisher){
                $userSession->set('publisher', $publisher);
            }else{
                
            }
        }
        if($user->getCountryId()){
            $userSession->set( 'countryId', $user->getCountryId());
        }
        $this->LOG->info('Success login with Username -> "' . $user->getEmail() . '"');
        $this->javascript()->redirect('index');
    }

    public function logoutAction() {
        @Zend_Session::destroy(true);
        $this->javascript()->redirect('index');
    }

    public function &setEmail($val) {
        $this->email = $val;
        return $this;
    }
    
    public function &setPassword($val) {
        $this->password = $val;
        return $this;
    }
    
    public function &setId($val) {
        $this->id = $val;
        return $this;
    }

}
