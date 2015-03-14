<?php
namespace Kaom\Leaderboard\Repositories;

use Kaom\Leaderboard\Contracts\BoardRepository;
use Kaom\Leaderboard\Exceptions\BlacklistedException;
use Kaom\Leaderboard\Exceptions\InsufficientFundsException;
use Kaom\Leaderboard\Models\Board;

/**
 * Class EloquentBoardRepository.
 */
class EloquentBoardRepository implements BoardRepository
{
    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * Create a new repository instance.
     *
     * @param \Kaom\Leaderboard\Traits\Boardable $model
     */
    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * Reward the given of amount of points.
     *
     * @param int $points
     *
     * @throws BlacklistedException
     */
    public function reward($points)
    {
        $this->abortIfBlacklisted();

        if ($this->getBoardQuery()->count()) {
            $this->getBoard()->increment('points', $points);
        } else {
            $this->getBoardQuery()->save(
                new Board(['points' => $points])
            );
        }

        $this->calculateRankings();
    }

    /**
     * Remove the given amount of points.
     *
     * @param int $points
     *
     * @throws BlacklistedException
     */
    public function penalize($points)
    {
        $this->abortIfBlacklisted();

        $this->getBoard()->decrement('points', $points);

        $this->saveBoardInstance();
    }

    /**
     * Multiply all points by the given factor.
     *
     * @param float|int $multiplier
     *
     * @throws BlacklistedException
     */
    public function multiply($multiplier)
    {
        $this->abortIfBlacklisted();

        $this->getBoard()->points = $this->getBoard()->points * $multiplier;

        $this->saveBoardInstance();
    }

    /**
     * Redeem the given amount of points.
     *
     * @param int $points
     *
     * @throws BlacklistedException
     * @throws InsufficientFundsException
     *
     * @return bool
     */
    public function redeem($points)
    {
        $this->abortIfBlacklisted();

        $afterRedemeption = $this->getBoard()->points - $points;

        if ($afterRedemeption < 0) {
            throw new InsufficientFundsException(
                $this->getBoard()->getType(),
                $this->getBoard()->getId(),
                $afterRedemeption
            );
        }

        $this->penalize($points);

        return true;
    }

    /**
     * Disable an account for receiving points.
     */
    public function blacklist()
    {
        $this->getBoard()->blacklisted = true;

        $this->saveBoardInstance();
    }

    /**
     * Enable an account for receiving points.
     */
    public function whitelist()
    {
        $this->getBoard()->blacklisted = false;

        $this->saveBoardInstance();
    }

    /**
     * Reset an accounts points.
     *
     * @throws BlacklistedException
     */
    public function reset()
    {
        $this->abortIfBlacklisted();

        $this->getBoard()->points = 0;

        $this->saveBoardInstance();
    }

    /**
     * Calculate the ranks based on points.
     */
    protected function calculateRankings()
    {
        $boards = Board::orderBy('points', 'DESC')->get();

        foreach ($boards as $index => $board) {
            $board->rank = $index + 1;
            $board->push();
        }
    }

    /**
     * Cancel the current action if a user is blacklisted.
     *
     * @throws BlacklistedException
     *
     * @return bool
     */
    protected function abortIfBlacklisted()
    {
        if ($this->model->isBlacklisted()) {
            throw new BlacklistedException(
                $this->getBoard()->getType(),
                $this->getBoard()->getId()
            );
        }

        return false;
    }

    /**
     * Save the board model and recalculate all ranks.
     */
    protected function saveBoardInstance()
    {
        $this->getBoard()->save();

        $this->calculateRankings();
    }

    /**
     * @return mixed
     */
    protected function getBoard()
    {
        return $this->model->board;
    }

    /**
     * @return mixed
     */
    protected function getBoardQuery()
    {
        return $this->model->board();
    }
}
