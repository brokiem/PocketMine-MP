<?php

declare(strict_types=1);

namespace pocketmine\command\defaults;

use pocketmine\command\CommandSender;
use pocketmine\permission\DefaultPermissionNames;
use Webmozart\PathUtil\Path;
use function date;

class DumpMemoryCommand extends VanillaCommand{

	public function __construct(string $name){
		parent::__construct(
			$name,
			"Dumps the memory",
			"/$name [path]"
		);
		$this->setPermission(DefaultPermissionNames::COMMAND_DUMPMEMORY);
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args){
		if(!$this->testPermission($sender)){
			return true;
		}

		$sender->getServer()->getMemoryManager()->dumpServerMemory($args[0] ?? (Path::join($sender->getServer()->getDataPath(), "memory_dumps" . date("D_M_j-H.i.s-T_Y"))), 48, 80);
		return true;
	}
}
