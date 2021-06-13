<?php

declare(strict_types=1);

namespace pocketmine\utils;

use function spl_object_id;

/**
 * @phpstan-template TValue
 */
final class Promise{
	/**
	 * @var \Closure[]
	 * @phpstan-var array<int, \Closure(TValue) : void>
	 */
	private array $onSuccess = [];

	/**
	 * @var \Closure[]
	 * @phpstan-var array<int, \Closure() : void>
	 */
	private array $onFailure = [];

	private bool $resolved = false;

	/**
	 * @var mixed
	 * @phpstan-var TValue|null
	 */
	private $result = null;

	/**
	 * @phpstan-param \Closure(TValue) : void $onSuccess
	 * @phpstan-param \Closure() : void $onFailure
	 */
	public function onCompletion(\Closure $onSuccess, \Closure $onFailure) : void{
		if($this->resolved){
			$this->result === null ? $onFailure() : $onSuccess($this->result);
		}else{
			$this->onSuccess[spl_object_id($onSuccess)] = $onSuccess;
			$this->onFailure[spl_object_id($onFailure)] = $onFailure;
		}
	}

	/**
	 * @param mixed $value
	 * @phpstan-param TValue $value
	 */
	public function resolve($value) : void{
		if($this->resolved){
			throw new \InvalidStateException("Promise has already been resolved/rejected");
		}
		$this->resolved = true;
		$this->result = $value;
		foreach($this->onSuccess as $c){
			$c($value);
		}
		$this->onSuccess = [];
		$this->onFailure = [];
	}

	public function reject() : void{
		if($this->resolved){
			throw new \InvalidStateException("Promise has already been resolved/rejected");
		}
		$this->resolved = true;
		foreach($this->onFailure as $c){
			$c();
		}
		$this->onSuccess = [];
		$this->onFailure = [];
	}
}
