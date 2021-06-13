<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;
use pocketmine\network\mcpe\protocol\types\inventory\ItemStackWrapper;
use Ramsey\Uuid\UuidInterface;
use function count;

class CraftingEventPacket extends DataPacket implements ServerboundPacket{
	public const NETWORK_ID = ProtocolInfo::CRAFTING_EVENT_PACKET;

	/** @var int */
	public $windowId;
	/** @var int */
	public $type;
	/** @var UuidInterface */
	public $id;
	/** @var ItemStackWrapper[] */
	public $input = [];
	/** @var ItemStackWrapper[] */
	public $output = [];

	protected function decodePayload(PacketSerializer $in) : void{
		$this->windowId = $in->getByte();
		$this->type = $in->getVarInt();
		$this->id = $in->getUUID();

		$size = $in->getUnsignedVarInt();
		if($in->getProtocolId() >= ProtocolInfo::PROTOCOL_1_16_220){
			for($i = 0; $i < $size and $i < 128; ++$i){
				$this->input[] = ItemStackWrapper::read($in);
			}
		}else{
			for($i = 0; $i < $size and $i < 128; ++$i){
				$this->input[] = ItemStackWrapper::legacy($in->getItemStackWithoutStackId());
			}
		}

		$size = $in->getUnsignedVarInt();
		if($in->getProtocolId() >= ProtocolInfo::PROTOCOL_1_16_220){
			for($i = 0; $i < $size and $i < 128; ++$i){
				$this->output[] = ItemStackWrapper::read($in);
			}
		}else{
			for($i = 0; $i < $size and $i < 128; ++$i){
				$this->output[] = ItemStackWrapper::legacy($in->getItemStackWithoutStackId());
			}
		}
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putByte($this->windowId);
		$out->putVarInt($this->type);
		$out->putUUID($this->id);

		$out->putUnsignedVarInt(count($this->input));
		if($out->getProtocolId() >= ProtocolInfo::PROTOCOL_1_16_220){
			foreach($this->input as $item){
				$item->write($out);
			}
		}else{
			foreach($this->input as $item){
				$out->putItemStackWithoutStackId($item->getItemStack());
			}
		}

		$out->putUnsignedVarInt(count($this->output));
		if($out->getProtocolId() >= ProtocolInfo::PROTOCOL_1_16_220){
			foreach($this->output as $item){
				$item->write($out);
			}
		}else{
			foreach($this->output as $item){
				$out->putItemStackWithoutStackId($item->getItemStack());
			}
		}
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleCraftingEvent($this);
	}
}
