<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BaseController extends Controller{
    /**
     * Service a ser manipulado
     *
     * @var Service
     */
    protected $service;


    /**
     * Display a listing of the resource.
     */
    public function index() : JsonResponse{
        return response()->json($this->service->index());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store() : JsonResponse{
        return response()->json($this->service->store());
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id) : JsonResponse{
        return response()->json($this->service->show($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(int $id) : JsonResponse{
        return response()->json($this->service->update($id));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id) : JsonResponse{
        if(!$this->service->destroy($id)){
            return response()->json([
                "message"=> "Não foi possível deletar o registro {$id}!"
            ]);
        }
        return response()->json([
            "message" => "Registro deletado com sucesso."
        ]);
    }
}
