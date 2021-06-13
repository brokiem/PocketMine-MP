<?php

declare(strict_types=1);

namespace pocketmine\block;

use function count;

class BlockIdentifierFlattened extends BlockIdentifier{

	/** @var int[] */
	private array $additionalIds;

	/**
	 * @param int[] $additionalIds
	 */
	public function __construct(int $blockId, array $additionalIds, int $variant, ?int $itemId = null, ?string $tileClass = null){
		if(count($additionalIds) === 0){
			throw new \InvalidArgumentException("Expected at least 1 additional ID");
		}
		parent::__construct($blockId, $variant, $itemId, $tileClass);

		$this->additionalIds = $additionalIds;
	}

	public function getAdditionalId(int $index) : int{
		if(!isset($this->additionalIds[$index])){
			throw new \InvalidArgumentException("No such ID at index $index");
		}
		return $this->additionalIds[$index];
	}

	public function getSecondId() : int{
		return $this->getAdditionalId(0);
	}

	public function getAllBlockIds() : array{
		return [$this->getBlockId(), ...$this->additionalIds];
	}
}
