<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property int $user_id
 * @property string|null $case
 * @property float|null $mileage
 * @property Carbon|null $bought_at
 * @property string|null $picture
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read Collection|ReferenceValue[] $referenceValues
 */
class TempInsurance extends Model
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

    public function referenceValues(): BelongsToMany
    {
        return $this->belongsToMany(ReferenceValue::class, 'reference_value_temp_insurance');
    }
}
