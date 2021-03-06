<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\block\utils\TreeType;
use pocketmine\item\Axe;
use pocketmine\item\Item;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use pocketmine\utils\AssumptionFailedError;

class Wood extends Opaque{

	private TreeType $treeType;

	private bool $stripped;

	public function __construct(BlockIdentifier $idInfo, string $name, BlockBreakInfo $breakInfo, TreeType $treeType, bool $stripped){
		$this->stripped = $stripped; //TODO: this should be dynamic, but right now legacy shit gets in the way
		parent::__construct($idInfo, $name, $breakInfo);
		$this->treeType = $treeType;
	}

	/**
	 * TODO: this is ad hoc, but add an interface for this to all tree-related blocks
	 */
	public function getTreeType() : TreeType{
		return $this->treeType;
	}

	public function isStripped() : bool{ return $this->stripped; }

	public function getFuelTime() : int{
		return 300;
	}

	public function getFlameEncouragement() : int{
		return 5;
	}

	public function getFlammability() : int{
		return 5;
	}

	public function onInteract(Item $item, int $face, Vector3 $clickVector, ?Player $player = null) : bool{
		if(!$this->stripped and $item instanceof Axe){
			$item->applyDamage(10);
			$this->pos->getWorld()->setBlock($this->pos, $this->getStrippedLogBlock($this->getTreeType()));
			return true;
		}
		return false;
	}

	public function getStrippedLogBlock(TreeType $treeType) : Block{
		switch($treeType->id()){
			case TreeType::OAK()->id():
				return VanillaBlocks::STRIPPED_OAK_LOG();
			case TreeType::SPRUCE()->id():
				return VanillaBlocks::STRIPPED_SPRUCE_LOG();
			case TreeType::BIRCH()->id():
				return VanillaBlocks::STRIPPED_BIRCH_LOG();
			case TreeType::JUNGLE()->id():
				return VanillaBlocks::STRIPPED_JUNGLE_LOG();
			case TreeType::ACACIA()->id():
				return VanillaBlocks::STRIPPED_ACACIA_LOG();
			case TreeType::DARK_OAK()->id():
				return VanillaBlocks::STRIPPED_DARK_OAK_LOG();
		}
		throw new AssumptionFailedError("Switch should cover all wood types");
	}
}
