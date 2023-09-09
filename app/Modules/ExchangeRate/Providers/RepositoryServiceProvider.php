<?php

declare(strict_types=1);

namespace App\Modules\ExchangeRate\Providers;

use App\Modules\ExchangeRate\Contracts\Repositories\CbrRepositoryContract;
use App\Modules\ExchangeRate\Repositories\CbrRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public array $bindings = [
        CbrRepositoryContract::class => CbrRepository::class,
    ];
}
