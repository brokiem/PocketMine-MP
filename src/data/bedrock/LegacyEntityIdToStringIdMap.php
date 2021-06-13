<?php

declare(strict_types=1);

namespace pocketmine\data\bedrock;

use pocketmine\utils\SingletonTrait;

final class LegacyEntityIdToStringIdMap extends LegacyToStringBidirectionalIdMap{
	use SingletonTrait;

	public function __construct(){
		parent::__construct(\pocketmine\RESOURCE_PATH . '/vanilla/entity_id_map.json');
	}
}
