<?php

/**
 * This is Logger for PocketMine-MP.
 * 
 * @author xqwtxon
 * @link https://www.xqwtxon.ml/
 */

declare(strict_types=1);

namespace xqwtxon\Logger;

use Exception;

class LoggerException extends Exception {
    
    private string $message;
    
    public function __construct(string $message){
        //NOOP
    }
    
    public function errorMessage() {
        return $this->message;
    }
}