<?php

declare(strict_types=1);

namespace pocketmine\command\defaults;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\lang\KnownTranslationKeys;
use pocketmine\lang\TranslationContainer;
use pocketmine\permission\DefaultPermissionNames;

class SaveOffCommand extends VanillaCommand{

	public function __construct(string $name){
		parent::__construct(
			$name,
			"%" . KnownTranslationKeys::POCKETMINE_COMMAND_SAVEOFF_DESCRIPTION,
			"%" . KnownTranslationKeys::COMMANDS_SAVE_OFF_USAGE
		);
		$this->setPermission(DefaultPermissionNames::COMMAND_SAVE_DISABLE);
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args){
		if(!$this->testPermission($sender)){
			return true;
		}

		$sender->getServer()->getWorldManager()->setAutoSave(false);

		Command::broadcastCommandMessage($sender, new TranslationContainer(KnownTranslationKeys::COMMANDS_SAVE_DISABLED));

		return true;
	}
}
