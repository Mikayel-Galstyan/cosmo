<?php
require_once ('ControllerActionSupport.php');

class AuthController extends ControllerActionSupport {
    
    private $email = null;
    private $password = null;

    public function init() {
        parent::init();    
        $this->_helper->layout()->setLayout('login');
        $this->LOG = Zend_Registry::get('log');
    }
    
    public function indexAction() {
        $this->_forward('login');
    }
    
    public function loginAction() {
        if($this->_request->isXmlHttpRequest()) {
            $this->javascript()->redirect('auth');
        }
        $userSession = new Miqo_Session_Base();
        if ($userSession->get('authUser')) {
            return $this->_redirect('index');
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
        if($user->getCountryId()){
            $userSession->set( 'countryId', $user->getCountryId());
        }
        $this->LOG->info('Success login with Username -> "' . $user->getEmail() . '"');
        return $this->_redirect('index');
    }

    public function logoutAction() {
        Zend_Session::destroy(true);
        $this->_redirect('auth');
    }

    public function &setEmail($val) {
        $this->email = $val;
        return $this;
    }
    
    public function &setPassword($val) {
        $this->password = $val;
        return $this;
    }

}
