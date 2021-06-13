<?php

declare(strict_types=1);

namespace pocketmine\world\generator;

/**
 * Manages thread-local caches for generators and the things needed to support them
 */
final class ThreadLocalGeneratorContext{
	/**
	 * @var self[]
	 * @phpstan-var array<int, self>
	 */
	private static $contexts = [];

	public static function register(self $context, int $worldId) : void{
		self::$contexts[$worldId] = $context;
	}

	public static function unregister(int $worldId) : void{
		unset(self::$contexts[$worldId]);
	}

	public static function fetch(int $worldId) : ?self{
		return self::$contexts[$worldId] ?? null;
	}

	/** @var Generator */
	private $generator;

	/** @var int */
	private $worldMinY;
	/** @var int */
	private $worldMaxY;

	public function __construct(Generator $generator, int $worldMinY, int $worldMaxY){
		$this->generator = $generator;
		$this->worldMinY = $worldMinY;
		$this->worldMaxY = $worldMaxY;
	}

	public function getGenerator() : Generator{ return $this->generator; }

	public function getWorldMinY() : int{ return $this->worldMinY; }

	public function getWorldMaxY() : int{ return $this->worldMaxY; }
}
