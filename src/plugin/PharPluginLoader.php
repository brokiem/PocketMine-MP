<?php

declare(strict_types=1);

namespace pocketmine\plugin;

use function is_file;
use function strlen;
use function substr;

/**
 * Handles different types of plugins
 */
class PharPluginLoader implements PluginLoader{

	/** @var \DynamicClassLoader */
	private $loader;

	public function __construct(\DynamicClassLoader $loader){
		$this->loader = $loader;
	}

	public function canLoadPlugin(string $path) : bool{
		$ext = ".phar";
		return is_file($path) and substr($path, -strlen($ext)) === $ext;
	}

	/**
	 * Loads the plugin contained in $file
	 */
	public function loadPlugin(string $file) : void{
		$description = $this->getPluginDescription($file);
		if($description !== null){
			$this->loader->addPath($description->getSrcNamespacePrefix(), "$file/src");
		}
	}

	/**
	 * Gets the PluginDescription from the file
	 */
	public function getPluginDescription(string $file) : ?PluginDescription{
		$phar = new \Phar($file);
		if(isset($phar["plugin.yml"])){
			return new PluginDescription($phar["plugin.yml"]->getContent());
		}

		return null;
	}

	public function getAccessProtocol() : string{
		return "phar://";
	}
}
