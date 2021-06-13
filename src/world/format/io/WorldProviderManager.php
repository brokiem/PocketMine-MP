<?php

declare(strict_types=1);

namespace pocketmine\world\format\io;

use pocketmine\utils\Utils;
use pocketmine\world\format\io\leveldb\LevelDB;
use pocketmine\world\format\io\region\Anvil;
use pocketmine\world\format\io\region\McRegion;
use pocketmine\world\format\io\region\PMAnvil;
use function strtolower;
use function trim;

final class WorldProviderManager{
	/**
	 * @var string[]
	 * @phpstan-var array<string, class-string<WorldProvider>>
	 */
	protected $providers = [];

	/**
	 * @var string
	 * @phpstan-var class-string<WritableWorldProvider>
	 */
	private $default = LevelDB::class;

	public function __construct(){
		$this->addProvider(Anvil::class, "anvil");
		$this->addProvider(McRegion::class, "mcregion");
		$this->addProvider(PMAnvil::class, "pmanvil");
		$this->addProvider(LevelDB::class, "leveldb");
	}

	/**
	 * Returns the default format used to generate new worlds.
	 *
	 * @phpstan-return class-string<WritableWorldProvider>
	 */
	public function getDefault() : string{
		return $this->default;
	}

	/**
	 * Sets the default format.
	 *
	 * @param string $class Class implementing WritableWorldProvider
	 * @phpstan-param class-string<WritableWorldProvider> $class
	 *
	 * @throws \InvalidArgumentException
	 */
	public function setDefault(string $class) : void{
		Utils::testValidInstance($class, WritableWorldProvider::class);

		$this->default = $class;
	}

	/**
	 * @phpstan-param class-string<WorldProvider> $class
	 */
	public function addProvider(string $class, string $name, bool $overwrite = false) : void{
		Utils::testValidInstance($class, WorldProvider::class);

		$name = strtolower($name);
		if(!$overwrite and isset($this->providers[$name])){
			throw new \InvalidArgumentException("Alias \"$name\" is already assigned");
		}

		$this->providers[$name] = $class;
	}

	/**
	 * Returns a WorldProvider class for this path, or null
	 *
	 * @return string[]
	 * @phpstan-return array<string, class-string<WorldProvider>>
	 */
	public function getMatchingProviders(string $path) : array{
		$result = [];
		foreach($this->providers as $alias => $provider){
			if($provider::isValid($path)){
				$result[$alias] = $provider;
			}
		}
		return $result;
	}

	/**
	 * @return string[]
	 * @phpstan-return array<string, class-string<WorldProvider>>
	 */
	public function getAvailableProviders() : array{
		return $this->providers;
	}

	/**
	 * Returns a WorldProvider by name, or null if not found
	 *
	 * @phpstan-return class-string<WorldProvider>|null
	 */
	public function getProviderByName(string $name) : ?string{
		return $this->providers[trim(strtolower($name))] ?? null;
	}
}
