<?php

declare(strict_types=1);

namespace pocketmine\block\utils;

trait PoweredByRedstoneTrait{
	protected bool $powered = false;

	public function isPowered() : bool{ return $this->powered; }

	/** @return $this */
	public function setPowered(bool $powered) : self{
		$this->powered = $powered;
		return $this;
	}
}
