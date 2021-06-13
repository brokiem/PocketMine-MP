<?php

declare(strict_types=1);

namespace pocketmine\event\player;

use pocketmine\command\CommandSender;
use pocketmine\event\Cancellable;
use pocketmine\event\CancellableTrait;
use pocketmine\player\Player;
use pocketmine\utils\Utils;

/**
 * Called when a player chats something
 */
class PlayerChatEvent extends PlayerEvent implements Cancellable{
	use CancellableTrait;

	/** @var string */
	protected $message;

	/** @var string */
	protected $format;

	/** @var CommandSender[] */
	protected $recipients = [];

	/**
	 * @param CommandSender[] $recipients
	 */
	public function __construct(Player $player, string $message, array $recipients, string $format = "chat.type.text"){
		$this->player = $player;
		$this->message = $message;

		$this->format = $format;

		$this->recipients = $recipients;
	}

	public function getMessage() : string{
		return $this->message;
	}

	public function setMessage(string $message) : void{
		$this->message = $message;
	}

	/**
	 * Changes the player that is sending the message
	 */
	public function setPlayer(Player $player) : void{
		$this->player = $player;
	}

	public function getFormat() : string{
		return $this->format;
	}

	public function setFormat(string $format) : void{
		$this->format = $format;
	}

	/**
	 * @return CommandSender[]
	 */
	public function getRecipients() : array{
		return $this->recipients;
	}

	/**
	 * @param CommandSender[] $recipients
	 */
	public function setRecipients(array $recipients) : void{
		Utils::validateArrayValueType($recipients, function(CommandSender $_) : void{});
		$this->recipients = $recipients;
	}
}
