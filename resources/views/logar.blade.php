<x-layout title="Login">
    <x-nav />
    <x-form-geral>

        @if (session('logout'))
            <div class="alert alert-danger mt-3">
                {{session('logout')}}
            </div>
        @endif
        <x-form-login />
    </x-form-geral>


</x-layout>