<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types\login;

/**
 * Model class for LoginPacket JSON data for JsonMapper
 */
final class ClientDataPersonaPieceTintColor{
	/** @required */
	public string $PieceType;

	/**
	 * @var string[]
	 * @required
	 */
	public array $Colors;
}
