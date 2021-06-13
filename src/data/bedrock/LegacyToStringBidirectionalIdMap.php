<?php

declare(strict_types=1);

namespace pocketmine\data\bedrock;

use pocketmine\utils\AssumptionFailedError;
use function file_get_contents;
use function is_array;
use function is_int;
use function is_string;
use function json_decode;

abstract class LegacyToStringBidirectionalIdMap{

	/**
	 * @var string[]
	 * @phpstan-var array<int, string>
	 */
	private $legacyToString = [];
	/**
	 * @var int[]
	 * @phpstan-var array<string, int>
	 */
	private $stringToLegacy = [];

	public function __construct(string $file){
		$stringToLegacyId = json_decode(file_get_contents($file), true);
		if(!is_array($stringToLegacyId)){
			throw new AssumptionFailedError("Invalid format of ID map");
		}
		foreach($stringToLegacyId as $stringId => $legacyId){
			if(!is_string($stringId) or !is_int($legacyId)){
				throw new AssumptionFailedError("ID map should have string keys and int values");
			}
			$this->legacyToString[$legacyId] = $stringId;
			$this->stringToLegacy[$stringId] = $legacyId;
		}
	}

	public function legacyToString(int $legacy) : ?string{
		return $this->legacyToString[$legacy] ?? null;
	}

	public function stringToLegacy(string $string) : ?int{
		return $this->stringToLegacy[$string] ?? null;
	}

	/**
	 * @return string[]
	 * @phpstan-return array<int, string>
	 */
	public function getLegacyToStringMap() : array{
		return $this->legacyToString;
	}

	/**
	 * @return int[]
	 * @phpstan-return array<string, int>
	 */
	public function getStringToLegacyMap() : array{
		return $this->stringToLegacy;
	}
}
