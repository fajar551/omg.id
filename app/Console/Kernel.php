<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use YlsIdeas\FeatureFlags\Commands\CheckFeatureState;
use YlsIdeas\FeatureFlags\Commands\SwitchOffFeature;
use YlsIdeas\FeatureFlags\Commands\SwitchOnFeature;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        CheckFeatureState::class,
        SwitchOffFeature::class,
        SwitchOnFeature::class,
    ];
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('cron:amountactivate')
        ->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
