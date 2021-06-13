<?php

declare(strict_types=1);

namespace pocketmine\network;

use pocketmine\network\mcpe\NetworkSession;
use function count;
use function spl_object_id;

class NetworkSessionManager{

	/** @var NetworkSession[] */
	private $sessions = [];
	/** @var NetworkSession[] */
	private $updateSessions = [];

	/**
	 * Adds a network session to the manager. This should only be called on session creation.
	 */
	public function add(NetworkSession $session) : void{
		$idx = spl_object_id($session);
		$this->sessions[$idx] = $this->updateSessions[$idx] = $session;
	}

	/**
	 * Removes the given network session, due to disconnect. This should only be called by a network session on
	 * disconnection.
	 */
	public function remove(NetworkSession $session) : void{
		$idx = spl_object_id($session);
		unset($this->sessions[$idx], $this->updateSessions[$idx]);
	}

	/**
	 * Requests an update to be scheduled on the given network session at the next tick.
	 */
	public function scheduleUpdate(NetworkSession $session) : void{
		$this->updateSessions[spl_object_id($session)] = $session;
	}

	/**
	 * Returns the number of known connected sessions.
	 */
	public function getSessionCount() : int{
		return count($this->sessions);
	}

	/** @return NetworkSession[] */
	public function getSessions() : array{ return $this->sessions; }

	/**
	 * Updates all sessions which need it.
	 */
	public function tick() : void{
		foreach($this->updateSessions as $k => $session){
			if(!$session->tick()){
				unset($this->updateSessions[$k]);
			}
		}
	}

	/**
	 * Terminates all connected sessions with the given reason.
	 */
	public function close(string $reason = "") : void{
		foreach($this->sessions as $session){
			$session->disconnect($reason);
		}
		$this->sessions = [];
		$this->updateSessions = [];
	}
}
