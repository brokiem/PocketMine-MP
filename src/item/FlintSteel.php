<?php

declare(strict_types=1);

namespace pocketmine\item;

use pocketmine\block\Block;
use pocketmine\block\BlockLegacyIds;
use pocketmine\block\VanillaBlocks;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use pocketmine\world\sound\FlintSteelSound;

class FlintSteel extends Tool{

	public function onInteractBlock(Player $player, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector) : ItemUseResult{
		if($blockReplace->getId() === BlockLegacyIds::AIR){
			$world = $player->getWorld();
			$world->setBlock($blockReplace->getPos(), VanillaBlocks::FIRE());
			$world->addSound($blockReplace->getPos()->add(0.5, 0.5, 0.5), new FlintSteelSound());

			$this->applyDamage(1);

			return ItemUseResult::SUCCESS();
		}

		return ItemUseResult::NONE();
	}

	public function getMaxDurability() : int{
		return 65;
	}
}
