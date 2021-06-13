<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types\command;

class CommandEnum{
	/** @var string */
	private $enumName;
	/**
	 * @var string[]
	 * @phpstan-var list<string>
	 */
	private $enumValues = [];

	/**
	 * @param string[] $enumValues
	 * @phpstan-param list<string> $enumValues
	 */
	public function __construct(string $enumName, array $enumValues){
		$this->enumName = $enumName;
		$this->enumValues = $enumValues;
	}

	public function getName() : string{
		return $this->enumName;
	}

	/**
	 * @return string[]
	 * @phpstan-return list<string>
	 */
	public function getValues() : array{
		return $this->enumValues;
	}
}
