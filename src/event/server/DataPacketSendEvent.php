<?php

declare(strict_types=1);

namespace pocketmine\event\server;

use pocketmine\event\Cancellable;
use pocketmine\event\CancellableTrait;
use pocketmine\network\mcpe\NetworkSession;
use pocketmine\network\mcpe\protocol\ClientboundPacket;

/**
 * Called when packets are sent to network sessions.
 */
class DataPacketSendEvent extends ServerEvent implements Cancellable{
	use CancellableTrait;

	/** @var NetworkSession[] */
	private $targets;
	/** @var ClientboundPacket[] */
	private $packets;

	/**
	 * @param NetworkSession[]    $targets
	 * @param ClientboundPacket[] $packets
	 */
	public function __construct(array $targets, array $packets){
		$this->targets = $targets;
		$this->packets = $packets;
	}

	/**
	 * @return NetworkSession[]
	 */
	public function getTargets() : array{
		return $this->targets;
	}

	/**
	 * @return ClientboundPacket[]
	 */
	public function getPackets() : array{
		return $this->packets;
	}
}
