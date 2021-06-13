<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types\entity;

use pocketmine\math\Vector3;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\network\mcpe\protocol\ProtocolInfo;
use pocketmine\player\Player;
use function get_class;

class EntityMetadataCollection{

	/**
	 * @var MetadataProperty[]
	 * @phpstan-var array<int, MetadataProperty>
	 */
	private $properties = [];
	/**
	 * @var MetadataProperty[]
	 * @phpstan-var array<int, MetadataProperty>
	 */
	private $dirtyProperties = [];

	public function __construct(){

	}

	public function setByte(int $key, int $value, bool $force = false) : void{

		$this->set($key, new ByteMetadataProperty($value), $force);
	}

	public function setShort(int $key, int $value, bool $force = false) : void{
		$this->set($key, new ShortMetadataProperty($value), $force);
	}

	public function setInt(int $key, int $value, bool $force = false) : void{
		$this->set($key, new IntMetadataProperty($value), $force);
	}

	public function setFloat(int $key, float $value, bool $force = false) : void{
		$this->set($key, new FloatMetadataProperty($value), $force);
	}

	public function setString(int $key, string $value, bool $force = false) : void{
		$this->set($key, new StringMetadataProperty($value), $force);
	}

	public function setCompoundTag(int $key, CompoundTag $value, bool $force = false) : void{
		$this->set($key, new CompoundTagMetadataProperty($value), $force);
	}

	public function setBlockPos(int $key, ?Vector3 $value, bool $force = false) : void{
		$this->set($key, new BlockPosMetadataProperty($value ?? new Vector3(0, 0, 0)), $force);
	}

	public function setLong(int $key, int $value, bool $force = false) : void{
		$this->set($key, new LongMetadataProperty($value), $force);
	}

	public function setVector3(int $key, ?Vector3 $value, bool $force = false) : void{
		$this->set($key, new Vec3MetadataProperty($value ?? new Vector3(0, 0, 0)), $force);
	}

	public function set(int $key, MetadataProperty $value, bool $force = false) : void{
		if(!$force and isset($this->properties[$key]) and !($this->properties[$key] instanceof $value)){
			throw new \InvalidArgumentException("Can't overwrite property with mismatching types (have " . get_class($this->properties[$key]) . ")");
		}
		if(!isset($this->properties[$key]) or !$this->properties[$key]->equals($value)){
			$this->properties[$key] = $this->dirtyProperties[$key] = $value;
		}
	}

	public function setGenericFlag(int $flagId, bool $value) : void{
		$propertyId = $flagId >= 64 ? EntityMetadataProperties::FLAGS2 : EntityMetadataProperties::FLAGS;
		$realFlagId = $flagId % 64;
		$flagSetProp = $this->properties[$propertyId] ?? null;
		if($flagSetProp === null){
			$flagSet = 0;
		}elseif($flagSetProp instanceof LongMetadataProperty){
			$flagSet = $flagSetProp->getValue();
		}else{
			throw new \InvalidArgumentException("Wrong type found for flags, want long, but have " . get_class($flagSetProp));
		}

		if((($flagSet >> $realFlagId) & 1) !== ($value ? 1 : 0)){
			$flagSet ^= (1 << $realFlagId);
			$this->setLong($propertyId, $flagSet);
		}
	}

	public function setPlayerFlag(int $flagId, bool $value) : void{
		$flagSetProp = $this->properties[EntityMetadataProperties::PLAYER_FLAGS] ?? null;
		if($flagSetProp === null){
			$flagSet = 0;
		}elseif($flagSetProp instanceof ByteMetadataProperty){
			$flagSet = $flagSetProp->getValue();
		}else{
			throw new \InvalidArgumentException("Wrong type found for flags, want byte, but have " . get_class($flagSetProp));
		}
		if((($flagSet >> $flagId) & 1) !== ($value ? 1 : 0)){
			$flagSet ^= (1 << $flagId);
			$this->setByte(EntityMetadataProperties::PLAYER_FLAGS, $flagSet);
		}
	}

	/**
	 * Returns all properties.
	 *
	 * @return MetadataProperty[]
	 * @phpstan-return array<int, MetadataProperty>
	 */
	public function getAll(int $protocolId) : array{
		return $this->convertProperties($this->properties, $protocolId);
	}

	public static function getMetadataProtocol(int $protocolId) : int{
		return $protocolId <= ProtocolInfo::PROTOCOL_1_16_200 ? ProtocolInfo::PROTOCOL_1_16_200 : ProtocolInfo::CURRENT_PROTOCOL;
	}

	/**
	 * @param Player[] $players
	 *
	 * @return Player[][]
	 */
	public static function sortByProtocol(array $players) : array{
		$sortPlayers = [];

		foreach($players as $player){
			$protocolId = self::getMetadataProtocol($player->getNetworkSession()->getProtocolId());

			if(isset($sortPlayers[$protocolId])){
				$sortPlayers[$protocolId][] = $player;
			}else{
				$sortPlayers[$protocolId] = [$player];
			}
		}

		return $sortPlayers;
	}

	private function convertProperties(array $properties, int $protocolId): array
	{
		if ($protocolId <= ProtocolInfo::PROTOCOL_1_16_200) {
			$newProperties = [];

			foreach ($properties as $key => $property){
				$newProperties[$key >= EntityMetadataProperties::AREA_EFFECT_CLOUD_RADIUS ? $key - 1 : $key] = $property;
			}

			return $newProperties;
		}

		return $properties;
	}

	/**
	 * Returns properties that have changed and need to be broadcasted.
	 *
	 * @return MetadataProperty[]
	 * @phpstan-return array<int, MetadataProperty>
	 */
	public function getDirty(int $protocolId) : array{
		return $this->convertProperties($this->dirtyProperties, $protocolId);
	}

	/**
	 * Clears records of dirty properties.
	 */
	public function clearDirtyProperties() : void{
		$this->dirtyProperties = [];
	}
}
