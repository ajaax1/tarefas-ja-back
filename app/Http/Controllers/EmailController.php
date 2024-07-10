<?php

namespace App\Http\Controllers;
use App\Mail\EsqueceuSenha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Http\Requests\MudarSenha;
class EmailController extends Controller
{

    public function store($arr)
    {
        Mail::to($arr['email'])->send(new EsqueceuSenha($arr['token'], $arr['email']));
    }

    public function verificarSenhaToken(Request $request){
        $user = User::where('esqueceu_token', $request->token)->first();
        if($user === null) {
            return response()->json('Token inválido', 401);
        }
        return response()->json('Token válido', 200);
    }

    public function mudarSenha(MudarSenha $request){
        if($request->password !== $request->password_confirmation){
            return response()->json(['message' => 'As senhas não são iguais'], 401);
        }
        $user = User::where('esqueceu_token', $request->token)->first();
        $user->password = bcrypt($request->password);
        $user->esqueceu_token = null;
        $user->save();
        $user->esqueceu_token = null;
        return response()->json('Senha alterada com sucesso', 200);
    }
}
