<?php
namespace Kaom\Leaderboard\Contracts;

/**
 * Interface BoardRepository.
 */
interface BoardRepository
{
    /**
     * Reward the given of amount of points.
     *
     * @param int $points
     */
    public function reward($points);

    /**
     * Remove the given amount of points.
     *
     * @param int $points
     */
    public function penalize($points);

    /**
     * Multiply all points by the given factor.
     *
     * @param int|float $multiplier
     */
    public function multiply($multiplier);

    /**
     * Redeem the given amount of points.
     *
     * @param int $points
     */
    public function redeem($points);

    /**
     * Disable an account for receiving points.
     */
    public function blacklist();

    /**
     * Enable an account for receiving points.
     */
    public function whitelist();

    /**
     * Reset all points of an entity to zero.
     */
    public function reset();
}
