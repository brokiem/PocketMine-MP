<?php

declare(strict_types=1);

namespace pocketmine\block\utils;

use pocketmine\utils\Utils;
use function array_fill;
use function array_pad;
use function array_slice;
use function count;
use function explode;
use function is_int;

class SignText{
	public const LINE_COUNT = 4;

	/** @var string[] */
	private $lines;

	/**
	 * @param string[]|null $lines index-sensitive; omitting an index will leave it unchanged
	 *
	 * @throws \InvalidArgumentException if the array size is greater than 4
	 * @throws \InvalidArgumentException if invalid keys (out of bounds or string) are found in the array
	 * @throws \InvalidArgumentException if any line is not valid UTF-8 or contains a newline
	 */
	public function __construct(?array $lines = null){
		$this->lines = array_fill(0, self::LINE_COUNT, "");
		if($lines !== null){
			if(count($lines) > self::LINE_COUNT){
				throw new \InvalidArgumentException("Expected at most 4 lines, got " . count($lines));
			}
			foreach($lines as $k => $line){
				$this->checkLineIndex($k);
				Utils::checkUTF8($line);
				if(str_contains($line, "\n")){
					throw new \InvalidArgumentException("Line must not contain newlines");
				}
				//TODO: add length checks
				$this->lines[$k] = $line;
			}
		}
	}

	/**
	 * Parses sign lines from the given string blob.
	 * TODO: add a strict mode for this
	 *
	 * @throws \InvalidArgumentException if the text is not valid UTF-8
	 */
	public static function fromBlob(string $blob) : SignText{
		return new self(array_slice(array_pad(explode("\n", $blob), self::LINE_COUNT, ""), 0, self::LINE_COUNT));
	}

	/**
	 * Returns an array of lines currently on the sign.
	 *
	 * @return string[]
	 */
	public function getLines() : array{
		return $this->lines;
	}

	/**
	 * @param int|string $index
	 */
	private function checkLineIndex($index) : void{
		if(!is_int($index)){
			throw new \InvalidArgumentException("Index must be an integer");
		}
		if($index < 0 or $index >= self::LINE_COUNT){
			throw new \InvalidArgumentException("Line index is out of bounds");
		}
	}

	/**
	 * Returns the sign line at the given offset.
	 *
	 * @throws \InvalidArgumentException
	 */
	public function getLine(int $index) : string{
		$this->checkLineIndex($index);
		return $this->lines[$index];
	}
}
