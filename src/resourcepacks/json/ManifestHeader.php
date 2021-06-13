<?php

declare(strict_types=1);

namespace pocketmine\resourcepacks\json;

final class ManifestHeader{
	/** @var string */
	public $description;

	/**
	 * @var string
	 * @required
	 */
	public $name;

	/**
	 * @var string
	 * @required
	 */
	public $uuid;

	/**
	 * @var int[]
	 * @phpstan-var array{int, int, int}
	 * @required
	 */
	public $version;

	/**
	 * @var int[]
	 * @phpstan-var array{int, int, int}
	 */
	public $min_engine_version;
}
