<form action="{{route('login')}}" method="POST">
    @csrf

    </div>
    <div class="mb-3">
        <label for="inputEmail" class="form-label">E-mail</label>
        <input type="email" name="inputEmail" class="form-control" id="inputEmail" aria-describedby="emailHelp"
            value="{{old('inputEmail')}}">
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
    @if ($errors->has('email'))
        <div class="alert alert-danger">
            {{ $errors->first('email') }}
        </div>
    @endif

    <button type="submit" class="btn btn-primary">Fazer login</button>
</form>