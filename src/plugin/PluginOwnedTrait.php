<?php

declare(strict_types=1);

namespace pocketmine\plugin;

/**
 * @see PluginOwned
 */
trait PluginOwnedTrait{
	/** @var Plugin */
	private $owningPlugin;

	public function __construct(Plugin $owningPlugin){
		$this->owningPlugin = $owningPlugin;
	}

	public function getOwningPlugin() : Plugin{
		return $this->owningPlugin;
	}
}
