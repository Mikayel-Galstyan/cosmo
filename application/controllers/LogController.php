<?php
require_once('SecureController.php');
class LogController extends SecureController{
    
    private $name = null;
    private $dateForImport = null;
    private $dateTo = null;
    private $calculateErrors = null;
    
    const LOG_TYPE_WARN = 'WARN';
    const LOG_TYPE_ERR = 'ERR';
    const MANUAL_TYPE = 'manual';
    const DAILY_TYPE = 'daily';
    const APP_VERSION = 'Multi Country Support: Version 1.0';
    //default $chunkSize = 1024*1024 (1 megabyte)
    const CHUNK_SIZE = 1048576;
    
  public function init() {
        parent::init();
        $this->dateForImport = new Miqo_Util_Date();
    }
    
    
    public function indexAction() {  
        $currentDate =  new Miqo_Util_Date();
        $formatting = $this->view->getHelper('DataFormatting');
        $dates['current'] = $currentDate;
        $dates['previous'] = $currentDate->subDays(7);
        $this->view->dates = $dates;
        $this->view->appVersion = self::APP_VERSION;
        $dates['current'] = $formatting->logFilePeriod($dates['current']);
        $dates['previous'] = $formatting->logFilePeriod($dates['previous']);
        $importLogErrors['current'][self::LOG_TYPE_ERR] = 0;
        $importLogErrors['current'][self::LOG_TYPE_WARN] = 0;
        $importLogErrors['previous'][self::LOG_TYPE_ERR] = 0;
        $importLogErrors['previous'][self::LOG_TYPE_WARN] = 0;
        $systemLogErrors['current'][self::LOG_TYPE_ERR] = 0;
        $systemLogErrors['current'][self::LOG_TYPE_WARN] = 0;
        $systemLogErrors['previous'][self::LOG_TYPE_ERR] = 0;
        $systemLogErrors['previous'][self::LOG_TYPE_WARN] = 0;
        $logFile = APPLICATION_PATH."/data/logs/import_".$dates['current'].".log";
        if(file_exists($logFile)){
            $importLogErrors['current'][self::LOG_TYPE_ERR] = $this->getKeyCountInFile($logFile, self::LOG_TYPE_ERR);
            $importLogErrors['current'][self::LOG_TYPE_WARN] = $this->getKeyCountInFile($logFile, self::LOG_TYPE_WARN);
        }
        $logFile = APPLICATION_PATH."/data/logs/import_".$dates['previous'].".log";
        if(file_exists($logFile)){
            $importLogErrors['previous'][self::LOG_TYPE_ERR] = $this->getKeyCountInFile($logFile, self::LOG_TYPE_ERR);
            $importLogErrors['previous'][self::LOG_TYPE_WARN] = $this->getKeyCountInFile($logFile, self::LOG_TYPE_WARN);
        }
        $logFile = APPLICATION_PATH."/data/logs/app_".$dates['current'].".log";
        if(file_exists($logFile)){
            $systemLogErrors['current'][self::LOG_TYPE_ERR] = $this->getKeyCountInFile($logFile, self::LOG_TYPE_ERR);
            $systemLogErrors['current'][self::LOG_TYPE_WARN] = $this->getKeyCountInFile($logFile, self::LOG_TYPE_WARN);
        }
        $logFile = APPLICATION_PATH."/data/logs/app_".$dates['previous'].".log";
        if(file_exists($logFile)){
            $systemLogErrors['previous'][self::LOG_TYPE_ERR] = $this->getKeyCountInFile($logFile, self::LOG_TYPE_ERR);
            $systemLogErrors['previous'][self::LOG_TYPE_WARN] = $this->getKeyCountInFile($logFile, self::LOG_TYPE_WARN);
        }
        $this->view->importLogErrors = $importLogErrors;
        $this->view->systemLogErrors = $systemLogErrors;
    }
    
