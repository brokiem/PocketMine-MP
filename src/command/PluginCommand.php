<?php

declare(strict_types=1);

namespace pocketmine\command;

use pocketmine\command\utils\InvalidCommandSyntaxException;
use pocketmine\plugin\Plugin;
use pocketmine\plugin\PluginOwned;
use pocketmine\plugin\PluginOwnedTrait;

final class PluginCommand extends Command implements PluginOwned{
	use PluginOwnedTrait;

	/** @var CommandExecutor */
	private $executor;

	public function __construct(string $name, Plugin $owner, CommandExecutor $executor){
		parent::__construct($name);
		$this->owningPlugin = $owner;
		$this->executor = $executor;
		$this->usageMessage = "";
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args){

		if(!$this->owningPlugin->isEnabled()){
			return false;
		}

		if(!$this->testPermission($sender)){
			return false;
		}

		$success = $this->executor->onCommand($sender, $this, $commandLabel, $args);

		if(!$success and $this->usageMessage !== ""){
			throw new InvalidCommandSyntaxException();
		}

		return $success;
	}

	public function getExecutor() : CommandExecutor{
		return $this->executor;
	}

	public function setExecutor(CommandExecutor $executor) : void{
		$this->executor = $executor;
	}
}
