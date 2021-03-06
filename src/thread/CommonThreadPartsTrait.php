<?php

declare(strict_types=1);

namespace pocketmine\thread;

use pocketmine\errorhandler\ErrorToExceptionHandler;
use pocketmine\Server;
use function error_reporting;

trait CommonThreadPartsTrait{
	/** @var \ClassLoader|null */
	protected $classLoader;
	/** @var string|null */
	protected $composerAutoloaderPath;

	/** @var bool */
	protected $isKilled = false;

	public function getClassLoader() : ?\ClassLoader{
		return $this->classLoader;
	}

	public function setClassLoader(?\ClassLoader $loader = null) : void{
		$this->composerAutoloaderPath = \pocketmine\COMPOSER_AUTOLOADER_PATH;

		if($loader === null){
			$loader = Server::getInstance()->getLoader();
		}
		$this->classLoader = $loader;
	}

	/**
	 * Registers the class loader for this thread.
	 *
	 * WARNING: This method MUST be called from any descendent threads' run() method to make autoloading usable.
	 * If you do not do this, you will not be able to use new classes that were not loaded when the thread was started
	 * (unless you are using a custom autoloader).
	 */
	public function registerClassLoader() : void{
		if($this->composerAutoloaderPath !== null){
			require $this->composerAutoloaderPath;
		}
		if($this->classLoader !== null){
			$this->classLoader->register(false);
		}
	}

	final public function run() : void{
		error_reporting(-1);
		$this->registerClassLoader();
		//set this after the autoloader is registered
		ErrorToExceptionHandler::set();
		$this->onRun();
	}

	/**
	 * Runs code on the thread.
	 */
	abstract protected function onRun() : void;

	public function getThreadName() : string{
		return (new \ReflectionClass($this))->getShortName();
	}
}
