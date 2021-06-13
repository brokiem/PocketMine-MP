<?php

declare(strict_types=1);

namespace pocketmine\scheduler;

use pocketmine\utils\Utils;

/**
 * Task implementation which allows closures to be called by a scheduler.
 *
 * Example usage:
 *
 * ```
 * TaskScheduler->scheduleTask(new ClosureTask(function() : void{
 *     echo "HI\n";
 * });
 * ```
 */
class ClosureTask extends Task{

	/**
	 * @var \Closure
	 * @phpstan-var \Closure() : void
	 */
	private $closure;

	/**
	 * @param \Closure $closure Must accept zero parameters
	 * @phpstan-param \Closure() : void $closure
	 */
	public function __construct(\Closure $closure){
		Utils::validateCallableSignature(function() : void{}, $closure);
		$this->closure = $closure;
	}

	public function getName() : string{
		return Utils::getNiceClosureName($this->closure);
	}

	public function onRun() : void{
		($this->closure)();
	}
}
