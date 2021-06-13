<?php

declare(strict_types=1);

namespace pocketmine\world\light;

final class LightPropagationContext{

	/**
	 * @var \SplQueue
	 * @phpstan-var \SplQueue<array{int, int, int}>
	 */
	public $spreadQueue;
	/**
	 * @var true[]
	 * @phpstan-var array<int, true>
	 */
	public $spreadVisited = [];

	/**
	 * @var \SplQueue
	 * @phpstan-var \SplQueue<array{int, int, int, int}>
	 */
	public $removalQueue;
	/**
	 * @var true[]
	 * @phpstan-var array<int, true>
	 */
	public $removalVisited = [];

	public function __construct(){
		$this->removalQueue = new \SplQueue();
		$this->spreadQueue = new \SplQueue();
	}
}
