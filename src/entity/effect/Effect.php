<?php

declare(strict_types=1);

namespace pocketmine\entity\effect;

use pocketmine\color\Color;
use pocketmine\entity\Entity;
use pocketmine\entity\Living;

class Effect{

	/** @var int */
	protected $internalRuntimeId;
	/** @var string */
	protected $name;
	/** @var Color */
	protected $color;
	/** @var bool */
	protected $bad;
	/** @var bool */
	protected $hasBubbles;

	/**
	 * @param int    $internalRuntimeId Internal runtime ID, unique to this effect type. Used for comparisons.
	 * @param string $name Translation key used for effect name
	 * @param Color  $color Color of bubbles given by this effect
	 * @param bool   $isBad Whether the effect is harmful
	 * @param bool   $hasBubbles Whether the effect has potion bubbles. Some do not (e.g. Instant Damage has its own particles instead of bubbles)
	 */
	public function __construct(int $internalRuntimeId, string $name, Color $color, bool $isBad = false, bool $hasBubbles = true){
		$this->internalRuntimeId = $internalRuntimeId;
		$this->name = $name;
		$this->color = $color;
		$this->bad = $isBad;
		$this->hasBubbles = $hasBubbles;
	}

	/**
	 * Returns a unique identifier for this effect type
	 * WARNING: DO NOT STORE THIS - IT MAY CHANGE BETWEEN RESTARTS
	 */
	public function getRuntimeId() : int{
		return $this->internalRuntimeId;
	}

	/**
	 * Returns the translation key used to translate this effect's name.
	 */
	public function getName() : string{
		return $this->name;
	}

	/**
	 * Returns a Color object representing this effect's particle colour.
	 */
	public function getColor() : Color{
		return $this->color;
	}

	/**
	 * Returns whether this effect is harmful.
	 * TODO: implement inverse effect results for undead mobs
	 */
	public function isBad() : bool{
		return $this->bad;
	}

	/**
	 * Returns the default duration (in ticks) this effect will apply for if a duration is not specified.
	 */
	public function getDefaultDuration() : int{
		return 600;
	}

	/**
	 * Returns whether this effect will give the subject potion bubbles.
	 */
	public function hasBubbles() : bool{
		return $this->hasBubbles;
	}

	/**
	 * Returns whether the effect will do something on the current tick.
	 */
	public function canTick(EffectInstance $instance) : bool{
		return false;
	}

	/**
	 * Applies effect results to an entity. This will not be called unless canTick() returns true.
	 */
	public function applyEffect(Living $entity, EffectInstance $instance, float $potency = 1.0, ?Entity $source = null) : void{

	}

	/**
	 * Applies effects to the entity when the effect is first added.
	 */
	public function add(Living $entity, EffectInstance $instance) : void{

	}

	/**
	 * Removes the effect from the entity, resetting any changed values back to their original defaults.
	 */
	public function remove(Living $entity, EffectInstance $instance) : void{

	}
}
