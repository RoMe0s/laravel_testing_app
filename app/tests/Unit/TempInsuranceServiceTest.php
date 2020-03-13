<?php

namespace Tests\Unit;

use App\Services\FileService;
use Illuminate\Http\UploadedFile;
use App\Models\{User, TempInsurance, ReferenceValue};
use App\Services\TempInsurance\{SaveTempInsuranceDTO, TempInsuranceService};

class TempInsuranceServiceTest extends UnitTestCase
{
    public function test_should_create_temp_insurance()
    {
        $user = factory(User::class)->create();
        $referenceValue = factory(ReferenceValue::class)->create();

        $case = time() . ' case';
        $saveTempInsuranceDTO = new SaveTempInsuranceDTO(
            $user->id,
            $case,
            1000,
            (new \DateTime())->format('Y-m-d'),
            [$referenceValue->id]
        );

        /** @var TempInsuranceService $tempInsuranceService */
        $tempInsuranceService = resolve(TempInsuranceService::class);
        $tempInsurance = $tempInsuranceService->save($saveTempInsuranceDTO);

        $this->assertEquals($case, $tempInsurance->case);
        $this->assertEquals(1, $tempInsurance->referenceValues->count());
    }

    public function test_should_update_temp_insurance()
    {
        $user = factory(User::class)->create();
        $preSavedTempInsurance = factory(TempInsurance::class)->create(['user_id' => $user->id]);
        $referenceValue = factory(ReferenceValue::class)->create();

        $case = time() . ' case';
        $saveTempInsuranceDTO = new SaveTempInsuranceDTO(
            $user->id,
            $case,
            1000,
            (new \DateTime())->format('Y-m-d'),
            [$referenceValue->id]
        );

        /** @var TempInsuranceService $tempInsuranceService */
        $tempInsuranceService = resolve(TempInsuranceService::class);
        $tempInsurance = $tempInsuranceService->save($saveTempInsuranceDTO);

        $this->assertEquals($preSavedTempInsurance->id, $tempInsurance->id);
        $this->assertEquals($case, $tempInsurance->case);
        $this->assertEquals(1, $tempInsurance->referenceValues->count());
    }

    public function test_should_update_picture()
    {
        /** @var TempInsurance $preSavedTempInsurance */
        $preSavedTempInsurance = factory(TempInsurance::class)->create();

        $this->assertNull($preSavedTempInsurance->picture);

        $this->instance(
            FileService::class,
            \Mockery::mock(FileService::class, function ($mock) {
                $mock->shouldReceive('saveFile')->once();
            })
        );

        /** @var TempInsuranceService $tempInsuranceService */
        $tempInsuranceService = resolve(TempInsuranceService::class);
        $tempInsurance = $tempInsuranceService->replacePicture(
            $preSavedTempInsurance,
            UploadedFile::fake()->image('image.png')
        );

        $this->assertEquals($preSavedTempInsurance->id, $tempInsurance->id);
        $this->assertNotNull($tempInsurance->picture);
    }

    public function test_should_replace_picture()
    {
        /** @var TempInsurance $preSavedTempInsurance */
        $preSavedTempInsurance = factory(TempInsurance::class)->create([
            'picture' => 'picture file path'
        ]);

        $this->assertNotNull($preSavedTempInsurance->picture);

        $this->instance(
            FileService::class,
            \Mockery::mock(FileService::class, function ($mock) {
                $mock->shouldReceive('deleteFile')->once()->with('picture file path');

                $mock->shouldReceive('saveFile')->once();
            })
        );

        /** @var TempInsuranceService $tempInsuranceService */
        $tempInsuranceService = resolve(TempInsuranceService::class);
        $tempInsurance = $tempInsuranceService->replacePicture(
            $preSavedTempInsurance,
            UploadedFile::fake()->image('image.png')
        );

        $this->assertEquals($preSavedTempInsurance->id, $tempInsurance->id);
        $this->assertNotNull($tempInsurance->picture);
    }
}
