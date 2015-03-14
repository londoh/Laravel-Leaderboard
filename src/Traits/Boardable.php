<?php
namespace Kaom\Leaderboard\Traits;

use Kaom\Leaderboard\Repositories\EloquentBoardRepository;

/**
 * Class Boardable.
 */
trait Boardable
{
    /**
     * Reward the given of amount of points.
     *
     * @param int $points
     *
     * @return mixed
     */
    public function reward($points)
    {
        return $this->leaderboard()->reward($points);
    }

    /**
     * Remove the given amount of points.
     *
     * @param int $points
     *
     * @return mixed
     */
    public function penalize($points)
    {
        return $this->leaderboard()->penalize($points);
    }

    /**
     * Multiply all points by the given factor.
     *
     * @param int|float $multiplier
     *
     * @return mixed
     */
    public function multiply($multiplier)
    {
        return $this->leaderboard()->multiply($multiplier);
    }

    /**
     * Redeem the given amount of points.
     *
     * @param int $points
     *
     * @return boolean
     */
    public function redeem($points)
    {
        return $this->leaderboard()->redeem($points);
    }

    /**
     * Disable an account for receiving points.
     *
     * @return mixed
     */
    public function blacklist()
    {
        return $this->leaderboard()->blacklist();
    }

    /**
     * Enable an account for receiving points.
     *
     * @return mixed
     */
    public function whitelist()
    {
        return $this->leaderboard()->whitelist();
    }

    /**
     * Reset all points of an entity to zero.
     *
     * @return mixed
     */
    public function reset()
    {
        return $this->leaderboard()->reset();
    }

    /**
     * Get get total points of the entity.
     *
     * @return int
     */
    public function getPoints()
    {
        return $this->board->points;
    }

    /**
     * Get the current rank of the entity.
     *
     * @return int
     */
    public function getRank()
    {
        return $this->board->rank;
    }

    /**
     * @return bool
     */
    public function isBlacklisted()
    {
        return $this->board->blacklisted;
    }

    /**
     * @return mixed
     */
    public function board()
    {
        return $this->morphOne('Kaom\Leaderboard\Models\Board', 'boardable');
    }

    /**
     * @return EloquentBoardRepository
     */
    protected function leaderboard()
    {
        return new EloquentBoardRepository($this);
    }
}
