<?php

declare(strict_types=1);

namespace App\Modules\ExchangeRate\DTOs;

use App\Modules\ExchangeRate\Enums\CbrCurrency;
use Illuminate\Http\Request;
use Carbon\CarbonInterface;
use Carbon\Carbon;

class ExchangeRateRequestDto
{
    public CarbonInterface $date;

    public CbrCurrency $currency;

    public CbrCurrency $baseCurrency;

    /**
     * @param Request $request
     *
     * @return self
     */
    public static function fromRequest(Request $request): self
    {
        $dto = new self();

        $dto->date = Carbon::parse($request->input('date'));
        $dto->currency = CbrCurrency::from($request->input('currency'));
        $dto->baseCurrency = $request->input('base_currency') ?
            CbrCurrency::from($request->input('base_currency')) :
            CbrCurrency::RUB;

        return $dto;
    }
}
