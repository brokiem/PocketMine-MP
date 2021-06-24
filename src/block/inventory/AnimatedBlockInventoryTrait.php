<?php

declare(strict_types=1);

namespace pocketmine\block\inventory;

use pocketmine\player\Player;
use pocketmine\world\sound\Sound;
use function count;

trait AnimatedBlockInventoryTrait{
	use BlockInventoryTrait;

	public function getViewerCount() : int{
		return count($this->getViewers());
	}

	/**
	 * @return Player[]
	 * @phpstan-return array<int, Player>
	 */
	abstract public function getViewers() : array;

	abstract protected function getOpenSound() : Sound;

	abstract protected function getCloseSound() : Sound;

	public function onOpen(Player $who) : void{
		parent::onOpen($who);

		if($this->getHolder()->isValid() and $this->getViewerCount() === 1){
			//TODO: this crap really shouldn't be managed by the inventory
			$this->animateBlock(true);
			$this->getHolder()->getWorld()->addSound($this->getHolder()->add(0.5, 0.5, 0.5), $this->getOpenSound());
		}
	}

	abstract protected function animateBlock(bool $isOpen) : void;

	public function onClose(Player $who) : void{
		if($this->getHolder()->isValid() and $this->getViewerCount() === 1){
			//TODO: this crap really shouldn't be managed by the inventory
			$this->animateBlock(false);
			$this->getHolder()->getWorld()->addSound($this->getHolder()->add(0.5, 0.5, 0.5), $this->getCloseSound());
		}
		parent::onClose($who);
	}
}
