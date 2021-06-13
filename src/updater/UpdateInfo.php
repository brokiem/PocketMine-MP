<?php

declare(strict_types=1);

namespace pocketmine\updater;

/**
 * Model class for JsonMapper to represent the information returned from the updater API.
 * @link https://update.pmmp.io/api
 */
final class UpdateInfo{
	/**
	 * @var string
	 * @required
	 */
	public $job;
	/**
	 * @var string
	 * @required
	 */
	public $php_version;
	/**
	 * @var string
	 * @required
	 */
	public $base_version;
	/**
	 * @var int
	 * @required
	 */
	public $build_number;
	/**
	 * @var bool
	 * @required
	 */
	public $is_dev;
	/**
	 * @var string
	 * @required
	 */
	public $branch;
	/**
	 * @var string
	 * @required
	 */
	public $git_commit;
	/**
	 * @var string
	 * @required
	 */
	public $mcpe_version;
	/**
	 * @var string
	 * @required
	 */
	public $phar_name;
	/**
	 * @var int
	 * @required
	 */
	public $build;
	/**
	 * @var int
	 * @required
	 */
	public $date;
	/**
	 * @var string
	 * @required
	 */
	public $details_url;
	/**
	 * @var string
	 * @required
	 */
	public $download_url;
}
