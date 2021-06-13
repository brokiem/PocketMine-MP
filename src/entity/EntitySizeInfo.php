<?php

declare(strict_types=1);

namespace pocketmine\entity;

use function min;

final class EntitySizeInfo{
	/** @var float */
	private $height;
	/** @var float */
	private $width;
	/** @var float */
	private $eyeHeight;

	public function __construct(float $height, float $width, ?float $eyeHeight = null){
		$this->height = $height;
		$this->width = $width;
		$this->eyeHeight = $eyeHeight ?? min($this->height / 2 + 0.1, $this->height);
	}

	public function getHeight() : float{ return $this->height; }

	public function getWidth() : float{ return $this->width; }

	public function getEyeHeight() : float{ return $this->eyeHeight; }

	public function scale(float $newScale) : self{
		return new self(
			$this->height * $newScale,
			$this->width * $newScale,
			$this->eyeHeight * $newScale
		);
	}
}
