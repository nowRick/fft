<?php

declare(strict_types=1);

namespace App\Modules\ExchangeRate\Http\Resources;

use App\Modules\ExchangeRate\DTOs\ExchangeRateDto;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;
use Illuminate\Http\Request;

class ExchangeRateResource extends JsonResource
{
    #[
        OA\Response(
            response: 'ExchangeRateResource',
            description: 'Успешность выполнения запроса',
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(
                        property: 'data',
                        description: 'Данные',
                        properties: [
                            new OA\Property(
                                property: 'exchange_rate',
                                description: 'Значение курса',
                                type: 'string',
                                example: '95.35246816142513',
                            ),
                            new OA\Property(
                                property: 'difference',
                                description: 'Разница с предыдущим торговым днем',
                                type: 'string',
                                example: '0.00425281752521',
                            ),
                        ],
                        type: 'object',
                    ),
                ],
                type: 'object',
            ),
        ),
    ]
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
