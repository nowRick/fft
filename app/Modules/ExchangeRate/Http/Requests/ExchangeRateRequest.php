<?php

declare(strict_types=1);

namespace App\Modules\ExchangeRate\Http\Requests;

use App\Modules\ExchangeRate\DTOs\ExchangeRateRequestDto;
use App\Modules\ExchangeRate\Enums\CbrCurrency;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class ExchangeRateRequest extends FormRequest
{
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
