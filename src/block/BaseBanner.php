<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\block\tile\Banner as TileBanner;
use pocketmine\block\utils\BannerPatternLayer;
use pocketmine\block\utils\DyeColor;
use pocketmine\data\bedrock\DyeColorIdMap;
use pocketmine\item\Banner as ItemBanner;
use pocketmine\item\Item;
use pocketmine\item\ItemFactory;
use pocketmine\item\ItemIds;
use pocketmine\math\AxisAlignedBB;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use pocketmine\world\BlockTransaction;
use function array_filter;
use function assert;
use function count;

abstract class BaseBanner extends Transparent{

	protected DyeColor $baseColor;

	/**
	 * @var BannerPatternLayer[]
	 * @phpstan-var list<BannerPatternLayer>
	 */
	protected array $patterns = [];

	public function __construct(BlockIdentifier $idInfo, string $name, BlockBreakInfo $breakInfo){
		parent::__construct($idInfo, $name, $breakInfo);
		$this->baseColor = DyeColor::BLACK();
	}

	public function readStateFromWorld() : void{
		parent::readStateFromWorld();
		$tile = $this->pos->getWorld()->getTile($this->pos);
		if($tile instanceof TileBanner){
			$this->baseColor = $tile->getBaseColor();
			$this->setPatterns($tile->getPatterns());
		}
	}

	public function writeStateToWorld() : void{
		parent::writeStateToWorld();
		$tile = $this->pos->getWorld()->getTile($this->pos);
		assert($tile instanceof TileBanner);
		$tile->setBaseColor($this->baseColor);
		$tile->setPatterns($this->patterns);
	}

	public function isSolid() : bool{
		return false;
	}

	/**
	 * TODO: interface method? this is only the BASE colour...
	 */
	public function getColor() : DyeColor{
		return $this->baseColor;
	}

	/**
	 * @return BannerPatternLayer[]
	 * @phpstan-return list<BannerPatternLayer>
	 */
	public function getPatterns() : array{
		return $this->patterns;
	}

	/**
	 * @param BannerPatternLayer[]             $patterns
	 *
	 * @phpstan-param list<BannerPatternLayer> $patterns
	 * @return $this
	 */
	public function setPatterns(array $patterns) : self{
		$checked = array_filter($patterns, fn($v) => $v instanceof BannerPatternLayer);
		if(count($checked) !== count($patterns)){
			throw new \TypeError("Deque must only contain " . BannerPatternLayer::class . " objects");
		}
		$this->patterns = $checked;
		return $this;
	}

	/**
	 * @return AxisAlignedBB[]
	 */
	protected function recalculateCollisionBoxes() : array{
		return [];
	}

	public function place(BlockTransaction $tx, Item $item, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector, ?Player $player = null) : bool{
		if($item instanceof ItemBanner){
			$this->baseColor = $item->getColor();
			$this->setPatterns($item->getPatterns());
		}

		return parent::place($tx, $item, $blockReplace, $blockClicked, $face, $clickVector, $player);
	}

	abstract protected function getSupportingFace() : int;

	public function onNearbyBlockChange() : void{
		if($this->getSide($this->getSupportingFace())->getId() === BlockLegacyIds::AIR){
			$this->pos->getWorld()->useBreakOn($this->pos);
		}
	}

	public function asItem() : Item{
		return ItemFactory::getInstance()->get(ItemIds::BANNER, DyeColorIdMap::getInstance()->toInvertedId($this->baseColor));
	}

	public function getDropsForCompatibleTool(Item $item) : array{
		$drop = $this->asItem();
		if($drop instanceof ItemBanner and count($this->patterns) > 0){
			$drop->setPatterns($this->patterns);
		}

		return [$drop];
	}

	public function getPickedItem(bool $addUserData = false) : Item{
		$result = $this->asItem();
		if($addUserData and $result instanceof ItemBanner and count($this->patterns) > 0){
			$result->setPatterns($this->patterns);
		}
		return $result;
	}
}
