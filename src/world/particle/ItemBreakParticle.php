<?php

declare(strict_types=1);

namespace pocketmine\world\particle;

use pocketmine\item\Item;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\LevelEventPacket;
use pocketmine\network\mcpe\protocol\types\ParticleIds;

class ItemBreakParticle implements Particle{
	/** @var Item */
	private $item;

	public function __construct(Item $item){
		$this->item = $item;
	}

	public function encode(Vector3 $pos) : array{
		return [LevelEventPacket::standardParticle(ParticleIds::ITEM_BREAK, ($this->item->getId() << 16) | $this->item->getMeta(), $pos)];
	}
}
