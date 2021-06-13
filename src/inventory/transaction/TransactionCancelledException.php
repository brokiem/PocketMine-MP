<?php

declare(strict_types=1);

namespace pocketmine\inventory\transaction;

/**
 * Thrown when an inventory transaction is valid, but can't proceed due to other factors (e.g. a plugin intervened).
 */
final class TransactionCancelledException extends TransactionException{

}
