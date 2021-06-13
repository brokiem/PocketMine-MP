<?php

declare(strict_types=1);

namespace pocketmine\permission;

class PermissionAttachmentInfo{
	/** @var string */
	private $permission;

	/** @var PermissionAttachment|null */
	private $attachment;

	/** @var bool */
	private $value;

	/** @var PermissionAttachmentInfo|null */
	private $groupPermission;

	public function __construct(string $permission, ?PermissionAttachment $attachment, bool $value, ?PermissionAttachmentInfo $groupPermission){
		$this->permission = $permission;
		$this->attachment = $attachment;
		$this->value = $value;
		$this->groupPermission = $groupPermission;
	}

	public function getPermission() : string{
		return $this->permission;
	}

	public function getAttachment() : ?PermissionAttachment{
		return $this->attachment;
	}

	public function getValue() : bool{
		return $this->value;
	}

	/**
	 * Returns the info of the permission group that caused this permission to be set, if any.
	 * If null, the permission was set explicitly, either by a permission attachment or base permission.
	 */
	public function getGroupPermissionInfo() : ?PermissionAttachmentInfo{ return $this->groupPermission; }
}
