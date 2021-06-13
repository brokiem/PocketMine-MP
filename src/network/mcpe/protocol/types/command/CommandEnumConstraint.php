<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types\command;

class CommandEnumConstraint{
	/** @var CommandEnum */
	private $enum;
	/** @var int */
	private $valueOffset;
	/** @var int[] */
	private $constraints; //TODO: find constants

	/**
	 * @param int[]       $constraints
	 */
	public function __construct(CommandEnum $enum, int $valueOffset, array $constraints){
		(static function(int ...$_) : void{})(...$constraints);
		if(!isset($enum->getValues()[$valueOffset])){
			throw new \InvalidArgumentException("Invalid enum value offset $valueOffset");
		}
		$this->enum = $enum;
		$this->valueOffset = $valueOffset;
		$this->constraints = $constraints;
	}

	public function getEnum() : CommandEnum{
		return $this->enum;
	}

	public function getValueOffset() : int{
		return $this->valueOffset;
	}

	public function getAffectedValue() : string{
		return $this->enum->getValues()[$this->valueOffset];
	}

	/**
	 * @return int[]
	 */
	public function getConstraints() : array{
		return $this->constraints;
	}
}
