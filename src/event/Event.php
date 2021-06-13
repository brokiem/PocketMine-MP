<?php

declare(strict_types=1);

/**
 * Event related classes
 */
namespace pocketmine\event;

use function get_class;

abstract class Event{
	private const MAX_EVENT_CALL_DEPTH = 50;
	/** @var int */
	private static $eventCallDepth = 1;

	/** @var string|null */
	protected $eventName = null;

	final public function getEventName() : string{
		return $this->eventName ?? get_class($this);
	}

	/**
	 * Calls event handlers registered for this event.
	 *
	 * @throws \RuntimeException if event call recursion reaches the max depth limit
	 */
	public function call() : void{
		if(self::$eventCallDepth >= self::MAX_EVENT_CALL_DEPTH){
			//this exception will be caught by the parent event call if all else fails
			throw new \RuntimeException("Recursive event call detected (reached max depth of " . self::MAX_EVENT_CALL_DEPTH . " calls)");
		}

		$handlerList = HandlerListManager::global()->getListFor(get_class($this));

		++self::$eventCallDepth;
		try{
			foreach(EventPriority::ALL as $priority){
				$currentList = $handlerList;
				while($currentList !== null){
					foreach($currentList->getListenersByPriority($priority) as $registration){
						$registration->callEvent($this);
					}

					$currentList = $currentList->getParent();
				}
			}
		}finally{
			--self::$eventCallDepth;
		}
	}
}
