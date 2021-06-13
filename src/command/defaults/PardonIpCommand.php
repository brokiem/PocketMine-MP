<?php

declare(strict_types=1);

namespace pocketmine\command\defaults;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\utils\InvalidCommandSyntaxException;
use pocketmine\lang\TranslationContainer;
use function count;
use function preg_match;

class PardonIpCommand extends VanillaCommand{

	public function __construct(string $name){
		parent::__construct(
			$name,
			"%pocketmine.command.unban.ip.description",
			"%commands.unbanip.usage",
			["unban-ip"]
		);
		$this->setPermission("pocketmine.command.unban.ip");
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args){
		if(!$this->testPermission($sender)){
			return true;
		}

		if(count($args) !== 1){
			throw new InvalidCommandSyntaxException();
		}

		if(preg_match("/^([01]?\\d\\d?|2[0-4]\\d|25[0-5])\\.([01]?\\d\\d?|2[0-4]\\d|25[0-5])\\.([01]?\\d\\d?|2[0-4]\\d|25[0-5])\\.([01]?\\d\\d?|2[0-4]\\d|25[0-5])$/", $args[0])){
			$sender->getServer()->getIPBans()->remove($args[0]);
			$sender->getServer()->getNetwork()->unblockAddress($args[0]);
			Command::broadcastCommandMessage($sender, new TranslationContainer("commands.unbanip.success", [$args[0]]));
		}else{
			$sender->sendMessage(new TranslationContainer("commands.unbanip.invalid"));
		}

		return true;
	}
}
