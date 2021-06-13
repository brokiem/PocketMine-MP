<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;
use function count;

class AnimateEntityPacket extends DataPacket implements ClientboundPacket{
	public const NETWORK_ID = ProtocolInfo::ANIMATE_ENTITY_PACKET;

	/** @var string */
	private $animation;
	/** @var string */
	private $nextState;
	/** @var string */
	private $stopExpression;
	/** @var string */
	private $controller;
	/** @var float */
	private $blendOutTime;
	/**
	 * @var int[]
	 * @phpstan-var list<int>
	 */
	private $actorRuntimeIds;

	/**
	 * @param int[] $actorRuntimeIds
	 * @phpstan-param list<int> $actorRuntimeIds
	 */
	public static function create(string $animation, string $nextState, string $stopExpression, string $controller, float $blendOutTime, array $actorRuntimeIds) : self{
		$result = new self;
		$result->animation = $animation;
		$result->nextState = $nextState;
		$result->stopExpression = $stopExpression;
		$result->controller = $controller;
		$result->blendOutTime = $blendOutTime;
		$result->actorRuntimeIds = $actorRuntimeIds;
		return $result;
	}

	public function getAnimation() : string{ return $this->animation; }

	public function getNextState() : string{ return $this->nextState; }

	public function getStopExpression() : string{ return $this->stopExpression; }

	public function getController() : string{ return $this->controller; }

	public function getBlendOutTime() : float{ return $this->blendOutTime; }

	/**
	 * @return int[]
	 * @phpstan-return list<int>
	 */
	public function getActorRuntimeIds() : array{ return $this->actorRuntimeIds; }

	protected function decodePayload(PacketSerializer $in) : void{
		$this->animation = $in->getString();
		$this->nextState = $in->getString();
		$this->stopExpression = $in->getString();
		$this->controller = $in->getString();
		$this->blendOutTime = $in->getLFloat();
		$this->actorRuntimeIds = [];
		for($i = 0, $len = $in->getUnsignedVarInt(); $i < $len; ++$i){
			$this->actorRuntimeIds[] = $in->getEntityRuntimeId();
		}
	}

	protected function encodePayload(PacketSerializer $out) : void{
		$out->putString($this->animation);
		$out->putString($this->nextState);
		$out->putString($this->stopExpression);
		$out->putString($this->controller);
		$out->putLFloat($this->blendOutTime);
		$out->putUnsignedVarInt(count($this->actorRuntimeIds));
		foreach($this->actorRuntimeIds as $id){
			$out->putEntityRuntimeId($id);
		}
	}

	public function handle(PacketHandlerInterface $handler) : bool{
		return $handler->handleAnimateEntity($this);
	}
}
