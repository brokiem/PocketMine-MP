<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types\inventory;

use pocketmine\network\mcpe\protocol\ProtocolInfo;
use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;

final class ItemStackWrapper{

	/** @var int */
	private $stackId;
	/** @var ItemStack */
	private $itemStack;

	public function __construct(int $stackId, ItemStack $itemStack){
		$this->stackId = $stackId;
		$this->itemStack = $itemStack;
	}

	public static function legacy(ItemStack $itemStack) : self{
		return new self($itemStack->getId() === 0 ? 0 : 1, $itemStack);
	}

	public function getStackId() : int{ return $this->stackId; }

	public function getItemStack() : ItemStack{ return $this->itemStack; }

	public static function read(PacketSerializer $in) : self{
		if($in->getProtocolId() >= ProtocolInfo::PROTOCOL_1_16_220){
			$stackId = 0;
			$stack = $in->getItemStack(function(PacketSerializer $in) use (&$stackId) : void{
				$hasNetId = $in->getBool();
				if($hasNetId){
					$stackId = $in->readGenericTypeNetworkId();
				}
			});
		}else{
			$stackId = $in->readGenericTypeNetworkId();
			$stack = $in->getItemStackWithoutStackId();
		}
		return new self($stackId, $stack);
	}

	public function write(PacketSerializer $out) : void{
		if($out->getProtocolId() >= ProtocolInfo::PROTOCOL_1_16_220){
			$out->putItemStack($this->itemStack, function(PacketSerializer $out) : void{
				$out->putBool($this->stackId !== 0);
				if($this->stackId !== 0){
					$out->writeGenericTypeNetworkId($this->stackId);
				}
			});
		}else{
			$out->writeGenericTypeNetworkId($this->stackId);
			$out->putItemStackWithoutStackId($this->itemStack);
		}
	}
}
