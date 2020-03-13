<?php

namespace Tests\Unit;

use App\Events\InsuranceCreatedEvent;
use App\Models\{User, ReferenceValue};
use App\Services\Insurance\{StoreInsuranceDTO, InsuranceService};
use Illuminate\Support\Facades\Event;

class InsuranceServiceTest extends UnitTestCase
{
    public function test_should_create_insurance_and_fire_an_event()
    {
        $user = factory(User::class)->create();
        $referenceValue = factory(ReferenceValue::class)->create();

        $case = time() . ' case';
        $storeInsuranceDTO = new StoreInsuranceDTO(
            $user->id,
            $case,
            1000,
            (new \DateTime())->format('Y-m-d'),
            null,
            [$referenceValue->id]
        );

        Event::fake();

        $insuranceService = new InsuranceService();
        $insurance = $insuranceService->store($storeInsuranceDTO);

        Event::assertDispatched(InsuranceCreatedEvent::class, function (InsuranceCreatedEvent $event) use ($insurance) {
            return $event->getInsurance()->id === $insurance->id;
        });

        $this->assertEquals($case, $insurance->case);
        $this->assertEquals(1, $insurance->referenceValues->count());
    }
}
