<?php

declare(strict_types=1);

namespace pocketmine\world\generator;

use pocketmine\scheduler\AsyncTask;
use pocketmine\world\World;

class GeneratorUnregisterTask extends AsyncTask{

	/** @var int */
	public $worldId;

	public function __construct(World $world){
		$this->worldId = $world->getId();
	}

	public function onRun() : void{
		ThreadLocalGeneratorContext::unregister($this->worldId);
	}
}
