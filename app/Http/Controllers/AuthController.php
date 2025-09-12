<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function index(){
        return view('logar');
    }

    public function login(Request $request){
        $credentials = $request->validate([
            'inputEmail'=>['required', 'email'],
            'inputPassword'=>['required'],
        ], [
            'inputEmail.required'=>'Campo e-mail de preenchimento obrigatório',
            'inputPassword.required'=>"Campo senha de preenchimento obrigatório"
        ]);

        if(Auth::attempt([
            'email' => $credentials['inputEmail'],
            'password'=>$credentials['inputPassword']
        ])){
            $user = Auth::user();
            $request->session()->regenerate(); //proteção contra session fixation
            return redirect()->intended('/dashboard')->with('success', $user->name);
        }

        return back()->withErrors([
            'email'=> 'Credenciais inválidas.',
        ]);
    }
        public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->with('logout', 'Sua sessão foi encerrada.');
    }
}
