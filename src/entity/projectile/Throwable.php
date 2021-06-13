<?php

declare(strict_types=1);

namespace pocketmine\entity\projectile;

use pocketmine\block\Block;
use pocketmine\entity\EntitySizeInfo;
use pocketmine\math\RayTraceResult;

abstract class Throwable extends Projectile{

	protected $gravity = 0.03;
	protected $drag = 0.01;

	protected function getInitialSizeInfo() : EntitySizeInfo{ return new EntitySizeInfo(0.25, 0.25); }

	protected function onHitBlock(Block $blockHit, RayTraceResult $hitResult) : void{
		parent::onHitBlock($blockHit, $hitResult);
		$this->flagForDespawn();
	}
}
