<?php

declare(strict_types=1);

namespace pocketmine\event\entity;

use pocketmine\entity\effect\VanillaEffects;
use pocketmine\entity\Entity;
use pocketmine\entity\Living;

/**
 * Called when an entity takes damage from another entity.
 */
class EntityDamageByEntityEvent extends EntityDamageEvent{
	/** @var int */
	private $damagerEntityId;
	/** @var float */
	private $knockBack;

	/**
	 * @param float[] $modifiers
	 */
	public function __construct(Entity $damager, Entity $entity, int $cause, float $damage, array $modifiers = [], float $knockBack = 0.4){
		$this->damagerEntityId = $damager->getId();
		$this->knockBack = $knockBack;
		parent::__construct($entity, $cause, $damage, $modifiers);
		$this->addAttackerModifiers($damager);
	}

	protected function addAttackerModifiers(Entity $damager) : void{
		if($damager instanceof Living){ //TODO: move this to entity classes
			$effects = $damager->getEffects();
			if(($strength = $effects->get(VanillaEffects::STRENGTH())) !== null){
				$this->setModifier($this->getBaseDamage() * 0.3 * $strength->getEffectLevel(), self::MODIFIER_STRENGTH);
			}

			if(($weakness = $effects->get(VanillaEffects::WEAKNESS())) !== null){
				$this->setModifier(-($this->getBaseDamage() * 0.2 * $weakness->getEffectLevel()), self::MODIFIER_WEAKNESS);
			}
		}
	}

	/**
	 * Returns the attacking entity, or null if the attacker has been killed or closed.
	 */
	public function getDamager() : ?Entity{
		return $this->getEntity()->getWorld()->getServer()->getWorldManager()->findEntity($this->damagerEntityId);
	}

	public function getKnockBack() : float{
		return $this->knockBack;
	}

	public function setKnockBack(float $knockBack) : void{
		$this->knockBack = $knockBack;
	}
}
