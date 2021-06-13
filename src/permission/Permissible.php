<?php

declare(strict_types=1);

namespace pocketmine\permission;

use pocketmine\plugin\Plugin;
use pocketmine\utils\ObjectSet;

interface Permissible{

	/**
	 * Assigns a baseline permission to the permissible. This is **always** calculated before anything else, which means
	 * that permissions set using addAttachment() will always override base permissions.
	 * You probably don't want to use this if you're not assigning (denying) operator permissions.
	 *
	 * @internal
	 * @see Permissible::addAttachment() for normal permission assignments
	 * @param Permission|string $name
	 */
	public function setBasePermission($name, bool $grant) : void;

	/**
	 * Unsets a baseline permission previously set. If it wasn't already set, this will have no effect.
	 * Note that this might have different results than setting the permission to false.
	 *
	 * @internal
	 * @param Permission|string $name
	 */
	public function unsetBasePermission($name) : void;

	/**
	 * Checks if this instance has a permission overridden
	 *
	 * @param string|Permission $name
	 */
	public function isPermissionSet($name) : bool;

	/**
	 * Returns the permission value if overridden, or the default value if not
	 *
	 * @param string|Permission $name
	 */
	public function hasPermission($name) : bool;

	public function addAttachment(Plugin $plugin, ?string $name = null, ?bool $value = null) : PermissionAttachment;

	public function removeAttachment(PermissionAttachment $attachment) : void;

	/**
	 * @return bool[] changed permission name => old value
	 * @phpstan-return array<string, bool>
	 */
	public function recalculatePermissions() : array;

	/**
	 * @return ObjectSet|\Closure[]
	 * @phpstan-return ObjectSet<\Closure(array<string, bool> $changedPermissionsOldValues) : void>
	 */
	public function getPermissionRecalculationCallbacks() : ObjectSet;

	/**
	 * @return PermissionAttachmentInfo[]
	 */
	public function getEffectivePermissions() : array;

}
