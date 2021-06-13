<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\compression;

use pocketmine\scheduler\AsyncTask;

class CompressBatchTask extends AsyncTask{

	private const TLS_KEY_PROMISE = "promise";

	/** @var string */
	private $data;
	/** @var Compressor */
	private $compressor;

	public function __construct(string $data, CompressBatchPromise $promise, Compressor $compressor){
		$this->data = $data;
		$this->compressor = $compressor;
		$this->storeLocal(self::TLS_KEY_PROMISE, $promise);
	}

	public function onRun() : void{
		$this->setResult($this->compressor->compress($this->data));
	}

	public function onCompletion() : void{
		/** @var CompressBatchPromise $promise */
		$promise = $this->fetchLocal(self::TLS_KEY_PROMISE);
		$promise->resolve($this->getResult());
	}
}
