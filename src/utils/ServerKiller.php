<?php

declare(strict_types=1);

namespace pocketmine\utils;

use pocketmine\thread\Thread;
use function time;

class ServerKiller extends Thread{

	/** @var int */
	public $time;

	/** @var bool */
	private $stopped = false;

	/**
	 * @param int $time
	 */
	public function __construct($time = 15){
		$this->time = $time;
	}

	protected function onRun() : void{
		$start = time();
		$this->synchronized(function() : void{
			if(!$this->stopped){
				$this->wait($this->time * 1000000);
			}
		});
		if(time() - $start >= $this->time){
			echo "\nTook too long to stop, server was killed forcefully!\n";
			@Process::kill(Process::pid());
		}
	}

	public function quit() : void{
		$this->synchronized(function() : void{
			$this->stopped = true;
			$this->notify();
		});
		parent::quit();
	}

	public function getThreadName() : string{
		return "Server Killer";
	}
}
