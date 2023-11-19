<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class UserErrorControllerTest extends TestCase
{
    use RefreshDatabase;

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
        $userCreate = User::factory()->create();
        $user = $this->reuseLogin();
  
        // Dados a serem usados para a atualização
        $updateData = [
            'name'     => fake()->name,
            'email'    => $userCreate->email,
            'password' => fake()->password,
        ];
        
        $response = $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $user['token'],
        ])->json('PUT', "/api/user/{$user['user']['id']}", $updateData);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
                 ->assertJsonStructure([
                    "message",
                 ]);
    }

    /** @test */
    public function test_find_by_id_error_user(): void
    {
        $user = $this->reuseLogin();
        
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $user['token'],
        ])->get("/api/user/99");
        
        $response->assertStatus(Response::HTTP_NOT_FOUND)
        ->assertJsonStructure([
            "message"
         ]);
    }

    /**
     * Reutilização do login
     */
    public function reuseLogin() : object{
        // Crie um usuário no banco de dados
        $user = User::factory()->create();

        // Seta o device
        $user->device_name = 'testeControllerLogin';

        // Faz o login
        return  $this->json('POST', '/api/login', [
            'email' => $user->email,
            'password' => 'password',
            'device_name' => $user->device_name
        ]);
    }
}
