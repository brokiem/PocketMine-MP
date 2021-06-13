<?php

declare(strict_types=1);

namespace pocketmine\network;

/**
 * Thrown when an error occurs during packet handling - for example, a message contained invalid options, packet shorter
 * than expected, unknown packet, etc.
 */
class PacketHandlingException extends \RuntimeException{

	public static function wrap(\Throwable $previous, ?string $prefix = null) : self{
		return new self(($prefix !== null ? $prefix . ": " : "") . $previous->getMessage(), 0, $previous);
	}
}
