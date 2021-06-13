<?php

declare(strict_types=1);

namespace pocketmine\network\mcpe\protocol\types\skin;

class SkinAnimation{

	public const TYPE_HEAD = 1;
	public const TYPE_BODY_32 = 2;
	public const TYPE_BODY_64 = 3;

	public const EXPRESSION_LINEAR = 0; //???
	public const EXPRESSION_BLINKING = 1;

	/** @var SkinImage */
	private $image;
	/** @var int */
	private $type;
	/** @var float */
	private $frames;
	/** @var int */
	private $expressionType;

	public function __construct(SkinImage $image, int $type, float $frames, int $expressionType){
		$this->image = $image;
		$this->type = $type;
		$this->frames = $frames;
		$this->expressionType = $expressionType;
	}

	/**
	 * Image of the animation.
	 */
	public function getImage() : SkinImage{
		return $this->image;
	}

	/**
	 * The type of animation you are applying.
	 */
	public function getType() : int{
		return $this->type;
	}

	/**
	 * The total amount of frames in an animation.
	 */
	public function getFrames() : float{
		return $this->frames;
	}

	public function getExpressionType() : int{ return $this->expressionType; }
}
