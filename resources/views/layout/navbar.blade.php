@section('stylesheets')
<link href="{{ asset('assets/css/layout/navbar.css') }}" rel="stylesheet">
@endsection

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <span class="navbar-brand mb-0 h1 font-weight-bold mr-3" id="textBrand">ParkingSystem</span>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item mr-3">
                <a class="nav-link" href="#">Parking</a>
            </li>
            @auth
                <li>
                    <a class="nav-link" href="#">Add vehicle</a>
                </li>
            @endauth
        </ul>
        <ul class="navbar-nav ml-auto mr-5">
            <li class="nav-item dropdown ml-lg-auto">
                @auth
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Username
                </a>
                <div class="dropdown-menu dropdown-menu-right animate slideIn dropdown-user" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="#">Favorites</a>
                    <a class="dropdown-item" href="#">Settings</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Logout</a>
                </div>
                @endauth
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Account
                </a>
                <div class="dropdown-menu dropdown-menu-right animate slideIn dropdown-anon" aria-labelledby="navbarDropdown">
                    <form class="px-4 py-3" id="loginForm">
                        <div class="form-group">
                            <label for="exampleDropdownFormEmail1">Email address</label>
                            <span class="text-danger font-weight-bold" id="validation-email" hidden><br>Enter correct email</span>
                            <input name="email" type="email" class="form-control" id="inputEmail" placeholder="email@example.com">
                        </div>
                        <div class="form-group">
                            <label for="exampleDropdownFormPassword1">Password</label>
                            <span class="text-danger font-weight-bold" id="validation-password-length" hidden><br>Password must be 8-16 characters</span>
                            <input name="password" type="password" class="form-control" id="inputPassword" placeholder="Password">
                        </div>
                        <div class="form-check mb-2">
                            <input type="checkbox" class="form-check-input" id="dropdownCheck">
                            <label class="form-check-label" for="dropdownCheck">
                                Remember me
                            </label>
                        </div>
                        <input type="hidden" name="_csrf_token" id="inputToken" value="#">
                        <button type="button" class="btn btn-primary" id="buttonLogin">Sign in</button>
                    </form>
                    <p class="text-white bg-danger h5 px-4" id="errorText"></p>
                </div>
            </li>
        </ul>
    </div>
</nav>

