<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\{HasOne, HasMany};
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read TempInsurance|null $tempInsurance
 * @property-read Collection $insurances
 */
class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $dates = [
        'email_verified_at',
    ];

    protected $casts = [
        'id' => 'int',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function tempInsurance(): HasOne
    {
        return $this->hasOne(TempInsurance::class);
    }

    public function insurances(): HasMany
    {
        return $this->hasMany(Insurance::class);
    }
}
