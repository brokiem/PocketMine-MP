<?php

declare(strict_types=1);

namespace pocketmine\entity;

use pocketmine\math\Vector3;
use pocketmine\nbt\NBT;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\DoubleTag;
use pocketmine\nbt\tag\FloatTag;
use pocketmine\nbt\tag\ListTag;
use pocketmine\world\World;
use function count;

final class EntityDataHelper{

	private function __construct(){
		//NOOP
	}

	public static function parseLocation(CompoundTag $nbt, World $world) : Location{
		$pos = self::parseVec3($nbt, "Pos", false);

		$yawPitch = $nbt->getTag("Rotation");
		if(!($yawPitch instanceof ListTag) or $yawPitch->getTagType() !== NBT::TAG_Float){
			throw new \UnexpectedValueException("'Rotation' should be a List<Float>");
		}
		/** @var FloatTag[] $values */
		$values = $yawPitch->getValue();
		if(count($values) !== 2){
			throw new \UnexpectedValueException("Expected exactly 2 entries for 'Rotation'");
		}

		return Location::fromObject($pos, $world, $values[0]->getValue(), $values[1]->getValue());
	}

	public static function parseVec3(CompoundTag $nbt, string $tagName, bool $optional) : Vector3{
		$pos = $nbt->getTag($tagName);
		if($pos === null and $optional){
			return new Vector3(0, 0, 0);
		}
		if(!($pos instanceof ListTag) or $pos->getTagType() !== NBT::TAG_Double){
			throw new \UnexpectedValueException("'$tagName' should be a List<Double>");
		}
		/** @var DoubleTag[] $values */
		$values = $pos->getValue();
		if(count($values) !== 3){
			throw new \UnexpectedValueException("Expected exactly 3 entries in '$tagName' tag");
		}
		return new Vector3($values[0]->getValue(), $values[1]->getValue(), $values[2]->getValue());
	}

	/**
	 * Helper function which creates minimal NBT needed to spawn an entity.
	 */
	public static function createBaseNBT(Vector3 $pos, ?Vector3 $motion = null, float $yaw = 0.0, float $pitch = 0.0) : CompoundTag{
		return CompoundTag::create()
			->setTag("Pos", new ListTag([
				new DoubleTag($pos->x),
				new DoubleTag($pos->y),
				new DoubleTag($pos->z)
			]))
			->setTag("Motion", new ListTag([
				new DoubleTag($motion !== null ? $motion->x : 0.0),
				new DoubleTag($motion !== null ? $motion->y : 0.0),
				new DoubleTag($motion !== null ? $motion->z : 0.0)
			]))
			->setTag("Rotation", new ListTag([
				new FloatTag($yaw),
				new FloatTag($pitch)
			]));
	}
}
