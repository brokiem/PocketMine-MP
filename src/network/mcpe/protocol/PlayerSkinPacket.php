<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;
use pocketmine\network\mcpe\protocol\types\skin\SkinData;
use Ramsey\Uuid\UuidInterface;

class PlayerSkinPacket extends DataPacket implements ClientboundPacket, ServerboundPacket{
	public const NETWORK_ID = ProtocolInfo::PLAYER_SKIN_PACKET;

	/** @var UuidInterface */
	public $uuid;
	/** @var string */
	public $oldSkinName = "";
	/** @var string */
	public $newSkinName = "";
	/** @var SkinData */
	public $skin;

	public static function create(UuidInterface $uuid, SkinData $skinData) : self{
		$result = new self;
		$result->uuid = $uuid;
		$result->skin = $skinData;
		return $result;
	}

	protected function decodePayload(PacketSerializer $in) : void{
		$this->uuid = $in->getUUID();
		$this->skin = $in->getSkin();
		$this->newSkinName = $in->getString();
		$this->oldSkinName = $in->getString();
		$this->skin->setVerified($in->getBool());
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putUUID($this->uuid);
		$out->putSkin($this->skin);
		$out->putString($this->newSkinName);
		$out->putString($this->oldSkinName);
		$out->putBool($this->skin->isVerified());
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handlePlayerSkin($this);
	}
}
