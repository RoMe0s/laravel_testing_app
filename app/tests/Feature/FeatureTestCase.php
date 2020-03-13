<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Tests\TestCase;

class FeatureTestCase extends TestCase
{
    use RefreshDatabase;

    public function signIn(): User
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);
        return $user;
    }
}
