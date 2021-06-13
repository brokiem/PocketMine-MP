<?php

declare(strict_types=1);

namespace pocketmine\plugin;

/**
 * This interface may be implemented by objects which are owned by plugins, to allow them to be identified as such.
 */
interface PluginOwned{

	public function getOwningPlugin() : Plugin;
}
