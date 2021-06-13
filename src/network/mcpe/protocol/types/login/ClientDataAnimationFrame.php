<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types\login;

/**
 * Model class for LoginPacket JSON data for JsonMapper
 */
final class ClientDataAnimationFrame{

	/** @required */
	public int $ImageHeight;

	/** @required */
	public int $ImageWidth;

	/** @required */
	public float $Frames;

	/** @required */
	public int $Type;

	/** @required */
	public string $Image;

	/** @required */
	public int $AnimationExpression;
}
