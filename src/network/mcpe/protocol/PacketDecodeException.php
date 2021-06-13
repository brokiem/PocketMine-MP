<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

final class PacketDecodeException extends \RuntimeException{

	public static function wrap(\Throwable $previous, ?string $prefix = null) : self{
		return new self(($prefix !== null ? $prefix . ": " : "") . $previous->getMessage(), 0, $previous);
	}
}