<?php

declare(strict_types=1);

namespace pocketmine\item;

use pocketmine\utils\Utils;

class WritableBookPage{

	/** @var string */
	private $text;
	/** @var string */
	private $photoName;

	public function __construct(string $text, string $photoName = ""){
		//TODO: data validation
		Utils::checkUTF8($text);
		$this->text = $text;
		$this->photoName = $photoName;
	}

	public function getText() : string{
		return $this->text;
	}

	public function getPhotoName() : string{
		return $this->photoName;
	}
}
