<?php

declare(strict_types=1);

namespace App\Modules\ExchangeRate\Services;

use App\Modules\ExchangeRate\Contracts\Services\CalculateExchangeRateServiceContract;
use App\Modules\ExchangeRate\Contracts\Repositories\CbrRepositoryContract;
use App\Modules\ExchangeRate\DTOs\ExchangeRateRequestDto;
use App\Modules\ExchangeRate\DTOs\ExchangeRateDto;
use App\Modules\ExchangeRate\Enums\CbrCurrency;

class CalculateExchangeRateService implements CalculateExchangeRateServiceContract
{
    public int $precision;

    public function __construct(
        private readonly CbrRepositoryContract $cbrRepository,
    ) {
        $this->precision = (int) config('modules.exchange_rate.cbr.precision');
    }

    /**
     * @param ExchangeRateRequestDto $dto
     *
     * @return ExchangeRateDto
     */
    public function calculate(ExchangeRateRequestDto $dto): ExchangeRateDto
    {
        $lastTradingDate = $this->cbrRepository->getLastTradingDate($dto->date);

        $currencyForSelectedDate = $this->cbrRepository->getExchangeRateCurrency($dto->currency, $dto->date);
        $currencyForLastTradingDate = $this->cbrRepository->getExchangeRateCurrency($dto->currency, $lastTradingDate);

        bcscale($this->precision);
        $exchangeRateCurrencyForSelectedDate = bcdiv($currencyForSelectedDate->value, $currencyForSelectedDate->nominal);
        $exchangeRateCurrencyForLastTradingDate = bcdiv($currencyForLastTradingDate->value, $currencyForLastTradingDate->nominal);

        if ($dto->baseCurrency === CbrCurrency::RUB) {
            $exchangeRate = $exchangeRateCurrencyForSelectedDate;
            $difference = bcsub($exchangeRate, $exchangeRateCurrencyForLastTradingDate);
        } else {
            $baseCurrencyForSelectedDate = $this->cbrRepository->getExchangeRateCurrency($dto->baseCurrency, $dto->date);
            $baseCurrencyForLastTradingDate = $this->cbrRepository->getExchangeRateCurrency($dto->baseCurrency, $lastTradingDate);

            $exchangeRateBaseCurrencyForSelectedDate = bcdiv($baseCurrencyForSelectedDate->value, $baseCurrencyForSelectedDate->nominal);
            $exchangeRateBaseCurrencyForLastTradingDate = bcdiv($baseCurrencyForLastTradingDate->value, $baseCurrencyForLastTradingDate->nominal);

            $exchangeRate = bcdiv($exchangeRateCurrencyForSelectedDate, $exchangeRateBaseCurrencyForSelectedDate);
            $difference = bcsub(
                $exchangeRate,
                bcdiv($exchangeRateCurrencyForLastTradingDate, $exchangeRateBaseCurrencyForLastTradingDate)
            );
        }

        $exchangeRateDto = new ExchangeRateDto();
        $exchangeRateDto->exchangeRate = $exchangeRate;
        $exchangeRateDto->difference = $difference;

        return $exchangeRateDto;
    }
}
