<?php

declare(strict_types=1);

namespace pocketmine\command\defaults;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\utils\InvalidCommandSyntaxException;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\lang\TranslationContainer;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;
use function count;

class KillCommand extends VanillaCommand{

	public function __construct(string $name){
		parent::__construct(
			$name,
			"%pocketmine.command.kill.description",
			"%pocketmine.command.kill.usage",
			["suicide"]
		);
		$this->setPermission("pocketmine.command.kill.self;pocketmine.command.kill.other");
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args){
		if(!$this->testPermission($sender)){
			return true;
		}

		if(count($args) >= 2){
			throw new InvalidCommandSyntaxException();
		}

		if(count($args) === 1){
			if(!$sender->hasPermission("pocketmine.command.kill.other")){
				$sender->sendMessage($sender->getLanguage()->translateString(TextFormat::RED . "%commands.generic.permission"));

				return true;
			}

			$player = $sender->getServer()->getPlayerByPrefix($args[0]);

			if($player instanceof Player){
				$player->attack(new EntityDamageEvent($player, EntityDamageEvent::CAUSE_SUICIDE, 1000));
				Command::broadcastCommandMessage($sender, new TranslationContainer("commands.kill.successful", [$player->getName()]));
			}else{
				$sender->sendMessage(new TranslationContainer(TextFormat::RED . "%commands.generic.player.notFound"));
			}

			return true;
		}

		if($sender instanceof Player){
			if(!$sender->hasPermission("pocketmine.command.kill.self")){
				$sender->sendMessage($sender->getLanguage()->translateString(TextFormat::RED . "%commands.generic.permission"));

				return true;
			}

			$sender->attack(new EntityDamageEvent($sender, EntityDamageEvent::CAUSE_SUICIDE, 1000));
			$sender->sendMessage(new TranslationContainer("commands.kill.successful", [$sender->getName()]));
		}else{
			throw new InvalidCommandSyntaxException();
		}

		return true;
	}
}
