<?php

declare(strict_types=1);

namespace pocketmine\thread;

use const PTHREADS_INHERIT_NONE;

/**
 * This class must be extended by all custom threading classes
 */
abstract class Worker extends \Worker{
	use CommonThreadPartsTrait;

	public function start(int $options = PTHREADS_INHERIT_NONE) : bool{
		//this is intentionally not traitified
		ThreadManager::getInstance()->add($this);

		if($this->getClassLoader() === null){
			$this->setClassLoader();
		}
		return parent::start($options);
	}

	/**
	 * Stops the thread using the best way possible. Try to stop it yourself before calling this.
	 */
	public function quit() : void{
		$this->isKilled = true;

		if(!$this->isShutdown()){
			while($this->unstack() !== null);
			$this->notify();
			$this->shutdown();
		}

		ThreadManager::getInstance()->remove($this);
	}
}
