<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types;

class ScoreboardIdentityPacketEntry{
	/** @var int */
	public $scoreboardId;
	/** @var int|null */
	public $entityUniqueId = null;

}
