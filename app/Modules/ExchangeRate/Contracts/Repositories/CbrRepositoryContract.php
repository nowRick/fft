<?php

declare(strict_types=1);

namespace App\Modules\ExchangeRate\Contracts\Repositories;

use App\Modules\ExchangeRate\DTOs\Cbr\CbrCurrencyDto;
use App\Modules\ExchangeRate\Enums\CbrCurrency;
use App\Modules\ExchangeRate\DTOs\Cbr\CbrDto;
use Carbon\CarbonInterface;

interface CbrRepositoryContract
{
    public function getExchangeRateCurrencies(CarbonInterface $date): CbrDto;

    public function getExchangeRateCurrency(CbrCurrency $currency, CarbonInterface $date): CbrCurrencyDto;

    public function getLastTradingDate(CarbonInterface $date): CarbonInterface;
}
