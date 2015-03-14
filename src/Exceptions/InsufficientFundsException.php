<?php
namespace Kaom\Leaderboard\Exceptions;

use Exception;

/**
 * Class InsufficientFundsException.
 */
class InsufficientFundsException extends Exception
{
    /**
     * Create a new exception instance.
     *
     * @param string $type
     * @param mixed  $id
     * @param int    $points
     */
    public function __construct($type, $id, $points)
    {
        $points = abs($points);

        parent::__construct("Entity [{$type}] with ID [{$id}] is missing [{$points}] points.");
    }
}
