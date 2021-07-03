<?php

declare(strict_types=1);

namespace pocketmine\command\defaults;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\utils\InvalidCommandSyntaxException;
use pocketmine\lang\KnownTranslationKeys;
use pocketmine\lang\TranslationContainer;
use pocketmine\permission\DefaultPermissionNames;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;
use function array_shift;
use function count;
use function implode;
use function trim;

class KickCommand extends VanillaCommand{

	public function __construct(string $name){
		parent::__construct(
			$name,
			"%" . KnownTranslationKeys::POCKETMINE_COMMAND_KICK_DESCRIPTION,
			"%" . KnownTranslationKeys::COMMANDS_KICK_USAGE
		);
		$this->setPermission(DefaultPermissionNames::COMMAND_KICK);
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args){
		if(!$this->testPermission($sender)){
			return true;
		}

		if(count($args) === 0){
			throw new InvalidCommandSyntaxException();
		}

		$name = array_shift($args);
		$reason = trim(implode(" ", $args));

		if(($player = $sender->getServer()->getPlayerByPrefix($name)) instanceof Player){
			$player->kick("Kicked by admin." . ($reason !== "" ? "Reason: " . $reason : ""));
			if($reason !== ""){
				Command::broadcastCommandMessage($sender, new TranslationContainer(KnownTranslationKeys::COMMANDS_KICK_SUCCESS_REASON, [$player->getName(), $reason]));
			}else{
				Command::broadcastCommandMessage($sender, new TranslationContainer(KnownTranslationKeys::COMMANDS_KICK_SUCCESS, [$player->getName()]));
			}
		}else{
			$sender->sendMessage(new TranslationContainer(TextFormat::RED . "%" . KnownTranslationKeys::COMMANDS_GENERIC_PLAYER_NOTFOUND));
		}

		return true;
	}
}
