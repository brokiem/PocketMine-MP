<?php

declare(strict_types=1);

namespace pocketmine\event\player;

use pocketmine\event\Cancellable;
use pocketmine\event\CancellableTrait;
use pocketmine\event\Event;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\player\Player;

/**
 * Called when a player's data is about to be saved to disk.
 */
class PlayerDataSaveEvent extends Event implements Cancellable{
	use CancellableTrait;

	/** @var CompoundTag */
	protected $data;
	/** @var string */
	protected $playerName;
	/** @var Player|null */
	private $player;

	public function __construct(CompoundTag $nbt, string $playerName, ?Player $player){
		$this->data = $nbt;
		$this->playerName = $playerName;
		$this->player = $player;
	}

	/**
	 * Returns the data to be written to disk as a CompoundTag
	 */
	public function getSaveData() : CompoundTag{
		return $this->data;
	}

	public function setSaveData(CompoundTag $data) : void{
		$this->data = $data;
	}

	/**
	 * Returns the username of the player whose data is being saved. This is not necessarily an online player.
	 */
	public function getPlayerName() : string{
		return $this->playerName;
	}

	/**
	 * Returns the player whose data is being saved, if online.
	 * If null, this data is for an offline player (possibly just disconnected).
	 */
	public function getPlayer() : ?Player{
		return $this->player;
	}
}
