<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\block\utils\PoweredByRedstoneTrait;

class RedstoneLamp extends Opaque{
	use PoweredByRedstoneTrait;

	protected BlockIdentifierFlattened $idInfoFlattened;

	public function __construct(BlockIdentifierFlattened $idInfo, string $name, BlockBreakInfo $breakInfo){
		$this->idInfoFlattened = $idInfo;
		parent::__construct($idInfo, $name, $breakInfo);
	}

	public function getId() : int{
		return $this->powered ? $this->idInfoFlattened->getSecondId() : parent::getId();
	}

	public function readStateFromData(int $id, int $stateMeta) : void{
		$this->powered = $id === $this->idInfoFlattened->getSecondId();
	}

	public function getLightLevel() : int{
		return $this->powered ? 15 : 0;
	}
}
