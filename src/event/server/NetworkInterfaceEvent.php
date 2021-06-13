<?php

declare(strict_types=1);

namespace pocketmine\event\server;

use pocketmine\network\NetworkInterface;

class NetworkInterfaceEvent extends ServerEvent{
	/** @var NetworkInterface */
	protected $interface;

	public function __construct(NetworkInterface $interface){
		$this->interface = $interface;
	}

	public function getInterface() : NetworkInterface{
		return $this->interface;
	}
}
