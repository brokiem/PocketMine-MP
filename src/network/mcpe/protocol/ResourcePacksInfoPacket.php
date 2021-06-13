<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;
use pocketmine\network\mcpe\protocol\types\resourcepacks\BehaviorPackInfoEntry;
use pocketmine\network\mcpe\protocol\types\resourcepacks\ResourcePackInfoEntry;
use function count;

class ResourcePacksInfoPacket extends DataPacket implements ClientboundPacket{
	public const NETWORK_ID = ProtocolInfo::RESOURCE_PACKS_INFO_PACKET;

	/** @var bool */
	public $mustAccept = false; //if true, forces client to use selected resource packs
	/** @var bool */
	public $hasScripts = false; //if true, causes disconnect for any platform that doesn't support scripts yet
	/** @var BehaviorPackInfoEntry[] */
	public $behaviorPackEntries = [];
	/** @var ResourcePackInfoEntry[] */
	public $resourcePackEntries = [];

	/**
	 * @param ResourcePackInfoEntry[] $resourcePacks
	 * @param BehaviorPackInfoEntry[] $behaviorPacks
	 *
	 * @return ResourcePacksInfoPacket
	 */
	public static function create(array $resourcePacks, array $behaviorPacks, bool $mustAccept, bool $hasScripts = false) : self{
		$result = new self;
		$result->mustAccept = $mustAccept;
		$result->hasScripts = $hasScripts;
		$result->resourcePackEntries = $resourcePacks;
		$result->behaviorPackEntries = $behaviorPacks;
		return $result;
	}

	protected function decodePayload(PacketSerializer $in) : void{
		$this->mustAccept = $in->getBool();
		$this->hasScripts = $in->getBool();
		$behaviorPackCount = $in->getLShort();
		while($behaviorPackCount-- > 0){
			$this->behaviorPackEntries[] = BehaviorPackInfoEntry::read($in);
		}

		$resourcePackCount = $in->getLShort();
		while($resourcePackCount-- > 0){
			$this->resourcePackEntries[] = ResourcePackInfoEntry::read($in);
		}
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putBool($this->mustAccept);
		$out->putBool($this->hasScripts);
		$out->putLShort(count($this->behaviorPackEntries));
		foreach($this->behaviorPackEntries as $entry){
			$entry->write($out);
		}
		$out->putLShort(count($this->resourcePackEntries));
		foreach($this->resourcePackEntries as $entry){
			$entry->write($out);
		}
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleResourcePacksInfo($this);
	}
}
