<?php

declare(strict_types=1);

namespace pocketmine\data\bedrock;

use pocketmine\utils\SingletonTrait;

final class LegacyItemIdToStringIdMap extends LegacyToStringBidirectionalIdMap{
	use SingletonTrait;

	public function __construct(){
		parent::__construct(\pocketmine\RESOURCE_PATH . 'vanilla/item_id_map.json');
	}
}
