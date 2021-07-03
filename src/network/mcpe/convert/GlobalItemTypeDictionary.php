<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\convert;

use pocketmine\network\mcpe\protocol\ProtocolInfo;
use pocketmine\network\mcpe\protocol\serializer\ItemTypeDictionary;
use pocketmine\network\mcpe\protocol\types\ItemTypeEntry;
use pocketmine\player\Player;
use pocketmine\utils\AssumptionFailedError;
use pocketmine\utils\SingletonTrait;
use Webmozart\PathUtil\Path;
use function file_get_contents;
use function is_array;
use function is_bool;
use function is_int;
use function is_string;
use function json_decode;

final class GlobalItemTypeDictionary{
	use SingletonTrait;

	private static function make() : self{
		$paths = [
			ProtocolInfo::CURRENT_PROTOCOL => "",
			ProtocolInfo::PROTOCOL_1_16_220 => "-1.16.220"
		];

		$dictionaries = [];

		foreach ($paths as $protocolId => $path){
			$data = file_get_contents(Path::join(\pocketmine\RESOURCE_PATH, 'vanilla', 'required_item_list' . $path . '.json'));
			if($data === false) throw new AssumptionFailedError("Missing required resource file");
			$table = json_decode($data, true);
			if(!is_array($table)){
				throw new AssumptionFailedError("Invalid item list format");
			}

			$params = [];
			foreach($table as $name => $entry){
				if(!is_array($entry) || !is_string($name) || !isset($entry["component_based"], $entry["runtime_id"]) || !is_bool($entry["component_based"]) || !is_int($entry["runtime_id"])){
					throw new AssumptionFailedError("Invalid item list format");
				}
				$params[] = new ItemTypeEntry($name, $entry["runtime_id"], $entry["component_based"]);
			}

			$dictionaries[$protocolId] = new ItemTypeDictionary($params);
		}

		return new self($dictionaries);
	}

	/** @var ItemTypeDictionary[] */
	private array $dictionaries;

	/**
	 * @param ItemTypeDictionary[] $dictionaries
	 */
	public function __construct(array $dictionaries){
		$this->dictionaries = $dictionaries;
	}

	public static function getDictionaryProtocol(int $protocolId) : int{
		return $protocolId <= ProtocolInfo::PROTOCOL_1_16_220 ? ProtocolInfo::PROTOCOL_1_16_220 : ProtocolInfo::CURRENT_PROTOCOL;
	}

	/**
	 * @param Player[] $players
	 *
	 * @return Player[][]
	 */
	public static function sortByProtocol(array $players) : array{
		$sortPlayers = [];

		foreach($players as $player){
			$dictionaryProtocol = self::getDictionaryProtocol($player->getNetworkSession()->getProtocolId());

			if(isset($sortPlayers[$dictionaryProtocol])){
				$sortPlayers[$dictionaryProtocol][] = $player;
			}else{
				$sortPlayers[$dictionaryProtocol] = [$player];
			}
		}

		return $sortPlayers;
	}

	/**
	 * @return  ItemTypeDictionary[] $dictionaries
	 */
	public function getDictionaries(): array{ return $this->dictionaries; }

	public function getDictionary(int $dictionaryId = ProtocolInfo::CURRENT_PROTOCOL) : ItemTypeDictionary{ return $this->dictionaries[$dictionaryId] ?? $this->dictionaries[ProtocolInfo::CURRENT_PROTOCOL]; }
}
