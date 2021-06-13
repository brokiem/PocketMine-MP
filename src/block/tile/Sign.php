<?php

declare(strict_types=1);

namespace pocketmine\block\tile;

use pocketmine\block\utils\SignText;
use pocketmine\math\Vector3;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\StringTag;
use pocketmine\world\World;
use function array_pad;
use function array_slice;
use function explode;
use function implode;
use function mb_scrub;
use function sprintf;

/**
 * @deprecated
 * @see \pocketmine\block\BaseSign
 */
class Sign extends Spawnable{
	public const TAG_TEXT_BLOB = "Text";
	public const TAG_TEXT_LINE = "Text%d"; //sprintf()able

	/**
	 * @return string[]
	 */
	public static function fixTextBlob(string $blob) : array{
		return array_slice(array_pad(explode("\n", $blob), 4, ""), 0, 4);
	}

	/** @var SignText */
	protected $text;

	/** @var int|null */
	protected $editorEntityRuntimeId = null;

	public function __construct(World $world, Vector3 $pos){
		$this->text = new SignText();
		parent::__construct($world, $pos);
	}

	public function readSaveData(CompoundTag $nbt) : void{
		if(($textBlobTag = $nbt->getTag(self::TAG_TEXT_BLOB)) instanceof StringTag){ //MCPE 1.2 save format
			$this->text = SignText::fromBlob(mb_scrub($textBlobTag->getValue(), 'UTF-8'));
		}else{
			$text = [];
			for($i = 0; $i < SignText::LINE_COUNT; ++$i){
				$textKey = sprintf(self::TAG_TEXT_LINE, $i + 1);
				if(($lineTag = $nbt->getTag($textKey)) instanceof StringTag){
					$text[$i] = mb_scrub($lineTag->getValue(), 'UTF-8');
				}
			}
			$this->text = new SignText($text);
		}
	}

	protected function writeSaveData(CompoundTag $nbt) : void{
		$nbt->setString(self::TAG_TEXT_BLOB, implode("\n", $this->text->getLines()));

		for($i = 0; $i < SignText::LINE_COUNT; ++$i){ //Backwards-compatibility
			$textKey = sprintf(self::TAG_TEXT_LINE, $i + 1);
			$nbt->setString($textKey, $this->text->getLine($i));
		}
	}

	public function getText() : SignText{
		return $this->text;
	}

	public function setText(SignText $text) : void{
		$this->text = $text;
	}

	/**
	 * Returns the entity runtime ID of the player who placed this sign. Only the player whose entity ID matches this
	 * one may edit the sign text.
	 * This is needed because as of 1.16.220, there is still no reliable way to detect when the MCPE client closed the
	 * sign edit GUI, so we have no way to know when the text is finalized. This limits editing of the text to only the
	 * player who placed it, and only while that player is online.
	 * We can say for sure that the sign is finalized if either of the following occurs:
	 * - The player quits (after rejoin, the player's entity runtimeID will be different).
	 * - The chunk is unloaded (on next load, the entity runtimeID will be null, because it's not saved).
	 */
	public function getEditorEntityRuntimeId() : ?int{ return $this->editorEntityRuntimeId; }

	public function setEditorEntityRuntimeId(?int $editorEntityRuntimeId) : void{
		$this->editorEntityRuntimeId = $editorEntityRuntimeId;
	}

	protected function addAdditionalSpawnData(CompoundTag $nbt) : void{
		$nbt->setString(self::TAG_TEXT_BLOB, implode("\n", $this->text->getLines()));
	}
}
