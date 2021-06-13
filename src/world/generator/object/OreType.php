<?php

declare(strict_types=1);

namespace pocketmine\world\generator\object;

use pocketmine\block\Block;

class OreType{
	/** @var Block */
	public $material;
	/** @var Block */
	public $replaces;
	/** @var int */
	public $clusterCount;
	/** @var int */
	public $clusterSize;
	/** @var int */
	public $maxHeight;
	/** @var int */
	public $minHeight;

	public function __construct(Block $material, Block $replaces, int $clusterCount, int $clusterSize, int $minHeight, int $maxHeight){
		$this->material = $material;
		$this->replaces = $replaces;
		$this->clusterCount = $clusterCount;
		$this->clusterSize = $clusterSize;
		$this->maxHeight = $maxHeight;
		$this->minHeight = $minHeight;
	}
}
