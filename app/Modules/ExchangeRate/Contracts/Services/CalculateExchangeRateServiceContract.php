<?php

declare(strict_types=1);

namespace App\Modules\ExchangeRate\Contracts\Services;

use App\Modules\ExchangeRate\DTOs\ExchangeRateRequestDto;
use App\Modules\ExchangeRate\DTOs\ExchangeRateDto;

interface CalculateExchangeRateServiceContract
{
    public function calculate(ExchangeRateRequestDto $dto): ExchangeRateDto;
}
