@props(['dadosCarteira', 'errors'])

<form action="{{route('vender')}}" method="POST" class="m-2">
    @csrf

    <div class="row align-items-end g-3">
        <div class="col-md-4 w-50">
            <label class="form-label" for="acao">Ação</label>
            <select name="acao" id="acao" class="form-select">
                <option selected disabled>Selecione uma ação</option>

                @foreach ($dadosCarteira as $item)
                    <option value="{{$item['codigo']}}">{{$item['codigo']}}</option>
                @endforeach


            </select>
            @error('acao')
                <div class="text-danger fs-6 mt-3">
                    {{ $message }}
                </div>
            @enderror


        </div>
        <div class="col-md-4 w-25">
            <label for="iptQtd" class="form-label">Quantidade</label>
            <input name="qtd" id="iptQtd" type="number" class="form-control">
            @error('qtd')
                <div class="text-danger fs-6 mt-3">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="col-md-2 mt-3">
        <button type="submit" class="btn btn-primary btnVender">Vender</button>
    </div>


</form>