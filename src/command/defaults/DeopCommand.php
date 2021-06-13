<?php

declare(strict_types=1);

namespace pocketmine\command\defaults;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\utils\InvalidCommandSyntaxException;
use pocketmine\lang\TranslationContainer;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;
use function array_shift;
use function count;

class DeopCommand extends VanillaCommand{

	public function __construct(string $name){
		parent::__construct(
			$name,
			"%pocketmine.command.deop.description",
			"%commands.deop.usage"
		);
		$this->setPermission("pocketmine.command.op.take");
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args){
		if(!$this->testPermission($sender)){
			return true;
		}

		if(count($args) === 0){
			throw new InvalidCommandSyntaxException();
		}

		$name = array_shift($args);
		if(!Player::isValidUserName($name)){
			throw new InvalidCommandSyntaxException();
		}

		$sender->getServer()->removeOp($name);
		if(($player = $sender->getServer()->getPlayerExact($name)) !== null){
			$player->sendMessage(TextFormat::GRAY . "You are no longer op!");
		}
		Command::broadcastCommandMessage($sender, new TranslationContainer("commands.deop.success", [$name]));

		return true;
	}
}
