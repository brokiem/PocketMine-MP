<?php

declare(strict_types=1);

namespace pocketmine\world\format\io\region;

use pocketmine\block\Block;
use pocketmine\block\BlockLegacyIds;
use pocketmine\nbt\BigEndianNbtSerializer;
use pocketmine\nbt\NbtDataException;
use pocketmine\nbt\tag\ByteArrayTag;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\IntArrayTag;
use pocketmine\nbt\tag\ListTag;
use pocketmine\world\format\BiomeArray;
use pocketmine\world\format\Chunk;
use pocketmine\world\format\io\ChunkUtils;
use pocketmine\world\format\io\exception\CorruptedChunkException;
use pocketmine\world\format\io\SubChunkConverter;
use pocketmine\world\format\SubChunk;
use function zlib_decode;

class McRegion extends RegionWorldProvider{
	/**
	 * @throws CorruptedChunkException
	 */
	protected function deserializeChunk(string $data) : Chunk{
		$decompressed = @zlib_decode($data);
		if($decompressed === false){
			throw new CorruptedChunkException("Failed to decompress chunk NBT");
		}
		$nbt = new BigEndianNbtSerializer();
		try{
			$chunk = $nbt->read($decompressed)->mustGetCompoundTag();
		}catch(NbtDataException $e){
			throw new CorruptedChunkException($e->getMessage(), 0, $e);
		}
		$chunk = $chunk->getTag("Level");
		if(!($chunk instanceof CompoundTag)){
			throw new CorruptedChunkException("'Level' key is missing from chunk NBT");
		}

		$subChunks = [];
		$fullIds = self::readFixedSizeByteArray($chunk, "Blocks", 32768);
		$fullData = self::readFixedSizeByteArray($chunk, "Data", 16384);

		for($y = 0; $y < 8; ++$y){
			$subChunks[$y] = new SubChunk(BlockLegacyIds::AIR << Block::INTERNAL_METADATA_BITS, [SubChunkConverter::convertSubChunkFromLegacyColumn($fullIds, $fullData, $y)]);
		}

		$makeBiomeArray = function(string $biomeIds) : BiomeArray{
			try{
				return new BiomeArray($biomeIds);
			}catch(\InvalidArgumentException $e){
				throw new CorruptedChunkException($e->getMessage(), 0, $e);
			}
		};
		$biomeIds = null;
		if(($biomeColorsTag = $chunk->getTag("BiomeColors")) instanceof IntArrayTag){
			$biomeIds = $makeBiomeArray(ChunkUtils::convertBiomeColors($biomeColorsTag->getValue())); //Convert back to original format
		}elseif(($biomesTag = $chunk->getTag("Biomes")) instanceof ByteArrayTag){
			$biomeIds = $makeBiomeArray($biomesTag->getValue());
		}

		$result = new Chunk(
			$subChunks,
			($entitiesTag = $chunk->getTag("Entities")) instanceof ListTag ? self::getCompoundList("Entities", $entitiesTag) : [],
			($tilesTag = $chunk->getTag("TileEntities")) instanceof ListTag ? self::getCompoundList("TileEntities", $tilesTag) : [],
			$biomeIds
		);
		$result->setPopulated($chunk->getByte("TerrainPopulated", 0) !== 0);
		return $result;
	}

	protected static function getRegionFileExtension() : string{
		return "mcr";
	}

	protected static function getPcWorldFormatVersion() : int{
		return 19132;
	}

	public function getWorldMinY() : int{
		return 0;
	}

	public function getWorldMaxY() : int{
		//TODO: add world height options
		return 128;
	}
}
