<?php

namespace App\Http\Controllers\Login;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class loginController extends Controller
{
    public function entrar(Request $request)
    {
        $dados = $request->all();

        $request->validate([
            'usuario' => 'required',
            'senha' => 'required'
        ]);

        if (Auth::attempt(['name' => $dados['usuario'], 'password' => $dados['senha']])) {
            return redirect('/');
        } else {
            return redirect('/')->withErrors(['mensagem' => 'Usuário ou senha incorretos']);
        }
    }   

    public function sair()
    {
        Auth::logout();
    }
}
