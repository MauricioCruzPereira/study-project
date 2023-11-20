<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class LoginErrorControllerTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function test_login_error_email_user(): void
    {
        $response =  $this->json('POST', '/api/login', [
            'email'       => 'emailError@gmail.com',
            'password'    => 'password',
            'device_name' => 'testeError'
        ]);

        $response->assertStatus(Response::HTTP_NOT_FOUND)
        ->assertExactJson([
            "message" => "E-mail não encontrado",
         ]);
    }

    /** @test */
    public function test_login_error_password_user(): void
    {
        // Crie um usuário no banco de dados
        $user = User::factory()->create();

        $response =  $this->json('POST', '/api/login', [
            'email'       => $user->email,
            'password'    => 'passwordError',
            'device_name' => 'testeError'
        ]);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED)
        ->assertExactJson([
            "message" => "Senha inválida",
         ]);
    }

    /** @test */
    public function test_logout_error_token_user() : void{
        
        $response = $this->withHeaders([
            'Authorization' => 'Bearer 5|yBgnJ5Ssu02me7cVDfFEg0eT2UhVvo9UMVpsUdXe3cb6b9c7',
        ])->json('POST', 'api/logout');
        
        $response->assertStatus(Response::HTTP_UNAUTHORIZED)
        ->assertExactJson(['message' => 'Unauthenticated.']);
    }

    /** @test */
    public function test_me_error_token_user() : void{
        
        $response = $this->withHeaders([
            'Authorization' => 'Bearer 5|yBgnJ5Ssu02me7cVDfFEg0eT2UhVvo9UMVpsUdXe3cb6b9c7',
        ])->json('GET', 'api/me');

        $response->assertStatus(Response::HTTP_UNAUTHORIZED)
        ->assertExactJson(['message' => 'Unauthenticated.']);
    }

}
