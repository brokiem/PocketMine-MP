<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types\command;

class CommandData{
	/** @var string */
	public $name;
	/** @var string */
	public $description;
	/** @var int */
	public $flags;
	/** @var int */
	public $permission;
	/** @var CommandEnum|null */
	public $aliases;
	/** @var CommandParameter[][] */
	public $overloads = [];

	/**
	 * @param CommandParameter[][] $overloads
	 */
	public function __construct(string $name, string $description, int $flags, int $permission, ?CommandEnum $aliases, array $overloads){
		(function(array ...$overloads) : void{
			foreach($overloads as $overload){
				(function(CommandParameter ...$parameters) : void{})(...$overload);
			}
		})(...$overloads);
		$this->name = $name;
		$this->description = $description;
		$this->flags = $flags;
		$this->permission = $permission;
		$this->aliases = $aliases;
		$this->overloads = $overloads;
	}

	public function getName() : string{
		return $this->name;
	}

	public function getDescription() : string{
		return $this->description;
	}

	public function getFlags() : int{
		return $this->flags;
	}

	public function getPermission() : int{
		return $this->permission;
	}

	public function getAliases() : ?CommandEnum{
		return $this->aliases;
	}

	/**
	 * @return CommandParameter[][]
	 */
	public function getOverloads() : array{
		return $this->overloads;
	}
}
