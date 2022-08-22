<?php

/**
 * This is Logger for PocketMine-MP.
 * 
 * @author xqwtxon
 * @link https://www.xqwtxon.ml/
 */

declare(strict_types=1);

namespace xqwtxon\Logger;

interface LoggerInterface {
    
    public function error(string $message) : void;
    
    public function info(string $message) : void;
    
    public function critical(string $message) : void;
    
    public function alert(string $message) : void;
    
    public function emergency(string $message) : void;
    
    public function warning(string $message) : void;
    
    public function custom(string $message, string $prefix) : void;
    
    public static function getInstance() : self;
    
}