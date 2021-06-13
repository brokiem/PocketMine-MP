<?php

declare(strict_types=1);

namespace pocketmine\thread;

use function spl_object_id;

class ThreadManager extends \Volatile{

	/** @var ThreadManager|null */
	private static $instance = null;

	public static function init() : void{
		self::$instance = new ThreadManager();
	}

	public static function getInstance() : ThreadManager{
		if(self::$instance === null){
			self::$instance = new ThreadManager();
		}
		return self::$instance;
	}

	/**
	 * @param Worker|Thread $thread
	 */
	public function add($thread) : void{
		if($thread instanceof Thread or $thread instanceof Worker){
			$this[spl_object_id($thread)] = $thread;
		}
	}

	/**
	 * @param Worker|Thread $thread
	 */
	public function remove($thread) : void{
		if($thread instanceof Thread or $thread instanceof Worker){
			unset($this[spl_object_id($thread)]);
		}
	}

	/**
	 * @return Worker[]|Thread[]
	 */
	public function getAll() : array{
		$array = [];
		foreach($this as $key => $thread){
			$array[$key] = $thread;
		}

		return $array;
	}

	public function stopAll() : int{
		$logger = \GlobalLogger::get();

		$erroredThreads = 0;

		foreach($this->getAll() as $thread){
			$logger->debug("Stopping " . $thread->getThreadName() . " thread");
			try{
				$thread->quit();
				$logger->debug($thread->getThreadName() . " thread stopped successfully.");
			}catch(ThreadException $e){
				++$erroredThreads;
				$logger->debug("Could not stop " . $thread->getThreadName() . " thread: " . $e->getMessage());
			}
		}

		return $erroredThreads;
	}
}
