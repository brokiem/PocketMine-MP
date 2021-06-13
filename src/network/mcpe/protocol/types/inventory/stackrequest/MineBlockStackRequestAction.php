<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types\inventory\stackrequest;

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

final class MineBlockStackRequestAction extends ItemStackRequestAction{

	/** @var int */
	private $unknown1;
	/** @var int */
	private $predictedDurability;
	/** @var int */
	private $stackId;

	public function __construct(int $unknown1, int $predictedDurability, int $stackId){
		$this->unknown1 = $unknown1;
		$this->predictedDurability = $predictedDurability;
		$this->stackId = $stackId;
	}

	public function getUnknown1() : int{ return $this->unknown1; }

	public function getPredictedDurability() : int{ return $this->predictedDurability; }

	public function getStackId() : int{ return $this->stackId; }

	public static function getTypeId() : int{ return ItemStackRequestActionType::MINE_BLOCK; }

	public static function read(PacketSerializer $in) : self{
		$unknown1 = $in->getVarInt();
		$predictedDurability = $in->getVarInt();
		$stackId = $in->readGenericTypeNetworkId();
		return new self($unknown1, $predictedDurability, $stackId);
	}

	public function write(PacketSerializer $out) : void{
		$out->putVarInt($this->unknown1);
		$out->putVarInt($this->predictedDurability);
		$out->writeGenericTypeNetworkId($this->stackId);
	}
}
