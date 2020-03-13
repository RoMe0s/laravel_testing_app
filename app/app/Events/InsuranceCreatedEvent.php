<?php

namespace App\Events;

use App\Models\Insurance;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class InsuranceCreatedEvent
{
    use Dispatchable, SerializesModels;

    private Insurance $insurance;

    public function __construct(Insurance $insurance)
    {
        $this->insurance = $insurance;
    }

    public function getInsurance(): Insurance
    {
        return $this->insurance;
    }
}
