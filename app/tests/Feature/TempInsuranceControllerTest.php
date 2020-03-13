<?php

namespace Tests\Feature;

use App\Models\TempInsurance;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class TempInsuranceControllerTest extends FeatureTestCase
{
    public function test_should_throw_unauthorized_on_index_when_user_is_guest()
    {
        $response = $this->getJson('/api/temp-insurances');

        $response->assertUnauthorized();
    }

    public function test_should_throw_not_found_on_index_when_user_is_auth_and_does_not_have_a_temp_insurance()
    {
        $this->signIn();

        $response = $this->getJson('/api/temp-insurances');

        $response->assertNotFound();
    }

    public function test_should_return_temp_insurance_when_user_is_auth_and_does_has_a_temp_insurance()
    {
        $user = $this->signIn();
        /** @var TempInsurance $tempInsurance */
        $tempInsurance = factory(TempInsurance::class)->create(['user_id' => $user->id]);

        $response = $this->getJson('/api/temp-insurances');

        $response->assertJsonFragment([
            'case' => $tempInsurance->case,
            'mileage' => $tempInsurance->mileage,
            'bought_at' => $tempInsurance->bought_at->toDateString(),
            'picture' => null,
            'reference_values' => [],
        ]);
    }

    public function test_should_throw_unauthorized_on_store_when_user_is_guest()
    {
        $response = $this->postJson('/api/temp-insurances');

        $response->assertUnauthorized();
    }

    public function test_should_create_empty_temp_insurance_when_user_is_auth_and_no_data()
    {
        $this->signIn();

        $response = $this->postJson('/api/temp-insurances');

        $response->assertJsonFragment([
            'case' => null,
            'mileage' => null,
            'bought_at' => null,
            'picture' => null,
            'reference_values' => [],
        ]);
    }

    public function test_should_create_temp_insurance_with_the_passed_data_when_user_is_auth_and_data_is_passed()
    {
        $this->signIn();

        $response = $this->postJson('/api/temp-insurances', [
            'case' => 'test case',
        ]);

        $response->assertJsonFragment([
            'case' => 'test case',
            'mileage' => null,
            'bought_at' => null,
            'picture' => null,
            'reference_values' => [],
        ]);
    }

    public function test_should_update_temp_insurance_when_user_is_auth_and_data_is_passed()
    {
        $user = $this->signIn();
        /** @var TempInsurance $tempInsurance */
        $tempInsurance = factory(TempInsurance::class)->create([
            'user_id' => $user->id,
            'case' => 'test case 1',
            'mileage' => null,
        ]);

        $response = $this->postJson('/api/temp-insurances', [
            'case' => $tempInsurance->case,
            'mileage' => 777,
        ]);

        $response->assertJsonFragment([
            'case' => $tempInsurance->case,
            'mileage' => 777,
            'bought_at' => null,
            'picture' => null,
            'reference_values' => [],
        ]);
    }

    public function test_should_throw_unauthorized_on_update_picture_when_user_is_guest()
    {
        $response = $this->postJson('/api/temp-insurances/update-picture');

        $response->assertUnauthorized();
    }

    public function test_should_throw_validation_error_on_update_picture_when_user_is_auth_and_no_picture()
    {
        $this->signIn();

        $response = $this->postJson('/api/temp-insurances/update-picture');

        $response->assertJsonValidationErrors(['picture']);
    }

    public function test_should_throw_not_found_on_update_picture_when_user_is_auth_and_does_not_have_a_temp_insurance()
    {
        $this->signIn();

        Storage::fake();

        $response = $this->postJson('/api/temp-insurances/update-picture', [
            'picture' => UploadedFile::fake()->image('image.png'),
        ]);

        $response->assertNotFound();
    }

    public function test_should_update_picture_when_user_is_auth_and_does_not_have_a_temp_insurance()
    {
        $user = $this->signIn();
        /** @var TempInsurance $tempInsurance */
        $tempInsurance = factory(TempInsurance::class)->create(['user_id' => $user->id]);

        $this->assertNull($tempInsurance->picture);

        Storage::fake();

        $response = $this->postJson('/api/temp-insurances/update-picture', [
            'picture' => UploadedFile::fake()->image('image.png'),
        ]);

        $response->assertJsonFragment([
            'case' => $tempInsurance->case,
            'mileage' => $tempInsurance->mileage,
            'bought_at' => $tempInsurance->bought_at->toDateString(),
            'picture' => url('pictures/image.png'),
            'reference_values' => [],
        ]);
    }
}
