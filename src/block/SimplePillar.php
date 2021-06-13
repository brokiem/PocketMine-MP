<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\block\utils\PillarRotationInMetadataTrait;

/**
 * @internal This class provides a general base for pillar-like blocks. It **should not** be used for contract binding
 * in APIs, because not all pillar-like blocks extend this class.
 */
class SimplePillar extends Opaque{
	use PillarRotationInMetadataTrait;
}
