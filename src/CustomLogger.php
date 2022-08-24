<?php

/**
 * Logger For PocketMine-MP
 *
 * @author xqwtxon
 * @link https://xqwtxon.ml/
 */

declare(strict_types=1);

namespace xqwtxon\Logger;

use xqwtxon\Logger\Logger;

class CustomLogger extends Logger {

	private string $prefix;
	private string $dataPath;

	public function __construct(string $dataPath, string $prefix){
		$this->dataPath = $dataPath;
		$this->prefix = $prefix;
		// CONTRUCTOR FOR LOGGER BASE
		parent::__construct($dataPath);
	}

	public function info(string $message) : void{
		$this->custom($message, $this->prefix);
	}

	public function critical(string $message) : void{
		$this->custom($message, $this->prefix);
	}

	public function warning(string $message) : void{
		$this->custom($message, $this->prefix);
	}

	public function alert(string $message) : void{
		$this->custom($message, $this->prefix);
	}

	public function error(string $message) : void{
		$this->custom($message, $this->prefix);
	}
}
