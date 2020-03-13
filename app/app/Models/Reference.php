<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property string $key
 * @property string $name
 * @property-read Collection|ReferenceValue[] $values
 * @property-read Collection|ReferenceValue[] $dependOnValues
 */
class Reference extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'key',
        'name',
    ];

    protected $casts = [
        'id' => 'int',
    ];

    public function values(): HasMany
    {
        return $this->hasMany(ReferenceValue::class);
    }

    public function dependOnValues(): BelongsToMany
    {
        return $this->belongsToMany(ReferenceValue::class, 'reference_reference_value');
    }
}
