<?php

declare(strict_types=1);

namespace pocketmine\item;

abstract class TieredTool extends Tool{

	/** @var ToolTier */
	protected $tier;

	public function __construct(ItemIdentifier $identifier, string $name, ToolTier $tier){
		parent::__construct($identifier, $name);
		$this->tier = $tier;
	}

	public function getMaxDurability() : int{
		return $this->tier->getMaxDurability();
	}

	public function getTier() : ToolTier{
		return $this->tier;
	}

	protected function getBaseMiningEfficiency() : float{
		return $this->tier->getBaseEfficiency();
	}

	public function getFuelTime() : int{
		if($this->tier->equals(ToolTier::WOOD())){
			return 200;
		}

		return 0;
	}
}
