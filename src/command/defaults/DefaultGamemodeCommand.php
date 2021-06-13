<?php

declare(strict_types=1);

namespace pocketmine\command\defaults;

use pocketmine\command\CommandSender;
use pocketmine\command\utils\InvalidCommandSyntaxException;
use pocketmine\lang\TranslationContainer;
use pocketmine\player\GameMode;
use function count;

class DefaultGamemodeCommand extends VanillaCommand{

	public function __construct(string $name){
		parent::__construct(
			$name,
			"%pocketmine.command.defaultgamemode.description",
			"%commands.defaultgamemode.usage"
		);
		$this->setPermission("pocketmine.command.defaultgamemode");
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args){
		if(!$this->testPermission($sender)){
			return true;
		}

		if(count($args) === 0){
			throw new InvalidCommandSyntaxException();
		}

		try{
			$gameMode = GameMode::fromString($args[0]);
		}catch(\InvalidArgumentException $e){
			$sender->sendMessage("Unknown game mode");
			return true;
		}

		$sender->getServer()->getConfigGroup()->setConfigInt("gamemode", $gameMode->getMagicNumber());
		$sender->sendMessage(new TranslationContainer("commands.defaultgamemode.success", [$gameMode->getTranslationKey()]));
		return true;
	}
}
