<?php

declare(strict_types=1);

namespace App\Modules\ExchangeRate\Http\Requests;

use App\Modules\ExchangeRate\DTOs\ExchangeRateRequestDto;
use App\Modules\ExchangeRate\Enums\CbrCurrency;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use OpenApi\Attributes as OA;

class ExchangeRateRequest extends FormRequest
{
    #[
        OA\Parameter(
            parameter: 'date',
            name: 'date',
            description: 'Дата (dd-mm-YYYY)',
            in: 'query',
            required: true,
            schema: new OA\Schema(
                type: 'string',
                format: 'date',
            ),
        ),
        OA\Parameter(
            parameter: 'currency',
            name: 'currency',
            description: 'Код валюты в формате ISO 4217 (USD)',
            in: 'query',
            required: true,
            schema: new OA\Schema(
                type: 'string',
            ),
        ),
        OA\Parameter(
            parameter: 'base_currency',
            name: 'base_currency',
            description: 'Код базовой валюты в формате ISO 4217 (RUB)',
            in: 'query',
            schema: new OA\Schema(
                type: 'string',
            ),
        ),
    ]
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'date' => ['required', 'date', 'before_or_equal:now'],
            'currency' => ['required', new Enum(CbrCurrency::class)],
            'base_currency' => ['nullable', new Enum(CbrCurrency::class)],
        ];
    }

    /**
     * @return ExchangeRateRequestDto
     */
    public function toDto(): ExchangeRateRequestDto
    {
        return ExchangeRateRequestDto::fromRequest($this);
    }
}
