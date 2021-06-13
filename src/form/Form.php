<?php

declare(strict_types=1);

namespace pocketmine\form;

use pocketmine\player\Player;

/**
 * Form implementations must implement this interface to be able to utilize the Player form-sending mechanism.
 * There is no restriction on custom implementations other than that they must implement this.
 */
interface Form extends \JsonSerializable{

	/**
	 * Handles a form response from a player.
	 *
	 * @param mixed  $data
	 *
	 * @throws FormValidationException if the data could not be processed
	 */
	public function handleResponse(Player $player, $data) : void;
}
