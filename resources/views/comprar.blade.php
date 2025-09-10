<x-layout title="Comprar">
    <x-nav-dashboard/>
    
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-6">
                <h2>Comprar Ações</h2>
                <x-form-comprar/>
                @if (session('success'))
                    <div class="text-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->has('cotacao'))
                        <div class="text-danger">
                        {{ $errors->first('cotacao') }}
                    </div>
                @endif
            </div>
            <div class="col-md-6">
                <x-tabela-carteira/>
            </div>
        </div>
    </div>
</x-layout>