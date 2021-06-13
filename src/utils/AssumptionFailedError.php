<?php

declare(strict_types=1);

namespace pocketmine\utils;

/**
 * This exception should be thrown in places where something is assumed to be true, but the type system does not provide
 * a guarantee. This makes static analysers happy and makes sure that the server will crash properly if any assumption
 * does not hold.
 */
final class AssumptionFailedError extends \Error{

}
