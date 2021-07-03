<?php

declare(strict_types=1);

namespace pocketmine\command\defaults;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\utils\InvalidCommandSyntaxException;
use pocketmine\lang\KnownTranslationKeys;
use pocketmine\lang\TranslationContainer;
use pocketmine\math\Vector3;
use pocketmine\permission\DefaultPermissionNames;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;
use function count;
use function round;

class SetWorldSpawnCommand extends VanillaCommand{

	public function __construct(string $name){
		parent::__construct(
			$name,
			"%" . KnownTranslationKeys::POCKETMINE_COMMAND_SETWORLDSPAWN_DESCRIPTION,
			"%" . KnownTranslationKeys::COMMANDS_SETWORLDSPAWN_USAGE
		);
		$this->setPermission(DefaultPermissionNames::COMMAND_SETWORLDSPAWN);
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args){
		if(!$this->testPermission($sender)){
			return true;
		}

		if(count($args) === 0){
			if($sender instanceof Player){
				$location = $sender->getPosition();
				$world = $location->getWorld();
				$pos = $location->asVector3()->round();
			}else{
				$sender->sendMessage(TextFormat::RED . "You can only perform this command as a player");

				return true;
			}
		}elseif(count($args) === 3){
			$world = $sender->getServer()->getWorldManager()->getDefaultWorld();
			$pos = new Vector3($this->getInteger($sender, $args[0]), $this->getInteger($sender, $args[1]), $this->getInteger($sender, $args[2]));
		}else{
			throw new InvalidCommandSyntaxException();
		}

		$world->setSpawnLocation($pos);

		Command::broadcastCommandMessage($sender, new TranslationContainer(KnownTranslationKeys::COMMANDS_SETWORLDSPAWN_SUCCESS, [round($pos->x, 2), round($pos->y, 2), round($pos->z, 2)]));

		return true;
	}
}
