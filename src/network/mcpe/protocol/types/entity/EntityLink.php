<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types\entity;

class EntityLink{

	public const TYPE_REMOVE = 0;
	public const TYPE_RIDER = 1;
	public const TYPE_PASSENGER = 2;

	/** @var int */
	public $fromEntityUniqueId;
	/** @var int */
	public $toEntityUniqueId;
	/** @var int */
	public $type;
	/** @var bool */
	public $immediate; //for dismounting on mount death
	/** @var bool */
	public $causedByRider;

	public function __construct(int $fromEntityUniqueId, int $toEntityUniqueId, int $type, bool $immediate, bool $causedByRider){
		$this->fromEntityUniqueId = $fromEntityUniqueId;
		$this->toEntityUniqueId = $toEntityUniqueId;
		$this->type = $type;
		$this->immediate = $immediate;
		$this->causedByRider = $causedByRider;
	}
}
