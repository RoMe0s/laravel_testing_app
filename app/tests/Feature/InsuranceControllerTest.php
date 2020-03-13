<?php

namespace Tests\Feature;

class InsuranceControllerTest extends FeatureTestCase
{
    public function test_should_throw_unauthorized_on_store_when_user_is_guest()
    {
        $response = $this->postJson('/api/insurances');

        $response->assertUnauthorized();
    }

    public function test_should_throw_validation_error_on_store_when_user_is_auth_and_data_is_wrong()
    {
        $this->signIn();

        $response = $this->postJson('/api/insurances');

        $response->assertJsonValidationErrors(['case', 'mileage', 'bought_at']);
    }

    public function test_should_store_when_user_is_auth_and_data_is_correct()
    {
        $this->signIn();

        $response = $this->postJson('/api/insurances', [
            'case' => 'test case',
            'mileage' => 1000,
            'bought_at' => (new \DateTime())->format('Y-m-d'),
        ]);

        $response->assertOk();
    }
}
