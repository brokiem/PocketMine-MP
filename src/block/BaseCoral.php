<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\block\utils\CoralType;
use pocketmine\item\Item;

abstract class BaseCoral extends Transparent{

	protected CoralType $coralType;
	protected bool $dead = false;

	public function __construct(BlockIdentifier $idInfo, string $name, BlockBreakInfo $breakInfo){
		parent::__construct($idInfo, $name, $breakInfo);
		$this->coralType = CoralType::TUBE();
	}

	public function getCoralType() : CoralType{ return $this->coralType; }

	/** @return $this */
	public function setCoralType(CoralType $coralType) : self{
		$this->coralType = $coralType;
		return $this;
	}

	public function isDead() : bool{ return $this->dead; }

	/** @return $this */
	public function setDead(bool $dead) : self{
		$this->dead = $dead;
		return $this;
	}

	public function onNearbyBlockChange() : void{
		if(!$this->dead){
			$world = $this->pos->getWorld();

			$hasWater = false;
			foreach($this->pos->sides() as $vector3){
				if($world->getBlock($vector3) instanceof Water){
					$hasWater = true;
					break;
				}
			}

			//TODO: check water inside the block itself (not supported on the API yet)
			if(!$hasWater){
				$world->setBlock($this->pos, $this->setDead(true));
			}
		}
	}

	public function getDropsForCompatibleTool(Item $item) : array{
		return [];
	}

	public function isAffectedBySilkTouch() : bool{
		return true;
	}

	public function isSolid() : bool{ return false; }

	protected function recalculateCollisionBoxes() : array{ return []; }
}
