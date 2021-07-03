<?php

declare(strict_types=1);

namespace pocketmine\command\defaults;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\lang\KnownTranslationKeys;
use pocketmine\lang\TranslationContainer;
use pocketmine\permission\DefaultPermissionNames;

class StopCommand extends VanillaCommand{

	public function __construct(string $name){
		parent::__construct(
			$name,
			"%" . KnownTranslationKeys::POCKETMINE_COMMAND_STOP_DESCRIPTION,
			"%" . KnownTranslationKeys::COMMANDS_STOP_USAGE
		);
		$this->setPermission(DefaultPermissionNames::COMMAND_STOP);
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args){
		if(!$this->testPermission($sender)){
			return true;
		}

		Command::broadcastCommandMessage($sender, new TranslationContainer(KnownTranslationKeys::COMMANDS_STOP_START));

		$sender->getServer()->shutdown();

		return true;
	}
}
