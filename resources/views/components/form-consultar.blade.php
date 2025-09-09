<form id="formCotacao" action="{{route('consultar')}}" method="POST">
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
    <button type="submit" class="btn btn-primary">Consultar</button>
</form>

<div id="resultado" class="alert alert-info mt-3 d-none"></div>

<script>
document.getElementById('formCotacao').addEventListener('submit', async function (e) {
    e.preventDefault();

    let form = e.target;
    let formData = new FormData(form);

    try {
        let response = await fetch("{{ route('consultar') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": formData.get("_token"),
                "Accept": "application/json"
            },
            body: formData
        });

        let data = await response.json();

        if (data.success) {
            document.getElementById('resultado').textContent = data.frase;
            document.getElementById('resultado').classList.remove('d-none', 'alert-danger');
            document.getElementById('resultado').classList.add('alert-info');
            document.getElementById('erro').textContent = "";
        } else {
            document.getElementById('resultado').textContent = data.message;
            document.getElementById('resultado').classList.remove('d-none', 'alert-info');
            document.getElementById('resultado').classList.add('alert-danger');
        }
    } catch (err) {
        document.getElementById('erro').textContent = "Erro inesperado, tente novamente.";
    }
});
</script>