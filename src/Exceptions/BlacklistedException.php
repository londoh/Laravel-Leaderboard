<?php
namespace Kaom\Leaderboard\Exceptions;

use Exception;

/**
 * Class BlacklistedException.
 */
class BlacklistedException extends Exception
{
    /**
     * Create a new exception instance.
     *
     * @param string $type
     * @param mixed  $id
     */
    public function __construct($type, $id)
    {
        parent::__construct("Entity [{$type}] with ID [{$id}] is blacklisted.");
    }
}