    public function downloadAction() {      
        $this->disableLayout();
        $this->setNoRender();
        $file = APPLICATION_PATH."/data/logs/".$this->name.".log";
        $path_parts = pathinfo($file);
        $fsize = 0;
        $fsize = filesize($file);
        if(file_exists($file)) {            
            $fsize = filesize($file);            
        }
        header("Content-Disposition: attachment; filename=\"".$path_parts["basename"]."\"");
        header("Content-Type: plain/text");
        header('Content-Length: '.$fsize);
        if(file_exists($file)) {
            $handle = fopen($file, 'rb');
            while (!feof($handle)) {
                echo fread($handle, self::CHUNK_SIZE);
            }
        }
    }
    
    public function importAction() {        
        $this->disableLayout();
        $this->setNoRender();
        $date = '';
        $isValid = true;
        if($this->dateTo instanceof Miqo_Util_Date) {
            $today = new Miqo_Util_Date();
            if($today->isEarlierOrEqual($this->dateTo)) {
                $isValid = false;
                $this->printJsonFail($this->translate('daily.import.failed.validation.error'));
            }
        }
        if($isValid) {
            try {            
                $importService = new Service_Adserver_Import();
//                if($this->dateTo){
//                    $date = $this->dateTo->toString('yyyy-MM-dd');
//                }
                $import = $importService->importDailyChanges($this->dateTo);
                $this->printJsonSuccess($this->translate('daily.import.success'));
            } catch ( Service_Adserver_Exception_RequestFailed $ex ) {
                $this->printJsonFail($this->translate('daily.import.request.limit.error'));
            } catch ( Service_Adserver_Exception_Auth $ex ) {
                $this->printJsonFail($this->translate('daily.import.failed.auth'));
            } catch ( Miqo_Util_Exception_Base $ex ) {
                $this->printJsonFail($this->translate('daily.import.failed'));
            }
        }
    }
    
    public function importbydateAction() {
        if($this->dateForImport) {
            $importLogService = new Service_Adserver_ImportLog();
            $importDailyLog = $importLogService->getAllByDateAndType($this->dateForImport,self::DAILY_TYPE);
            $importLogService = new Service_Adserver_ImportLog();
            $importManualLog = $importLogService->getAllByDateAndType($this->dateForImport,self::MANUAL_TYPE);
            if($importDailyLog || $importManualLog){
                $this->view->importDailyLog = $importDailyLog;
                $this->view->importManualLog = $importManualLog;
                if(sizeof($importDailyLog)>0) {
                    $importLogItemsService = new Service_Adserver_ImportLogItems();
                    $getByLogId = $importLogItemsService->getByLogId($importDailyLog[0]->getId());
                    $this->view->dailyLogItems = $getByLogId;
                }
                if(sizeof($importManualLog)>0) {
                    $importLogItemsService = new Service_Adserver_ImportLogItems();
                    $getByLogId = $importLogItemsService->getByLogId($importManualLog[0]->getId());
                    $this->view->manualLogItems = $getByLogId;
                }
            } else {
                $this->view->notifyMessage = "no.data.available";
            }
        } else {
            $this->view->EmptyDatemessage = "please.select.date";
        }
    }
    
    private function getKeyCountInFile($file, $key, $chunkSize = self::CHUNK_SIZE) {
        $buffer = '';
        $count = 0;
        $handle = fopen($file, 'rb');
        while (!feof($handle)) {
            $buffer = fread($handle, $chunkSize);
            $count +=  substr_count($buffer, $key);
        }
        return $count;
    }
    
    
    public function &setCalculateErrors($val) {
        $this->calculateErrors = $val;
        return $this;
    }
    public function &setName($val) {
        $this->name = $val;
        return $this;
    }  
    public function &setDateTo($val) {
        $this->dateTo = $this->parseToDate($val);
        return $this;
    }
    public function &setDateForImport($val) {
        $this->dateForImport = $this->parseToDate($val);
        return $this;
    }
}
