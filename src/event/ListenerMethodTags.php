<?php

declare(strict_types=1);

namespace pocketmine\event;

/**
 * Provides constants for all the PhpDoc tags supported for Listener methods.
 * @see Listener
 */
final class ListenerMethodTags{
	public const HANDLE_CANCELLED = "handleCancelled";
	public const NOT_HANDLER = "notHandler";
	public const PRIORITY = "priority";
}
