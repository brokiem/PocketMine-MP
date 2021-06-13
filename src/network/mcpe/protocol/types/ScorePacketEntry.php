<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types;

class ScorePacketEntry{
	public const TYPE_PLAYER = 1;
	public const TYPE_ENTITY = 2;
	public const TYPE_FAKE_PLAYER = 3;

	/** @var int */
	public $scoreboardId;
	/** @var string */
	public $objectiveName;
	/** @var int */
	public $score;

	/** @var int */
	public $type;

	/** @var int|null (if type entity or player) */
	public $entityUniqueId;
	/** @var string|null (if type fake player) */
	public $customName;
}
