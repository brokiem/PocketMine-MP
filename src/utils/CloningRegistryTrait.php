<?php

declare(strict_types=1);

namespace pocketmine\utils;

trait CloningRegistryTrait{
	use RegistryTrait;

	protected static function preprocessMember(object $member) : object{
		return clone $member;
	}
}
