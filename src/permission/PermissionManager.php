<?php

declare(strict_types=1);

namespace pocketmine\permission;

use function count;
use function spl_object_id;

class PermissionManager{
	/** @var PermissionManager|null */
	private static $instance = null;

	public static function getInstance() : PermissionManager{
		if(self::$instance === null){
			self::$instance = new self;
		}

		return self::$instance;
	}

	/** @var Permission[] */
	protected $permissions = [];
	/** @var PermissibleInternal[][] */
	protected $permSubs = [];

	public function getPermission(string $name) : ?Permission{
		return $this->permissions[$name] ?? null;
	}

	public function addPermission(Permission $permission) : bool{
		if(!isset($this->permissions[$permission->getName()])){
			$this->permissions[$permission->getName()] = $permission;

			return true;
		}

		return false;
	}

	/**
	 * @param string|Permission $permission
	 */
	public function removePermission($permission) : void{
		if($permission instanceof Permission){
			unset($this->permissions[$permission->getName()]);
		}else{
			unset($this->permissions[$permission]);
		}
	}

	public function subscribeToPermission(string $permission, PermissibleInternal $permissible) : void{
		if(!isset($this->permSubs[$permission])){
			$this->permSubs[$permission] = [];
		}
		$this->permSubs[$permission][spl_object_id($permissible)] = $permissible;
	}

	public function unsubscribeFromPermission(string $permission, PermissibleInternal $permissible) : void{
		if(isset($this->permSubs[$permission])){
			unset($this->permSubs[$permission][spl_object_id($permissible)]);
			if(count($this->permSubs[$permission]) === 0){
				unset($this->permSubs[$permission]);
			}
		}
	}

	public function unsubscribeFromAllPermissions(PermissibleInternal $permissible) : void{
		foreach($this->permSubs as $permission => &$subs){
			unset($subs[spl_object_id($permissible)]);
			if(count($subs) === 0){
				unset($this->permSubs[$permission]);
			}
		}
	}

	/**
	 * @return PermissibleInternal[]
	 */
	public function getPermissionSubscriptions(string $permission) : array{
		return $this->permSubs[$permission] ?? [];
	}

	/**
	 * @return Permission[]
	 */
	public function getPermissions() : array{
		return $this->permissions;
	}

	public function clearPermissions() : void{
		$this->permissions = [];
	}
}
