<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types;

class MapTrackedObject{
	public const TYPE_ENTITY = 0;
	public const TYPE_BLOCK = 1;

	/** @var int */
	public $type;

	/** @var int Only set if is TYPE_ENTITY */
	public $entityUniqueId;

	/** @var int */
	public $x;
	/** @var int */
	public $y;
	/** @var int */
	public $z;

}
