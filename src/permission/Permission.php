<?php

declare(strict_types=1);

/**
 * Permission related classes
 */

namespace pocketmine\permission;

/**
 * Represents a permission
 */
class Permission{
	/** @var string */
	private $name;

	/** @var string */
	private $description;

	/**
	 * @var bool[]
	 * @phpstan-var array<string, bool>
	 */
	private $children;

	/**
	 * Creates a new Permission object to be attached to Permissible objects
	 *
	 * @param bool[] $children
	 * @phpstan-param array<string, bool> $children
	 */
	public function __construct(string $name, ?string $description = null, array $children = []){
		$this->name = $name;
		$this->description = $description ?? "";
		$this->children = $children;

		$this->recalculatePermissibles();
	}

	public function getName() : string{
		return $this->name;
	}

	/**
	 * @return bool[]
	 * @phpstan-return array<string, bool>
	 */
	public function getChildren() : array{
		return $this->children;
	}

	public function getDescription() : string{
		return $this->description;
	}

	public function setDescription(string $value) : void{
		$this->description = $value;
	}

	/**
	 * @return PermissibleInternal[]
	 */
	public function getPermissibles() : array{
		return PermissionManager::getInstance()->getPermissionSubscriptions($this->name);
	}

	public function recalculatePermissibles() : void{
		$perms = $this->getPermissibles();

		foreach($perms as $p){
			$p->recalculatePermissions();
		}
	}

	public function addChild(string $name, bool $value) : void{
		$this->children[$name] = $value;
		$this->recalculatePermissibles();
	}

	public function removeChild(string $name) : void{
		unset($this->children[$name]);
		$this->recalculatePermissibles();

	}
}
