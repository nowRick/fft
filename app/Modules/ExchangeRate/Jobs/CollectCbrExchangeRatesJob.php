<?php

declare(strict_types=1);

namespace App\Modules\ExchangeRate\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Queue\SerializesModels;
use Illuminate\Bus\Queueable;
use Carbon\CarbonInterface;

class CollectCbrExchangeRatesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private int $days;

    /**
     * Create a new job instance.
     */
    public function __construct(
      private readonly CarbonInterface $date,
    ) {
        $this->days = (int) config('modules.exchange_rate.cbr.days');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $daysRange = range(0, $this->days - 1);

        foreach ($daysRange as $day) {
            Artisan::call('cbr:collect-exchange-rates', [
                '--date' => $this->date->subDays($day)->format('d-m-Y'),
            ]);
        }
    }
}
