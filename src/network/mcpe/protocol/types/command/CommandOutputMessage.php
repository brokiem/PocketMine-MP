<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types\command;

class CommandOutputMessage{
	/** @var bool */
	public $isInternal;
	/** @var string */
	public $messageId;
	/** @var string[] */
	public $parameters = [];

}
