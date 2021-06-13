<?php

declare(strict_types=1);

namespace pocketmine\event\entity;

use pocketmine\block\Block;
use pocketmine\entity\Entity;
use pocketmine\event\Cancellable;
use pocketmine\event\CancellableTrait;
use pocketmine\utils\Utils;
use pocketmine\world\Position;

/**
 * Called when a entity explodes
 * @phpstan-extends EntityEvent<Entity>
 */
class EntityExplodeEvent extends EntityEvent implements Cancellable{
	use CancellableTrait;

	/** @var Position */
	protected $position;

	/** @var Block[] */
	protected $blocks;

	/** @var float */
	protected $yield;

	/**
	 * @param Block[]  $blocks
	 */
	public function __construct(Entity $entity, Position $position, array $blocks, float $yield){
		$this->entity = $entity;
		$this->position = $position;
		$this->blocks = $blocks;
		$this->yield = $yield;
	}

	public function getPosition() : Position{
		return $this->position;
	}

	/**
	 * @return Block[]
	 */
	public function getBlockList() : array{
		return $this->blocks;
	}

	/**
	 * @param Block[] $blocks
	 */
	public function setBlockList(array $blocks) : void{
		Utils::validateArrayValueType($blocks, function(Block $_) : void{});
		$this->blocks = $blocks;
	}

	public function getYield() : float{
		return $this->yield;
	}

	public function setYield(float $yield) : void{
		$this->yield = $yield;
	}
}
