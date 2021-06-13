<?php

declare(strict_types=1);

namespace pocketmine\scheduler;

final class BulkCurlTaskOperation{

	/** @var string */
	private $page;
	/** @var float */
	private $timeout;
	/**
	 * @var string[]
	 * @phpstan-var list<string>
	 */
	private $extraHeaders;
	/**
	 * @var mixed[]
	 * @phpstan-var array<int, mixed>
	 */
	private $extraOpts;

	/**
	 * @param string[] $extraHeaders
	 * @param mixed[] $extraOpts
	 * @phpstan-param list<string> $extraHeaders
	 * @phpstan-param array<int, mixed> $extraOpts
	 */
	public function __construct(string $page, float $timeout = 10, array $extraHeaders = [], array $extraOpts = []){
		$this->page = $page;
		$this->timeout = $timeout;
		$this->extraHeaders = $extraHeaders;
		$this->extraOpts = $extraOpts;
	}

	public function getPage() : string{ return $this->page; }

	public function getTimeout() : float{ return $this->timeout; }

	/**
	 * @return string[]
	 * @phpstan-return list<string>
	 */
	public function getExtraHeaders() : array{ return $this->extraHeaders; }

	/**
	 * @return mixed[]
	 * @phpstan-return array<int, mixed>
	 */
	public function getExtraOpts() : array{ return $this->extraOpts; }
}
