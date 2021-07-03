<?php

declare(strict_types=1);

namespace pocketmine\command\defaults;

use pocketmine\command\CommandSender;
use pocketmine\command\utils\InvalidCommandSyntaxException;
use pocketmine\lang\KnownTranslationKeys;
use pocketmine\lang\TranslationContainer;
use pocketmine\permission\BanEntry;
use pocketmine\permission\DefaultPermissionNames;
use function array_map;
use function count;
use function implode;
use function sort;
use function strtolower;
use const SORT_STRING;

class BanListCommand extends VanillaCommand{

	public function __construct(string $name){
		parent::__construct(
			$name,
			"%" . KnownTranslationKeys::POCKETMINE_COMMAND_BANLIST_DESCRIPTION,
			"%" . KnownTranslationKeys::COMMANDS_BANLIST_USAGE
		);
		$this->setPermission(DefaultPermissionNames::COMMAND_BAN_LIST);
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args){
		if(!$this->testPermission($sender)){
			return true;
		}

		if(isset($args[0])){
			$args[0] = strtolower($args[0]);
			if($args[0] === "ips"){
				$list = $sender->getServer()->getIPBans();
			}elseif($args[0] === "players"){
				$list = $sender->getServer()->getNameBans();
			}else{
				throw new InvalidCommandSyntaxException();
			}
		}else{
			$list = $sender->getServer()->getNameBans();
			$args[0] = "players";
		}

		$list = array_map(function(BanEntry $entry) : string{
			return $entry->getName();
		}, $list->getEntries());
		sort($list, SORT_STRING);
		$message = implode(", ", $list);

		if($args[0] === "ips"){
			$sender->sendMessage(new TranslationContainer(KnownTranslationKeys::COMMANDS_BANLIST_IPS, [count($list)]));
		}else{
			$sender->sendMessage(new TranslationContainer(KnownTranslationKeys::COMMANDS_BANLIST_PLAYERS, [count($list)]));
		}

		$sender->sendMessage($message);

		return true;
	}
}
