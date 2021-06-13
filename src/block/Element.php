<?php

declare(strict_types=1);

namespace pocketmine\block;

class Element extends Opaque{

	private int $atomicWeight;
	private int $group;
	private string $symbol;

	public function __construct(BlockIdentifier $idInfo, string $name, BlockBreakInfo $breakInfo, string $symbol, int $atomicWeight, int $group){
		parent::__construct($idInfo, $name, $breakInfo);
		$this->atomicWeight = $atomicWeight;
		$this->group = $group;
		$this->symbol = $symbol;
	}

	public function getAtomicWeight() : int{
		return $this->atomicWeight;
	}

	public function getGroup() : int{
		return $this->group;
	}

	public function getSymbol() : string{
		return $this->symbol;
	}
}
