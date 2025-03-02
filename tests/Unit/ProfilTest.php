<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Profil;
use Tests\TestCase; 

class ProfilTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh');
    }

    public function test_user_can_create_profil()
    {
        $user = User::factory()->create();
        $data = [
            'firstname' => 'John',
            'lastname' => 'Doe',
            'status' => 'actif'
        ];

        $response = $this->actingAs($user)->postJson('/api/profils/create', $data);

        $response->assertStatus(201); 
        $this->assertDatabaseHas('profils', $data); 
    }

    public function test_user_can_update_profil()
    {
        $user = User::factory()->create();
        $profil = Profil::factory()->create([
            'lastname' => 'Doe',
            'firstname' => 'John',
            'status' => 'en attente',
            'user_id' => $user->id
        ]);

        $response = $this->actingAs($user)->postJson("/api/profils/{$profil->id}/update", [
            'lastname' => 'Deo',
            'firstname' => 'Joe',
            'status' => 'actif'
        ]);

        $this->assertDatabaseHas('profils', [
            'id' => $profil->id,
            'lastname' => 'Deo',
            'firstname' => 'Joe',
            'status' => 'actif'
        ]);
    }

    public function test_user_can_delete_profil()
    {
        $user = User::factory()->create();
        $profil = Profil::factory()->create(['user_id' => $user->id]);
        $profil_id = $profil->id;
        $response = $this->actingAs($user)->deleteJson("/api/profils/{$profil->id}/delete");

        $response->assertStatus(201);

        $this->assertTrue(!Profil::whereId($profil_id)->exists());
    }
}
