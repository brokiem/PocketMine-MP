<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types;

final class EducationEditionOffer{

	private function __construct(){
		//NOOP
	}

	public const NONE = 0;
	public const EVERYWHERE_EXCEPT_CHINA = 1;
	public const CHINA = 2;
}
