<?php

declare(strict_types=1);

namespace pocketmine\resourcepacks\json;

final class ManifestModuleEntry{

	/**
	 * @var string
	 */
	public $description;

	/**
	 * @var string
	 * @required
	 */
	public $type;

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
}
