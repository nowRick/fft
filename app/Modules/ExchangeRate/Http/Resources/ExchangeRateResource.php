<?php

declare(strict_types=1);

namespace App\Modules\ExchangeRate\Http\Resources;

use App\Modules\ExchangeRate\DTOs\ExchangeRateDto;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class ExchangeRateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var ExchangeRateDto $this */
        return [
            'exchange_rate' => $this->exchangeRate,
            'difference' => $this->difference,
        ];
    }
}
