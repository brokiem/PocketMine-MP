<?php

declare(strict_types=1);

namespace pocketmine\lang;

final class TranslationContainer{

	/** @var string $text */
	protected $text;
	/** @var string[] $params */
	protected $params = [];

	/**
	 * @param (float|int|string)[] $params
	 */
	public function __construct(string $text, array $params = []){
		$this->text = $text;

		$i = 0;
		foreach($params as $str){
			$this->params[$i] = (string) $str;

			++$i;
		}
	}

	public function getText() : string{
		return $this->text;
	}

	/**
	 * @return string[]
	 */
	public function getParameters() : array{
		return $this->params;
	}

	public function getParameter(int $i) : ?string{
		return $this->params[$i] ?? null;
	}

	public function __toString() : string{
		return $this->getText();
	}
}
