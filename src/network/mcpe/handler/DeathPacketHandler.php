<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\handler;

use pocketmine\network\mcpe\NetworkSession;
use pocketmine\network\mcpe\protocol\PlayerActionPacket;
use pocketmine\network\mcpe\protocol\RespawnPacket;
use pocketmine\player\Player;

class DeathPacketHandler extends PacketHandler{

	/** @var Player */
	private $player;
	/** @var NetworkSession */
	private $session;

	public function __construct(Player $player, NetworkSession $session){
		$this->player = $player;
		$this->session = $session;
	}

	public function setUp() : void{
		$this->session->sendDataPacket(RespawnPacket::create(
			$this->player->getOffsetPosition($this->player->getSpawn()),
			RespawnPacket::SEARCHING_FOR_SPAWN,
			$this->player->getId()
		));
	}

	public function handlePlayerAction(PlayerActionPacket $packet) : bool{
		if($packet->action === PlayerActionPacket::ACTION_RESPAWN){
			$this->player->respawn();
			return true;
		}

		return false;
	}

	public function handleRespawn(RespawnPacket $packet) : bool{
		if($packet->respawnState === RespawnPacket::CLIENT_READY_TO_SPAWN){
			$this->session->sendDataPacket(RespawnPacket::create(
				$this->player->getOffsetPosition($this->player->getSpawn()),
				RespawnPacket::READY_TO_SPAWN,
				$this->player->getId()
			));
			return true;
		}
		return false;
	}
}
