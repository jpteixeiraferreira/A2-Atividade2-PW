<x-layout title="Vender">
    <x-nav-dashboard />

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-6">
                <h2>Vender Ações</h2>
                <x-form-vender :dados-carteira="$dadosCarteira" />
                @if (session('success'))
                    <div class="text-success">
                        {{session('success')}};
                    </div>
                @endif

                @if (session('error'))
                    <div class="text-danger">
                        {{session('error')}}
                    </div>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            @if (!$dadosCarteira)
                <div class="text-danger">Você ainda não possui ações em sua carteira.</div>
            @endif
            <x-tabela-carteira />
        </div>
    </div>

    @if($errors->any())
        <div class="text-danger fs-6">
            <ul>
                @foreach ($errors->all() as $error)
                    <li> {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif



</x-layout>