@if(session('carteira') && count(session('carteira')) > 0)
    <div class="mt-4">
        <h4>Minha Carteira</h4>
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Código</th>
                        <th>Quantidade</th>
                        <th>Preço Atual (R$)</th>
                        <th>Total (R$)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach(session('carteira') as $acao)
                        <tr>
                            <td><strong>{{ $acao['codigo'] }}</strong></td>
                            <td>{{ $acao['quantidade'] }}</td>
                            <td>
                                @if($acao['preco_atual'] !== 'N/A')
                                    R$ {{ $acao['preco_atual'] }}
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td><strong>R$ {{ $acao['total'] }}</strong></td>
                        </tr>
                    @endforeach
                    <tfoot class="table-dark">
                        <tr>
                            <td colspan="3">Saldo restante:</td>
                            <td>{{Auth::user()->saldo}}</td>
                        </tr>
                    </tfoot>
                </tbody>

            </table>
        </div>
    </div>
@elseif(session('carteira') && count(session('carteira')) == 0)
    <div class="mt-4">
        <h4>Minha Carteira</h4>
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i> Você não possui ações na carteira.
        </div>
    </div>
@endif


