<?php

declare(strict_types=1);

namespace pocketmine\block\inventory;

use pocketmine\block\tile\EnderChest;
use pocketmine\inventory\DelegateInventory;
use pocketmine\inventory\Inventory;
use pocketmine\inventory\PlayerEnderInventory;
use pocketmine\network\mcpe\protocol\BlockEventPacket;
use pocketmine\player\Player;
use pocketmine\world\Position;
use pocketmine\world\sound\EnderChestCloseSound;
use pocketmine\world\sound\EnderChestOpenSound;
use pocketmine\world\sound\Sound;

/**
 * EnderChestInventory is not a real inventory; it's just a gateway to the player's ender inventory.
 */
class EnderChestInventory extends DelegateInventory implements BlockInventory{
	use AnimatedBlockInventoryTrait {
		onClose as animatedBlockInventoryTrait_onClose;
	}

	private PlayerEnderInventory $inventory;

	public function __construct(Position $holder, PlayerEnderInventory $inventory){
		parent::__construct($inventory);
		$this->holder = $holder;
		$this->inventory = $inventory;
	}

	public function getEnderInventory() : PlayerEnderInventory{
		return $this->inventory;
	}

	public function getViewerCount() : int{
		$enderChest = $this->getHolder()->getWorld()->getTile($this->getHolder());
		if(!$enderChest instanceof EnderChest){
			return 0;
		}
		return $enderChest->getViewerCount();
	}

	protected function getOpenSound() : Sound{
		return new EnderChestOpenSound();
	}

	protected function getCloseSound() : Sound{
		return new EnderChestCloseSound();
	}

	protected function animateBlock(bool $isOpen) : void{
		$holder = $this->getHolder();

		//event ID is always 1 for a chest
		$holder->getWorld()->broadcastPacketToViewers($holder, BlockEventPacket::create(1, $isOpen ? 1 : 0, $holder->asVector3()));
	}

	public function onClose(Player $who) : void{
		$this->animatedBlockInventoryTrait_onClose($who);
		$enderChest = $this->getHolder()->getWorld()->getTile($this->getHolder());
		if($enderChest instanceof EnderChest){
			$enderChest->setViewerCount($enderChest->getViewerCount() - 1);
		}
	}
}
