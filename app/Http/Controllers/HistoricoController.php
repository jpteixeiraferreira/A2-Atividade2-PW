<?php

namespace App\Http\Controllers;

use App\Models\Historico;
use Illuminate\Http\Request;

class HistoricoController extends Controller
{
    public function index(){
        $userId = auth()->id();
        $historico = Historico::where('user_id', $userId)->orderBy('data_operacao', 'desc')->get();
        return view('historico', compact('historico'));
    }
}
