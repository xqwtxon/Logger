<?php

declare(strict_types=1);

namespace xqwtxon\CustomLogger;

// The Custom Class Registry
use xqwtxon\Logger\CustomLogger as ModifiedCustomLogger;

class CustomLogger extends  ModifiedCustomLogger {
	public function __construct(string $dataPath){
		parent::__construct($dataPath, "CustomLogger");
	}
}
