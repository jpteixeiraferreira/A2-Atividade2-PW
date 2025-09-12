<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class CadastrarController extends Controller
{
    public function index()
    {
        return view('cadastrar');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'inputName'     => 'required',
            'inputEmail'    => 'required|email|unique:users,email',
            'inputPassword' => 'required|confirmed',
        ], [
            'inputName.required' => 'Campo nome de preenchimento obrigatório',
            'inputEmail.required' => 'Campo e-mail de preenchimento obrigatório',
            'inputEmail.unique' => 'Já existe um cadastro associado a este e-mail',
            'inputPassword.required' => 'Campo senha de preenchimento obrigatório',
            'inputPassword.confirmed' => 'Senhas devem ser iguais',

        ]);

        $user = User::create([
            'name' => $validated['inputName'],
            'email' => $validated['inputEmail'],
            'password' => Hash::make($validated['inputPassword'],)
        ]);

        Auth::login($user);
        return redirect('/dashboard')->with('success', 'Cadastro realizado com sucesso!');
    }
}
