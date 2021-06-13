<?php

declare(strict_types=1);

namespace pocketmine\command;

use pocketmine\lang\Language;
use pocketmine\lang\TranslationContainer;
use pocketmine\permission\Permissible;
use pocketmine\Server;

interface CommandSender extends Permissible{

	public function getLanguage() : Language;

	/**
	 * @param TranslationContainer|string $message
	 */
	public function sendMessage($message) : void;

	public function getServer() : Server;

	public function getName() : string;

	/**
	 * Returns the line height of the command-sender's screen. Used for determining sizes for command output pagination
	 * such as in the /help command.
	 */
	public function getScreenLineHeight() : int;

	/**
	 * Sets the line height used for command output pagination for this command sender. `null` will reset it to default.
	 */
	public function setScreenLineHeight(?int $height) : void;
}
