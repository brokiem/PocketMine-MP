<?php

declare(strict_types=1);

namespace pocketmine\event;

/**
 * This trait provides a basic boolean-setter-style implementation for `Cancellable` to reduce boilerplate.
 * The precise meaning of `setCancelled` is subject to definition by the class using this trait.
 *
 * Implementors of `Cancellable` are not required to use this trait.
 *
 * @see Cancellable
 */
trait CancellableTrait{
	/** @var bool */
	private $isCancelled = false;

	public function isCancelled() : bool{
		return $this->isCancelled;
	}

	public function cancel() : void{
		$this->isCancelled = true;
	}

	public function uncancel() : void{
		$this->isCancelled = false;
	}
}
