<?php

declare(strict_types=1);

namespace pocketmine\command\defaults;

use pocketmine\command\CommandSender;
use pocketmine\command\utils\InvalidCommandSyntaxException;
use pocketmine\data\java\GameModeIdMap;
use pocketmine\lang\KnownTranslationKeys;
use pocketmine\lang\TranslationContainer;
use pocketmine\permission\DefaultPermissionNames;
use pocketmine\player\GameMode;
use function count;

class DefaultGamemodeCommand extends VanillaCommand{

	public function __construct(string $name){
		parent::__construct(
			$name,
			"%" . KnownTranslationKeys::POCKETMINE_COMMAND_DEFAULTGAMEMODE_DESCRIPTION,
			"%" . KnownTranslationKeys::COMMANDS_DEFAULTGAMEMODE_USAGE
		);
		$this->setPermission(DefaultPermissionNames::COMMAND_DEFAULTGAMEMODE);
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args){
		if(!$this->testPermission($sender)){
			return true;
		}

		if(count($args) === 0){
			throw new InvalidCommandSyntaxException();
		}

		$gameMode = GameMode::fromString($args[0]);
		if($gameMode === null){
			$sender->sendMessage("Unknown game mode");
			return true;
		}

		$sender->getServer()->getConfigGroup()->setConfigInt("gamemode", GameModeIdMap::getInstance()->toId($gameMode));
		$sender->sendMessage(new TranslationContainer(KnownTranslationKeys::COMMANDS_DEFAULTGAMEMODE_SUCCESS, [$gameMode->getTranslationKey()]));
		return true;
	}
}
