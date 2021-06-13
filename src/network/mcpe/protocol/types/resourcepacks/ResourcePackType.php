<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types\resourcepacks;

final class ResourcePackType{

	private function __construct(){
		//NOOP
	}

	public const INVALID = 0;
	public const ADDON = 1;
	public const CACHED = 2;
	public const COPY_PROTECTED = 3;
	public const BEHAVIORS = 4;
	public const PERSONA_PIECE = 5;
	public const RESOURCES = 6;
	public const SKINS = 7;
	public const WORLD_TEMPLATE = 8;
}
