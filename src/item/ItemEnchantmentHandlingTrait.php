<?php

declare(strict_types=1);

namespace pocketmine\item;

use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\EnchantmentInstance;
use function count;

/**
 * This trait encapsulates all enchantment handling needed for itemstacks.
 * The primary purpose of this trait is providing scope isolation for the methods it contains.
 */
trait ItemEnchantmentHandlingTrait{
	/** @var EnchantmentInstance[] */
	protected $enchantments = [];

	public function hasEnchantments() : bool{
		return count($this->enchantments) > 0;
	}

	public function hasEnchantment(Enchantment $enchantment, int $level = -1) : bool{
		$id = $enchantment->getRuntimeId();
		return isset($this->enchantments[$id]) and ($level === -1 or $this->enchantments[$id]->getLevel() === $level);
	}

	public function getEnchantment(Enchantment $enchantment) : ?EnchantmentInstance{
		return $this->enchantments[$enchantment->getRuntimeId()] ?? null;
	}

	/**
	 * @return $this
	 */
	public function removeEnchantment(Enchantment $enchantment, int $level = -1) : self{
		$instance = $this->getEnchantment($enchantment);
		if($instance !== null and ($level === -1 or $instance->getLevel() === $level)){
			unset($this->enchantments[$enchantment->getRuntimeId()]);
		}

		return $this;
	}

	/**
	 * @return $this
	 */
	public function removeEnchantments() : self{
		$this->enchantments = [];
		return $this;
	}

	/**
	 * @return $this
	 */
	public function addEnchantment(EnchantmentInstance $enchantment) : self{
		$this->enchantments[$enchantment->getRuntimeId()] = $enchantment;
		return $this;
	}

	/**
	 * @return EnchantmentInstance[]
	 */
	public function getEnchantments() : array{
		return $this->enchantments;
	}

	/**
	 * Returns the level of the enchantment on this item with the specified ID, or 0 if the item does not have the
	 * enchantment.
	 */
	public function getEnchantmentLevel(Enchantment $enchantment) : int{
		return ($instance = $this->getEnchantment($enchantment)) !== null ? $instance->getLevel() : 0;
	}
}
