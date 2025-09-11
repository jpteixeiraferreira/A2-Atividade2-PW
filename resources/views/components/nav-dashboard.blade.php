
   <nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="{{route('dashboard')}}">Finance App</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="{{route('consultar')}}">Consultar</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{route('comprar')}}">Comprar</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{route('vender')}}">Vender</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{route('historico')}}">Histórico</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{route('logout')}}">Logout</a>
        </li>
      </ul>
          <span class="nav-link ms-auto fw-bold">Saldo atual: R$ {{Auth::user()->saldo}} </span>
    </div>
  </div>
</nav>
