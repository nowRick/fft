<?php

declare(strict_types=1);

namespace App\Modules\ExchangeRate\Commands;

use App\Modules\ExchangeRate\Contracts\Repositories\CbrRepositoryContract;
use App\Modules\ExchangeRate\DTOs\Cbr\CbrCurrencyDto;
use App\Models\CbrExchangeRate;
use Illuminate\Console\Command;
use Carbon\Carbon;

class CollectCbrExchangeRates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cbr:collect-exchange-rates
                            {--date=now : Override date (default is now)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Collection of exchange rates from cbr.ru';

    public function __construct(
        private CbrRepositoryContract $cbrRepository,
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $date = match ($this->option('date')) {
            'now' => Carbon::now(),
            default => Carbon::parse($this->option('date')),
        };

        if ($date >= Carbon::now()) {
            $this->alert('The entered date must be less than or equal to the current date!');
            return;
        }

        $cbrDto = $this->cbrRepository->getExchangeRateCurrencies($date);

        /** @var CbrCurrencyDto $currency */
        foreach ($cbrDto->currencies as $currency) {
            $isExists = CbrExchangeRate::query()
                ->where('char_code', $currency->charCode)
                ->whereDate('date', $cbrDto->date)
                ->exists();

            if ($isExists) {
                $this->warn(
                    "For the specified date {$cbrDto->date->format('d.m.Y')} " .
                    "there is already data on the currency {$currency->charCode->value}!"
                );
                continue;
            }

            CbrExchangeRate::query()->create([
                'identifier' => $currency->id,
                'num_code' => $currency->numCode,
                'char_code' => $currency->charCode,
                'nominal' => $currency->nominal,
                'name' => $currency->name,
                'value' => $currency->value,
                'date' => $cbrDto->date,
            ]);
        }

        $this->info('The command worked successfully!');
    }
}
