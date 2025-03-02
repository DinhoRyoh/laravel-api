<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase; 
use App\Models\User;
use App\Models\Profil;

class CommentaireTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh');
    }

    public function test_user_can_create_comment_on_profil_only_once()
    {
        $user = User::factory()->create();
        $profil = Profil::factory()->create([
            'lastname' => 'Doe',
            'firstname' => 'John',
            'status' => 'en attente',
            'user_id' => $user->id
        ]);

        $data = [
            'content' => 'lorem ipsum'
        ];

        $response = $this->actingAs($user)->postJson("/api/profils/{$profil->id}/commentaires/create", $data);

        $response->assertStatus(201); 
        $this->assertDatabaseHas('commentaires', $data); 

        // encore une fois
        $response = $this->actingAs($user)->postJson("/api/profils/{$profil->id}/commentaires/create", $data);
        $response->assertStatus(422); 
    }
}
