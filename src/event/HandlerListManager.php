<?php

declare(strict_types=1);

namespace pocketmine\event;

use pocketmine\plugin\Plugin;
use pocketmine\utils\Utils;

class HandlerListManager{

	/** @var HandlerListManager|null */
	private static $globalInstance = null;

	public static function global() : self{
		return self::$globalInstance ?? (self::$globalInstance = new self);
	}

	/** @var HandlerList[] classname => HandlerList */
	private $allLists = [];

	/**
	 * Unregisters all the listeners
	 * If a Plugin or Listener is passed, all the listeners with that object will be removed
	 *
	 * @param Plugin|Listener|null $object
	 */
	public function unregisterAll($object = null) : void{
		if($object instanceof Listener or $object instanceof Plugin){
			foreach($this->allLists as $h){
				$h->unregister($object);
			}
		}else{
			foreach($this->allLists as $h){
				$h->clear();
			}
		}
	}

	/**
	 * @phpstan-param \ReflectionClass<Event> $class
	 */
	private static function isValidClass(\ReflectionClass $class) : bool{
		$tags = Utils::parseDocComment((string) $class->getDocComment());
		return !$class->isAbstract() || isset($tags["allowHandle"]);
	}

	/**
	 * @phpstan-param \ReflectionClass<Event> $class
	 *
	 * @phpstan-return \ReflectionClass<Event>|null
	 */
	private static function resolveNearestHandleableParent(\ReflectionClass $class) : ?\ReflectionClass{
		for($parent = $class->getParentClass(); $parent !== false; $parent = $parent->getParentClass()){
			if(self::isValidClass($parent)){
				return $parent;
			}
			//NOOP
		}
		return null;
	}

	/**
	 * Returns the HandlerList for listeners that explicitly handle this event.
	 *
	 * Calling this method also lazily initializes the $classMap inheritance tree of handler lists.
	 *
	 * @throws \ReflectionException
	 * @throws \InvalidArgumentException
	 */
	public function getListFor(string $event) : HandlerList{
		if(isset($this->allLists[$event])){
			return $this->allLists[$event];
		}

		$class = new \ReflectionClass($event);
		if(!self::isValidClass($class)){
			throw new \InvalidArgumentException("Event must be non-abstract or have the @allowHandle annotation");
		}

		$parent = self::resolveNearestHandleableParent($class);
		return $this->allLists[$event] = new HandlerList($event, $parent !== null ? $this->getListFor($parent->getName()) : null);
	}

	/**
	 * @return HandlerList[]
	 */
	public function getAll() : array{
		return $this->allLists;
	}
}
