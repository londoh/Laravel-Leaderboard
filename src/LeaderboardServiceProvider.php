<?php
namespace Kaom\Leaderboard;

use Illuminate\Support\ServiceProvider;

/**
 * Class LeaderboardServiceProvider.
 */
class LeaderboardServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../database/migrations/' => base_path('/database/migrations'),
        ], 'migrations');
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->bind(
            'Kaom\Leaderboard\Contracts\BoardRepository',
            'Kaom\Leaderboard\Repositories\EloquentBoardRepository'
        );
    }
}
