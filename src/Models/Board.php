<?php
namespace Kaom\Leaderboard\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Board.
 */
class Board extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'leaderboard';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['points', 'rank', 'locked'];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'points' => 'integer',
        'rank'   => 'integer',
        'locked' => 'boolean',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function boardable()
    {
        return $this->morphTo();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->boardable_id;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->boardable_type;
    }
}
