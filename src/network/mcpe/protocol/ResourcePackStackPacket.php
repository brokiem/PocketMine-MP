<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;
use pocketmine\network\mcpe\protocol\types\Experiments;
use pocketmine\network\mcpe\protocol\types\resourcepacks\ResourcePackStackEntry;
use function count;

class ResourcePackStackPacket extends DataPacket implements ClientboundPacket{
	public const NETWORK_ID = ProtocolInfo::RESOURCE_PACK_STACK_PACKET;

	/** @var bool */
	public $mustAccept = false;

	/** @var ResourcePackStackEntry[] */
	public $behaviorPackStack = [];
	/** @var ResourcePackStackEntry[] */
	public $resourcePackStack = [];

	/** @var string */
	public $baseGameVersion = ProtocolInfo::MINECRAFT_VERSION_NETWORK;

	/** @var Experiments */
	public $experiments;

	/**
	 * @param ResourcePackStackEntry[] $resourcePacks
	 * @param ResourcePackStackEntry[] $behaviorPacks
	 *
	 * @return ResourcePackStackPacket
	 */
	public static function create(array $resourcePacks, array $behaviorPacks, bool $mustAccept, Experiments $experiments) : self{
		$result = new self;
		$result->mustAccept = $mustAccept;
		$result->resourcePackStack = $resourcePacks;
		$result->behaviorPackStack = $behaviorPacks;
		$result->experiments = $experiments;
		return $result;
	}

	protected function decodePayload(PacketSerializer $in) : void{
		$this->mustAccept = $in->getBool();
		$behaviorPackCount = $in->getUnsignedVarInt();
		while($behaviorPackCount-- > 0){
			$this->behaviorPackStack[] = ResourcePackStackEntry::read($in);
		}

		$resourcePackCount = $in->getUnsignedVarInt();
		while($resourcePackCount-- > 0){
			$this->resourcePackStack[] = ResourcePackStackEntry::read($in);
		}

		$this->baseGameVersion = $in->getString();
		$this->experiments = Experiments::read($in);
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putBool($this->mustAccept);

		$out->putUnsignedVarInt(count($this->behaviorPackStack));
		foreach($this->behaviorPackStack as $entry){
			$entry->write($out);
		}

		$out->putUnsignedVarInt(count($this->resourcePackStack));
		foreach($this->resourcePackStack as $entry){
			$entry->write($out);
		}

		$out->putString($this->baseGameVersion);
		$this->experiments->write($out);
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleResourcePackStack($this);
	}
}
