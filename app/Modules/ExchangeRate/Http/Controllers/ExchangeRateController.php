<?php

declare(strict_types=1);

namespace App\Modules\ExchangeRate\Http\Controllers;

use App\Modules\ExchangeRate\Contracts\Services\CalculateExchangeRateServiceContract;
use App\Modules\ExchangeRate\Http\Resources\ExchangeRateResource;
use App\Modules\ExchangeRate\Http\Requests\ExchangeRateRequest;
use App\Http\Controllers\Controller;

class ExchangeRateController extends Controller
{
    public function __construct(
        private readonly CalculateExchangeRateServiceContract $calculateExchangeRateService,
    ) {}

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
