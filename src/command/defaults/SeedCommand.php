<?php

declare(strict_types=1);

namespace pocketmine\command\defaults;

use pocketmine\command\CommandSender;
use pocketmine\lang\TranslationContainer;
use pocketmine\player\Player;

class SeedCommand extends VanillaCommand{

	public function __construct(string $name){
		parent::__construct(
			$name,
			"%pocketmine.command.seed.description",
			"%commands.seed.usage"
		);
		$this->setPermission("pocketmine.command.seed");
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args){
		if(!$this->testPermission($sender)){
			return true;
		}

		if($sender instanceof Player){
			$seed = $sender->getPosition()->getWorld()->getSeed();
		}else{
			$seed = $sender->getServer()->getWorldManager()->getDefaultWorld()->getSeed();
		}
		$sender->sendMessage(new TranslationContainer("commands.seed.success", [$seed]));

		return true;
	}
}
