<?php

declare(strict_types=1);

namespace pocketmine\block;

use pocketmine\math\Facing;

class Rail extends BaseRail{

	/* extended meta values for regular rails, to allow curving */

	private const CURVE_CONNECTIONS = [
		BlockLegacyMetadata::RAIL_CURVE_SOUTHEAST => [
			Facing::SOUTH,
			Facing::EAST
		],
		BlockLegacyMetadata::RAIL_CURVE_SOUTHWEST => [
			Facing::SOUTH,
			Facing::WEST
		],
		BlockLegacyMetadata::RAIL_CURVE_NORTHWEST => [
			Facing::NORTH,
			Facing::WEST
		],
		BlockLegacyMetadata::RAIL_CURVE_NORTHEAST => [
			Facing::NORTH,
			Facing::EAST
		]
	];

	protected function getMetaForState(array $connections) : int{
		try{
			return self::searchState($connections, self::CURVE_CONNECTIONS);
		}catch(\InvalidArgumentException $e){
			return parent::getMetaForState($connections);
		}
	}

	protected function getConnectionsFromMeta(int $meta) : ?array{
		return self::CURVE_CONNECTIONS[$meta] ?? self::CONNECTIONS[$meta] ?? null;
	}

	protected function getPossibleConnectionDirectionsOneConstraint(int $constraint) : array{
		$possible = parent::getPossibleConnectionDirectionsOneConstraint($constraint);

		if(($constraint & self::FLAG_ASCEND) === 0){
			foreach([
				Facing::NORTH,
				Facing::SOUTH,
				Facing::WEST,
				Facing::EAST
			] as $d){
				if($constraint !== $d){
					$possible[$d] = true;
				}
			}
		}

		return $possible;
	}
}
