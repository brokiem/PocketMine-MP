<?php

declare(strict_types=1);

namespace pocketmine\data\bedrock;

use pocketmine\block\BlockLegacyMetadata;
use pocketmine\block\utils\CoralType;
use pocketmine\utils\SingletonTrait;
use function array_key_exists;

final class CoralTypeIdMap{
	use SingletonTrait;

	/**
	 * @var CoralType[]
	 * @phpstan-var array<int, CoralType>
	 */
	private $idToEnum = [];
	/**
	 * @var int[]
	 * @phpstan-var array<int, int>
	 */
	private $enumToId = [];

	public function __construct(){
		$this->register(BlockLegacyMetadata::CORAL_VARIANT_TUBE, CoralType::TUBE());
		$this->register(BlockLegacyMetadata::CORAL_VARIANT_BRAIN, CoralType::BRAIN());
		$this->register(BlockLegacyMetadata::CORAL_VARIANT_BUBBLE, CoralType::BUBBLE());
		$this->register(BlockLegacyMetadata::CORAL_VARIANT_FIRE, CoralType::FIRE());
		$this->register(BlockLegacyMetadata::CORAL_VARIANT_HORN, CoralType::HORN());
	}

	public function register(int $id, CoralType $type) : void{
		$this->idToEnum[$id] = $type;
		$this->enumToId[$type->id()] = $id;
	}

	public function fromId(int $id) : ?CoralType{
		return $this->idToEnum[$id] ?? null;
	}

	public function toId(CoralType $type) : int{
		if(!array_key_exists($type->id(), $this->enumToId)){
			throw new \InvalidArgumentException("Coral type does not have a mapped ID"); //this should never happen
		}
		return $this->enumToId[$type->id()];
	}
}
