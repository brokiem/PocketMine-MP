<?php

declare(strict_types=1);

namespace pocketmine\event\player;

use pocketmine\event\Cancellable;
use pocketmine\event\CancellableTrait;
use pocketmine\player\Player;

class PlayerTransferEvent extends PlayerEvent implements Cancellable{
	use CancellableTrait;

	/** @var string */
	protected $address;
	/** @var int */
	protected $port = 19132;
	/** @var string */
	protected $message;

	public function __construct(Player $player, string $address, int $port, string $message){
		$this->player = $player;
		$this->address = $address;
		$this->port = $port;
		$this->message = $message;
	}

	public function getAddress() : string{
		return $this->address;
	}

	public function setAddress(string $address) : void{
		$this->address = $address;
	}

	public function getPort() : int{
		return $this->port;
	}

	public function setPort(int $port) : void{
		$this->port = $port;
	}

	public function getMessage() : string{
		return $this->message;
	}

	public function setMessage(string $message) : void{
		$this->message = $message;
	}
}
