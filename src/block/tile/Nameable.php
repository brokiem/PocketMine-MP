<?php

declare(strict_types=1);

namespace pocketmine\block\tile;

interface Nameable{
	public const TAG_CUSTOM_NAME = "CustomName";

	public function getDefaultName() : string;

	public function getName() : string;

	public function setName(string $str) : void;

	public function hasName() : bool;
}
