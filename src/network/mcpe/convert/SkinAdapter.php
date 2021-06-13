<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\convert;

use pocketmine\entity\InvalidSkinException;
use pocketmine\entity\Skin;
use pocketmine\network\mcpe\protocol\types\skin\SkinData;

/**
 * Used to convert new skin data to the skin entity or old skin entity to skin data.
 */
interface SkinAdapter{

	/**
	 * Allows you to convert a skin entity to skin data.
	 */
	public function toSkinData(Skin $skin) : SkinData;

	/**
	 * Allows you to convert skin data to a skin entity.
	 * @throws InvalidSkinException
	 */
	public function fromSkinData(SkinData $data) : Skin;
}
