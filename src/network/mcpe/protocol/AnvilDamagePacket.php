<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

class AnvilDamagePacket extends DataPacket implements ServerboundPacket{
	public const NETWORK_ID = ProtocolInfo::ANVIL_DAMAGE_PACKET;

	/** @var int */
	private $x;
	/** @var int */
	private $y;
	/** @var int */
	private $z;
	/** @var int */
	private $damageAmount;

	public static function create(int $x, int $y, int $z, int $damageAmount) : self{
		$result = new self;
		[$result->x, $result->y, $result->z] = [$x, $y, $z];
		$result->damageAmount = $damageAmount;
		return $result;
	}

	public function getDamageAmount() : int{
		return $this->damageAmount;
	}

	public function getX() : int{
		return $this->x;
	}

	public function getY() : int{
		return $this->y;
	}

	public function getZ() : int{
		return $this->z;
	}

	protected function decodePayload(PacketSerializer $in) : void{
		$this->damageAmount = $in->getByte();
		$in->getBlockPosition($this->x, $this->y, $this->z);
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putByte($this->damageAmount);
		$out->putBlockPosition($this->x, $this->y, $this->z);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleAnvilDamage($this);
	}
}
