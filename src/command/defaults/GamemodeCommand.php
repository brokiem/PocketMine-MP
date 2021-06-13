<?php

declare(strict_types=1);

namespace pocketmine\command\defaults;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\utils\InvalidCommandSyntaxException;
use pocketmine\lang\TranslationContainer;
use pocketmine\player\GameMode;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;
use function count;

class GamemodeCommand extends VanillaCommand{

	public function __construct(string $name){
		parent::__construct(
			$name,
			"%pocketmine.command.gamemode.description",
			"%commands.gamemode.usage"
		);
		$this->setPermission("pocketmine.command.gamemode");
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

		if(isset($args[1])){
			$target = $sender->getServer()->getPlayerByPrefix($args[1]);
			if($target === null){
				$sender->sendMessage(new TranslationContainer(TextFormat::RED . "%commands.generic.player.notFound"));

				return true;
			}
		}elseif($sender instanceof Player){
			$target = $sender;
		}else{
			throw new InvalidCommandSyntaxException();
		}

		$target->setGamemode($gameMode);
		if(!$gameMode->equals($target->getGamemode())){
			$sender->sendMessage("Game mode change for " . $target->getName() . " failed!");
		}else{
			if($target === $sender){
				Command::broadcastCommandMessage($sender, new TranslationContainer("commands.gamemode.success.self", [$gameMode->getTranslationKey()]));
			}else{
				$target->sendMessage(new TranslationContainer("gameMode.changed", [$gameMode->getTranslationKey()]));
				Command::broadcastCommandMessage($sender, new TranslationContainer("commands.gamemode.success.other", [$gameMode->getTranslationKey(), $target->getName()]));
			}
		}

		return true;
	}
}
