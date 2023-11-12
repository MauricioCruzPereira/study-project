<?php

namespace App\Services\Login;

use App\Exceptions\ExceptionNotFoundEmail;
use App\Exceptions\ExceptionPasswordDifferent;
use App\Models\User;
use App\Services\BaseService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginService extends BaseService{

  public function login() : array{
    $user = User::where('email',$this->validate()['email'])->first();

    //validações personalizadas
    if(!$user){
      throw new ExceptionNotFoundEmail('E-mail não encontrado', Response::HTTP_NOT_FOUND);
    }
    if(!Hash::check($this->validate()['password'], $user->password)){
      throw new ExceptionPasswordDifferent('Senha inválida',Response::HTTP_UNAUTHORIZED);
    }

    $user->tokens()->delete();
    
    $token = $user->createToken($this->validate()['device_name'])->plainTextToken;
    
    //Desloga a conta em todos os dispositivos conectados
    return [
      'user' => $user,
      'token' =>$token,
    ];
  }

  public function logout() : array{
      $user = Request()->user();

      // Revogue o token atual do usuário
      if ($user) {
          $user->tokens()->delete();
      }

      return ['message' => 'sucesso'];
  }

  public function me() : array{
    $user = Request()->user();

    return [
      'user' => $user,
    ];
  }

}