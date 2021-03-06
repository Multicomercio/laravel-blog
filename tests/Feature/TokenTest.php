<?php

namespace Tests\Feature;

use Tests\TestCase;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Hash;

class TokenTest extends TestCase
{
    use DatabaseMigrations;

    public function testStore()
    {
        $user = $this->user(['api_token' => null]);

        $response = $this->actingAs($user)->post("/tokens/{$user->id}", []);

        $user->refresh();

        $response->assertStatus(302);
        $response->assertRedirect("/users/{$user->id}/edit");
        $this->assertNotNull($user->api_token);
    }

    public function testDestroy()
    {
        $user = $this->user();

        $response = $this->actingAs($user)->delete("/tokens/{$user->id}", []);

        $user->refresh();

        $response->assertStatus(302);
        $response->assertRedirect("/users/{$user->id}/edit");
        $this->assertNull($user->api_token);
    }
}
