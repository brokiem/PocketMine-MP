<?php

declare(strict_types=1);

namespace pocketmine\world\format\io\region;

use function range;

class RegionLocationTableEntry{

	/** @var int */
	private $firstSector;
	/** @var int */
	private $sectorCount;
	/** @var int */
	private $timestamp;

	/**
	 * @throws \InvalidArgumentException
	 */
	public function __construct(int $firstSector, int $sectorCount, int $timestamp){
		if($firstSector < 0 or $firstSector >= 2 ** 24){
			throw new \InvalidArgumentException("Start sector must be positive, got $firstSector");
		}
		$this->firstSector = $firstSector;
		if($sectorCount < 1){
			throw new \InvalidArgumentException("Sector count must be positive, got $sectorCount");
		}
		$this->sectorCount = $sectorCount;
		$this->timestamp = $timestamp;
	}

	public function getFirstSector() : int{
		return $this->firstSector;
	}

	public function getLastSector() : int{
		return $this->firstSector + $this->sectorCount - 1;
	}

	/**
	 * Returns an array of sector offsets reserved by this chunk.
	 * @return int[]
	 */
	public function getUsedSectors() : array{
		return range($this->getFirstSector(), $this->getLastSector());
	}

	public function getSectorCount() : int{
		return $this->sectorCount;
	}

	public function getTimestamp() : int{
		return $this->timestamp;
	}

	public function overlaps(RegionLocationTableEntry $other) : bool{
		$overlapCheck = static function(RegionLocationTableEntry $entry1, RegionLocationTableEntry $entry2) : bool{
			$entry1Last = $entry1->getLastSector();
			$entry2Last = $entry2->getLastSector();

			return (
				($entry2->firstSector >= $entry1->firstSector and $entry2->firstSector <= $entry1Last) or
				($entry2Last >= $entry1->firstSector and $entry2Last <= $entry1Last)
			);
		};
		return $overlapCheck($this, $other) or $overlapCheck($other, $this);
	}
}
