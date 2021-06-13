<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\raklib;

use raklib\server\ipc\InterThreadChannelReader;

final class PthreadsChannelReader implements InterThreadChannelReader{
	/** @var \Threaded */
	private $buffer;

	public function __construct(\Threaded $buffer){
		$this->buffer = $buffer;
	}

	public function read() : ?string{
		return $this->buffer->shift();
	}
}
