<?php

declare(strict_types=1);

/**
 * Plugin related classes
 */
namespace pocketmine\plugin;

use pocketmine\scheduler\TaskScheduler;
use pocketmine\Server;

/**
 * It is recommended to use PluginBase for the actual plugin
 */
interface Plugin{

	public function __construct(PluginLoader $loader, Server $server, PluginDescription $description, string $dataFolder, string $file, ResourceProvider $resourceProvider);

	public function isEnabled() : bool;

	/**
	 * Called by the plugin manager when the plugin is enabled or disabled to inform the plugin of its enabled state.
	 *
	 * @internal This is intended for core use only and should not be used by plugins
	 * @see PluginManager::enablePlugin()
	 * @see PluginManager::disablePlugin()
	 */
	public function onEnableStateChange(bool $enabled) : void;

	/**
	 * Gets the plugin's data folder to save files and configuration.
	 * This directory name has a trailing slash.
	 */
	public function getDataFolder() : string;

	public function getDescription() : PluginDescription;

	public function getName() : string;

	public function getLogger() : \AttachableLogger;

	public function getPluginLoader() : PluginLoader;

	public function getScheduler() : TaskScheduler;

}
