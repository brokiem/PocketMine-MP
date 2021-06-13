<?php

declare(strict_types=1);

namespace pocketmine\event\block;

use pocketmine\block\Block;
use pocketmine\event\Cancellable;
use pocketmine\event\CancellableTrait;
use pocketmine\math\Vector3;

class BlockTeleportEvent extends BlockEvent implements Cancellable{
	use CancellableTrait;

	/** @var Vector3 */
	private $to;

	public function __construct(Block $block, Vector3 $to){
		parent::__construct($block);
		$this->to = $to;
	}

	public function getTo() : Vector3{
		return $this->to;
	}

	public function setTo(Vector3 $to) : void{
		$this->to = $to;
	}
}
