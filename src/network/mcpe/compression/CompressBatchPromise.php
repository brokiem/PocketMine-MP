<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\compression;

use pocketmine\utils\Utils;
use function array_push;

class CompressBatchPromise{
	/**
	 * @var \Closure[]
	 * @phpstan-var (\Closure(self) : void)[]
	 */
	private $callbacks = [];

	/** @var string|null */
	private $result = null;

	/** @var bool */
	private $cancelled = false;

	/**
	 * @phpstan-param \Closure(self) : void ...$callbacks
	 */
	public function onResolve(\Closure ...$callbacks) : void{
		$this->checkCancelled();
		foreach($callbacks as $callback){
			Utils::validateCallableSignature(function(CompressBatchPromise $promise) : void{}, $callback);
		}
		if($this->result !== null){
			foreach($callbacks as $callback){
				$callback($this);
			}
		}else{
			array_push($this->callbacks, ...$callbacks);
		}
	}

	public function resolve(string $result) : void{
		if(!$this->cancelled){
			if($this->result !== null){
				throw new \InvalidStateException("Cannot resolve promise more than once");
			}
			$this->result = $result;
			foreach($this->callbacks as $callback){
				$callback($this);
			}
			$this->callbacks = [];
		}
	}

	/**
	 * @return \Closure[]
	 * @phpstan-return (\Closure(self) : void)[]
	 */
	public function getResolveCallbacks() : array{
		return $this->callbacks;
	}

	public function getResult() : string{
		$this->checkCancelled();
		if($this->result === null){
			throw new \InvalidStateException("Promise has not yet been resolved");
		}
		return $this->result;
	}

	public function hasResult() : bool{
		return $this->result !== null;
	}

	public function isCancelled() : bool{
		return $this->cancelled;
	}

	public function cancel() : void{
		if($this->hasResult()){
			throw new \InvalidStateException("Cannot cancel a resolved promise");
		}
		$this->cancelled = true;
	}

	private function checkCancelled() : void{
		if($this->cancelled){
			throw new \InvalidArgumentException("Promise has been cancelled");
		}
	}
}
