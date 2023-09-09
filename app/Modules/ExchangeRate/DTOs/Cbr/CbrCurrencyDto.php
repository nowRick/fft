<?php

declare(strict_types=1);

namespace App\Modules\ExchangeRate\DTOs\Cbr;

use App\Modules\ExchangeRate\Enums\CbrCurrency;

class CbrCurrencyDto
{
    public string $id;

    public string $numCode;

    public CbrCurrency $charCode;

    public string $nominal;

    public string $name;

    public string $value;

    /**
     * @param array $data
     *
     * @return self
     */
    public static function fromArray(array $data): self
    {
        $dto = new self();

        $dto->id = $data['@attributes']['ID'];
        $dto->numCode = $data['NumCode'];
        $dto->charCode = CbrCurrency::from($data['CharCode']);
        $dto->nominal = $data['Nominal'];
        $dto->name = $data['Name'];
        $dto->value = str_replace(',', '.', $data['Value']);

        return $dto;
    }
}
