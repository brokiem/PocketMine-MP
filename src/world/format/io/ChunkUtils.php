<?php

declare(strict_types=1);

namespace pocketmine\world\format\io;

use function chr;
use function str_repeat;

class ChunkUtils{

	/**
	 * Converts pre-MCPE-1.0 biome color array to biome ID array.
	 *
	 * @param int[] $array of biome color values
	 * @phpstan-param list<int> $array
	 */
	public static function convertBiomeColors(array $array) : string{
		$result = str_repeat("\x00", 256);
		foreach($array as $i => $color){
			$result[$i] = chr(($color >> 24) & 0xff);
		}
		return $result;
	}

}
