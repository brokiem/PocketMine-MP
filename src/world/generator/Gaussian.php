<?php

declare(strict_types=1);

namespace pocketmine\world\generator;

use function exp;

final class Gaussian{

	/** @var int */
	public $smoothSize;
	/** @var float[][] */
	public $kernel = [];

	public function __construct(int $smoothSize){
		$this->smoothSize = $smoothSize;

		$bellSize = 1 / $this->smoothSize;
		$bellHeight = 2 * $this->smoothSize;

		for($sx = -$this->smoothSize; $sx <= $this->smoothSize; ++$sx){
			$this->kernel[$sx + $this->smoothSize] = [];

			for($sz = -$this->smoothSize; $sz <= $this->smoothSize; ++$sz){
				$bx = $bellSize * $sx;
				$bz = $bellSize * $sz;
				$this->kernel[$sx + $this->smoothSize][$sz + $this->smoothSize] = $bellHeight * exp(-($bx * $bx + $bz * $bz) / 2);
			}
		}
	}
}
