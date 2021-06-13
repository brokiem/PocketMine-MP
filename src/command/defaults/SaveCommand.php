<?php

declare(strict_types=1);

namespace pocketmine\command\defaults;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\lang\TranslationContainer;
use function microtime;
use function round;

class SaveCommand extends VanillaCommand{

	public function __construct(string $name){
		parent::__construct(
			$name,
			"%pocketmine.command.save.description",
			"%commands.save.usage"
		);
		$this->setPermission("pocketmine.command.save.perform");
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args){
		if(!$this->testPermission($sender)){
			return true;
		}

		Command::broadcastCommandMessage($sender, new TranslationContainer("pocketmine.save.start"));
		$start = microtime(true);

		foreach($sender->getServer()->getOnlinePlayers() as $player){
			$player->save();
		}

		foreach($sender->getServer()->getWorldManager()->getWorlds() as $world){
			$world->save(true);
		}

		Command::broadcastCommandMessage($sender, new TranslationContainer("pocketmine.save.success", [round(microtime(true) - $start, 3)]));

		return true;
	}
}
