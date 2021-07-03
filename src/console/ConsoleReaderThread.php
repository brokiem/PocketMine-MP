<?php

declare(strict_types=1);

namespace pocketmine\console;

use pocketmine\snooze\SleeperNotifier;
use pocketmine\thread\Thread;
use pocketmine\thread\ThreadException;
use function microtime;
use function preg_replace;
use function usleep;

final class ConsoleReaderThread extends Thread{
	private \Threaded $buffer;
	private ?SleeperNotifier $notifier;

	public bool $shutdown = false;

	public function __construct(\Threaded $buffer, ?SleeperNotifier $notifier = null){
		$this->buffer = $buffer;
		$this->notifier = $notifier;
	}

	public function shutdown() : void{
		$this->shutdown = true;
	}

	public function quit() : void{
		$wait = microtime(true) + 0.5;
		while(microtime(true) < $wait){
			if($this->isRunning()){
				usleep(100000);
			}else{
				parent::quit();
				return;
			}
		}

		throw new ThreadException("CommandReader is stuck in a blocking STDIN read");
	}

	protected function onRun() : void{
		$buffer = $this->buffer;
		$notifier = $this->notifier;

		$reader = new ConsoleReader();
		while(!$this->shutdown){
			$line = $reader->readLine();

			if($line !== null){
				$buffer[] = preg_replace("#\\x1b\\x5b([^\\x1b]*\\x7e|[\\x40-\\x50])#", "", $line);
				if($notifier !== null){
					$notifier->wakeupSleeper();
				}
			}
		}
	}

	public function getThreadName() : string{
		return "Console";
	}
}
