<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_create_user()
    {
        $userData = [
            'name'     => fake()->name,
            'email'    => fake()->email,
            'password' => fake()->password, 
        ];

        $response = $this->json('POST', '/api/user', $userData);

        $response->assertStatus(Response::HTTP_OK)
                 ->assertJsonStructure([
                    "id",
                    "name",
                    "email",
                    "created_at",
                    "updated_at"
                 ]);

    }

    /** @test */
    public function test_update_user()
    {
        $user = $this->reuseLogin();

        // Dados a serem usados para a atualização
        $updateData = [
            'name'     => fake()->name,
            'email'    => fake()->email,
            'password' => fake()->password,
        ];
        
        // Faça uma solicitação PUT
        $response = $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $user['token'],
        ])->json('PUT', "/api/user/{$user['user']['id']}", $updateData);
        
        $response->assertStatus(Response::HTTP_OK);
        
        $this->assertDatabaseHas('users', [
            'id'    => $user['user']['id'],
            'name'  => $updateData['name'],
            'email' => $updateData['email'],
        ]);
    }

    /** @test */
    public function test_all_user(): void
    {
        $response = $this->get('/api/user');

        $response->assertStatus(Response::HTTP_OK);
    }

    /** @test */
    public function test_find_by_id_user(): void
    {
        $user = $this->reuseLogin();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $user['token'],
        ])->get("/api/user/{$user['user']['id']}");
      
        $response->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure([
            "id",
            "name",
            "email",
            "created_at",
            "updated_at"
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
