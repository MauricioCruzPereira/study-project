<?php

namespace App\Services\User;

use App\Services\BaseService;
use Illuminate\Database\Eloquent\Collection;

class UserService extends BaseService{
  public function index(): Collection{
    return $this->model::get();
  }
}