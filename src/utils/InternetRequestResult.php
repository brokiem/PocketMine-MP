<?php

declare(strict_types=1);

namespace pocketmine\utils;

final class InternetRequestResult{

	/**
	 * @var string[][]
	 * @phpstan-var list<array<string, string>>
	 */
	private $headers;
	/** @var string */
	private $body;
	/** @var int */
	private $code;

	/**
	 * @param string[][] $headers
	 * @phpstan-param list<array<string, string>> $headers
	 */
	public function __construct(array $headers, string $body, int $code){
		$this->headers = $headers;
		$this->body = $body;
		$this->code = $code;
	}

	/**
	 * @return string[][]
	 * @phpstan-return list<array<string, string>>
	 */
	public function getHeaders() : array{ return $this->headers; }

	public function getBody() : string{ return $this->body; }

	public function getCode() : int{ return $this->code; }
}
