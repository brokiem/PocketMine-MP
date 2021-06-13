<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types;

final class GeneratorType{

	private function __construct(){
		//NOOP
	}

	public const FINITE_OVERWORLD = 0;
	public const OVERWORLD = 1;
	public const FLAT = 2;
	public const NETHER = 3;
	public const THE_END = 4;
}
