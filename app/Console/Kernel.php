<?php

namespace App\Console;

use App\Modules\ExchangeRate\Jobs\CollectCbrExchangeRatesJob;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Console\Scheduling\Schedule;
use Carbon\Carbon;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->job(new CollectCbrExchangeRatesJob(Carbon::now()))->everyFiveSeconds();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load([
            __DIR__ . '/Commands',
            app_path() . '/Modules/ExchangeRate/Commands',
        ]);

        require base_path('routes/console.php');
    }
}
