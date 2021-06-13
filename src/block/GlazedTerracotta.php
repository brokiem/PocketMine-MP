<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\block\utils\FacesOppositePlacingPlayerTrait;
use pocketmine\block\utils\NormalHorizontalFacingInMetadataTrait;

class GlazedTerracotta extends Opaque{
	use FacesOppositePlacingPlayerTrait;
	use NormalHorizontalFacingInMetadataTrait;
}
