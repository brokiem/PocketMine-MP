<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;
use pocketmine\network\mcpe\protocol\types\CacheableNbt;
use pocketmine\network\mcpe\protocol\types\inventory\WindowTypes;

class UpdateTradePacket extends DataPacket implements ClientboundPacket{
	public const NETWORK_ID = ProtocolInfo::UPDATE_TRADE_PACKET;

	//TODO: find fields

	/** @var int */
	public $windowId;
	/** @var int */
	public $windowType = WindowTypes::TRADING; //Mojang hardcoded this -_-
	/** @var int */
	public $windowSlotCount = 0; //useless, seems to be part of a standard container header
	/** @var int */
	public $tradeTier;
	/** @var int */
	public $traderEid;
	/** @var int */
	public $playerEid;
	/** @var string */
	public $displayName;
	/** @var bool */
	public $isV2Trading;
	/** @var bool */
	public $isWilling;
	/**
	 * @var CacheableNbt
	 * @phpstan-var CacheableNbt<\pocketmine\nbt\tag\CompoundTag>
	 */
	public $offers;

	protected function decodePayload(PacketSerializer $in) : void{
		$this->windowId = $in->getByte();
		$this->windowType = $in->getByte();
		$this->windowSlotCount = $in->getVarInt();
		$this->tradeTier = $in->getVarInt();
		$this->traderEid = $in->getEntityUniqueId();
		$this->playerEid = $in->getEntityUniqueId();
		$this->displayName = $in->getString();
		$this->isV2Trading = $in->getBool();
		$this->isWilling = $in->getBool();
		$this->offers = new CacheableNbt($in->getNbtCompoundRoot());
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putByte($this->windowId);
		$out->putByte($this->windowType);
		$out->putVarInt($this->windowSlotCount);
		$out->putVarInt($this->tradeTier);
		$out->putEntityUniqueId($this->traderEid);
		$out->putEntityUniqueId($this->playerEid);
		$out->putString($this->displayName);
		$out->putBool($this->isV2Trading);
		$out->putBool($this->isWilling);
		$out->put($this->offers->getEncodedNbt());
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleUpdateTrade($this);
	}
}
