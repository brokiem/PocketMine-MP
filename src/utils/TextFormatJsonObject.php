<?php

declare(strict_types=1);

namespace pocketmine\utils;

/**
 * @internal
 * @see TextFormat::toJSON()
 */
final class TextFormatJsonObject implements \JsonSerializable{
	/** @var string|null */
	public $text = null;
	/** @var string|null */
	public $color = null;
	/** @var bool|null */
	public $bold = null;
	/** @var bool|null */
	public $italic = null;
	/** @var bool|null */
	public $underlined = null;
	/** @var bool|null */
	public $strikethrough = null;
	/** @var bool|null */
	public $obfuscated = null;
	/**
	 * @var TextFormatJsonObject[]|null
	 * @phpstan-var array<int, TextFormatJsonObject>|null
	 */
	public $extra = null;

	public function jsonSerialize(){
		$result = (array) $this;
		foreach($result as $k => $v){
			if($v === null){
				unset($result[$k]);
			}
		}
		return $result;
	}
}
