<?php

declare(strict_types=1);

namespace pocketmine\entity\animation;

use pocketmine\entity\Human;
use pocketmine\item\Item;
use pocketmine\network\mcpe\convert\ItemTranslator;
use pocketmine\network\mcpe\protocol\ActorEventPacket;
use pocketmine\network\mcpe\protocol\ProtocolInfo;

final class ConsumingItemAnimation implements Animation{

	/** @var Human */
	private $human;
	/** @var Item */
	private $item;

	public function __construct(Human $human, Item $item){
		//TODO: maybe this can be expanded to more than just player entities?
		$this->human = $human;
		$this->item = $item;
	}

	public function encode() : array{
		[$netId, $netData] = ItemTranslator::getInstance()->toNetworkId(ProtocolInfo::CURRENT_PROTOCOL, $this->item->getId(), $this->item->getMeta());
		return [
			//TODO: need to check the data values
			ActorEventPacket::create($this->human->getId(), ActorEventPacket::EATING_ITEM, ($netId << 16) | $netData)
		];
	}
}
