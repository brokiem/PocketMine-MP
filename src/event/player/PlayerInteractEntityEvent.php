<?php

declare(strict_types=1);

namespace pocketmine\event\player;

use pocketmine\entity\Entity;
use pocketmine\event\Cancellable;
use pocketmine\event\CancellableTrait;
use pocketmine\math\Vector3;
use pocketmine\player\Player;

class PlayerInteractEntityEvent extends PlayerEvent implements Cancellable{
	use CancellableTrait;

	private Vector3 $clickPos;
	private Entity $entity;

	public function __construct(Player $player, Entity $entity, Vector3 $clickPos){
		$this->player = $player;
		$this->entity = $entity;
		$this->clickPos = $clickPos;
	}

	public function getEntity() : Entity{
		return $this->entity;
	}

	public function getClickPos() : Vector3{
		return $this->clickPos;
	}
}