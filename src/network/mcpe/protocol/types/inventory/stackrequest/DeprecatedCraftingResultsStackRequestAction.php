<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types\inventory\stackrequest;

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;
use pocketmine\network\mcpe\protocol\types\inventory\ItemStack;
use function count;

/**
 * Not clear what this is needed for, but it is very clearly marked as deprecated, so hopefully it'll go away before I
 * have to write a proper description for it.
 */
final class DeprecatedCraftingResultsStackRequestAction extends ItemStackRequestAction{

	/** @var ItemStack[] */
	private $results;
	/** @var int */
	private $iterations;

	/**
	 * @param ItemStack[] $results
	 */
	public function __construct(array $results, int $iterations){
		$this->results = $results;
		$this->iterations = $iterations;
	}

	/** @return ItemStack[] */
	public function getResults() : array{ return $this->results; }

	public function getIterations() : int{ return $this->iterations; }

	public static function getTypeId() : int{
		return ItemStackRequestActionType::CRAFTING_RESULTS_DEPRECATED_ASK_TY_LAING;
	}

	public static function read(PacketSerializer $in) : self{
		$results = [];
		for($i = 0, $len = $in->getUnsignedVarInt(); $i < $len; ++$i){
			$results[] = $in->getItemStackWithoutStackId();
		}
		$iterations = $in->getByte();
		return new self($results, $iterations);
	}

	public function write(PacketSerializer $out) : void{
		$out->putUnsignedVarInt(count($this->results));
		foreach($this->results as $result){
			$out->putItemStackWithoutStackId($result);
		}
		$out->putByte($this->iterations);
	}
}
