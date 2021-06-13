<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types\skin;

use function strlen;

class SkinImage{

	/** @var int */
	private $height;
	/** @var int */
	private $width;
	/** @var string */
	private $data;

	public function __construct(int $height, int $width, string $data){
		if($height < 0 or $width < 0){
			throw new \InvalidArgumentException("Height and width cannot be negative");
		}
		if(($expected = $height * $width * 4) !== ($actual = strlen($data))){
			throw new \InvalidArgumentException("Data should be exactly $expected bytes, got $actual bytes");
		}
		$this->height = $height;
		$this->width = $width;
		$this->data = $data;
	}

	public static function fromLegacy(string $data) : SkinImage{
		switch(strlen($data)){
			case 64 * 32 * 4:
				return new self(32, 64, $data);
			case 64 * 64 * 4:
				return new self(64, 64, $data);
			case 128 * 128 * 4:
				return new self(128, 128, $data);
		}

		throw new \InvalidArgumentException("Unknown size");
	}

	public function getHeight() : int{
		return $this->height;
	}

	public function getWidth() : int{
		return $this->width;
	}

	public function getData() : string{
		return $this->data;
	}
}
