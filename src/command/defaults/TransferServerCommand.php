<?php

declare(strict_types=1);

namespace pocketmine\command\defaults;

use pocketmine\command\CommandSender;
use pocketmine\command\utils\InvalidCommandSyntaxException;
use pocketmine\lang\KnownTranslationKeys;
use pocketmine\permission\DefaultPermissionNames;
use pocketmine\player\Player;
use function count;

class TransferServerCommand extends VanillaCommand{

	public function __construct(string $name){
		parent::__construct(
			$name,
			"%" . KnownTranslationKeys::POCKETMINE_COMMAND_TRANSFERSERVER_DESCRIPTION,
			"%" . KnownTranslationKeys::POCKETMINE_COMMAND_TRANSFERSERVER_USAGE
		);
		$this->setPermission(DefaultPermissionNames::COMMAND_TRANSFERSERVER);
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args){
		if(!$this->testPermission($sender)){
			return true;
		}

		if(count($args) < 1){
			throw new InvalidCommandSyntaxException();
		}elseif(!($sender instanceof Player)){
			$sender->sendMessage("This command must be executed as a player");

			return false;
		}

		$sender->transfer($args[0], (int) ($args[1] ?? 19132));

		return true;
	}
}
