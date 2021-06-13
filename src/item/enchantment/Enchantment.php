<?php

declare(strict_types=1);

namespace pocketmine\item\enchantment;

/**
 * Manages enchantment type data.
 */
class Enchantment{

	/** @var int */
	private $internalRuntimeId;
	/** @var string */
	private $name;
	/** @var int */
	private $rarity;
	/** @var int */
	private $primaryItemFlags;
	/** @var int */
	private $secondaryItemFlags;
	/** @var int */
	private $maxLevel;

	public function __construct(int $internalRuntimeId, string $name, int $rarity, int $primaryItemFlags, int $secondaryItemFlags, int $maxLevel){
		$this->internalRuntimeId = $internalRuntimeId;
		$this->name = $name;
		$this->rarity = $rarity;
		$this->primaryItemFlags = $primaryItemFlags;
		$this->secondaryItemFlags = $secondaryItemFlags;
		$this->maxLevel = $maxLevel;
	}

	/**
	 * Returns the internal runtime ID of this enchantment.
	 * WARNING: DO NOT STORE THIS IDENTIFIER - IT MAY CHANGE AFTER RESTART
	 */
	public function getRuntimeId() : int{
		return $this->internalRuntimeId;
	}

	/**
	 * Returns a translation key for this enchantment's name.
	 */
	public function getName() : string{
		return $this->name;
	}

	/**
	 * Returns an int constant indicating how rare this enchantment type is.
	 */
	public function getRarity() : int{
		return $this->rarity;
	}

	/**
	 * Returns a bitset indicating what item types can have this item applied from an enchanting table.
	 */
	public function getPrimaryItemFlags() : int{
		return $this->primaryItemFlags;
	}

	/**
	 * Returns a bitset indicating what item types cannot have this item applied from an enchanting table, but can from
	 * an anvil.
	 */
	public function getSecondaryItemFlags() : int{
		return $this->secondaryItemFlags;
	}

	/**
	 * Returns whether this enchantment can apply to the item type from an enchanting table.
	 */
	public function hasPrimaryItemType(int $flag) : bool{
		return ($this->primaryItemFlags & $flag) !== 0;
	}

	/**
	 * Returns whether this enchantment can apply to the item type from an anvil, if it is not a primary item.
	 */
	public function hasSecondaryItemType(int $flag) : bool{
		return ($this->secondaryItemFlags & $flag) !== 0;
	}

	/**
	 * Returns the maximum level of this enchantment that can be found on an enchantment table.
	 */
	public function getMaxLevel() : int{
		return $this->maxLevel;
	}

	//TODO: methods for min/max XP cost bounds based on enchantment level (not needed yet - enchanting is client-side)
}
