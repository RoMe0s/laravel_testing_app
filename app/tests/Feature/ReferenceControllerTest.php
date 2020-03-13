<?php

namespace Tests\Feature;

use App\Models\ReferenceValue;

class ReferenceControllerTest extends FeatureTestCase
{
    public function test_should_throw_unauthorized_on_index_when_user_is_guest()
    {
        $response = $this->getJson('/api/references');

        $response->assertUnauthorized();
    }

    public function test_should_show_references_list_when_user_is_auth()
    {
        $this->signIn();

        /** @var ReferenceValue $referenceValue */
        $referenceValue = factory(ReferenceValue::class)->create();
        $reference = $referenceValue->reference;

        $response = $this->getJson('/api/references');

        $response->assertOk()->assertJsonFragment([
            'data' => [
                [
                    'id' => $reference->id,
                    'key' => $reference->key,
                    'name' => $reference->name,
                    'values' => [
                        [
                            'id' => $referenceValue->id,
                            'value' => $referenceValue->value,
                        ]
                    ]
                ]
            ]
        ]);
    }

    public function test_should_throw_unauthorized_on_filter_when_user_is_guest()
    {
        $response = $this->postJson('/api/references/filter');

        $response->assertUnauthorized();
    }

    public function test_should_show_filtered_independent_references_list_when_user_is_auth_and_no_data_is_passed()
    {
        $this->signIn();

        /** @var ReferenceValue $mainReferenceValue */
        $mainReferenceValue = factory(ReferenceValue::class)->create();
        $mainReference = $mainReferenceValue->reference;

        /** @var ReferenceValue $dependentReferenceValue */
        $dependentReferenceValue = factory(ReferenceValue::class)->create();
        $dependentReference = $dependentReferenceValue->reference;
        $dependentReference->dependOnValues()->attach($mainReference->id);

        $response = $this->postJson('/api/references/filter', []);

        $response->assertOk()->assertJsonFragment([
            'data' => [
                [
                    'id' => $mainReference->id,
                    'key' => $mainReference->key,
                    'name' => $mainReference->name,
                    'values' => [
                        [
                            'id' => $mainReferenceValue->id,
                            'value' => $mainReferenceValue->value,
                        ]
                    ]
                ]
            ]
        ]);
    }

    public function test_should_show_filtered_independent_references_list_when_user_is_auth_and_data_is_passed()
    {
        $this->signIn();

        /** @var ReferenceValue $mainReferenceValue */
        $mainReferenceValue = factory(ReferenceValue::class)->create();
        $mainReference = $mainReferenceValue->reference;

        /** @var ReferenceValue $dependentReferenceValue */
        $dependentReferenceValue = factory(ReferenceValue::class)->create();
        $dependentReference = $dependentReferenceValue->reference;
        $dependentReference->dependOnValues()->attach($mainReference->id);

        $response = $this->postJson('/api/references/filter', ['reference_values' => [$mainReferenceValue->id]]);

        $response->assertOk()->assertJsonFragment([
            'data' => [
                [
                    'id' => $mainReference->id,
                    'key' => $mainReference->key,
                    'name' => $mainReference->name,
                    'values' => [
                        [
                            'id' => $mainReferenceValue->id,
                            'value' => $mainReferenceValue->value,
                        ]
                    ]
                ],
                [
                    'id' => $dependentReference->id,
                    'key' => $dependentReference->key,
                    'name' => $dependentReference->name,
                    'values' => [
                        [
                            'id' => $dependentReferenceValue->id,
                            'value' => $dependentReferenceValue->value,
                        ]
                    ]
                ],
            ]
        ]);
    }
}
