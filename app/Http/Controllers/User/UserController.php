<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\BaseController;
use App\Services\User\UserService;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends BaseController
{
  public function __construct($service = null) {
    $this->service = (new UserService())
    ->setModel(User::class);
  }
}
