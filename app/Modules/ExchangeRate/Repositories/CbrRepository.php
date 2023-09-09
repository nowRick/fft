<?php

declare(strict_types=1);

namespace App\Modules\ExchangeRate\Repositories;

use App\Modules\ExchangeRate\Contracts\Repositories\CbrRepositoryContract;
use App\Modules\ExchangeRate\DTOs\Cbr\CbrCurrencyDto;
use App\Modules\ExchangeRate\Enums\CbrCurrency;
use App\Modules\ExchangeRate\DTOs\Cbr\CbrDto;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Carbon\CarbonInterface;
use Carbon\Carbon;

class CbrRepository implements CbrRepositoryContract
{
    public string $url;

    public int $ttlInMinutes;

    public function __construct()
    {
        $this->url = config('modules.exchange_rate.cbr.url');
        $this->ttlInMinutes = (int) config('modules.exchange_rate.cbr.cache_ttl');
    }

    /**
     * @param CarbonInterface $date
     *
     * @return CbrDto
     */
    public function getExchangeRateCurrencies(CarbonInterface $date): CbrDto
    {
        $cacheKey = class_basename(__METHOD__) . ':' . $date->format('d-m-Y');
        $ttl = Carbon::now()->addMinutes($this->ttlInMinutes);

        return Cache::remember($cacheKey, $ttl, function () use ($date) {
            $response = Http::get($this->url, ['date_req' => $date->format('d/m/Y')]);

            $data = json_decode(
                json_encode(
                    simplexml_load_string($response->body())
                ),
                true
            );

            return CbrDto::fromArray($data);
        });
    }

    /**
     * @param CbrCurrency $currency
     * @param CarbonInterface $date
     *
     * @return CbrCurrencyDto
     */
    public function getExchangeRateCurrency(CbrCurrency $currency, CarbonInterface $date): CbrCurrencyDto
    {
        if ($currency === CbrCurrency::RUB) {
            $currencyDto = new CbrCurrencyDto();
            $currencyDto->id = '0';
            $currencyDto->numCode = '0';
            $currencyDto->charCode = CbrCurrency::RUB;
            $currencyDto->nominal = '1';
            $currencyDto->name = 'Российский рубль';
            $currencyDto->value = '1';
        } else {
            /** @var CbrCurrencyDto $currencyForSelectedDate */
            $currencyDto = $this->getExchangeRateCurrencies($date)->currencies[$currency->value];
        }

        return $currencyDto;
    }

    /**
     * @param CarbonInterface $date
     *
     * @return CarbonInterface
     */
    public function getLastTradingDate(CarbonInterface $date): CarbonInterface
    {
        return match ($date->dayOfWeekIso) {
            1 => (clone $date)->subDays(3),
            7 => (clone $date)->subDays(2),
            default => (clone $date)->subDay(),
        };
    }
}
