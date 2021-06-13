<?php

declare(strict_types=1);

namespace pocketmine\scheduler;

/**
 * This exception can be thrown from Task::onRun() to cancel the execution of the task.
 * @see Task::onRun()
 */
final class CancelTaskException extends \Exception{

}
