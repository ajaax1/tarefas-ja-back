<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Http\Requests\CategoriaRequest;

class CategoriaController extends Controller
{
    private $categoria;
    public function __construct(Categoria $categoria) {
        $this->categoria = $categoria;
    }
    public function index()
    {
        $categoria = $this->categoria->all();
        if($categoria == null) {
            return response()->json(['message' => 'Nenhuma categoria encontrada'], 404);
        }
        return response()->json($categoria);
    }

    public function store(StorecategoriaRequest $request)
    {
        $categoria = $this->categoria->create($request->validated());
        return response()->json($categoria, 201);
    }

    public function show($id)
    {
        $categoria = $this->categoria->find($id);
        if($categoria == null) {
            return response()->json(['message' => 'Categoria não encontrada'], 404);
        }
        return response()->json($categoria);
    }

    public function update(UpdatecategoriaRequest $request, $id)
    {
        $categoria = $this->categoria->find($id);
        if($categoria == null) {
            return response()->json(['message' => 'Categoria não encontrada'], 404);
        }
        $categoria->update($request->validated());
        return response()->json($categoria);
    }

    public function destroy($id)
    {
        $categoria = $this->categoria->find($id);
        $categoria->delete();
        return response()->json(['message' => 'Categoria removida com sucesso']);
    }
}
