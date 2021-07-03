<?php

declare(strict_types=1);

namespace pocketmine\entity\object;

use pocketmine\block\Block;
use pocketmine\block\BlockFactory;
use pocketmine\block\utils\Fallable;
use pocketmine\entity\Entity;
use pocketmine\entity\EntitySizeInfo;
use pocketmine\entity\Location;
use pocketmine\event\entity\EntityBlockChangeEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\math\Vector3;
use pocketmine\nbt\tag\ByteTag;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\IntTag;
use pocketmine\network\mcpe\convert\RuntimeBlockMapping;
use pocketmine\network\mcpe\protocol\types\entity\EntityIds;
use pocketmine\network\mcpe\protocol\types\entity\EntityMetadataCollection;
use pocketmine\network\mcpe\protocol\types\entity\EntityMetadataProperties;
use pocketmine\player\Player;
use function abs;

class FallingBlock extends Entity{

	public static function getNetworkTypeId() : string{ return EntityIds::FALLING_BLOCK; }

	protected $gravity = 0.04;
	protected $drag = 0.02;

	/** @var Block */
	protected $block;

	public $canCollide = false;

	public function __construct(Location $location, Block $block, ?CompoundTag $nbt = null){
		$this->block = $block;
		parent::__construct($location, $nbt);
	}

	protected function getInitialSizeInfo() : EntitySizeInfo{ return new EntitySizeInfo(0.98, 0.98); }

	public static function parseBlockNBT(BlockFactory $factory, CompoundTag $nbt) : Block{
		$blockId = 0;

		//TODO: 1.8+ save format
		if(($tileIdTag = $nbt->getTag("TileID")) instanceof IntTag){
			$blockId = $tileIdTag->getValue();
		}elseif(($tileTag = $nbt->getTag("Tile")) instanceof ByteTag){
			$blockId = $tileTag->getValue();
		}

		if($blockId === 0){
			throw new \UnexpectedValueException("Missing block info from NBT");
		}

		$damage = $nbt->getByte("Data", 0);

		return $factory->get($blockId, $damage);
	}

	public function canCollideWith(Entity $entity) : bool{
		return false;
	}

	public function canBeMovedByCurrents() : bool{
		return false;
	}

	public function attack(EntityDamageEvent $source) : void{
		if($source->getCause() === EntityDamageEvent::CAUSE_VOID){
			parent::attack($source);
		}
	}

	protected function entityBaseTick(int $tickDiff = 1) : bool{
		if($this->closed){
			return false;
		}

		$hasUpdate = parent::entityBaseTick($tickDiff);

		if(!$this->isFlaggedForDespawn()){
			$world = $this->getWorld();
			$pos = $this->location->add(-$this->size->getWidth() / 2, $this->size->getHeight(), -$this->size->getWidth() / 2)->floor();

			$this->block->position($world, $pos->x, $pos->y, $pos->z);

			$blockTarget = null;
			if($this->block instanceof Fallable){
				$blockTarget = $this->block->tickFalling();
			}

			if($this->onGround or $blockTarget !== null){
				$this->flagForDespawn();

				$block = $world->getBlock($pos);
				if(!$block->canBeReplaced() or !$world->isInWorld($pos->getFloorX(), $pos->getFloorY(), $pos->getFloorZ()) or ($this->onGround and abs($this->location->y - $this->location->getFloorY()) > 0.001)){
					//FIXME: anvils are supposed to destroy torches
					$world->dropItem($this->location, $this->block->asItem());
				}else{
					$ev = new EntityBlockChangeEvent($this, $block, $blockTarget ?? $this->block);
					$ev->call();
					if(!$ev->isCancelled()){
						$world->setBlock($pos, $ev->getTo());
					}
				}
				$hasUpdate = true;
			}
		}

		return $hasUpdate;
	}

	public function getBlock() : Block{
		return $this->block;
	}

	public function saveNBT() : CompoundTag{
		$nbt = parent::saveNBT();
		$nbt->setInt("TileID", $this->block->getId());
		$nbt->setByte("Data", $this->block->getMeta());

		return $nbt;
	}

	protected function sendSpawnPacket(Player $player) : void{
		$this->getNetworkProperties()->setInt(EntityMetadataProperties::VARIANT, RuntimeBlockMapping::getInstance()->toRuntimeId($this->block->getFullId(), RuntimeBlockMapping::getMappingProtocol($player->getNetworkSession()->getProtocolId())));
		$this->getNetworkProperties()->clearDirtyProperties(); //needed for multi protocol

		parent::sendSpawnPacket($player);
	}

	//protected function syncNetworkData(EntityMetadataCollection $properties) : void{ No need due to multi protocol
	//	parent::syncNetworkData($properties);
	//
	//	$properties->setInt(EntityMetadataProperties::VARIANT, RuntimeBlockMapping::getInstance()->toRuntimeId($this->block->getFullId()));
	//}

	public function getOffsetPosition(Vector3 $vector3) : Vector3{
		return $vector3->add(0, 0.49, 0); //TODO: check if height affects this
	}
}
