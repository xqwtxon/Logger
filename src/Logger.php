<?php

/**
 * This is Logger for PocketMine-MP.
 * 
 * @author xqwtxon
 * @link https://www.xqwtxon.ml/
 */

declare(strict_types=1);

namespace xqwtxon\Logger;

use pocketmine\plugin\PluginBase;

use xqwtxon\Logger\LoggerException;

use DateTime;
use function vsprintf;
use function file_put_contents;
use function file_get_contents;
use function file_exists;

class Logger extends PluginBase {
    
    public const ALERT = 0;
    public const WARNING = 1;
    public const INFO = 2;
    public const ERROR = 3;
    public const CRITICAL = 4;
    
    private bool $save = false;
    
    public string $format = "[%s] [%s]: %s";
    public string $output = "server-%s.%s";
    public string $current_output = "server.%s";
    
    private string $date_format = "H:i:s.v";
    private string $file_type;
    private string $info = "INFO";
    private string $warning = "WARNING";
    private string $error = "ERROR";
    private string $alert = "ALERT";
    private string $critical = "CRITICAL";
    private string $dataPath;
    
    /** @var self $instance */
    private static self $instance;
    
    public function __construct(string $dataPath){
        self::$instance = $this;
        $this->dataPath = $dataPath;
    }
    
    /**
     * Saves the logger.
     * @return void
     */
    public function save() :void{
        if (file_exists($this->getLoggerPath())){
            $this->renew();
            $this->is_save = true;
        } else {
            $this->new();
            $this->is_save = true;
        }
    }
    
    /**
     * Is save?
     * @return bool
     */
    public function is_save() : bool{
        return $this->save;
    }
    
    /**
     * Info Logger
     * @param string $message
     * @return void
     */
    public function info(string $message) : void{
        $this->setMessage($message, self::INFO);
    }
    
    /**
     * Warning Logger
     * @param string $message
     * @return void
     */
    public function warning(string $message) : void{
        $this->setMessage($message, self::WARNING);
    }
    
    /**
     * Error Logger
     * @param string $message
     * @return void
     */
    public function error(string $message) : void{
        $this->setMessage($message, self::ERROR);
    }
    
    /**
     * Critical Logger
     * @param string $message
     */
    public function critical(string $message) : void{
        $this->setMessage($message, self::CRITICAL);
    }
    
    /**
     * Sets Message to current logger.
     * DO NOT CALL DIRECTLY!
     * @return void
     */
    private function setMessage(string $message, int $type){
        if (!is_save()){
            $this->save();
        }
        
        switch($type){
            case self::INFO:
                @file_put_contents(vsprintf($format, [$this->getTime(), $this->info, $message]), $this->getLoggerPath());
                break;
            case self::WARNING:
                @file_put_contents(vsprintf($format, [$this->getTime(), $this->warning, $message]), $this->getLoggerPath());
                break;
            case self::CRITICAL:
                @file_put_contents(vsprintf($format, [$this->getTime(), $this->critical, $message]), $this->getLoggerPath());
                break;
            case self::ERROR:
                @file_put_contents(vsprintf($format, [$this->getTime(), $this->error, $message]), $this->getLoggerPath());
                break;
            case self::ALERT:
                @file_put_contents(vsprintf($format, [$this->getTime(), $this->alert, $message]), $this->getLoggerPath());
                break;
            default:
                throw new LoggerException("Invalid logger type given. Possible invalid operation provided.");
                break;
        }
    }
    
    /**
     * Gets the times currently format for logger.
     * DO NOT CALL DIRECTLY!
     * @return string
     */
    private function getTime() : string {
        $dateNow = new DateTime("now");
        
        return $dateNow->format($this->date_format);
    }
    
    /**
     * Renew the logger.
     * @return void
     */
    public function renew() : void{
        if(!is_save()){
            $this->save();
        }
        
        @rename(vsprintf($this->current_output, [$this->getFileType()]), vsprintf($this->output, [$now->format("m-d-y"), $this->getFileType()]));
    }
    
    /**
     * Gets the file type.
     * @return void
     */
    public function getFileType() : string{
        return $this->file_type;
    }
    
    /**
     * Sets the file type.
     * @return void
     */
    private function setFileType(string $filetype) : void{
        $this->file_type = $file_type;
    }
    
    /**
     * Setup the Logger()
     * @return void
     */
    public static function setup() : void{
        $this->setFileType("log");
        
        if (!$this->is_save()){
            $this->save();
        }
    }
    
    /**
     * New logger.
     * @return void
     */
    public function new() : bool{
        if (!file_exists($this->getLoggerPath())){
            @file_put_contents($this->getLog
            return true;
        } else {
            throw new LoggerException("Cannot Logger->new() because the file is exists. Please use Logger->renew() instead.");
        }
    }
    
    /**
     * Gets the logger path()
     * @return void
     */
    public function getLoggerPath() : string{
        return vsprintf($this->current_output, [$this->getFileType()]);
    }
    
    /**
     * Retuns the static instance.
     * @return self
     */
    public static function getInstance() : self {
        return self::$instance;
    }
    
    /**
     * Gets the data path of server.
     * @return string
     */
    public static function getDataPath() :string{
        return $this->getServer()->getDataPath();
    }
    
}