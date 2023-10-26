<?php

namespace App\Services;

use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BaseService{
  protected ?Model $model; 

  public function index(): Collection{
    return $this->model::get();
  }

  public function store(): Model{
    return $this->model::create($this->validate());
  }
  
  public function show($id): Model{
    return $this->model::findOrFail($id);
  }

  public function update($id): Model{
    $model = $this->show($id);
    $model->update($this->validate());
    return $model->refresh();
  }

  public function destroy($id): bool{
    $model = $this->show($id);
    return $model->delete();
  }

  /**
   * Método reponsável por inicializar o model
   * @var Model | string $model
   * @return self
   */
  public function setModel(Model | string $model) : self{
    $this->model = $model instanceof Model ? $model : new $model();
    return $this;
  }

  public function validate(object | string $requestClass = null, int $currentId = null) : array{
    if(!$requestClass){
      //Define a classe de form validator que será utilizada no momento da requisição
      $requestClass = $this->defineClassByRequest();
    }

    if(!$currentId){
      $currentId = request()->isMethod('put') ? request()->route()->id : null;
    }
    
    //Incializa a classe de form validator
    $requestClass = is_object($requestClass) ? $requestClass : new $requestClass();

    return Validator::validate(request()->all(),$requestClass->rules($currentId),$requestClass->messages());
  }

  private function defineClassByRequest() : string{
    $action = Request()->route()->getActionMethod();

    $requestPrefixes = ["App", "Http","Requests"];

    foreach(explode("\\",static::class) as $prefix){
      if($prefix !== "App" && $prefix !== "Services" && $prefix != class_basename(static::class)){
        //Armazena o caminho para pegar o form request
        $requestPrefixes[] = $prefix;
      }
    }
    //$requestPrefixes [] = Str::replace("Service", "",class_basename(static::class));
    $requestPrefixes [] = Str::ucfirst(Str::camel($action))."Request";

    //Monta completo a class de form request.
    $class = implode("\\", $requestPrefixes);
    if(!class_exists($class)){
      throw new Exception("The class {$class} does not exists.");
    }

    return $class;

  }

}