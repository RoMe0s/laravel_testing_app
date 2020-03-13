<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, BelongsToMany};
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property int $user_id
 * @property string $case
 * @property float $mileage
 * @property Carbon $bought_at
 * @property string|null $picture
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read User $user
 * @property-read Collection|ReferenceValue[] $referenceValues
 */
class Insurance extends Model
{
    protected $fillable = [
        'user_id',
        'case',
        'mileage',
        'bought_at',
        'picture',
    ];

    protected $dates = [
        'bought_at',
    ];

    protected $casts = [
        'id' => 'int',
        'user_id' => 'int',
        'mileage' => 'float',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function referenceValues(): BelongsToMany
    {
        return $this->belongsToMany(ReferenceValue::class, 'insurance_reference_value');
    }
}
