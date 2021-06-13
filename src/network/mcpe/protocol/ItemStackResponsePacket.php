<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;
use pocketmine\network\mcpe\protocol\types\inventory\stackresponse\ItemStackResponse;
use function count;

class ItemStackResponsePacket extends DataPacket implements ClientboundPacket{
	public const NETWORK_ID = ProtocolInfo::ITEM_STACK_RESPONSE_PACKET;

	/** @var ItemStackResponse[] */
	private $responses;

	/**
	 * @param ItemStackResponse[] $responses
	 */
	public static function create(array $responses) : self{
		$result = new self;
		$result->responses = $responses;
		return $result;
	}

	/** @return ItemStackResponse[] */
	public function getResponses() : array{ return $this->responses; }

	protected function decodePayload(PacketSerializer $in) : void{
		$this->responses = [];
		for($i = 0, $len = $in->getUnsignedVarInt(); $i < $len; ++$i){
			$this->responses[] = ItemStackResponse::read($in);
		}
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putUnsignedVarInt(count($this->responses));
		foreach($this->responses as $response){
			$response->write($out);
		}
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleItemStackResponse($this);
	}
}
