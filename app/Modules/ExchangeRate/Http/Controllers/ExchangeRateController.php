<?php

declare(strict_types=1);

namespace App\Modules\ExchangeRate\Http\Controllers;

use App\Modules\ExchangeRate\Contracts\Services\CalculateExchangeRateServiceContract;
use App\Modules\ExchangeRate\Http\Resources\ExchangeRateResource;
use App\Modules\ExchangeRate\Http\Requests\ExchangeRateRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;
use OpenApi\Attributes as OA;

class ExchangeRateController extends Controller
{
    public function __construct(
        private readonly CalculateExchangeRateServiceContract $calculateExchangeRateService,
    ) {}

    #[
        OA\Get(
            path: '/api/exchange-rate',
            description: 'Получение курсов, кроскурсов.',
            tags: ['ExchangeRate'],
            parameters: [
                new OA\Parameter(ref: '#/components/parameters/date'),
                new OA\Parameter(ref: '#/components/parameters/currency'),
                new OA\Parameter(ref: '#/components/parameters/base_currency'),
            ],
        ),
        OA\Response(
            ref: '#/components/responses/ExchangeRateResource',
            response: Response::HTTP_OK,
        ),
    ]
    /**
     * @param ExchangeRateRequest $request
     *
     * @return ExchangeRateResource
     */
    public function show(ExchangeRateRequest $request): ExchangeRateResource
    {
        return new ExchangeRateResource(
            $this->calculateExchangeRateService->calculate($request->toDto())
        );
    }
}
