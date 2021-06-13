<?php

declare(strict_types=1);

namespace pocketmine\command\defaults;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\lang\TranslationContainer;

class StopCommand extends VanillaCommand{

	public function __construct(string $name){
		parent::__construct(
			$name,
			"%pocketmine.command.stop.description",
			"%commands.stop.usage"
		);
		$this->setPermission("pocketmine.command.stop");
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args){
		if(!$this->testPermission($sender)){
			return true;
		}

		Command::broadcastCommandMessage($sender, new TranslationContainer("commands.stop.start"));

		$sender->getServer()->shutdown();

		return true;
	}
}
