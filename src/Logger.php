<?php

/**
 * This is Logger for PocketMine-MP.
 * 
 * @author xqwtxon
 * @link https://www.xqwtxon.ml/
 */

declare(strict_types=1);

namespace xqwtxon\Logger;

use pocketmine\utils\Utils;

use xqwtxon\Logger\LoggerBase;
use xqwtxon\Logger\LoggerException;
use xqwtxon\Logger\LoggerInterface;

use DateTime;
use function vsprintf;
use function file_put_contents;
use function file_get_contents;
use function file_exists;

class Logger implements LoggerInterface {
    
    public const ALERT = 0;
    public const WARNING = 1;
    public const INFO = 2;
    public const ERROR = 3;
    public const CRITICAL = 4;
    public const EMERGENCY = 5;
    public const CUSTOM = 6;
    
    private bool $save = false;
    
    public string $format = "[%s] [%s]: %s";
    public string $output = "server-%s.%s";
    public string $current_output = "server.%s";
    
    private string $date_format = "H:i:s.v";
    private string $file_type = "log";
    private string $info = "INFO";
    private string $warning = "WARNING";
    private string $error = "ERROR";
    private string $alert = "ALERT";
    private string $critical = "CRITICAL";
    private string $emergency = "EMERGENCY";
    private string $dataPath;
    
    /** @var self $instance */
    private static self $instance;
    
    /**
     * The constructor.
     * @param string $dataPath
     */
    public function __construct(string $dataPath){
        self::$instance = $this;
        $this->plugin = LoggerBase::getInstance();
        $this->dataPath = $dataPath;
    }
    
    /**
     * Saves the logger.
     */
    public function save() : void{
        if (!file_exists($this->getLoggerPath())){
            $this->new();
            return;
        }
        
        $this->renew();
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
        $this->setMessage($message . PHP_EOL, self::INFO);
    }
    
    /**
     * Warning Logger
     * @param string $message
     * @return void
     */
    public function warning(string $message) : void{
        $this->setMessage($message . PHP_EOL, self::WARNING);
    }
    
    /**
     * Error Logger
     * @param string $message
     * @return void
     */
    public function error(string $message) : void{
        $this->setMessage($message . PHP_EOL, self::ERROR);
    }
    
    /**
     * Critical Logger
     * @param string $message
     * @return void
     */
    public function critical(string $message) : void{
        $this->setMessage($message . PHP_EOL, self::CRITICAL);
    }
    
    
    /**
     * Emergency Logger 
     * @param string $message
     * @return void
     */
    public function emergency(string $message) :void{
        $this->setMessage($message . PHP_EOL, self::EMERGENCY);
    }
    
    /**
     * Alert Logger
     * @param string $message
     * @return void
     */
    public function alert(string $message) : void{
        $this->setMessage($message . PHP_EOL, self::ALERT);
    }
    
    /**
     * Custom Prefixed Logger.
     * @param string $message
     * @param string $prefix
     * @return void
     */
    public function custom(string $message, string $prefix) : void{
        $this->setMessage($message . PHP_EOL, self::CUSTOM, $prefix);
    }
    
    /**
     * Sets Message to current logger.
     * DO NOT CALL DIRECTLY!
     * @return void
     */
    private function setMessage(string $message, int $type, ?string $custom_prefix = "UNKNOWN") : void{
        switch($type){
            case self::INFO:
                Utils::assumeNotFalse(@file_put_contents($this->getLoggerPath(), vsprintf($this->format, [$this->getTime(), $this->info, $message]), FILE_APPEND));
                break;
            case self::WARNING:
                Utils::assumeNotFalse(@file_put_contents($this->getLoggerPath(), vsprintf($this->format, [$this->getTime(), $this->warning, $message]), FILE_APPEND));
                break;
            case self::CRITICAL:
                Utils::assumeNotFalse(@file_put_contents($this->getLoggerPath(), vsprintf($this->format, [$this->getTime(), $this->critical, $message]), FILE_APPEND));
                break;
            case self::ERROR:
                Utils::assumeNotFalse(@file_put_contents($this->getLoggerPath(), vsprintf($this->format, [$this->getTime(), $this->error, $message]), FILE_APPEND));
                break;
            case self::ALERT:
                Utils::assumeNotFalse(@file_put_contents($this->getLoggerPath(), vsprintf($this->format, [$this->getTime(), $this->alert, $message]), FILE_APPEND));
                break;
            case self::EMERGENCY:
                Utils::assumeNotFalse(@file_put_contents($this->getLoggerPath(), vsprintf($this->format, [$this->getTime(), $this->emergency, $message]), FILE_APPEND));
                break;
            case self::CUSTOM:
                Utils::assumeNotFalse(@file_put_contents($this->getLoggerPath(), vsprintf($this->format, [$this->getTime(), $custom_prefix, $message]), FILE_APPEND));
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
    private function getTime() : string{
        $dateNow = new DateTime("now");
        
        return $dateNow->format($this->date_format);
    }
    
    /**
     * Renew the logger.
     * @return void
     */
    private function renew() : void{
        if(!file_exists($this->newLoggerPath())){
            Utils::assumeNotFalse(@rename($this->getLoggerPath(), $this->newLoggerPath()));
        } else {
            Utils::assumeNotFalse(@file_put_contents($this->getLoggerPath(), str_repeat("-", 60) . PHP_EOL, FILE_APPEND));
        }
        $this->is_save = true;
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
    public function setFileType(string $file_type) : void{
        $this->file_type = $file_type;
    }
    
    /**
     * New logger.
     * @return void
     */
    private function new() : bool{
        if (!file_exists($this->getLoggerPath())){
            Utils::assumeNotFalse(@file_put_contents($this->getLoggerPath(), str_repeat("-", 30) . $this->plugin->getDescription()->getFullName() . str_repeat("-", 30) . PHP_EOL, FILE_APPEND));
            return true;
        } else {
            throw new LoggerException("Cannot Logger->new() because the file is exists. Please use Logger->renew() instead. This is possible to be a bug.");
            return false;
        }
        
        $this->is_save = true;
    }
    
    /**
     * Gets the logger path()
     * @return void
     */
    public function getLoggerPath() : string{
        return $this->getDataPath() . "/" . vsprintf($this->current_output, [$this->getFileType()]);
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
    private function getDataPath() : string{
        return $this->dataPath;
    }
    
    /**
     * New Logger Path()
     * @return void
     */
    private function newLoggerPath() : string{
        
        $now = new DateTime("now");
        
        return $this->getDataPath() . "/" . vsprintf($this->output, [$now->format("m-d-y"), $this->getFileType()]);
    }
}