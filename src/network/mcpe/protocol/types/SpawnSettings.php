<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types;

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

final class SpawnSettings{
	public const BIOME_TYPE_DEFAULT = 0;
	public const BIOME_TYPE_USER_DEFINED = 1;

	/** @var int */
	private $biomeType;
	/** @var string */
	private $biomeName;
	/** @var int */
	private $dimension;

	public function __construct(int $biomeType, string $biomeName, int $dimension){
		$this->biomeType = $biomeType;
		$this->biomeName = $biomeName;
		$this->dimension = $dimension;
	}

	public function getBiomeType() : int{
		return $this->biomeType;
	}

	public function getBiomeName() : string{
		return $this->biomeName;
	}

	/**
	 * @see DimensionIds
	 */
	public function getDimension() : int{
		return $this->dimension;
	}

	public static function read(PacketSerializer $in) : self{
		$biomeType = $in->getLShort();
		$biomeName = $in->getString();
		$dimension = $in->getVarInt();

		return new self($biomeType, $biomeName, $dimension);
	}

	public function write(PacketSerializer $out) : void{
		$out->putLShort($this->biomeType);
		$out->putString($this->biomeName);
		$out->putVarInt($this->dimension);
	}
}
