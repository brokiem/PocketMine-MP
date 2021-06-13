<?php

declare(strict_types=1);

namespace pocketmine\command\defaults;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\utils\InvalidCommandSyntaxException;
use pocketmine\lang\TranslationContainer;
use pocketmine\world\World;
use function count;

class DifficultyCommand extends VanillaCommand{

	public function __construct(string $name){
		parent::__construct(
			$name,
			"%pocketmine.command.difficulty.description",
			"%commands.difficulty.usage"
		);
		$this->setPermission("pocketmine.command.difficulty");
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args){
		if(!$this->testPermission($sender)){
			return true;
		}

		if(count($args) !== 1){
			throw new InvalidCommandSyntaxException();
		}

		$difficulty = World::getDifficultyFromString($args[0]);

		if($sender->getServer()->isHardcore()){
			$difficulty = World::DIFFICULTY_HARD;
		}

		if($difficulty !== -1){
			$sender->getServer()->getConfigGroup()->setConfigInt("difficulty", $difficulty);

			//TODO: add per-world support
			foreach($sender->getServer()->getWorldManager()->getWorlds() as $world){
				$world->setDifficulty($difficulty);
			}

			Command::broadcastCommandMessage($sender, new TranslationContainer("commands.difficulty.success", [$difficulty]));
		}else{
			throw new InvalidCommandSyntaxException();
		}

		return true;
	}
}
