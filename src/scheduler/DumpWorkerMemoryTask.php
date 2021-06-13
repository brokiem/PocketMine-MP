<?php

declare(strict_types=1);

namespace pocketmine\scheduler;

use pocketmine\MemoryManager;
use const DIRECTORY_SEPARATOR;

/**
 * Task used to dump memory from AsyncWorkers
 */
class DumpWorkerMemoryTask extends AsyncTask{
	/** @var string */
	private $outputFolder;
	/** @var int */
	private $maxNesting;
	/** @var int */
	private $maxStringSize;

	public function __construct(string $outputFolder, int $maxNesting, int $maxStringSize){
		$this->outputFolder = $outputFolder;
		$this->maxNesting = $maxNesting;
		$this->maxStringSize = $maxStringSize;
	}

	public function onRun() : void{
		MemoryManager::dumpMemory(
			$this->worker,
			$this->outputFolder . DIRECTORY_SEPARATOR . "AsyncWorker#" . $this->worker->getAsyncWorkerId(),
			$this->maxNesting,
			$this->maxStringSize,
			new \PrefixedLogger($this->worker->getLogger(), "Memory Dump")
		);
	}
}
