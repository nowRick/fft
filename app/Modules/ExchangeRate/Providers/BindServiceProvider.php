<?php

declare(strict_types=1);

namespace App\Modules\ExchangeRate\Providers;

use App\Modules\ExchangeRate\Contracts\Services\CalculateExchangeRateServiceContract;
use App\Modules\ExchangeRate\Services\CalculateExchangeRateService;
use Illuminate\Support\ServiceProvider;

class BindServiceProvider extends ServiceProvider
{
    public array $bindings = [
        CalculateExchangeRateServiceContract::class => CalculateExchangeRateService::class,
    ];
}
