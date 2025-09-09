@if(session('carteira') && count(session('carteira')) > 0)
    <div class="mt-4">
        <h4>Minha Carteira</h4>
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Código</th>
                        <th>Quantidade</th>
                        <th>Preço Médio (R$)</th>
                        <th>Preço Atual (R$)</th>
                        <th>Total (R$)</th>
                        <th>Variação</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach(session('carteira') as $acao)
                        <tr>
                            <td><strong>{{ $acao['codigo'] }}</strong></td>
                            <td>{{ $acao['quantidade'] }}</td>
                            <td>R$ {{ $acao['preco_medio'] }}</td>
                            <td>
                                @if($acao['preco_atual'] !== 'N/A')
                                    R$ {{ $acao['preco_atual'] }}
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td><strong>R$ {{ $acao['total'] }}</strong></td>
                            <td>
                                @if($acao['preco_atual'] !== 'N/A')
                                    @if($acao['variacao'] >= 0)
                                        <span class="text-success">
                                            +R$ {{ number_format($acao['variacao'], 2, ',', '.') }}
                                            ({{ number_format($acao['variacao_percentual'], 2, ',', '.') }}%)
                                        </span>
                                    @else
                                        <span class="text-danger">
                                            R$ {{ number_format($acao['variacao'], 2, ',', '.') }}
                                            ({{ number_format($acao['variacao_percentual'], 2, ',', '.') }}%)
                                        </span>
                                    @endif
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@elseif(session('carteira') && count(session('carteira')) == 0)
    <div class="mt-4">
        <h4>Minha Carteira</h4>
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i> Você ainda não possui ações na carteira.
        </div>
    </div>
@endif
