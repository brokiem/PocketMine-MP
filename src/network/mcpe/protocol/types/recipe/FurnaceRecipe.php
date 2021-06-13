<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types\recipe;

use pocketmine\network\mcpe\protocol\CraftingDataPacket;
use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;
use pocketmine\network\mcpe\protocol\types\inventory\ItemStack;

final class FurnaceRecipe extends RecipeWithTypeId{

	/** @var int */
	private $inputId;
	/** @var int|null */
	private $inputMeta;
	/** @var ItemStack */
	private $result;
	/** @var string */
	private $blockName;

	public function __construct(int $typeId, int $inputId, ?int $inputMeta, ItemStack $result, string $blockName){
		parent::__construct($typeId);
		$this->inputId = $inputId;
		$this->inputMeta = $inputMeta;
		$this->result = $result;
		$this->blockName = $blockName;
	}

	public function getInputId() : int{
		return $this->inputId;
	}

	public function getInputMeta() : ?int{
		return $this->inputMeta;
	}

	public function getResult() : ItemStack{
		return $this->result;
	}

	public function getBlockName() : string{
		return $this->blockName;
	}

	public static function decode(int $typeId, PacketSerializer $in) : self{
		$inputId = $in->getVarInt();
		$inputData = null;
		if($typeId === CraftingDataPacket::ENTRY_FURNACE_DATA){
			$inputData = $in->getVarInt();
		}
		$output = $in->getItemStackWithoutStackId();
		$block = $in->getString();

		return new self($typeId, $inputId, $inputData, $output, $block);
	}

	public function encode(PacketSerializer $out) : void{
		$out->putVarInt($this->inputId);
		if($this->getTypeId() === CraftingDataPacket::ENTRY_FURNACE_DATA){
			$out->putVarInt($this->inputMeta);
		}
		$out->putItemStackWithoutStackId($this->result);
		$out->putString($this->blockName);
	}
}
