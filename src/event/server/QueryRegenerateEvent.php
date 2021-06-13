<?php

declare(strict_types=1);

namespace pocketmine\event\server;

use pocketmine\network\query\QueryInfo;

class QueryRegenerateEvent extends ServerEvent{
	/** @var QueryInfo */
	private $queryInfo;

	public function __construct(QueryInfo $queryInfo){
		$this->queryInfo = $queryInfo;
	}

	public function getQueryInfo() : QueryInfo{
		return $this->queryInfo;
	}
}
