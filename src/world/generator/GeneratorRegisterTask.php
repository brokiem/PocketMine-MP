<?php

declare(strict_types=1);

namespace pocketmine\world\generator;

use pocketmine\scheduler\AsyncTask;
use pocketmine\world\World;

class GeneratorRegisterTask extends AsyncTask{

	/**
	 * @var string
	 * @phpstan-var class-string<Generator>
	 */
	public $generatorClass;
	/** @var string */
	public $settings;
	/** @var int */
	public $seed;
	/** @var int */
	public $worldId;
	/** @var int */
	public $worldMinY;
	/** @var int */
	public $worldMaxY;

	/**
	 * @phpstan-param class-string<Generator> $generatorClass
	 */
	public function __construct(World $world, string $generatorClass, string $generatorSettings){
		$this->generatorClass = $generatorClass;
		$this->settings = $generatorSettings;
		$this->seed = $world->getSeed();
		$this->worldId = $world->getId();
		$this->worldMinY = $world->getMinY();
		$this->worldMaxY = $world->getMaxY();
	}

	public function onRun() : void{
		/**
		 * @var Generator $generator
		 * @see Generator::__construct()
		 */
		$generator = new $this->generatorClass($this->seed, $this->settings);
		ThreadLocalGeneratorContext::register(new ThreadLocalGeneratorContext($generator, $this->worldMinY, $this->worldMaxY), $this->worldId);
	}
}
