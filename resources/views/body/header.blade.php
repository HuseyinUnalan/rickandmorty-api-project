<nav class="navbar navbar-expand-sm navbar-color">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('/') }}">
            <img src="{{ asset('assets/images/logo.png') }}" alt="" width="240px" height="auto" class="img-fluid">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mynavbar">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('characters') }}">Characters</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('episodes') }}">Episodes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('locations') }}">Locations</a>
                </li>



            </ul>

            @auth

                <div class="dropdown" style="margin-right: 15px">
                    <div class="avatar dropdown-toggle" id="avatarDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <ul class="dropdown-menu" aria-labelledby="avatarDropdown">
                        <li><a class="dropdown-item" href="{{ route('my.favorite.characters') }}">My Favorite Characters</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="{{ route('logout') }}">Logout</a></li>
                    </ul>
                </div>
            @else
                <a class="btn btn-secondary m-2" href="{{ route('login') }}">Login</a>

                <a class="btn btn-secondary m-2" href="{{ route('register') }}">Register</a>
            @endauth

            <form action="{{ route('search') }}" method="POST" class="d-flex mr-5">
                @csrf
                <input class="form-control me-2" type="text" name="searchkeyword" placeholder="Search for Character">
                <button class="btn btn-search" type="submit">Search</button>
            </form>


        </div>
    </div>
</nav>
