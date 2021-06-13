<?php

declare(strict_types=1);

namespace pocketmine\world\format\io;

use pocketmine\world\format\io\exception\CorruptedWorldException;
use pocketmine\world\format\io\exception\UnsupportedWorldFormatException;
use pocketmine\world\WorldException;
use function file_exists;

abstract class BaseWorldProvider implements WorldProvider{
	/** @var string */
	protected $path;
	/** @var WorldData */
	protected $worldData;

	public function __construct(string $path){
		if(!file_exists($path)){
			throw new WorldException("World does not exist");
		}

		$this->path = $path;
		$this->worldData = $this->loadLevelData();
	}

	/**
	 * @throws CorruptedWorldException
	 * @throws UnsupportedWorldFormatException
	 */
	abstract protected function loadLevelData() : WorldData;

	public function getPath() : string{
		return $this->path;
	}

	public function getWorldData() : WorldData{
		return $this->worldData;
	}
}
