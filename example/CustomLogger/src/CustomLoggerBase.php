<?php

declare(strict_types=1);

namespace xqwtxon\CustomLogger;

use pocketmine\plugin\PluginBase;
use xqwtxon\CustomLogger\CustomLogger;

class CustomLoggerBase extends PluginBase {

	public function getCustomLogger() : CustomLogger {
		return new CustomLogger($this->getDataFolder());
	}

	public function onEnable() : void{
		$this->getCustomLogger()->info("Custom Logger for PocketMine-MP");
	}
}
