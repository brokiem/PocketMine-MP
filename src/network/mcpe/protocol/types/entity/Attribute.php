<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types\entity;

final class Attribute{
	/** @var string */
	private $id;
	/** @var float */
	private $min;
	/** @var float */
	private $max;
	/** @var float */
	private $current;
	/** @var float */
	private $default;

	public function __construct(string $id, float $min, float $max, float $current, float $default){
		$this->id = $id;
		$this->min = $min;
		$this->max = $max;
		$this->current = $current;
		$this->default = $default;
	}

	public function getId() : string{
		return $this->id;
	}

	public function getMin() : float{
		return $this->min;
	}

	public function getMax() : float{
		return $this->max;
	}

	public function getCurrent() : float{
		return $this->current;
	}

	public function getDefault() : float{
		return $this->default;
	}
}
