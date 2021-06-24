<?php

declare(strict_types=1);

namespace pocketmine\world\format\io\region;

use pocketmine\block\Block;
use pocketmine\block\BlockLegacyIds;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\world\format\io\SubChunkConverter;
use pocketmine\world\format\SubChunk;

/**
 * This format is exactly the same as the PC Anvil format, with the only difference being that the stored data order
 * is XZY instead of YZX for more performance loading and saving worlds.
 */
class PMAnvil extends RegionWorldProvider{
	use LegacyAnvilChunkTrait;

	protected function deserializeSubChunk(CompoundTag $subChunk) : SubChunk{
		return new SubChunk(BlockLegacyIds::AIR << Block::INTERNAL_METADATA_BITS, [SubChunkConverter::convertSubChunkXZY(
			self::readFixedSizeByteArray($subChunk, "Blocks", 4096),
			self::readFixedSizeByteArray($subChunk, "Data", 2048)
		)]);
	}

	protected static function getRegionFileExtension() : string{
		return "mcapm";
	}

	protected static function getPcWorldFormatVersion() : int{
		return -1; //Not a PC format, only PocketMine-MP
	}

	public function getWorldMinY() : int{
		return 0;
	}

	public function getWorldMaxY() : int{
		return 256;
	}
}
