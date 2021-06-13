<?php

declare(strict_types=1);

namespace pocketmine\block\inventory;

use pocketmine\block\Barrel;
use pocketmine\inventory\SimpleInventory;
use pocketmine\world\Position;
use pocketmine\world\sound\BarrelCloseSound;
use pocketmine\world\sound\BarrelOpenSound;
use pocketmine\world\sound\Sound;

class BarrelInventory extends SimpleInventory implements BlockInventory{
	use AnimatedBlockInventoryTrait;

	public function __construct(Position $holder){
		$this->holder = $holder;
		parent::__construct(27);
	}

	protected function getOpenSound() : Sound{
		return new BarrelOpenSound();
	}

	protected function getCloseSound() : Sound{
		return new BarrelCloseSound();
	}

	protected function animateBlock(bool $isOpen) : void{
		$holder = $this->getHolder();
		$block = $holder->getWorld()->getBlock($holder);
		if($block instanceof Barrel){
			$holder->getWorld()->setBlock($holder, $block->setOpen($isOpen));
		}
	}
}
