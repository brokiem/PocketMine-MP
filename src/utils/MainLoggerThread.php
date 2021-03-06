<?php

declare(strict_types=1);

namespace pocketmine\utils;

use function fclose;
use function fopen;
use function fwrite;
use function is_resource;
use function touch;

final class MainLoggerThread extends \Thread{

	private string $logFile;
	private \Threaded $buffer;
	private bool $syncFlush = false;
	private bool $shutdown = false;

	public function __construct(string $logFile){
		$this->buffer = new \Threaded();
		touch($logFile);
		$this->logFile = $logFile;
	}

	public function write(string $line) : void{
		$this->synchronized(function() use ($line) : void{
			$this->buffer[] = $line;
			$this->notify();
		});
	}

	public function syncFlushBuffer() : void{
		$this->synchronized(function() : void{
			$this->syncFlush = true;
			$this->notify(); //write immediately
		});
		$this->synchronized(function() : void{
			while($this->syncFlush){
				$this->wait(); //block until it's all been written to disk
			}
		});
	}

	public function shutdown() : void{
		$this->synchronized(function() : void{
			$this->shutdown = true;
			$this->notify();
		});
		$this->join();
	}

	/**
	 * @param resource $logResource
	 */
	private function writeLogStream($logResource) : void{
		while($this->buffer->count() > 0){
			/** @var string $chunk */
			$chunk = $this->buffer->shift();
			fwrite($logResource, $chunk);
		}

		$this->synchronized(function() : void{
			if($this->syncFlush){
				$this->syncFlush = false;
				$this->notify(); //if this was due to a sync flush, tell the caller to stop waiting
			}
		});
	}

	public function run() : void{
		$logResource = fopen($this->logFile, "ab");
		if(!is_resource($logResource)){
			throw new \RuntimeException("Couldn't open log file");
		}

		while(!$this->shutdown){
			$this->writeLogStream($logResource);
			$this->synchronized(function() : void{
				if(!$this->shutdown && !$this->syncFlush){
					$this->wait();
				}
			});
		}

		$this->writeLogStream($logResource);

		fclose($logResource);
	}
}
