<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types\login;

/**
 * Model class for LoginPacket JSON data for JsonMapper
 */
final class AuthenticationData{

	/** @required */
	public string $displayName;

	/** @required */
	public string $identity;

	public string $titleId = ""; //TODO: find out what this is for

	/** @required */
	public string $XUID;
}
