<?php

declare(strict_types=1);

namespace pocketmine\command\defaults;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\utils\InvalidCommandSyntaxException;
use pocketmine\lang\TranslationContainer;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;
use pocketmine\world\World;
use function count;

class TimeCommand extends VanillaCommand{

	public function __construct(string $name){
		parent::__construct(
			$name,
			"%pocketmine.command.time.description",
			"%pocketmine.command.time.usage"
		);
		$this->setPermission("pocketmine.command.time.add;pocketmine.command.time.set;pocketmine.command.time.start;pocketmine.command.time.stop");
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args){
		if(count($args) < 1){
			throw new InvalidCommandSyntaxException();
		}

		if($args[0] === "start"){
			if(!$sender->hasPermission("pocketmine.command.time.start")){
				$sender->sendMessage($sender->getLanguage()->translateString(TextFormat::RED . "%commands.generic.permission"));

				return true;
			}
			foreach($sender->getServer()->getWorldManager()->getWorlds() as $world){
				$world->startTime();
			}
			Command::broadcastCommandMessage($sender, "Restarted the time");
			return true;
		}elseif($args[0] === "stop"){
			if(!$sender->hasPermission("pocketmine.command.time.stop")){
				$sender->sendMessage($sender->getLanguage()->translateString(TextFormat::RED . "%commands.generic.permission"));

				return true;
			}
			foreach($sender->getServer()->getWorldManager()->getWorlds() as $world){
				$world->stopTime();
			}
			Command::broadcastCommandMessage($sender, "Stopped the time");
			return true;
		}elseif($args[0] === "query"){
			if(!$sender->hasPermission("pocketmine.command.time.query")){
				$sender->sendMessage($sender->getLanguage()->translateString(TextFormat::RED . "%commands.generic.permission"));

				return true;
			}
			if($sender instanceof Player){
				$world = $sender->getWorld();
			}else{
				$world = $sender->getServer()->getWorldManager()->getDefaultWorld();
			}
			$sender->sendMessage($sender->getLanguage()->translateString("commands.time.query", [$world->getTime()]));
			return true;
		}

		if(count($args) < 2){
			throw new InvalidCommandSyntaxException();
		}

		if($args[0] === "set"){
			if(!$sender->hasPermission("pocketmine.command.time.set")){
				$sender->sendMessage($sender->getLanguage()->translateString(TextFormat::RED . "%commands.generic.permission"));

				return true;
			}

			switch($args[1]){
				case "day":
					$value = World::TIME_DAY;
					break;
				case "noon":
					$value = World::TIME_NOON;
					break;
				case "sunset":
					$value = World::TIME_SUNSET;
					break;
				case "night":
					$value = World::TIME_NIGHT;
					break;
				case "midnight":
					$value = World::TIME_MIDNIGHT;
					break;
				case "sunrise":
					$value = World::TIME_SUNRISE;
					break;
				default:
					$value = $this->getInteger($sender, $args[1], 0);
					break;
			}

			foreach($sender->getServer()->getWorldManager()->getWorlds() as $world){
				$world->setTime($value);
			}
			Command::broadcastCommandMessage($sender, new TranslationContainer("commands.time.set", [$value]));
		}elseif($args[0] === "add"){
			if(!$sender->hasPermission("pocketmine.command.time.add")){
				$sender->sendMessage($sender->getLanguage()->translateString(TextFormat::RED . "%commands.generic.permission"));

				return true;
			}

			$value = $this->getInteger($sender, $args[1], 0);
			foreach($sender->getServer()->getWorldManager()->getWorlds() as $world){
				$world->setTime($world->getTime() + $value);
			}
			Command::broadcastCommandMessage($sender, new TranslationContainer("commands.time.added", [$value]));
		}else{
			throw new InvalidCommandSyntaxException();
		}

		return true;
	}
}
