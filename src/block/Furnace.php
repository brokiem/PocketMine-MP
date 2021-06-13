<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\block\tile\Furnace as TileFurnace;
use pocketmine\block\utils\FacesOppositePlacingPlayerTrait;
use pocketmine\block\utils\NormalHorizontalFacingInMetadataTrait;
use pocketmine\item\Item;
use pocketmine\math\Vector3;
use pocketmine\player\Player;

class Furnace extends Opaque{
	use FacesOppositePlacingPlayerTrait;
	use NormalHorizontalFacingInMetadataTrait {
		readStateFromData as readFacingStateFromData;
	}

	protected BlockIdentifierFlattened $idInfoFlattened;

	protected bool $lit = false; //this is set based on the blockID

	public function __construct(BlockIdentifierFlattened $idInfo, string $name, BlockBreakInfo $breakInfo){
		$this->idInfoFlattened = $idInfo;
		parent::__construct($idInfo, $name, $breakInfo);
	}

	public function getId() : int{
		return $this->lit ? $this->idInfoFlattened->getSecondId() : parent::getId();
	}

	public function readStateFromData(int $id, int $stateMeta) : void{
		$this->readFacingStateFromData($id, $stateMeta);
		$this->lit = $id === $this->idInfoFlattened->getSecondId();
	}

	public function getLightLevel() : int{
		return $this->lit ? 13 : 0;
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

	public function onInteract(Item $item, int $face, Vector3 $clickVector, ?Player $player = null) : bool{
		if($player instanceof Player){
			$furnace = $this->pos->getWorld()->getTile($this->pos);
			if($furnace instanceof TileFurnace and $furnace->canOpenWith($item->getCustomName())){
				$player->setCurrentWindow($furnace->getInventory());
			}
		}

		return true;
	}

	public function onScheduledUpdate() : void{
		$furnace = $this->pos->getWorld()->getTile($this->pos);
		if($furnace instanceof TileFurnace and $furnace->onUpdate()){
			$this->pos->getWorld()->scheduleDelayedBlockUpdate($this->pos, 1); //TODO: check this
		}
	}
}
