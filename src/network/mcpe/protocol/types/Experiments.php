<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types;

use pocketmine\network\mcpe\protocol\serializer\PacketSerializer;
use function count;

final class Experiments{

	/**
	 * @var bool[]
	 * @phpstan-var array<string, bool>
	 */
	private $experiments;
	/** @var bool */
	private $hasPreviouslyUsedExperiments;

	/**
	 * @param bool[] $experiments
	 * @phpstan-param array<string, bool> $experiments
	 */
	public function __construct(array $experiments, bool $hasPreviouslyUsedExperiments){
		$this->experiments = $experiments;
		$this->hasPreviouslyUsedExperiments = $hasPreviouslyUsedExperiments;
	}

	/** @return bool[] */
	public function getExperiments() : array{ return $this->experiments; }

	public function hasPreviouslyUsedExperiments() : bool{ return $this->hasPreviouslyUsedExperiments; }

	public static function read(PacketSerializer $in) : self{
		$experiments = [];
		for($i = 0, $len = $in->getLInt(); $i < $len; ++$i){
			$experimentName = $in->getString();
			$enabled = $in->getBool();
			$experiments[$experimentName] = $enabled;
		}
		$hasPreviouslyUsedExperiments = $in->getBool();
		return new self($experiments, $hasPreviouslyUsedExperiments);
	}

	public function write(PacketSerializer $out) : void{
		$out->putLInt(count($this->experiments));
		foreach($this->experiments as $experimentName => $enabled){
			$out->putString($experimentName);
			$out->putBool($enabled);
		}
		$out->putBool($this->hasPreviouslyUsedExperiments);
	}
}
