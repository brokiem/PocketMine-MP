<?php

declare(strict_types=1);

namespace pocketmine\command\defaults;

use pocketmine\command\CommandSender;
use pocketmine\command\utils\InvalidCommandSyntaxException;
use pocketmine\lang\KnownTranslationKeys;
use pocketmine\lang\TranslationContainer;
use pocketmine\permission\DefaultPermissionNames;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;
use function count;
use function implode;

class MeCommand extends VanillaCommand{

	public function __construct(string $name){
		parent::__construct(
			$name,
			"%" . KnownTranslationKeys::POCKETMINE_COMMAND_ME_DESCRIPTION,
			"%" . KnownTranslationKeys::COMMANDS_ME_USAGE
		);
		$this->setPermission(DefaultPermissionNames::COMMAND_ME);
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args){
		if(!$this->testPermission($sender)){
			return true;
		}

		if(count($args) === 0){
			throw new InvalidCommandSyntaxException();
		}

		$sender->getServer()->broadcastMessage(new TranslationContainer(KnownTranslationKeys::CHAT_TYPE_EMOTE, [$sender instanceof Player ? $sender->getDisplayName() : $sender->getName(), TextFormat::WHITE . implode(" ", $args)]));

		return true;
	}
}
