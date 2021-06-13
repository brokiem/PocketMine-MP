<?php

declare(strict_types=1);

namespace pocketmine\block;

/**
 * Types of tools that can be used to break blocks
 * Blocks may allow multiple tool types by combining these bitflags
 */
final class BlockToolType{

	private function __construct(){
		//NOOP
	}

	public const NONE = 0;
	public const SWORD = 1 << 0;
	public const SHOVEL = 1 << 1;
	public const PICKAXE = 1 << 2;
	public const AXE = 1 << 3;
	public const SHEARS = 1 << 4;
	public const HOE = 1 << 5;

}
