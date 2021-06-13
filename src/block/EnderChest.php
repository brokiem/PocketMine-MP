<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\block\inventory\EnderChestInventory;
use pocketmine\block\tile\EnderChest as TileEnderChest;
use pocketmine\block\utils\FacesOppositePlacingPlayerTrait;
use pocketmine\block\utils\NormalHorizontalFacingInMetadataTrait;
use pocketmine\item\Item;
use pocketmine\math\AxisAlignedBB;
use pocketmine\math\Facing;
use pocketmine\math\Vector3;
use pocketmine\player\Player;

class EnderChest extends Transparent{
	use FacesOppositePlacingPlayerTrait;
	use NormalHorizontalFacingInMetadataTrait;

	public function getLightLevel() : int{
		return 7;
	}

	/**
	 * @return AxisAlignedBB[]
	 */
	protected function recalculateCollisionBoxes() : array{
		//these are slightly bigger than in PC
		return [AxisAlignedBB::one()->contract(0.025, 0, 0.025)->trim(Facing::UP, 0.05)];
	}

	public function onInteract(Item $item, int $face, Vector3 $clickVector, ?Player $player = null) : bool{
		if($player instanceof Player){
			$enderChest = $this->pos->getWorld()->getTile($this->pos);
			if($enderChest instanceof TileEnderChest and $this->getSide(Facing::UP)->isTransparent()){
				$player->setCurrentWindow(new EnderChestInventory($this->pos, $player->getEnderInventory()));
			}
		}

		return true;
	}

	public function getDropsForCompatibleTool(Item $item) : array{
		return [
			VanillaBlocks::OBSIDIAN()->asItem()->setCount(8)
		];
	}
}
