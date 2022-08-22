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
use pocketmine\utils\NotCloneable;

class LoggerBase extends PluginBase {
    use NotCloneable;
    
    private static LoggerBase $instance;
     
    protected function onLoad() : void{
          self::$instance = $this;
          $this->getLogger()->warning("Unshaded plugin detected. Please use DEVirion instead.");
    }
     
    public static function getInstance() : LoggerBase{
          return self::$instance;
    }
     
}