<?php

declare(strict_types=1);

namespace pocketmine\permission;

interface PermissionRemovedExecutor{

	public function attachmentRemoved(Permissible $permissible, PermissionAttachment $attachment) : void;
}
