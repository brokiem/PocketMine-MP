<?php

declare(strict_types=1);

namespace pocketmine\item;

use pocketmine\block\utils\RecordType;

class Record extends Item{
	/** @var RecordType */
	private $recordType;

	public function __construct(ItemIdentifier $identifier, RecordType $recordType, string $name){
		$this->recordType = $recordType;
		parent::__construct($identifier, $name);
	}

	public function getRecordType() : RecordType{
		return $this->recordType;
	}

	public function getMaxStackSize() : int{
		return 1;
	}
}
