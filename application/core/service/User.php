<?php

class Service_User extends Miqo_Service_Base {
    
    const USER_ROLE = 2;
    const PUBLISHER_ROLE = 1;
    const ADMIN_ROLE = 3;
    
    private $validator = null;
    private static $VALIDATION_CONFIG = array (
            'email' => array (Miqo_Validation_Base::NOT_EMPTY, Miqo_Validation_Base::EMAIL_ADDRESS, Miqo_Validation_Base::DB_NO_RECORD_EXISTS => array('table'=>Dao_DbTable_List::USERS, 'field' => 'email')),
            'password' => array (Miqo_Validation_Base::PASSWORD),
            'passwordConfirm' => array (Miqo_Validation_Base::NOT_EMPTY),
    );

    private static $VALIDATION_CONFIG_RESTRICTED = array (
            'login' => array (Miqo_Validation_Base::NOT_EMPTY, Miqo_Validation_Base::EMAIL_ADDRESS, Miqo_Validation_Base::DB_NO_RECORD_EXISTS => array('table'=>Dao_DbTable_List::USERS, 'field' => 'email')),
            'password' => array (Miqo_Validation_Base::PASSWORD),
            'passwordConfirm' => array (Miqo_Validation_Base::NOT_EMPTY),
    );

    public function __construct() {
        parent::__construct();
        $this->dao = new Dao_User();
    }

    private function encodePassword($password, $salt){
        return hash("sha512", $password.$salt);
    }

    public function isSuperAdmin($domain){
        if (self::SUPER_ADMIN_ID == $domain->getId() && $this->encodePassword(self::SUPER_ADMIN_DEFAULT_PASSWORD, $domain->getPasswordSalt()) == $domain->getPassword()){
            return true;
        }
        return false;
    }

    public function getSuperAdmin() {
        return $this->getById(self::SUPER_ADMIN_ID);
    }

    public function &authenticate($email, $password) {        
        $user = $this->dao->authenticate($email, $password);
        return $user;
    }
    
    public function &__t_save(Domain_User $domain) {
        $errors = $this->validate($domain);       
        if (sizeof($errors) == 0) {            
            $id = $domain->getId();            
            if (!$id){                
                $domain->setDate(date("Y-m-d H:i:s"));
            }
            if ($domain->getPassword() != null){
                $domain->setPassword($this->encodePassword($domain->getPassword(),$domain->getPasswordSalt()));
            }
            $domain = $this->dao->save($domain);
            if(!is_dir ("users/".$domain->getEmail())){
                mkdir("users/".$domain->getEmail());
            }
            return $domain;
        } else {
            throw new Miqo_Util_Exception_Validation($errors, "save.of.user.is.suspended.as.there.are.validation.errors");
        }
    }

    public function saveRestricted(Domain_User $domain, $key) {
        if($domain->getEmail()){
            $errors = $this->validateRestricted($domain, $key);        
            if (sizeof($errors) == 0) {             
                $id = $domain->getId();            
                if (!$id){                
                    $domain->setDate(date("Y-m-d H:i:s"));
                }                       
                if ($domain->getPassword() != null){
                    $domain->setPassword($this->encodePassword($domain->getPassword(),$domain->getPasswordSalt()));
                }
                $item = &$this->dao->save($domain);
                return $item;
            } else {
                throw new Miqo_Util_Exception_Validation($errors, "save.of.user.is.suspended.as.there.are.validation.errors");
            }
        }
    }

    public function &getAllByParams(Filter_Order $filter) {
        $domains = &$this->dao->getByParams($filter);
        return $domains;
    }
    
    public function getByAgencyId($id) {
        $domain = $this->dao->getByAgencyId($id);
        return $domain;
    }
    
    public function getByPublisherId($id) {
        $domain = $this->dao->getByPublisherId($id);
        return $domain;
    }
    
    public function validate(Domain_User $domain) {
        $validationConf = self::$VALIDATION_CONFIG;
        $id = $domain->getId();
        $password = $domain->getPassword();
        $passwordConfirm = $domain->getPasswordConfirm();
        if ($id != null){                  
            if(empty($password)){
                unset($validationConf['password']);
                unset($validationConf['passwordConfirm']);
            }
            $item = $this->getById($id);
            $email = $item->getEmail();
            if ($email ==  $domain->getEmail()){
                unset($validationConf['email'][Miqo_Validation_Base::DB_NO_RECORD_EXISTS]);                
            }            
        }            
        if ($this->validator == null) {
            $this->validator = new Miqo_Validation_Base($validationConf);
        }
        $errors = $this->validator->validate($domain);
        if(!empty($password) && !empty($passwordConfirm) && $password != $passwordConfirm){
            $errors[] = new Miqo_Validation_Info('passwordConfirm', 'validation.user.passwrod.confirm' , array('Password confirmation does not match'));
        }                        
        return $errors;
    }  

    public function validateRestricted(Domain_User $domain, $key) {
        $validationConf = self::$VALIDATION_CONFIG_RESTRICTED;
        $id = $domain->getId();
        $password = $domain->getPassword();
        $passwordConfirm = $domain->getPasswordConfirm();        
        if ($id != null){                       
            if(empty($password)){
                unset($validationConf['password']);
                unset($validationConf['passwordConfirm']);                
            } 
            $item = $this->getById($id);
            $email = $item->getEmail();
            if ($email == $domain->getEmail()){
                unset($validationConf['login'][Miqo_Validation_Base::DB_NO_RECORD_EXISTS]);
            }            
        }                     
        if ($this->validator == null) {
            $this->validator = new Miqo_Validation_Base($validationConf);
        } else {
            $this->validator->setConf($validationConf);
        }
        $errors = $this->validator->validate($domain);
        if (sizeOf($errors) > 0){
            foreach ($errors as $error){
                $fildName = $error->getFieldName().'['.$key.']';
                $error->setFieldName($fildName);                
            }
        }
        if(!empty($password) && !empty($passwordConfirm) && $password != $passwordConfirm){
            $errors[] = new Miqo_Validation_Info('passwordConfirm['. $key .']', 'validation.user.passwrod.confirm' , array('Password confirmation does not match'));
        }   
        return $errors;
    }
}
?>
