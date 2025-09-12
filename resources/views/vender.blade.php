<x-layout title="Vender">
    <x-nav-dashboard />


    <x-form-geral>

        <h2>Vender Ações</h2>
        <x-form-vender :dados-carteira="$dadosCarteira" />
        @if (session('success'))
        <div class="alert alert-success mt-3">
            {{session('success')}}
        </div>
        @endif

        @if (session('error'))
        <div class="alert alert-danger mt-3">
            {{ session('error') }}
        </div>
        @endif
        <div class="col-md-6">
            @if (!$dadosCarteira)
            <div class="alert alert-danger mt-3">Você ainda não possui ações em sua carteira.</div>
            @endif
        </div>
        
    </x-form-geral>
    <div class="container w-50">

        <x-tabela-carteira />
    </div>
</x-layout>