<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\cache;

use pocketmine\network\mcpe\protocol\AvailableActorIdentifiersPacket;
use pocketmine\network\mcpe\protocol\BiomeDefinitionListPacket;
use pocketmine\network\mcpe\protocol\serializer\NetworkNbtSerializer;
use pocketmine\network\mcpe\protocol\types\CacheableNbt;
use pocketmine\utils\SingletonTrait;
use function file_get_contents;

class StaticPacketCache{
	use SingletonTrait;

	/** @var BiomeDefinitionListPacket */
	private $biomeDefs;
	/** @var AvailableActorIdentifiersPacket */
	private $availableActorIdentifiers;

	/**
	 * @phpstan-return CacheableNbt<\pocketmine\nbt\tag\CompoundTag>
	 */
	private static function loadCompoundFromFile(string $filePath) : CacheableNbt{
		$rawNbt = @file_get_contents($filePath);
		if($rawNbt === false) throw new \RuntimeException("Failed to read file");
		return new CacheableNbt((new NetworkNbtSerializer())->read($rawNbt)->mustGetCompoundTag());
	}

	private static function make() : self{
		return new self(
			BiomeDefinitionListPacket::create(self::loadCompoundFromFile(\pocketmine\RESOURCE_PATH . '/vanilla/biome_definitions.nbt')),
			AvailableActorIdentifiersPacket::create(self::loadCompoundFromFile(\pocketmine\RESOURCE_PATH . '/vanilla/entity_identifiers.nbt'))
		);
	}

	public function __construct(BiomeDefinitionListPacket $biomeDefs, AvailableActorIdentifiersPacket $availableActorIdentifiers){
		$this->biomeDefs = $biomeDefs;
		$this->availableActorIdentifiers = $availableActorIdentifiers;
	}

	public function getBiomeDefs() : BiomeDefinitionListPacket{
		return $this->biomeDefs;
	}

	public function getAvailableActorIdentifiers() : AvailableActorIdentifiersPacket{
		return $this->availableActorIdentifiers;
	}
}
