<?php

declare(strict_types=1);

namespace pocketmine\block\utils;

use pocketmine\block\BaseBanner;

/**
 * Contains information about a pattern layer on a banner.
 * @see BaseBanner
 */
class BannerPatternLayer{
	private BannerPatternType $type;
	/** @var DyeColor */
	private $color;

	public function __construct(BannerPatternType $type, DyeColor $color){
		$this->type = $type;
		$this->color = $color;
	}

	public function getType() : BannerPatternType{ return $this->type; }

	public function getColor() : DyeColor{
		return $this->color;
	}
}
