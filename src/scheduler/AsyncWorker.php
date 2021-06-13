<?php

declare(strict_types=1);

namespace pocketmine\scheduler;

use pocketmine\snooze\SleeperNotifier;
use pocketmine\thread\Worker;
use function gc_enable;
use function ini_set;

class AsyncWorker extends Worker{
	/** @var mixed[] */
	private static $store = [];

	/** @var \ThreadedLogger */
	private $logger;
	/** @var int */
	private $id;

	/** @var int */
	private $memoryLimit;

	/** @var SleeperNotifier */
	private $notifier;

	public function __construct(\ThreadedLogger $logger, int $id, int $memoryLimit, SleeperNotifier $notifier){
		$this->logger = $logger;
		$this->id = $id;
		$this->memoryLimit = $memoryLimit;
		$this->notifier = $notifier;
	}

	public function getNotifier() : SleeperNotifier{
		return $this->notifier;
	}

	protected function onRun() : void{
		\GlobalLogger::set($this->logger);

		gc_enable();

		if($this->memoryLimit > 0){
			ini_set('memory_limit', $this->memoryLimit . 'M');
			$this->logger->debug("Set memory limit to " . $this->memoryLimit . " MB");
		}else{
			ini_set('memory_limit', '-1');
			$this->logger->debug("No memory limit set");
		}
	}

	public function getLogger() : \ThreadedLogger{
		return $this->logger;
	}

	public function handleException(\Throwable $e) : void{
		$this->logger->logException($e);
	}

	public function getThreadName() : string{
		return "AsyncWorker#" . $this->id;
	}

	public function getAsyncWorkerId() : int{
		return $this->id;
	}

	/**
	 * Saves mixed data into the worker's thread-local object store. This can be used to store objects which you
	 * want to use on this worker thread from multiple AsyncTasks.
	 *
	 * @param mixed  $value
	 */
	public function saveToThreadStore(string $identifier, $value) : void{
		if(\Thread::getCurrentThread() !== $this){
			throw new \InvalidStateException("Thread-local data can only be stored in the thread context");
		}
		self::$store[$identifier] = $value;
	}

	/**
	 * Retrieves mixed data from the worker's thread-local object store.
	 *
	 * Note that the thread-local object store could be cleared and your data might not exist, so your code should
	 * account for the possibility that what you're trying to retrieve might not exist.
	 *
	 * Objects stored in this storage may ONLY be retrieved while the task is running.
	 *
	 * @return mixed
	 */
	public function getFromThreadStore(string $identifier){
		if(\Thread::getCurrentThread() !== $this){
			throw new \InvalidStateException("Thread-local data can only be fetched in the thread context");
		}
		return self::$store[$identifier] ?? null;
	}

	/**
	 * Removes previously-stored mixed data from the worker's thread-local object store.
	 */
	public function removeFromThreadStore(string $identifier) : void{
		if(\Thread::getCurrentThread() !== $this){
			throw new \InvalidStateException("Thread-local data can only be removed in the thread context");
		}
		unset(self::$store[$identifier]);
	}
}
