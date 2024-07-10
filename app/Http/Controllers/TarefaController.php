<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Tarefa;
use App\Http\Requests\TarefaRequest;

class TarefaController extends Controller
{
    private $tarefa;

    public function __construct(Tarefa $tarefa) {
        $this->tarefa = $tarefa;
    }

    public function index()
    {
        $tarefas = $this->tarefa->where('completo','PENDENTE')->get();
        
        if($tarefas == null) {
            return response()->json(['message' => 'Nenhuma tarefa encontrada'], 404);
        }
        return response()->json($tarefas);
    }

    public function store(TarefaRequest $request)
    {
        $tarefa = $this->tarefa->create($request->all());
        if($tarefa == null) {
            return response()->json(['message' => 'Nenhuma tarefa encontrada'], 404);
        }
        return response()->json($tarefa);
    }

    public function show($id)
    {
        $tarefa = $this->tarefa->find($id);
        if($tarefa == null) {
            return response()->json(['message' => 'Nenhuma tarefa encontrada'], 404);
        }
        return response()->json($tarefa);
    }

    public function update(TarefaRequest $request, $id)
    {
        $tarefa = $this->tarefa->find($id);
        if($tarefa == null) {
            return response()->json(['message' => 'Nenhuma tarefa encontrada'], 404);
        }
        $this->tarefa->update($request->all());
        return response()->json($tarefa); 
    }

    public function destroy($id)
    {
        $tarefa = $this->tarefa->find($id);
        if($tarefa == null) {
            return response()->json(['message' => 'Nenhuma tarefa encontrada'], 404);
        }
        $tarefa->delete();
        return response()->json(['message' => 'Tarefa deletada com sucesso']);
    }

    public function pesquisasPendentes($valor,$id){
        $tarefas = $this->tarefa->where('user_id',$id)->where('objetivo', 'like', '%'.$valor.'%')->where('completo','PENDENTE')->get();
        foreach ($tarefas as $tarefa) {
            $tarefa['data_criacao'] = $tarefa['created_at']->format('d/m/Y');
            $tarefa['horario_criacao'] = $tarefa['created_at']->format('H:i:s');
        }
        if($tarefas == null) {
            return response()->json(['message' => 'Nenhuma tarefa encontrada'], 404);
        }
        return response()->json($tarefas);
    }

    public function pesquisasConcluida($valor,$id){
        $tarefas = $this->tarefa->where('user_id',$id)->where('objetivo', 'like', '%'.$valor.'%')->where('completo','SIM')->get();
        foreach ($tarefas as $tarefa) {
            $tarefa['data_criacao'] = $tarefa['created_at']->format('d/m/Y');
            $tarefa['horario_criacao'] = $tarefa['created_at']->format('H:i:s');
        }
        if($tarefas == null) {
            return response()->json(['message' => 'Nenhuma tarefa encontrada'], 404);
        }
        return response()->json($tarefas);
    }
    
    
    public function concluir(Request $request, $id){
        $request->validate([
            'completo' => 'required|in:SIM'
        ]);
        $tarefa = $this->tarefa->find($id);
        if($tarefa == null) {
            return response()->json(['message' => 'Nenhuma tarefa encontrada'], 404);
        }
        $tarefa->completo = 'SIM';
        $tarefa->save();
        return response()->json($tarefa);
    }

    public function tarefasPorUsuario($id){
        $tarefas = $this->tarefa->where('user_id', $id)->where('completo','PENDENTE')->get();
        foreach ($tarefas as $tarefa) {
            $tarefa['data_criacao'] = $tarefa['created_at']->format('d/m/Y');
            $tarefa['horario_criacao'] = $tarefa['created_at']->format('H:i:s');
        }
        if($tarefas == null) {
            return response()->json(['message' => 'Nenhuma tarefa encontrada'], 404);
        }
        return response()->json($tarefas);
    }

    public function tarefasRealizadasPorUsuario($id){
        $tarefas = $this->tarefa->where('user_id', $id)->where('completo', 'SIM')->get();
        foreach ($tarefas as $tarefa) {
            $tarefa['data_criacao'] = $tarefa['created_at']->format('d/m/Y');
            $tarefa['horario_criacao'] = $tarefa['created_at']->format('H:i:s');
        }
        if($tarefas == null) {
            return response()->json(['message' => 'Nenhuma tarefa encontrada'], 404);
        }
        return response()->json($tarefas);
    }

    public function realizarTarefas(Request $request)
    {
        $tarefas = $request->input('tarefas'); 
        if (empty($tarefas)) {
            return response()->json(['message' => 'Nenhuma tarefa recebida'], 400);
        }
        foreach ($tarefas as $tarefaData) {
            $tarefa = $this->tarefa->find($tarefaData['id']);
            if ($tarefa == null) {
                return response()->json(['message' => 'Nenhuma tarefa encontrada com o ID ' . $tarefaData['id']], 404);
            }
            $tarefa->completo = 'SIM';
            $tarefa->save();
        }
        return response()->json(['message' => 'Tarefas atualizadas com sucesso']);
    }

    public function deletarTarefas(Request $request){
        $tarefas = $request->input('tarefas'); 
        if (empty($tarefas)) {
            return response()->json(['message' => 'Nenhuma tarefa recebida'], 400);
        }        
        foreach ($tarefas as $tarefaData) {
            $tarefa = $this->tarefa->find($tarefaData['id']);
            if($tarefa == null) {
                return response()->json(['message' => 'Nenhuma tarefa encontrada'], 404);
            }
            $tarefa->delete();
        }
        return response()->json(['message' => 'Tarefas deletadas com sucesso']);
    }
}
