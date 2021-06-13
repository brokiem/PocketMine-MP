<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\block\utils\InvalidBlockStateException;
use pocketmine\data\bedrock\CoralTypeIdMap;
use pocketmine\item\Item;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use pocketmine\world\BlockTransaction;

final class Coral extends BaseCoral{

	public function readStateFromData(int $id, int $stateMeta) : void{
		$coralType = CoralTypeIdMap::getInstance()->fromId($stateMeta);
		if($coralType === null){
			throw new InvalidBlockStateException("No such coral type");
		}
		$this->coralType = $coralType;
	}

	public function writeStateToMeta() : int{
		return CoralTypeIdMap::getInstance()->toId($this->coralType);
	}

	public function getStateBitmask() : int{
		return 0b0111;
	}

	public function getNonPersistentStateBitmask() : int{
		return 0b0000;
	}

	public function readStateFromWorld() : void{
		//TODO: this hack ensures correct state of coral plants, because they don't retain their dead flag in metadata
		$world = $this->pos->getWorld();
		$this->dead = true;
		foreach($this->pos->sides() as $vector3){
			if($world->getBlock($vector3) instanceof Water){
				$this->dead = false;
				break;
			}
		}
	}

	public function place(BlockTransaction $tx, Item $item, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector, ?Player $player = null) : bool{
		if(!$tx->fetchBlock($blockReplace->getPos()->down())->isSolid()){
			return false;
		}
		return parent::place($tx, $item, $blockReplace, $blockClicked, $face, $clickVector, $player);
	}

	public function onNearbyBlockChange() : void{
		$world = $this->pos->getWorld();
		if(!$world->getBlock($this->pos->down())->isSolid()){
			$world->useBreakOn($this->pos);
		}else{
			parent::onNearbyBlockChange();
		}
	}
}
