<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types\inventory\stackrequest;

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

/**
 * Completes a transaction involving a beacon consuming input to produce effects.
 */
final class BeaconPaymentStackRequestAction extends ItemStackRequestAction{

	/** @var int */
	private $primaryEffectId;
	/** @var int */
	private $secondaryEffectId;

	public function __construct(int $primaryEffectId, int $secondaryEffectId){
		$this->primaryEffectId = $primaryEffectId;
		$this->secondaryEffectId = $secondaryEffectId;
	}

	public function getPrimaryEffectId() : int{ return $this->primaryEffectId; }

	public function getSecondaryEffectId() : int{ return $this->secondaryEffectId; }

	public static function getTypeId() : int{ return ItemStackRequestActionType::BEACON_PAYMENT; }

	public static function read(PacketSerializer $in) : self{
		$primary = $in->getVarInt();
		$secondary = $in->getVarInt();
		return new self($primary, $secondary);
	}

	public function write(PacketSerializer $out) : void{
		$out->putVarInt($this->primaryEffectId);
		$out->putVarInt($this->secondaryEffectId);
	}
}
