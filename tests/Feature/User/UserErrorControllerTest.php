<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use Tests\TestCase;

class UserErrorControllerTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function test_create_error_user()
    {
        // Crie um usuário no banco de dados
        $user =User::factory()->create();
        $userData = [
            "name" => $user->name,
            "email" => $user->email,
            "password" => 'password',
        ];
        
        $response = $this->json('POST', '/api/user', $userData);
        
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
                 ->assertJsonStructure([
                    "message",
                 ]);

    }

    /** @test */
    public function test_update_error_user()
    {
        // Crie um usuário no banco de dados
        $user = User::factory()->count(2)->create();
  
        // Dados a serem usados para a atualização
        $updateData = [
            'name'     => fake()->name,
            'email'    => $user[1]->email,
            'password' => fake()->password,
        ];

        // Faça uma solicitação PUT
        $response = $this->json('PUT', "/api/user/{$user[0]->id}", $updateData);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
                 ->assertJsonStructure([
                    "message",
                 ]);
    }

    /** @test */
    public function test_find_by_id_error_user(): void
    {
        $response = $this->get("/api/user/99");
        $response->assertStatus(Response::HTTP_NOT_FOUND)
        ->assertJsonStructure([
            "message"
         ]);
    }
}
