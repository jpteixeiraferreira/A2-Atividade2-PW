<x-layout title="Historico">
    <x-nav-dashboard/>
        <h4>Histórico</h4>
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Símbolo</th>
                        <th>Quantidade</th>
                        <th>Preço (R$)</th>
                        <th>Transacionado em</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($historico as $hist)
                        <tr>
                            <td><strong>{{ $hist->acao }}</strong></td>
                            <td>{{$hist->tipo === 'Compra' ? '+' : '-' }}{{$hist->quantidade }}</td>
                            <td>R$ {{ number_format($hist->preco_unitario, 2, ',', '.') }}</td>
                            <td>{{ \Carbon\Carbon::parse($hist->data_operacao)
                                    ->timezone('America/Sao_Paulo')
                                    ->format('d/m/Y H:i') }}
                            </td>

                        </tr>
                    @empty
                        <tr>
                           <td colspan="4" class="text-center">Nenhuma operação encontrada</td> 
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layout>