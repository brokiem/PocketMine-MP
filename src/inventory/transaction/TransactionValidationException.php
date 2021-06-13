<?php

declare(strict_types=1);

namespace pocketmine\inventory\transaction;

/**
 * Thrown when a transaction cannot proceed due to preconditions not being met (e.g. transaction doesn't balance).
 */
class TransactionValidationException extends TransactionException{

}
