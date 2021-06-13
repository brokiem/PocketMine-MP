<?php

declare(strict_types=1);

namespace pocketmine\block\utils;

use pocketmine\utils\EnumTrait;

/**
 * This doc-block is generated automatically, do not modify it manually.
 * This must be regenerated whenever registry members are added, removed or changed.
 * @see \pocketmine\utils\RegistryUtils::_generateMethodAnnotations()
 *
 * @method static BannerPatternType BORDER()
 * @method static BannerPatternType BRICKS()
 * @method static BannerPatternType CIRCLE()
 * @method static BannerPatternType CREEPER()
 * @method static BannerPatternType CROSS()
 * @method static BannerPatternType CURLY_BORDER()
 * @method static BannerPatternType DIAGONAL_LEFT()
 * @method static BannerPatternType DIAGONAL_RIGHT()
 * @method static BannerPatternType DIAGONAL_UP_LEFT()
 * @method static BannerPatternType DIAGONAL_UP_RIGHT()
 * @method static BannerPatternType FLOWER()
 * @method static BannerPatternType GRADIENT()
 * @method static BannerPatternType GRADIENT_UP()
 * @method static BannerPatternType HALF_HORIZONTAL()
 * @method static BannerPatternType HALF_HORIZONTAL_BOTTOM()
 * @method static BannerPatternType HALF_VERTICAL()
 * @method static BannerPatternType HALF_VERTICAL_RIGHT()
 * @method static BannerPatternType MOJANG()
 * @method static BannerPatternType RHOMBUS()
 * @method static BannerPatternType SKULL()
 * @method static BannerPatternType SMALL_STRIPES()
 * @method static BannerPatternType SQUARE_BOTTOM_LEFT()
 * @method static BannerPatternType SQUARE_BOTTOM_RIGHT()
 * @method static BannerPatternType SQUARE_TOP_LEFT()
 * @method static BannerPatternType SQUARE_TOP_RIGHT()
 * @method static BannerPatternType STRAIGHT_CROSS()
 * @method static BannerPatternType STRIPE_BOTTOM()
 * @method static BannerPatternType STRIPE_CENTER()
 * @method static BannerPatternType STRIPE_DOWNLEFT()
 * @method static BannerPatternType STRIPE_DOWNRIGHT()
 * @method static BannerPatternType STRIPE_LEFT()
 * @method static BannerPatternType STRIPE_MIDDLE()
 * @method static BannerPatternType STRIPE_RIGHT()
 * @method static BannerPatternType STRIPE_TOP()
 * @method static BannerPatternType TRIANGLES_BOTTOM()
 * @method static BannerPatternType TRIANGLES_TOP()
 * @method static BannerPatternType TRIANGLE_BOTTOM()
 * @method static BannerPatternType TRIANGLE_TOP()
 */
final class BannerPatternType{
	use EnumTrait;

	protected static function setup() : void{
		self::registerAll(
			new self("border"),
			new self("bricks"),
			new self("circle"),
			new self("creeper"),
			new self("cross"),
			new self("curly_border"),
			new self("diagonal_left"),
			new self("diagonal_right"),
			new self("diagonal_up_left"),
			new self("diagonal_up_right"),
			new self("flower"),
			new self("gradient"),
			new self("gradient_up"),
			new self("half_horizontal"),
			new self("half_horizontal_bottom"),
			new self("half_vertical"),
			new self("half_vertical_right"),
			new self("mojang"),
			new self("rhombus"),
			new self("skull"),
			new self("small_stripes"),
			new self("square_bottom_left"),
			new self("square_bottom_right"),
			new self("square_top_left"),
			new self("square_top_right"),
			new self("straight_cross"),
			new self("stripe_bottom"),
			new self("stripe_center"),
			new self("stripe_downleft"),
			new self("stripe_downright"),
			new self("stripe_left"),
			new self("stripe_middle"),
			new self("stripe_right"),
			new self("stripe_top"),
			new self("triangle_bottom"),
			new self("triangle_top"),
			new self("triangles_bottom"),
			new self("triangles_top")
		);
	}
}
