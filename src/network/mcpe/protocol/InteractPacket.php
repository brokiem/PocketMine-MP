<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class InteractPacket extends DataPacket implements ServerboundPacket{
	public const NETWORK_ID = ProtocolInfo::INTERACT_PACKET;

	public const ACTION_LEAVE_VEHICLE = 3;
	public const ACTION_MOUSEOVER = 4;
	public const ACTION_OPEN_NPC = 5;
	public const ACTION_OPEN_INVENTORY = 6;

	/** @var int */
	public $action;
	/** @var int */
	public $target;

	/** @var float */
	public $x;
	/** @var float */
	public $y;
	/** @var float */
	public $z;

	protected function decodePayload(PacketSerializer $in) : void{
		$this->action = $in->getByte();
		$this->target = $in->getEntityRuntimeId();

		if($this->action === self::ACTION_MOUSEOVER){
			//TODO: should this be a vector3?
			$this->x = $in->getLFloat();
			$this->y = $in->getLFloat();
			$this->z = $in->getLFloat();
		}
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putByte($this->action);
		$out->putEntityRuntimeId($this->target);

		if($this->action === self::ACTION_MOUSEOVER){
			$out->putLFloat($this->x);
			$out->putLFloat($this->y);
			$out->putLFloat($this->z);
		}
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleInteract($this);
	}
}
