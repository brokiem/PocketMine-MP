<?php

declare(strict_types=1);

namespace pocketmine\command;

interface CommandExecutor{

	/**
	 * @param string[]      $args
	 */
	public function onCommand(CommandSender $sender, Command $command, string $label, array $args) : bool;

}
