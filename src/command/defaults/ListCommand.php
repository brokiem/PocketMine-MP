<?php

declare(strict_types=1);

namespace pocketmine\command\defaults;

use pocketmine\command\CommandSender;
use pocketmine\lang\KnownTranslationKeys;
use pocketmine\lang\TranslationContainer;
use pocketmine\permission\DefaultPermissionNames;
use pocketmine\player\Player;
use function array_filter;
use function array_map;
use function count;
use function implode;
use function sort;
use const SORT_STRING;

class ListCommand extends VanillaCommand{

	public function __construct(string $name){
		parent::__construct(
			$name,
			"%" . KnownTranslationKeys::POCKETMINE_COMMAND_LIST_DESCRIPTION,
			"%" . KnownTranslationKeys::COMMANDS_PLAYERS_USAGE
		);
		$this->setPermission(DefaultPermissionNames::COMMAND_LIST);
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args){
		if(!$this->testPermission($sender)){
			return true;
		}

		$playerNames = array_map(function(Player $player) : string{
			return $player->getName();
		}, array_filter($sender->getServer()->getOnlinePlayers(), function(Player $player) use ($sender) : bool{
			return !($sender instanceof Player) or $sender->canSee($player);
		}));
		sort($playerNames, SORT_STRING);

		$sender->sendMessage(new TranslationContainer(KnownTranslationKeys::COMMANDS_PLAYERS_LIST, [count($playerNames), $sender->getServer()->getMaxPlayers()]));
		$sender->sendMessage(implode(", ", $playerNames));

		return true;
	}
}
