<?php

class Domain_User extends Miqo_Domain_AbstractEntity {
    /**
     *
     * @var string
     */
    protected $email = null;
    
    /**
     *
     * @var int
     */
    protected $company = null;
    
    /**
     *
     * @var int
     */
    protected $lastName = null;
    
    /**
     *
     * @var int
     */
    protected $firstName = null;
    /**
     *
     * @var int
     */
    protected $gender = null;
    
    /**
     *
     * @var date
     */
    protected $date = null;
    
    /**
     *
     * @var string
     */    
    protected $password = null;
    
    /**
     *
     * @var string
     */
    protected $passwordSalt = null;
    
    /**
     *
     * @var string
     */
    protected $passwordConfirm = null;      
            
    /**
     *
     * @var int
     */
    protected $status = null;
    
    /**
     *
     * @var int
     */
    protected $agencyId = null;
        
    /**
     *
     * @var int
     */
    protected $publisherId = null;
    
    /**
     *
     * @var int
     */
    protected $countryId = null;
    
    public function getEmail() {
        return $this->email;
    }
    public function &setEmail($val) {
        $this->email = $val;
        return $this;
    }
    
    public function getGender() {
        return $this->gender;
    }
    public function &setGender($val) {
        $this->gender = $val;
        return $this;
    }

    public function getLogin() {
        return $this->email;
    }
    public function &setLogin($val) {
        $this->email = $val;
        return $this;
    }
    
    public function getCompany() {
        return $this->company;
    }
    public function &setCompany($val) {
        $this->company = $val;
        return $this;
    }
    public function getLastName() {
        return $this->lastName;
    }
    public function &setLastName($val) {
        $this->lastName = $val;
        return $this;
    }
    public function getFirstName() {
        return $this->firstName;
    }
    public function &setFirstName($val) {
        $this->firstName = $val;
        return $this;
    }
    public function getDate() {
        return $this->date;
    }
    public function &setDate($val) {
        $this->date = $val;
        return $this;
    }
    public function getPassword() {
        return $this->password;
    }
    public function &setPassword($val) {
        $this->password = $val;
        return $this;
    }
    public function getPasswordConfirm() {
        return $this->passwordConfirm;
    }
    public function &setPasswordConfirm($val) {
        $this->passwordConfirm = $val;
        return $this;
    }
    public function getPasswordSalt() {
        return $this->passwordSalt;
    }
    public function &setPasswordSalt($val) {
        $this->passwordSalt = $val;
        return $this;
    }      
    public function getStatus() {
        return $this->status;
    }
    public function &setStatus($val) {
        $this->status = $val;
        return $this;
    }
    public function getAgencyId() {
        return $this->agencyId;
    }
    public function &setAgencyId($val) {
        $this->agencyId = $val;
        return $this;
    }
    public function getPublisherId() {
        return $this->publisherId;
    }
    public function &setPublisherId($val) {
        $this->publisherId = $val;
        return $this;
    }
    public function getCountryId() {
        return $this->countryId;
    }
    public function &setCountryId($val) {
        $this->countryId = $val;
        return $this;
    }
}
?>