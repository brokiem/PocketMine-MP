<?php

declare(strict_types=1);

namespace pocketmine\event\server;

use pocketmine\updater\AutoUpdater;

/**
 * Called when the AutoUpdater receives notification of an available PocketMine-MP update.
 * Plugins may use this event to perform actions when an update notification is received.
 */
class UpdateNotifyEvent extends ServerEvent{
	/** @var AutoUpdater */
	private $updater;

	public function __construct(AutoUpdater $updater){
		$this->updater = $updater;
	}

	public function getUpdater() : AutoUpdater{
		return $this->updater;
	}
}
