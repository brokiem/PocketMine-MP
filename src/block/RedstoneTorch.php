<?php

declare(strict_types=1);

namespace pocketmine\block;

class RedstoneTorch extends Torch{

	protected BlockIdentifierFlattened $idInfoFlattened;

	protected bool $lit = true;

	public function __construct(BlockIdentifierFlattened $idInfo, string $name, BlockBreakInfo $breakInfo){
		$this->idInfoFlattened = $idInfo;
		parent::__construct($idInfo, $name, $breakInfo);
	}

	public function getId() : int{
		return $this->lit ? parent::getId() : $this->idInfoFlattened->getSecondId();
	}

	public function readStateFromData(int $id, int $stateMeta) : void{
		parent::readStateFromData($id, $stateMeta);
		$this->lit = $id !== $this->idInfoFlattened->getSecondId();
	}

	public function isLit() : bool{
		return $this->lit;
	}

	/**
	 * @return $this
	 */
	public function setLit(bool $lit = true) : self{
		$this->lit = $lit;
		return $this;
	}

	public function getLightLevel() : int{
		return $this->lit ? 7 : 0;
	}
}
