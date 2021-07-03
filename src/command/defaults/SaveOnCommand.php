<?php

declare(strict_types=1);

namespace pocketmine\command\defaults;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\lang\KnownTranslationKeys;
use pocketmine\lang\TranslationContainer;
use pocketmine\permission\DefaultPermissionNames;

class SaveOnCommand extends VanillaCommand{

	public function __construct(string $name){
		parent::__construct(
			$name,
			"%" . KnownTranslationKeys::POCKETMINE_COMMAND_SAVEON_DESCRIPTION,
			"%" . KnownTranslationKeys::COMMANDS_SAVE_ON_USAGE
		);
		$this->setPermission(DefaultPermissionNames::COMMAND_SAVE_ENABLE);
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args){
		if(!$this->testPermission($sender)){
			return true;
		}

		$sender->getServer()->getWorldManager()->setAutoSave(true);

		Command::broadcastCommandMessage($sender, new TranslationContainer(KnownTranslationKeys::COMMANDS_SAVE_ENABLED));

		return true;
	}
}
