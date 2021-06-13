<?php

declare(strict_types=1);

namespace pocketmine\command;

interface CommandMap{

	/**
	 * @param Command[] $commands
	 */
	public function registerAll(string $fallbackPrefix, array $commands) : void;

	public function register(string $fallbackPrefix, Command $command, ?string $label = null) : bool;

	public function dispatch(CommandSender $sender, string $cmdLine) : bool;

	public function clearCommands() : void;

	public function getCommand(string $name) : ?Command;

}
