<?php

declare(strict_types=1);

namespace pocketmine\player;

use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\LongTag;

class OfflinePlayer implements IPlayer{

	/** @var string */
	private $name;
	/** @var CompoundTag|null */
	private $namedtag;

	public function __construct(string $name, ?CompoundTag $namedtag){
		$this->name = $name;
		$this->namedtag = $namedtag;
	}

	public function getName() : string{
		return $this->name;
	}

	public function getFirstPlayed() : ?int{
		return ($this->namedtag !== null and ($firstPlayedTag = $this->namedtag->getTag("firstPlayed")) instanceof LongTag) ? $firstPlayedTag->getValue() : null;
	}

	public function getLastPlayed() : ?int{
		return ($this->namedtag !== null and ($lastPlayedTag = $this->namedtag->getTag("lastPlayed")) instanceof LongTag) ? $lastPlayedTag->getValue() : null;
	}

	public function hasPlayedBefore() : bool{
		return $this->namedtag !== null;
	}
}
