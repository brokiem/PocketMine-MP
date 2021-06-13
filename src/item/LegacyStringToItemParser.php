<?php

declare(strict_types=1);

namespace pocketmine\item;

use pocketmine\utils\AssumptionFailedError;
use pocketmine\utils\SingletonTrait;
use function explode;
use function file_get_contents;
use function is_array;
use function is_int;
use function is_numeric;
use function is_string;
use function json_decode;
use function mb_strtolower;
use function str_replace;
use function strtolower;
use function trim;

/**
 * This class fills in as a substitute for all the stuff that used to make ItemFactory::fromString()
 * work. Since legacy item IDs are on their way out, we can't keep using their constants as stringy
 * IDs (especially not considering the unnoticed BC-break potential posed by such a stupid idea).
 */
final class LegacyStringToItemParser{
	use SingletonTrait;

	/** @var ItemFactory */
	private $itemFactory;

	private static function make() : self{
		$result = new self(ItemFactory::getInstance());

		$mappingsRaw = @file_get_contents(\pocketmine\RESOURCE_PATH . '/item_from_string_bc_map.json');
		if($mappingsRaw === false) throw new AssumptionFailedError("Missing required resource file");

		$mappings = json_decode($mappingsRaw, true);
		if(!is_array($mappings)) throw new AssumptionFailedError("Invalid mappings format, expected array");

		foreach($mappings as $name => $id){
			if(!is_string($name) or !is_int($id)) throw new AssumptionFailedError("Invalid mappings format, expected string keys and int values");
			$result->addMapping($name, $id);
		}

		return $result;
	}

	/**
	 * @var int[]
	 * @phpstan-var array<string, int>
	 */
	private $map = [];

	public function __construct(ItemFactory $itemFactory){
		$this->itemFactory = $itemFactory;
	}

	public function addMapping(string $alias, int $id) : void{
		$this->map[$alias] = $id;
	}

	public function parseId(string $input) : ?int{
		return $this->map[mb_strtolower($this->reprocess($input))] ?? null;
	}

	/**
	 * Tries to parse the specified string into Item types.
	 *
	 * Example accepted formats:
	 * - `diamond_pickaxe:5`
	 * - `minecraft:string`
	 * - `351:4 (lapis lazuli ID:meta)`
	 *
	 * @throws \InvalidArgumentException if the given string cannot be parsed as an item identifier
	 */
	public function parse(string $input) : Item{
		$key = $this->reprocess($input);
		$b = explode(":", $key);

		if(!isset($b[1])){
			$meta = 0;
		}elseif(is_numeric($b[1])){
			$meta = (int) $b[1];
		}else{
			throw new \InvalidArgumentException("Unable to parse \"" . $b[1] . "\" from \"" . $input . "\" as a valid meta value");
		}

		if(is_numeric($b[0])){
			$item = $this->itemFactory->get((int) $b[0], $meta);
		}elseif(isset($this->map[strtolower($b[0])])){
			$item = $this->itemFactory->get($this->map[strtolower($b[0])], $meta);
		}else{
			throw new \InvalidArgumentException("Unable to resolve \"" . $input . "\" to a valid item");
		}

		return $item;
	}

	protected function reprocess(string $input) : string{
		return str_replace([" ", "minecraft:"], ["_", ""], trim($input));
	}
}
