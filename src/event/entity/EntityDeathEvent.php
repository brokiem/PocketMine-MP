<?php

declare(strict_types=1);

namespace pocketmine\event\entity;

use pocketmine\entity\Living;
use pocketmine\item\Item;
use pocketmine\utils\Utils;

/**
 * @phpstan-extends EntityEvent<Living>
 */
class EntityDeathEvent extends EntityEvent{
	/** @var Item[] */
	private $drops = [];
	/** @var int */
	private $xp;

	/**
	 * @param Item[] $drops
	 */
	public function __construct(Living $entity, array $drops = [], int $xp = 0){
		$this->entity = $entity;
		$this->drops = $drops;
		$this->xp = $xp;
	}

	/**
	 * @return Living
	 */
	public function getEntity(){
		return $this->entity;
	}

	/**
	 * @return Item[]
	 */
	public function getDrops() : array{
		return $this->drops;
	}

	/**
	 * @param Item[] $drops
	 */
	public function setDrops(array $drops) : void{
		Utils::validateArrayValueType($drops, function(Item $_) : void{});
		$this->drops = $drops;
	}

	/**
	 * Returns how much experience is dropped due to this entity's death.
	 */
	public function getXpDropAmount() : int{
		return $this->xp;
	}

	/**
	 * @throws \InvalidArgumentException
	 */
	public function setXpDropAmount(int $xp) : void{
		if($xp < 0){
			throw new \InvalidArgumentException("XP drop amount must not be negative");
		}
		$this->xp = $xp;
	}
}
