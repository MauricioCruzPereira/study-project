<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function test_login_user(): void
    {
        // Faz o login
        $response = $this->reuseLogin();

        $response->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure([
            "user",
            "token",
         ]);
    }

    /** @test */
    public function test_logout_user() : void{
        $user = $this->reuseLogin();
        
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $user['token'],
        ])->json('POST', 'api/logout');

        $response->assertStatus(Response::HTTP_OK)
        ->assertExactJson(['message' => 'sucesso']);
    }

    /** @test */
    public function test_me_user() : void{
        $user = $this->reuseLogin();
        
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $user['token'],
        ])->json('GET', 'api/me');

        $response->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure([
            "user"
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
