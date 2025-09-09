<form action="{{route('cadastrar')}}" method="POST">
    @csrf

    <div class="mb-3">
        <label for="inputName" class="form-label">Nome</label>
        <input type="text" name="inputName" class="form-control" id="inputName" value="{{old('inputName')}}">
        @error('inputName')
            <div class="text-danger fs-6">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="inputEmail" class="form-label">E-mail</label>
        <input type="email" name="inputEmail" class="form-control" id="inputEmail" aria-describedby="emailHelp" value="{{old('inputEmail')}}">
        <div id="emailHelp" class="form-text">Nós não compartilhamos seus dados com ninguém.</div>
        @error('inputEmail')
            <div class="text-danger fs-6">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="inputPassword" class="form-label">Senha</label>
        <input type="password" name="inputPassword" class="form-control" id="inputPassword">
        @error('inputPassword')
            <div class="text-danger fs-6">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="inputPassword_confirmation" class="form-label">Confirmar Senha</label>
        <input type="password" class="form-control" name="inputPassword_confirmation" id="inputPassword_confirmation">
    </div>
    <button type="submit" class="btn btn-primary">Cadastrar</button>
</form>