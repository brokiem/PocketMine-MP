<?php

declare(strict_types=1);

namespace pocketmine\network;

use function array_fill;
use function array_sum;
use function count;

final class BandwidthStatsTracker{
	/** @var int[] */
	private $history;
	/** @var int */
	private $nextHistoryIndex = 0;

	/** @var int */
	private $bytesSinceLastRotation = 0;

	/** @var int */
	private $totalBytes = 0;

	public function __construct(int $historySize){
		$this->history = array_fill(0, $historySize, 0);
	}

	public function add(int $bytes) : void{
		$this->totalBytes += $bytes;
		$this->bytesSinceLastRotation += $bytes;
	}

	public function getTotalBytes() : int{ return $this->totalBytes; }

	/**
	 * Adds the bytes tracked since the last rotation to the history array, overwriting an old entry.
	 * This should be called on a regular interval that you want to collect average measurements over
	 * (e.g. if you want bytes per second, call this every second).
	 */
	public function rotateHistory() : void{
		$this->history[$this->nextHistoryIndex] = $this->bytesSinceLastRotation;
		$this->bytesSinceLastRotation = 0;
		$this->nextHistoryIndex = ($this->nextHistoryIndex + 1) % count($this->history);
	}

	/**
	 * Returns the average of all the tracked history values.
	 */
	public function getAverageBytes() : float{
		return array_sum($this->history) / count($this->history);
	}

	public function resetHistory() : void{
		$this->history = array_fill(0, count($this->history), 0);
	}
}
