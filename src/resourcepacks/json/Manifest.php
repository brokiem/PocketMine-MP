<?php

declare(strict_types=1);

namespace pocketmine\resourcepacks\json;

/**
 * Model for JsonMapper to represent resource pack manifest.json contents.
 */
final class Manifest{
	/**
	 * @var int
	 * @required
	 */
	public $format_version;

	/**
	 * @var ManifestHeader
	 * @required
	 */
	public $header;

	/**
	 * @var ManifestModuleEntry[]
	 * @required
	 */
	public $modules;

	/** @var ManifestMetadata|null */
	public $metadata = null;
}
