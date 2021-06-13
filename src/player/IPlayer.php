<?php

declare(strict_types=1);

namespace pocketmine\player;

interface IPlayer{

	public function getName() : string;

	public function getFirstPlayed() : ?int;

	public function getLastPlayed() : ?int;

	public function hasPlayedBefore() : bool;

}
