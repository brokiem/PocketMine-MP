<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types\entity;

trait IntegerishMetadataProperty{
	/** @var int */
	private $value;

	public function __construct(int $value){
		if($value < $this->min() or $value > $this->max()){
			throw new \InvalidArgumentException("Value is out of range " . $this->min() . " - " . $this->max());
		}
		$this->value = $value;
	}

	abstract protected function min() : int;

	abstract protected function max() : int;

	public function getValue() : int{
		return $this->value;
	}

	public function equals(MetadataProperty $other) : bool{
		return $other instanceof self and $other->value === $this->value;
	}

	/**
	 * @param bool[] $flags
	 * @phpstan-param array<int, bool> $flags
	 */
	public static function buildFromFlags(array $flags) : self{
		$value = 0;
		foreach($flags as $flag => $v){
			if($v){
				$value |= 1 << $flag;
			}
		}
		return new self($value);
	}
}
