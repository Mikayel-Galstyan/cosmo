<?php
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {


    public function run() {
        $this->setupEnvironment();
        $front   = $this->getResource('FrontController');
        $default = $front->getDefaultModule();
        if (null === $front->getControllerDirectory($default)) {
            throw new Zend_Application_Bootstrap_Exception('No default controller directory registered with front controller');
        }
        $front->setParam('bootstrap', $this);
        $front->dispatch();
    }
   
    protected function setupEnvironment() {       
        $backendOptions = array('automatic_serialization' => true);  
        libxml_use_internal_errors(true);
        $defaultTimezone = new Zend_Config_Ini ( APPLICATION_PATH . '/configs/application.ini', APPLICATION_ENV);
        date_default_timezone_set($defaultTimezone->phpSettings->date->timezone);
    }
   
   
  
   
    protected function _initSession() {
        $config = new Zend_Config_Ini ( APPLICATION_PATH . '/configs/application.ini', APPLICATION_ENV);
        $sessionTimeout = $config->phpSettings->session->timeout;
        Zend_Registry::set('session_timeout', $sessionTimeout);
    }
    /**
    * Bootstrap autoloader for application resources
    *
    * @return Zend_Application_Module_Autoloader
    */
    protected function _initAutoload() {		
		$autoloader = new Zend_Application_Module_Autoloader(array(
            'namespace' => '',
            'basePath'  => APPLICATION_PATH));    
        $autoloader->setResourceTypes(array(
            'dbtable' => array(
                'namespace' => 'Dao_DbTable',
                'path'      => 'core/dao/dbtable',
            ),
            'dao' => array(
                'namespace' => 'Dao',
                'path'      => 'core/dao',
            ),
            'domain' => array(
                'namespace' => 'Domain',
                'path'      => 'core/domain',
            ),          
            'service' => array(
                'namespace' => 'Service',
                'path'      => 'core/service',
            ),  
            'filter' => array(
                'namespace' => 'Filter',
                'path'      => 'core/filter',
            ),
            'miqo_dao' => array(
                'namespace' => 'Miqo_Dao',
                'path'      => '/../library/Miqo/Dao',
            ),
            'miqo_domain' => array(
                'namespace' => 'Miqo_Domain',
                'path'      => '/../library/Miqo/Domain',
            ),
            'miqo_service' => array(
                'namespace' => 'Miqo_Service',
                'path'      =>  '/../library/Miqo/Service',
            ),
            'miqo_util' => array(
                'namespace' => 'Miqo_Util',
                'path'      => '/../library/Miqo/Util',
            ),
            'miqo_exception' => array(
                'namespace' => 'Miqo_Util_Exception',
                'path'      => '/../library/Miqo/Util/Exception',
            ),
            'miqo_session' => array(
                'namespace' => 'Miqo_Session',
                'path'      => '/../library/Miqo/Session',
            ),
            'miqo_validation' => array(
                'namespace' => 'Miqo_Validation',
                'path'      => '/../library/Miqo/Validation',
            ),                        
            'plugin' => array(
                'namespace' => 'Plugin',
                'path'      => 'plugins',
            ),
            'viewhelper'  => array(
                'namespace' => 'View_Helper',
                'path'      => 'views/helpers',
            ),           
        ));
        $autoloader->setDefaultResourceType('service');        
        return $autoloader;
    }
    
    protected function _initTranslate() {
        $langSession = new Miqo_Session_Base();
        $langFilePath = APPLICATION_PATH . '/languages/' . $langSession->get('lang') . '.php';
        if ($langSession->get('lang') == '' || !file_exists($langFilePath)) {
            $langSession->set('lang', 'en');
        }
        $translate = new Zend_Translate ( 'array', APPLICATION_PATH . '/languages/' . $langSession->get('lang') . '.php', $langSession->get('lang'));
        Zend_Registry::set ( 'translate', $translate );
    }
    /**
    * Bootstrap logger for the application
    */
    protected function _initLogging() {
        $this->bootstrap('frontController');
        $format = 'Ymd';
        $now = new Miqo_Util_Date();
        $date = $now->setWeekday('Monday');
        $filename = $date->format($format);
        $date = $date->addDays(6);
        $filename .= '_'.$date->format($format);
        $logger = new Zend_Log();
        $loggerImport = new Zend_Log();
        $writer = new Zend_Log_Writer_Stream(APPLICATION_PATH . '/data/logs/app_'.$filename.'.log');
        $writerImport = new Zend_Log_Writer_Stream(APPLICATION_PATH . '/data/logs/import_'.$filename.'.log');
        @chmod(APPLICATION_PATH . '/data/logs/app_'.$filename.'.log', 0777);
        @chmod(APPLICATION_PATH . '/data/logs/import_'.$filename.'.log', 0777);
        $formatter = new Zend_Log_Formatter_Simple('%timestamp% %priorityName% %message%' . PHP_EOL);
        $writer->setFormatter($formatter);
        $writerImport->setFormatter($formatter);
        $logger->addWriter($writer);
        $loggerImport->addWriter($writerImport);
        if ('development' == $this->getEnvironment()) {
        	$filter = new Zend_Log_Filter_Priority(Zend_Log::DEBUG);
        }else{
        	$filter = new Zend_Log_Filter_Priority(Zend_Log::INFO);        	
        }
        $logger->addFilter($filter);
        $loggerImport->addFilter($filter);
        Zend_Registry::set('log', $logger);
        Zend_Registry::set('import_log', $loggerImport);       
        Zend_Registry::set('environment', $this->getEnvironment());
    }

    protected function _initDefSession() {       
        $configuration = new Zend_Config_Ini ( APPLICATION_PATH . '/configs/application.ini', APPLICATION_ENV );
        Zend_Registry::set ( 'configuration', $configuration );
        
    }
    protected function _initRoutes() {
        $frontController = Zend_Controller_Front::getInstance();
        $router = $frontController->getRouter();
        $router->addRoute('image', new Zend_Controller_Router_Route('image/:folder/:name',
                array('controller' => 'image', 'action' => 'index', 'folder' => ':folder', 'name' => ':name' ))
        );
        $router->addRoute('add', new Zend_Controller_Router_Route(':controller/add',
            array('controller' => ':controller','action' => 'edit'))
        );         
        $router->addRoute('edit', new Zend_Controller_Router_Route(':controller/:id/edit',
            array('controller' => ':controller', 'action' => 'edit', 'id' => ':id'))
        );
		$router->addRoute('overview', new Zend_Controller_Router_Route(':controller/:id/overview',
            array('controller' => ':controller', 'action' => 'overview', 'id' => ':id'))
        );
        $router->addRoute('delete', new Zend_Controller_Router_Route(':controller/:id/delete',
            array('controller' => ':controller','action' => 'delete','id' => ':id'))
        );
        $router->addRoute('confirm', new Zend_Controller_Router_Route(':controller/:id/confirm',
            array('controller' => ':controller','action' => 'confirm','id' => ':id'))
        );
		/*$router->addRoute('defaultList', new Zend_Controller_Router_Route(':controller/:id/:action',
            array('controller' => ':controller','action' => ':action','id' => ':id'))
        );*/
    }
    /**
    * Bootstrap the view doctype
    *
    * @return void
    */
    protected function _initDoctype() {
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->headMeta ()->appendHttpEquiv ( 'Content-Type', 'text/html;charset=utf-8' );
    }
    
}

