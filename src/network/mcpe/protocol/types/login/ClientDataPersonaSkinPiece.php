<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types\login;

/**
 * Model class for LoginPacket JSON data for JsonMapper
 */
final class ClientDataPersonaSkinPiece{
	/** @required */
	public string $PieceId;

	/** @required */
	public string $PieceType;

	/** @required */
	public string $PackId;

	/** @required */
	public bool $IsDefault;

	/** @required */
	public string $ProductId;
}
