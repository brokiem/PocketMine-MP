<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;
use pocketmine\network\mcpe\protocol\types\inventory\stackrequest\ItemStackRequest;
use function count;

class ItemStackRequestPacket extends DataPacket implements ServerboundPacket{
	public const NETWORK_ID = ProtocolInfo::ITEM_STACK_REQUEST_PACKET;

	/** @var ItemStackRequest[] */
	private $requests;

	/**
	 * @param ItemStackRequest[] $requests
	 */
	public static function create(array $requests) : self{
		$result = new self;
		$result->requests = $requests;
		return $result;
	}

	/** @return ItemStackRequest[] */
	public function getRequests() : array{ return $this->requests; }

	protected function decodePayload(PacketSerializer $in) : void{
		$this->requests = [];
		for($i = 0, $len = $in->getUnsignedVarInt(); $i < $len; ++$i){
			$this->requests[] = ItemStackRequest::read($in);
		}
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putUnsignedVarInt(count($this->requests));
		foreach($this->requests as $request){
			$request->write($out);
		}
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleItemStackRequest($this);
	}
}
