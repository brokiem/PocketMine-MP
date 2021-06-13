<?php

declare(strict_types=1);

namespace pocketmine\scheduler;

use function gc_collect_cycles;
use function gc_enable;
use function gc_mem_caches;

class GarbageCollectionTask extends AsyncTask{

	public function onRun() : void{
		gc_enable();
		gc_collect_cycles();
		gc_mem_caches();
	}
}
