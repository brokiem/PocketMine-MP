<?php

declare(strict_types=1);

namespace pocketmine\player;

use pocketmine\entity\Skin;
use Ramsey\Uuid\UuidInterface;

/**
 * Encapsulates player info specific to players who are authenticated with XBOX Live.
 */
final class XboxLivePlayerInfo extends PlayerInfo{

	/** @var string */
	private $xuid;

	public function __construct(string $xuid, string $username, UuidInterface $uuid, Skin $skin, string $locale, array $extraData = []){
		parent::__construct($username, $uuid, $skin, $locale, $extraData);
		$this->xuid = $xuid;
	}

	public function getXuid() : string{
		return $this->xuid;
	}

	/**
	 * Returns a new PlayerInfo with XBL player info stripped. This is used to ensure that non-XBL players can't spoof
	 * XBL data.
	 */
	public function withoutXboxData() : PlayerInfo{
		return new PlayerInfo(
			$this->getUsername(),
			$this->getUuid(),
			$this->getSkin(),
			$this->getLocale(),
			$this->getExtraData()
		);
	}
}
