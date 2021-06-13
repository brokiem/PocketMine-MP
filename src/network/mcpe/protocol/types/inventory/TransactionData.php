<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types\inventory;

use pocketmine\network\mcpe\protocol\PacketDecodeException;
use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;
use pocketmine\utils\BinaryDataException;
use function count;

abstract class TransactionData{
	/** @var NetworkInventoryAction[] */
	protected $actions = [];

	/**
	 * @return NetworkInventoryAction[]
	 */
	final public function getActions() : array{
		return $this->actions;
	}

	abstract public function getTypeId() : int;

	/**
	 * @throws BinaryDataException
	 * @throws PacketDecodeException
	 */
	final public function decode(PacketSerializer $stream, bool $hasItemStackIds) : void{
		$actionCount = $stream->getUnsignedVarInt();
		for($i = 0; $i < $actionCount; ++$i){
			$this->actions[] = (new NetworkInventoryAction())->read($stream, $hasItemStackIds);
		}
		$this->decodeData($stream);
	}

	/**
	 * @throws BinaryDataException
	 * @throws PacketDecodeException
	 */
	abstract protected function decodeData(PacketSerializer $stream) : void;

	final public function encode(PacketSerializer $stream, bool $hasItemStackIds) : void{
		$stream->putUnsignedVarInt(count($this->actions));
		foreach($this->actions as $action){
			$action->write($stream, $hasItemStackIds);
		}
		$this->encodeData($stream);
	}

	abstract protected function encodeData(PacketSerializer $stream) : void;
}
