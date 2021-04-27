<link href="{{ asset('assets/css/layout/navbar.css') }}" rel="stylesheet">

<script src="{{ asset('assets/js/layout/navbar.js') }}"></script>
<script>
    var url_login = '{{ route('login') }}';
</script>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <span class="navbar-brand mb-0 h1 font-weight-bold mr-3" id="textBrand">ParkingSystem</span>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mr-auto">
            @auth
                <li class="nav-item mr-3">
                    <a class="nav-link" href="{{ route('index') }}">Data</a>
                </li>
                <li>
                    <a class="nav-link" href="{{ route('add_car') }}">Add vehicle</a>
                </li>
            @endauth
        </ul>
        <ul class="navbar-nav ml-auto mr-5">
            <li class="nav-item dropdown ml-lg-auto">
                @if(auth()->check())
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ auth()->user()->email }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-right animate slideIn dropdown-user" aria-labelledby="navbarDropdown">
                        <form method="post" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item">Logout</button>
                        </form>
                    </div>
                @endif
            </li>
        </ul>
    </div>
</nav>

