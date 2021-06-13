<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\block\tile\Tile;

class BlockIdentifier{

	private int $blockId;
	private int $variant;
	private ?int $itemId;
	/** @phpstan-var class-string<Tile>|null */
	private ?string $tileClass;

	/**
	 * @phpstan-param class-string<Tile>|null $tileClass
	 */
	public function __construct(int $blockId, int $variant, ?int $itemId = null, ?string $tileClass = null){
		$this->blockId = $blockId;
		$this->variant = $variant;
		$this->itemId = $itemId;
		$this->tileClass = $tileClass;
	}

	public function getBlockId() : int{
		return $this->blockId;
	}

	/**
	 * @return int[]
	 */
	public function getAllBlockIds() : array{
		return [$this->blockId];
	}

	public function getVariant() : int{
		return $this->variant;
	}

	public function getItemId() : int{
		return $this->itemId ?? ($this->blockId > 255 ? 255 - $this->blockId : $this->blockId);
	}

	/**
	 * @phpstan-return class-string<Tile>|null
	 */
	public function getTileClass() : ?string{
		return $this->tileClass;
	}
}
