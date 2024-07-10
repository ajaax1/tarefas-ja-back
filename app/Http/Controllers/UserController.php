<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\EmailController;
use Nette\Utils\Random;

class UserController extends Controller
{
    private $user;
    private $emailController;

    public function __construct(User $user, EmailController $emailController) {
        $this->user = $user;
        $this->emailController = $emailController;
    }

    public function index()
    {
        return $this->user->all();
    }

    public function store(UserRequest $request)
    {
        $user = $this->user->create($request->all());
        return response()->json($user, 201);
    }

    public function show(int $id)
    {
        $user = $this->user->find($id);
        if ($user === null) {
            return response()->json(['erro' => 'Recurso pesquisado não existe'], 404);
        }
        return response()->json($user);
    }

    public function update(UserRequest $request, string $id)
    {
        $user = $this->user->find($id);
        if ($user === null) {
            return response()->json(['erro' => 'Impossível realizar a atualização. O recurso solicitado não existe'], 404);
        }
        $user->update($request->all());
        return response()->json($user, 200);
    }

    public function destroy(string $id)
    {
        $user = $this->user->find($id);
        if ($user === null) {
            return response()->json(['erro' => 'Impossível realizar a exclusão. O recurso solicitado não existe'], 404);
        }
        $user->delete();
        return response()->json(['msg' => 'O usuário foi removido com sucesso!'], 200);
    }

    public function verificarEmail(Request $request){
        $email = $request->email;
        $user = $this->user->where('email', $email)->first();
        if($user === null) {
            return response()->json('evento disparado', 200);
        }
        $token = Random::generate(200);
        $user->update(['esqueceu_token' => $token]);
        $arr = [
            'email' => $user->email,
            'token' => $token
        ];
        $this->emailController->store($arr);
        return response()->json('evento disparado', 200);
    }

    
}
