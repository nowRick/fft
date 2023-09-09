<?php

declare(strict_types=1);

namespace App\Modules\ExchangeRate\DTOs\Cbr;

use Carbon\CarbonInterface;
use Carbon\Carbon;

class CbrDto
{
    public CarbonInterface $date;

    public  array $currencies;

    /**
     * @param array $data
     *
     * @return self
     */
    public static function fromArray(array $data): self
    {
        $dto = new self();

        $dto->date = Carbon::parse($data['@attributes']['Date']);

        foreach ($data['Valute'] as $currency) {
            $dto->currencies[$currency['CharCode']] = CbrCurrencyDto::fromArray($currency);
        }

        return $dto;
    }
}
