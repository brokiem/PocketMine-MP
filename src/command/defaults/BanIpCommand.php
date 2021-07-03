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
use function array_shift;
use function count;
use function implode;
use function preg_match;

class BanIpCommand extends VanillaCommand{

	public function __construct(string $name){
		parent::__construct(
			$name,
			"%" . KnownTranslationKeys::POCKETMINE_COMMAND_BAN_IP_DESCRIPTION,
			"%" . KnownTranslationKeys::COMMANDS_BANIP_USAGE
		);
		$this->setPermission(DefaultPermissionNames::COMMAND_BAN_IP);
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args){
		if(!$this->testPermission($sender)){
			return true;
		}

		if(count($args) === 0){
			throw new InvalidCommandSyntaxException();
		}

		$value = array_shift($args);
		$reason = implode(" ", $args);

		if(preg_match("/^([01]?\\d\\d?|2[0-4]\\d|25[0-5])\\.([01]?\\d\\d?|2[0-4]\\d|25[0-5])\\.([01]?\\d\\d?|2[0-4]\\d|25[0-5])\\.([01]?\\d\\d?|2[0-4]\\d|25[0-5])$/", $value)){
			$this->processIPBan($value, $sender, $reason);

			Command::broadcastCommandMessage($sender, new TranslationContainer(KnownTranslationKeys::COMMANDS_BANIP_SUCCESS, [$value]));
		}else{
			if(($player = $sender->getServer()->getPlayerByPrefix($value)) instanceof Player){
				$ip = $player->getNetworkSession()->getIp();
				$this->processIPBan($ip, $sender, $reason);

				Command::broadcastCommandMessage($sender, new TranslationContainer(KnownTranslationKeys::COMMANDS_BANIP_SUCCESS_PLAYERS, [$ip, $player->getName()]));
			}else{
				$sender->sendMessage(new TranslationContainer(KnownTranslationKeys::COMMANDS_BANIP_INVALID));

				return false;
			}
		}

		return true;
	}

	private function processIPBan(string $ip, CommandSender $sender, string $reason) : void{
		$sender->getServer()->getIPBans()->addBan($ip, $reason, null, $sender->getName());

		foreach($sender->getServer()->getOnlinePlayers() as $player){
			if($player->getNetworkSession()->getIp() === $ip){
				$player->kick("Banned by admin. Reason: " . ($reason !== "" ? $reason : "IP banned."));
			}
		}

		$sender->getServer()->getNetwork()->blockAddress($ip, -1);
	}
}
