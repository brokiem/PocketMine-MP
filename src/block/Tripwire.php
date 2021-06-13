<?php

declare(strict_types=1);

namespace pocketmine\block;

class Tripwire extends Flowable{

	protected bool $triggered = false;
	protected bool $suspended = false; //unclear usage, makes hitbox bigger if set
	protected bool $connected = false;
	protected bool $disarmed = false;

	protected function writeStateToMeta() : int{
		return ($this->triggered ? BlockLegacyMetadata::TRIPWIRE_FLAG_TRIGGERED : 0) |
			($this->suspended ? BlockLegacyMetadata::TRIPWIRE_FLAG_SUSPENDED : 0) |
			($this->connected ? BlockLegacyMetadata::TRIPWIRE_FLAG_CONNECTED : 0) |
			($this->disarmed ? BlockLegacyMetadata::TRIPWIRE_FLAG_DISARMED : 0);
	}

	public function readStateFromData(int $id, int $stateMeta) : void{
		$this->triggered = ($stateMeta & BlockLegacyMetadata::TRIPWIRE_FLAG_TRIGGERED) !== 0;
		$this->suspended = ($stateMeta & BlockLegacyMetadata::TRIPWIRE_FLAG_SUSPENDED) !== 0;
		$this->connected = ($stateMeta & BlockLegacyMetadata::TRIPWIRE_FLAG_CONNECTED) !== 0;
		$this->disarmed = ($stateMeta & BlockLegacyMetadata::TRIPWIRE_FLAG_DISARMED) !== 0;
	}

	public function getStateBitmask() : int{
		return 0b1111;
	}

	public function isTriggered() : bool{ return $this->triggered; }

	/** @return $this */
	public function setTriggered(bool $triggered) : self{
		$this->triggered = $triggered;
		return $this;
	}

	public function isSuspended() : bool{ return $this->suspended; }

	/** @return $this */
	public function setSuspended(bool $suspended) : self{
		$this->suspended = $suspended;
		return $this;
	}

	public function isConnected() : bool{ return $this->connected; }

	/** @return $this */
	public function setConnected(bool $connected) : self{
		$this->connected = $connected;
		return $this;
	}

	public function isDisarmed() : bool{ return $this->disarmed; }

	/** @return $this */
	public function setDisarmed(bool $disarmed) : self{
		$this->disarmed = $disarmed;
		return $this;
	}
}
