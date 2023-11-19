<?php

namespace App\Services;

use App\Exceptions\ExceptionRequest;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BaseService{
  protected ?Model $model; 

  public function index(): Collection{
    return $this->model::where('user_id', auth()->id())->get();
  }

  public function store(): Model{
    $dataValidate = $this->validate();
    $dataValidate['user_id'] = auth()->id() ?? 0;
    return $this->model::create($dataValidate);
  }
  
  public function show(int $id): Model{
    $this->validate();
    return $this->model::findOrFail($id);
  }

  public function update(int $id): Model{
    $model = $this->show($id);
    $model->update($this->validate());
    return $model->refresh();
  }

  public function destroy(int $id): bool{
    $this->validate();
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
    $requestClass->authorize($this->model);
    $validate = Validator::make(request()->all(),$requestClass->rules($currentId),$requestClass->messages());
    if($validate->fails()){
      throw new ExceptionRequest($validate->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
    }
    return $validate->validate();
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