<?php

declare(strict_types=1);

namespace pocketmine\utils;

use function preg_match;

trait EnumTrait{
	use RegistryTrait;

	/**
	 * Registers the given object as an enum member.
	 *
	 * @throws \InvalidArgumentException
	 */
	protected static function register(self $member) : void{
		self::_registryRegister($member->name(), $member);
	}

	protected static function registerAll(self ...$members) : void{
		foreach($members as $member){
			self::register($member);
		}
	}

	/**
	 * Returns all members of the enum.
	 * This is overridden to change the return typehint.
	 *
	 * @return self[]
	 */
	public static function getAll() : array{
		//phpstan doesn't support generic traits yet :(
		/** @var self[] $result */
		$result = self::_registryGetAll();
		return $result;
	}

	/** @var int|null */
	private static $nextId = null;

	/** @var string */
	private $enumName;
	/** @var int */
	private $runtimeId;

	/**
	 * @throws \InvalidArgumentException
	 */
	private function __construct(string $enumName){
		if(preg_match('/^\D[A-Za-z\d_]+$/u', $enumName, $matches) === 0){
			throw new \InvalidArgumentException("Invalid enum member name \"$enumName\", should only contain letters, numbers and underscores, and must not start with a number");
		}
		$this->enumName = $enumName;
		if(self::$nextId === null){
			self::$nextId = Process::pid(); //this provides enough base entropy to prevent hardcoding
		}
		$this->runtimeId = self::$nextId++;
	}

	public function name() : string{
		return $this->enumName;
	}

	/**
	 * Returns a runtime-only identifier for this enum member. This will be different with each run, so don't try to
	 * hardcode it.
	 * This can be useful for switches or array indexing.
	 */
	public function id() : int{
		return $this->runtimeId;
	}

	/**
	 * Returns whether the two objects are equivalent.
	 */
	public function equals(self $other) : bool{
		return $this->enumName === $other->enumName;
	}

	public function __clone(){
		throw new \LogicException("Enum members cannot be cloned");
	}

	public function __sleep(){
		throw new \LogicException("Enum members cannot be serialized");
	}

	public function __wakeup(){
		throw new \LogicException("Enum members cannot be unserialized");
	}
}
