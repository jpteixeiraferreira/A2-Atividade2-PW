<form id="formComprar" action="{{route('comprar')}}" method="POST">
    @csrf

    </div>
    <div class="mb-3">
        <label for="inputCode" class="form-label">Código da ação (ex: BBAS3)</label>
        <input type="text" name="inputCode" class="form-control w-50" id="inputCode" value="{{old('inputCode')}}">
        @error('inputCode')
            <div class="text-danger fs-6">
                {{ $message }}
            </div>
        @enderror
    </div>
        <div class="mb-3">
        <label for="inputQtd" class="form-label">Quantidade</label>
        <input type="number" name="inputQtd" class="form-control w-50" id="inputQtd" value="{{old('inputQtd')}}">
        @error('inputQtd')
            <div class="text-danger fs-6">
                {{ $message }}
            </div>
        @enderror
    </div>
    <button type="submit" class="btn btn-primary btnComprar">Comprar</button>
</form>
