<?php

declare(strict_types=1);

namespace pocketmine\utils;

/**
 * @phpstan-template TPriority
 * @phpstan-template TValue
 * @phpstan-extends \SplPriorityQueue<TPriority, TValue>
 */
class ReversePriorityQueue extends \SplPriorityQueue{

	/**
	 * @param mixed $priority1
	 * @param mixed $priority2
	 * @phpstan-param TPriority $priority1
	 * @phpstan-param TPriority $priority2
	 *
	 * @return int
	 */
	public function compare($priority1, $priority2){
		//TODO: this will crash if non-numeric priorities are used
		return (int) -($priority1 - $priority2);
	}
}
