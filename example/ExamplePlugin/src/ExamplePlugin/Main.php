<?php

/**
 * This is Logger for PocketMine-MP.
 * 
 * @author xqwtxon
 * @link https://www.xqwtxon.ml/
 */

declare(strict_types=1);

namespace ExamplePlugin;
 
use pocketmine\plugin\PluginBase;

use xqwtxon\Logger\Logger;

class Main extends PluginBase {
    
    public function onEnable() : void{
        /**
         * This sets the current extention of file type.
         * It can change anything here.
         */
        $this->getFileLogger()->setFileType("log");
        
        /**
         * This saves the current logger or initilize new one.
         * Please call this first before you are going to log to your file.
         */
        $this->getFileLogger()->save();
        
        /**
         * Here you can now log your actions by using this method:
         */
        $this->getFileLogger()->info("Information Logger");
        $this->getFileLogger()->alert("Alert Logger");
        $this->getFileLogger()->error("Error Logger");
        $this->getFileLogger()->warning("Warning Logger");
        $this->getFileLogger()->critical("Critical Logger");
        $this->getFileLogger()->emergency("Emergency Logger");
        
        /**
         * If you want a custom prefixed logger. Use this method to create your own.
         * 
         * PLEASE DO NOT LEAVE BLANK ON NEXT PARAMETER.
         * 
         */
        $this->getFileLogger()->custom("Custom Prefixed Logger", "Example Prefix");
    }
    
    public function getFileLogger() : Logger {
        return new Logger($this->getDataFolder());
    }
    
}