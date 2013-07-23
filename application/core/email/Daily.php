<?php
class Email_Daily extends Miqo_Email_Base  {   
    
    const TEMPLATE = "daily_import_fail.phtml";         
    
    /**
     * Send Email
     *
     * @access public      
     * @param  array $emailList (array of domains) 
     */            
    public function send(){
        $this->setTemplate(self::TEMPLATE);
        $this->setSubject('Daily import Failed.');                
        parent::send();
    }      
}
?>