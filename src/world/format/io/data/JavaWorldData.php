<?php

declare(strict_types=1);

namespace pocketmine\world\format\io\data;

use pocketmine\nbt\BigEndianNbtSerializer;
use pocketmine\nbt\NbtDataException;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\FloatTag;
use pocketmine\nbt\tag\StringTag;
use pocketmine\nbt\TreeRoot;
use pocketmine\world\format\io\exception\CorruptedWorldException;
use pocketmine\world\generator\GeneratorManager;
use pocketmine\world\World;
use pocketmine\world\WorldCreationOptions;
use function ceil;
use function file_get_contents;
use function file_put_contents;
use function microtime;
use function zlib_decode;
use function zlib_encode;
use const ZLIB_ENCODING_GZIP;

class JavaWorldData extends BaseNbtWorldData{

	public static function generate(string $path, string $name, WorldCreationOptions $options, int $version = 19133) : void{
		//TODO, add extra details

		$worldData = CompoundTag::create()
			->setByte("hardcore", 0)
			->setByte("Difficulty", $options->getDifficulty())
			->setByte("initialized", 1)
			->setInt("GameType", 0)
			->setInt("generatorVersion", 1) //2 in MCPE
			->setInt("SpawnX", $options->getSpawnPosition()->getFloorX())
			->setInt("SpawnY", $options->getSpawnPosition()->getFloorY())
			->setInt("SpawnZ", $options->getSpawnPosition()->getFloorZ())
			->setInt("version", $version)
			->setInt("DayTime", 0)
			->setLong("LastPlayed", (int) (microtime(true) * 1000))
			->setLong("RandomSeed", $options->getSeed())
			->setLong("SizeOnDisk", 0)
			->setLong("Time", 0)
			->setString("generatorName", GeneratorManager::getInstance()->getGeneratorName($options->getGeneratorClass()))
			->setString("generatorOptions", $options->getGeneratorOptions())
			->setString("LevelName", $name)
			->setTag("GameRules", new CompoundTag());

		$nbt = new BigEndianNbtSerializer();
		$buffer = zlib_encode($nbt->write(new TreeRoot(CompoundTag::create()->setTag("Data", $worldData))), ZLIB_ENCODING_GZIP);
		file_put_contents($path . "level.dat", $buffer);
	}

	protected function load() : CompoundTag{
		$rawLevelData = @file_get_contents($this->dataPath);
		if($rawLevelData === false){
			throw new CorruptedWorldException("Failed to read level.dat (permission denied or doesn't exist)");
		}
		$nbt = new BigEndianNbtSerializer();
		$decompressed = @zlib_decode($rawLevelData);
		if($decompressed === false){
			throw new CorruptedWorldException("Failed to decompress level.dat contents");
		}
		try{
			$worldData = $nbt->read($decompressed)->mustGetCompoundTag();
		}catch(NbtDataException $e){
			throw new CorruptedWorldException($e->getMessage(), 0, $e);
		}

		$dataTag = $worldData->getTag("Data");
		if(!($dataTag instanceof CompoundTag)){
			throw new CorruptedWorldException("Missing 'Data' key or wrong type");
		}
		return $dataTag;
	}

	protected function fix() : void{
		$generatorNameTag = $this->compoundTag->getTag("generatorName");
		if(!($generatorNameTag instanceof StringTag)){
			$this->compoundTag->setString("generatorName", "default");
		}elseif(($generatorName = self::hackyFixForGeneratorClasspathInLevelDat($generatorNameTag->getValue())) !== null){
			$this->compoundTag->setString("generatorName", $generatorName);
		}

		if(!($this->compoundTag->getTag("generatorOptions") instanceof StringTag)){
			$this->compoundTag->setString("generatorOptions", "");
		}
	}

	public function save() : void{
		$nbt = new BigEndianNbtSerializer();
		$buffer = zlib_encode($nbt->write(new TreeRoot(CompoundTag::create()->setTag("Data", $this->compoundTag))), ZLIB_ENCODING_GZIP);
		file_put_contents($this->dataPath, $buffer);
	}

	public function getDifficulty() : int{
		return $this->compoundTag->getByte("Difficulty", World::DIFFICULTY_NORMAL);
	}

	public function setDifficulty(int $difficulty) : void{
		$this->compoundTag->setByte("Difficulty", $difficulty);
	}

	public function getRainTime() : int{
		return $this->compoundTag->getInt("rainTime", 0);
	}

	public function setRainTime(int $ticks) : void{
		$this->compoundTag->setInt("rainTime", $ticks);
	}

	public function getRainLevel() : float{
		if(($rainLevelTag = $this->compoundTag->getTag("rainLevel")) instanceof FloatTag){ //PocketMine/MCPE
			return $rainLevelTag->getValue();
		}

		return (float) $this->compoundTag->getByte("raining", 0); //PC vanilla
	}

	public function setRainLevel(float $level) : void{
		$this->compoundTag->setFloat("rainLevel", $level); //PocketMine/MCPE
		$this->compoundTag->setByte("raining", (int) ceil($level)); //PC vanilla
	}

	public function getLightningTime() : int{
		return $this->compoundTag->getInt("thunderTime", 0);
	}

	public function setLightningTime(int $ticks) : void{
		$this->compoundTag->setInt("thunderTime", $ticks);
	}

	public function getLightningLevel() : float{
		if(($lightningLevelTag = $this->compoundTag->getTag("lightningLevel")) instanceof FloatTag){ //PocketMine/MCPE
			return $lightningLevelTag->getValue();
		}

		return (float) $this->compoundTag->getByte("thundering", 0); //PC vanilla
	}

	public function setLightningLevel(float $level) : void{
		$this->compoundTag->setFloat("lightningLevel", $level); //PocketMine/MCPE
		$this->compoundTag->setByte("thundering", (int) ceil($level)); //PC vanilla
	}
}
