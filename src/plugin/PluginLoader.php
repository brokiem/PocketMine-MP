<?php

declare(strict_types=1);

namespace pocketmine\plugin;

/**
 * Handles different types of plugins
 */
interface PluginLoader{

	/**
	 * Returns whether this PluginLoader can load the plugin in the given path.
	 */
	public function canLoadPlugin(string $path) : bool;

	/**
	 * Loads the plugin contained in $file
	 */
	public function loadPlugin(string $file) : void;

	/**
	 * Gets the PluginDescription from the file
	 */
	public function getPluginDescription(string $file) : ?PluginDescription;

	/**
	 * Returns the protocol prefix used to access files in this plugin, e.g. file://, phar://
	 */
	public function getAccessProtocol() : string;
}
