<?php

declare(strict_types=1);

namespace pocketmine\permission;

use pocketmine\plugin\Plugin;
use pocketmine\utils\ObjectSet;

trait PermissibleDelegateTrait{

	/** @var PermissibleBase */
	private $perm;

	/**
	 * @param Permission|string $name
	 */
	public function setBasePermission($name, bool $value) : void{
		$this->perm->setBasePermission($name, $value);
	}

	/**
	 * @param Permission|string $name
	 */
	public function unsetBasePermission($name) : void{
		$this->perm->unsetBasePermission($name);
	}

	/**
	 * @param Permission|string $name
	 */
	public function isPermissionSet($name) : bool{
		return $this->perm->isPermissionSet($name);
	}

	/**
	 * @param Permission|string $name
	 */
	public function hasPermission($name) : bool{
		return $this->perm->hasPermission($name);
	}

	public function addAttachment(Plugin $plugin, ?string $name = null, ?bool $value = null) : PermissionAttachment{
		return $this->perm->addAttachment($plugin, $name, $value);
	}

	public function removeAttachment(PermissionAttachment $attachment) : void{
		$this->perm->removeAttachment($attachment);
	}

	public function recalculatePermissions() : array{
		return $this->perm->recalculatePermissions();
	}

	/**
	 * @return ObjectSet|\Closure[]
	 * @phpstan-return ObjectSet<\Closure(array<string, bool> $changedPermissionsOldValues) : void>
	 */
	public function getPermissionRecalculationCallbacks() : ObjectSet{
		return $this->perm->getPermissionRecalculationCallbacks();
	}

	/**
	 * @return PermissionAttachmentInfo[]
	 */
	public function getEffectivePermissions() : array{
		return $this->perm->getEffectivePermissions();
	}

}
