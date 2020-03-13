<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $reference_id
 * @property string $value
 * @property-read Reference $reference
 */
class ReferenceValue extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'reference_id',
        'value',
    ];

    protected $casts = [
        'id' => 'int',
        'reference_id' => 'int',
        'value' => 'string',
    ];

    public function reference(): BelongsTo
    {
        return $this->belongsTo(Reference::class);
    }
}
