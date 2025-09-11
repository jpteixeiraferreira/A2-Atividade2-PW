<x-layout title="Login">
    <x-nav />
    <x-form-geral>

        @if (session('logout'))
            <div class="text-danger fs-6">
                {{session('logout')}}
            </div>
        @endif
        <x-form-login />
    </x-form-geral>


</x-layout>