<x-layout title="Comprar">
    <x-nav-dashboard />

    <x-form-geral>
        <h2>Comprar Ações</h2>
        <x-form-comprar />
        @if (session('success'))
            <div class="alert alert-info mt-3">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->has('cotacao'))
            <div class="alert alert-danger mt-3">
                {{ $errors->first('cotacao') }}
            </div>
        @endif
        <div class="col-md-6">
            <x-tabela-carteira />
        </div>
    </x-form-geral>

</x-layout>