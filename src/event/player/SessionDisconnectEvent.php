<?php

declare(strict_types=1);

namespace pocketmine\event\player;

use pocketmine\event\Event;
use pocketmine\network\mcpe\NetworkSession;

class SessionDisconnectEvent extends Event{
	/** @var NetworkSession */
	private $session;

	public function __construct(NetworkSession $session){
		$this->session = $session;
	}

	public function getSession() : NetworkSession{
		return $this->session;
	}
}
