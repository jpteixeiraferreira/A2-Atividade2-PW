<x-layout title="Minha Carteira">
    <x-nav-dashboard/>

    <div class="container mt-4">
        <h2>Minha Carteira</h2>

        @if(count($acoes) > 0)
            <table class="table table-striped table-bordered mt-3">
                <thead class="table-dark">
                    <tr>
                        <th>Código</th>
                        <th>Quantidade</th>
                        <th>Preço Atual (R$)</th>
                        <th>Total (R$)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($acoes as $acao)
                        <tr>
                            <td>{{ $acao['codigo'] }}</td>
                            <td>{{ $acao['quantidade'] }}</td>
                            <td>{{ $acao['preco_atual'] }}</td>
                            <td>{{ $acao['total'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="alert alert-info mt-3">
                Você ainda não possui ações na carteira.
            </div>
        @endif
    </div>
</x-layout>
