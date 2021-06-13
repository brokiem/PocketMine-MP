<?php

declare(strict_types=1);

namespace pocketmine\entity\effect;

use pocketmine\color\Color;
use pocketmine\entity\Entity;
use pocketmine\entity\Living;
use pocketmine\event\entity\EntityDamageEvent;

class PoisonEffect extends Effect{

	/** @var bool */
	private $fatal;

	public function __construct(int $internalRuntimeId, string $name, Color $color, bool $isBad = false, bool $hasBubbles = true, bool $fatal = false){
		parent::__construct($internalRuntimeId, $name, $color, $isBad, $hasBubbles);
		$this->fatal = $fatal;
	}

	public function canTick(EffectInstance $instance) : bool{
		if(($interval = (25 >> $instance->getAmplifier())) > 0){
			return ($instance->getDuration() % $interval) === 0;
		}
		return true;
	}

	public function applyEffect(Living $entity, EffectInstance $instance, float $potency = 1.0, ?Entity $source = null) : void{
		if($entity->getHealth() > 1 or $this->fatal){
			$ev = new EntityDamageEvent($entity, EntityDamageEvent::CAUSE_MAGIC, 1);
			$entity->attack($ev);
		}
	}
}
