<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types;

use pocketmine\network\mcpe\protocol\types\skin\SkinData;
use Ramsey\Uuid\UuidInterface;

class PlayerListEntry{

	/** @var UuidInterface */
	public $uuid;
	/** @var int */
	public $entityUniqueId;
	/** @var string */
	public $username;
	/** @var SkinData */
	public $skinData;
	/** @var string */
	public $xboxUserId;
	/** @var string */
	public $platformChatId = "";
	/** @var int */
	public $buildPlatform = DeviceOS::UNKNOWN;
	/** @var bool */
	public $isTeacher = false;
	/** @var bool */
	public $isHost = false;

	public static function createRemovalEntry(UuidInterface $uuid) : PlayerListEntry{
		$entry = new PlayerListEntry();
		$entry->uuid = $uuid;

		return $entry;
	}

	public static function createAdditionEntry(UuidInterface $uuid, int $entityUniqueId, string $username, SkinData $skinData, string $xboxUserId = "", string $platformChatId = "", int $buildPlatform = -1, bool $isTeacher = false, bool $isHost = false) : PlayerListEntry{
		$entry = new PlayerListEntry();
		$entry->uuid = $uuid;
		$entry->entityUniqueId = $entityUniqueId;
		$entry->username = $username;
		$entry->skinData = $skinData;
		$entry->xboxUserId = $xboxUserId;
		$entry->platformChatId = $platformChatId;
		$entry->buildPlatform = $buildPlatform;
		$entry->isTeacher = $isTeacher;
		$entry->isHost = $isHost;

		return $entry;
	}
}
