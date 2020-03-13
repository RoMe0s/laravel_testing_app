<?php

namespace App\Listeners;

use App\Events\InsuranceCreatedEvent;

class DeleteTempInsuranceListener
{
    public function handle(InsuranceCreatedEvent $event)
    {
        $event->getInsurance()->user->tempInsurance()->delete();
    }
}
