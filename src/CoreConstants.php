<?php

declare(strict_types=1);

namespace pocketmine;

use function define;
use function defined;
use function dirname;

// composer autoload doesn't use require_once and also pthreads can inherit things
if(defined('pocketmine\_CORE_CONSTANTS_INCLUDED')){
	return;
}
define('pocketmine\_CORE_CONSTANTS_INCLUDED', true);

define('pocketmine\PATH', dirname(__DIR__) . '/');
define('pocketmine\RESOURCE_PATH', dirname(__DIR__) . '/resources/');
