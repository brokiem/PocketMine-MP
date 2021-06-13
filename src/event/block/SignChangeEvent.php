<?php

declare(strict_types=1);

namespace pocketmine\event\block;

use pocketmine\block\BaseSign;
use pocketmine\block\utils\SignText;
use pocketmine\event\Cancellable;
use pocketmine\event\CancellableTrait;
use pocketmine\player\Player;

/**
 * Called when a sign's text is changed by a player.
 */
class SignChangeEvent extends BlockEvent implements Cancellable{
	use CancellableTrait;

	/** @var BaseSign */
	private $sign;

	/** @var Player */
	private $player;

	/** @var SignText */
	private $text;

	public function __construct(BaseSign $sign, Player $player, SignText $text){
		parent::__construct($sign);
		$this->sign = $sign;
		$this->player = $player;
		$this->text = $text;
	}

	public function getSign() : BaseSign{
		return $this->sign;
	}

	public function getPlayer() : Player{
		return $this->player;
	}

	/**
	 * Returns the text currently on the sign.
	 */
	public function getOldText() : SignText{
		return $this->sign->getText();
	}

	/**
	 * Returns the text which will be on the sign after the event.
	 */
	public function getNewText() : SignText{
		return $this->text;
	}

	/**
	 * Sets the text to be written on the sign after the event.
	 */
	public function setNewText(SignText $text) : void{
		$this->text = $text;
	}
}
