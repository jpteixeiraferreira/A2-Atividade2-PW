<?php

namespace App\Http\Controllers;
use App\Services\CotacaoService;
use Illuminate\Http\Request;



class ConsultarController extends Controller

{
    protected $cotacaoService;
    public function __construct(CotacaoService $cotacaoService){
        $this->cotacaoService = $cotacaoService;
    }
    public function create(){
        return view('consultar');
    }

    public function consultar(Request $request){
        $request->validate([
            'inputCode'=>'required|string',
        ], [
            'inputCode.required'=>'Código da ação deve ser informado'
        ]);

        try{
            $dados = $this->cotacaoService->buscarCotacao($request->inputCode);
            $frase = "O valor atual da ação do(a) {$dados['nome']} é de R$" . number_format($dados['preco'], 2, ',', '.');
            return response()->json([
                'success'=>true,
                'frase'=>$frase
            ]);
        } catch(\Exception $e){
            return response()->json([
                'success'=> false,
                'message'=> $e->getMessage()
            ], 400);
        }
    }
}
