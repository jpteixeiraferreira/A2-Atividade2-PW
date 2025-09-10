<x-layout title="Dashboard">
    <x-nav-dashboard/>

    <h1>Seja bem vindo(a), {{Auth::user()->name}}</h1>

    <p>Para continuar, acesse as abas do menu de navegação com a opção desejada.</p>
</x-layout>