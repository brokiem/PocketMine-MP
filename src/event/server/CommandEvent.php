<?php

declare(strict_types=1);

namespace pocketmine\event\server;

use pocketmine\command\CommandSender;
use pocketmine\event\Cancellable;
use pocketmine\event\CancellableTrait;

/**
 * Called when any CommandSender runs a command, early in the process
 *
 * You don't want to use this except for a few cases like logging commands,
 * blocking commands on certain places, or applying modifiers.
 *
 * The message DOES NOT contain a slash at the start
 */
class CommandEvent extends ServerEvent implements Cancellable{
	use CancellableTrait;

	/** @var string */
	protected $command;

	/** @var CommandSender */
	protected $sender;

	public function __construct(CommandSender $sender, string $command){
		$this->sender = $sender;
		$this->command = $command;
	}

	public function getSender() : CommandSender{
		return $this->sender;
	}

	public function getCommand() : string{
		return $this->command;
	}

	public function setCommand(string $command) : void{
		$this->command = $command;
	}
}
