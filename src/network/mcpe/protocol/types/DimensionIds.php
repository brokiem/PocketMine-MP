<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types;

final class DimensionIds{

	private function __construct(){
		//NOOP
	}

	public const OVERWORLD = 0;
	public const NETHER = 1;
	public const THE_END = 2;

}
