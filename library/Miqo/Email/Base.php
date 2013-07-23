<?php
/**
 * @package library_TF_email
 */

/**
 * The base class to send emails.
 *
 * @package library_TF_email
 */
class Miqo_Email_Base {
    /**
     * @var array
     */
    private $list    = array();
    /**
     * @var string
     */
    private $templatePath = '/core/email/template';    
    /**
     * @var string
     */
    private $template     = 'default.phtml';
    /**
     * @var string
     */
    private $content      = '';
    /**
     * @var string
     */
    private $subject      = 'no-replay';
    /**
     * @var string
     */
    private $css          = 'default.css';
    /**
     * @var string
     */
    private $charset      = 'UTF-8';
    
    /**
     * The class constructor.
     * 
     * Initialises configs for emails.
     *
     * @param array $tempConfArray  E.g. array('encoding'=>'ASCI', 'Language'=>'en')      
     */
    public function __construct(Array $tempConfArray = array()) {        
        foreach ($tempConfArray as $methodName => $value){
            $method = 'set' . ucfirst($methodName) . 'Template';
            if (method_exists($this, $method)){
                $this->$method($value);
            }
        }      
    }
    
    /**
     * Sends emails to specified email addresses.
     * 
     * @throws TF_Email_Exception
     */            
    public function send(){
        try {
            $mail = new Zend_Mail($this->charset);
            $html = $this->renderTemplate();
            $from = Zend_Registry::get('configuration')->email->from;
            $senderName = Zend_Registry::get('configuration')->email->sendername;
            $mail->setFrom($from, $senderName)
            ->setSubject($this->subject)
            ->setBodyHtml($html);            
            foreach($this->list as $item){
                $mail->addTo($item->getEmail());
            }
            $mail->send();
        } catch (Zend_Exception $ex) {
            throw new Miqo_Email_Exception($ex);
        }        
    } 

    /**
     * Sets the array of emails.
     *
     * @param  array $list
     * @return TF_Email_Base
     */
    public function setList($list){
        $this->list = $list;
        return $this;
    }
    
    /**
     * Sets the subject of email.
     *
     * @param string $subject
     * @return TF_Email_Base
     */
    public function setSubject($subject){
        $this->subject = $subject;
        return $this;
    }
        
    /**
     * Sets the charset of email.
     *
     * @param string $charset
     * @return TF_Email_Base
     */
    public function setCharset($charset){
        $this->charset = $charset;
        return $this;
    }
    
    
    /**
     * Returns name of the document�s template.
     *
     * @return string
     */
    private function getTemplate(){
        return $this->template;
    }
    
    /**
     * Sets name of the document�s template.
     *
     * @param string $name
     * @return TF_Email_Base
     */
    public function setTemplate($name){
        $this->template = $name;
        return $this;
    }
    
    /**
     * Returns content of email.
     *
     * @return string
     */
    private function getContent(){
        return $this->content;
    }
    
    /**
     * Sets content of mail.
     *
     * @param string $content
     * @return TF_Email_Base
     */
    public function setContent($content){
        $this->content = $content;
        return $this;
    }
    
    /**
     * Renders the template.
     *
     * @return string
     */
    private function renderTemplate(){
        $location = $this->getTemplate();
        ob_start();
        $this->includeFile($location);
        return  ob_get_clean();       
    }
    
    /**
     * Returns name of the CSS template.
     *
     * @return string
     */
    private function getCSS(){
        return $this->css;
    }
    
    /**
     * Sets name of the CSS template.
     *
     * @param  string
     * @return TF_Email_Base
     */
    public function setCSS($templateName){
        $this->css = $templateName;
        return $this;
    }
    
    /**
     * Renders the CSS.
     *
     * @return string
     */
    private function renderCSS(){
        $location = 'css/'.$this->getCSS();
        return $this->includeFile($location);
    }
    
    /**
     * Get file by location from a template directory.
     *
     * @param  string $location
     * @return boolen
     */
    private function includeFile($location){
        $fullPath = APPLICATION_PATH . $this->templatePath . '/' . $location;        
        if (file_exists($fullPath)) {
            include  $fullPath;
        }
        return false;
    }
}
?>