<?php

declare(strict_types=1);

namespace pocketmine\scheduler;

use pocketmine\utils\Utils;

abstract class Task{

	/** @var TaskHandler|null */
	private $taskHandler = null;

	/**
	 * @return TaskHandler|null
	 */
	final public function getHandler(){
		return $this->taskHandler;
	}

	public function getName() : string{
		return Utils::getNiceClassName($this);
	}

	final public function setHandler(?TaskHandler $taskHandler) : void{
		if($this->taskHandler === null or $taskHandler === null){
			$this->taskHandler = $taskHandler;
		}
	}

	/**
	 * Actions to execute when run
	 *
	 * @throws CancelTaskException
	 */
	abstract public function onRun() : void;

	/**
	 * Actions to execute if the Task is cancelled
	 */
	public function onCancel() : void{

	}
}
