<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Modules\ExchangeRate\Enums\CbrCurrency;
use Illuminate\Database\Eloquent\Model;
use Carbon\CarbonInterface;

/**
 * @property int $id
 * @property string $identifier
 * @property string $num_code
 * @property CbrCurrency $char_code
 * @property string $nominal
 * @property string $name
 * @property string $value
 * @property CarbonInterface $date
 * @property CarbonInterface $created_at
 * @property CarbonInterface $updated_at
 */
class CbrExchangeRate extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'identifier',
        'num_code',
        'char_code',
        'nominal',
        'name',
        'value',
        'date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'char_code' => CbrCurrency::class,
        'value' => 'decimal:14',
        'date' => 'date',
    ];
}
