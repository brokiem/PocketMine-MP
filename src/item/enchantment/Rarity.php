<?php

declare(strict_types=1);

namespace pocketmine\item\enchantment;

final class Rarity{
	private function __construct(){
		//NOOP
	}

	public const COMMON = 10;
	public const UNCOMMON = 5;
	public const RARE = 2;
	public const MYTHIC = 1;
}
