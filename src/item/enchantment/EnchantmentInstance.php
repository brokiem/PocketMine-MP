<?php

declare(strict_types=1);

namespace pocketmine\item\enchantment;

/**
 * Container for enchantment data applied to items.
 *
 * Note: This class is assumed to be immutable. Consider this before making alterations.
 */
final class EnchantmentInstance{
	/** @var Enchantment */
	private $enchantment;
	/** @var int */
	private $level;

	/**
	 * EnchantmentInstance constructor.
	 *
	 * @param Enchantment $enchantment Enchantment type
	 * @param int         $level Level of enchantment
	 */
	public function __construct(Enchantment $enchantment, int $level = 1){
		$this->enchantment = $enchantment;
		$this->level = $level;
	}

	/**
	 * Returns the type of this enchantment.
	 */
	public function getType() : Enchantment{
		return $this->enchantment;
	}

	/**
	 * Returns the runtime type identifier of this enchantment instance.
	 * WARNING: DO NOT STORE THIS IDENTIFIER - IT MAY CHANGE AFTER SERVER RESTART
	 */
	public function getRuntimeId() : int{
		return $this->enchantment->getRuntimeId();
	}

	/**
	 * Returns the level of the enchantment.
	 */
	public function getLevel() : int{
		return $this->level;
	}
}
