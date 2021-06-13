<?php

declare(strict_types=1);

namespace pocketmine\item;

use pocketmine\block\Block;
use pocketmine\block\Lava;
use pocketmine\block\Liquid;
use pocketmine\event\player\PlayerBucketEmptyEvent;
use pocketmine\math\Vector3;
use pocketmine\player\Player;

class LiquidBucket extends Item{

	/** @var Liquid */
	private $liquid;

	public function __construct(ItemIdentifier $identifier, string $name, Liquid $liquid){
		parent::__construct($identifier, $name);
		$this->liquid = $liquid;
	}

	public function getMaxStackSize() : int{
		return 1;
	}

	public function getFuelTime() : int{
		if($this->liquid instanceof Lava){
			return 20000;
		}

		return 0;
	}

	public function getFuelResidue() : Item{
		return VanillaItems::BUCKET();
	}

	public function onInteractBlock(Player $player, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector) : ItemUseResult{
		if(!$blockReplace->canBeReplaced()){
			return ItemUseResult::NONE();
		}

		//TODO: move this to generic placement logic
		$resultBlock = clone $this->liquid;

		$ev = new PlayerBucketEmptyEvent($player, $blockReplace, $face, $this, VanillaItems::BUCKET());
		$ev->call();
		if(!$ev->isCancelled()){
			$player->getWorld()->setBlock($blockReplace->getPos(), $resultBlock->getFlowingForm());
			$player->getWorld()->addSound($blockReplace->getPos()->add(0.5, 0.5, 0.5), $resultBlock->getBucketEmptySound());

			if($player->hasFiniteResources()){
				$player->getInventory()->setItemInHand($ev->getItem());
			}
			return ItemUseResult::SUCCESS();
		}

		return ItemUseResult::FAIL();
	}

	public function getLiquid() : Liquid{
		return $this->liquid;
	}
}
