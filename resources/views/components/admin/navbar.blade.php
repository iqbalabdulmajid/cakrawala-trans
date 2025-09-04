<nav class="app-header navbar navbar-expand bg-body">
    <div class="container-fluid">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                    <i class="bi bi-list"></i>
                </a>
            </li>
            <li class="nav-item d-none d-md-block">
                {{-- Link untuk melihat halaman depan situs --}}
                <a href="{{ route('home') }}" class="nav-link" target="_blank">Lihat Situs</a>
            </li>
        </ul>
        <ul class="navbar-nav ms-auto">
            <li class="nav-item">
                <a class="nav-link" href="#" data-lte-toggle="fullscreen">
                    <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
                    <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none;"></i>
                </a>
            </li>
            @auth
                <li class="nav-item dropdown user-menu">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                        {{-- Ganti gambar statis dengan inisial atau gambar profil dinamis jika ada --}}
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random"
                            class="user-image rounded-circle shadow" alt="User Image" />
                        {{-- Tampilkan nama user yang login --}}
                        <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                        <li class="user-header text-bg-primary">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random"
                                class="rounded-circle shadow" alt="User Image" />
                            <p>
                                {{ Auth::user()->name }}
                                {{-- Tampilkan role user --}}
                                <small>Member since {{ Auth::user()->created_at->format('M. Y') }}</small>
                            </p>
                        </li>
                        <li class="user-footer">
                            <a href="#" class="btn btn-default btn-flat">Profile</a>

                            {{-- Tombol Logout yang berfungsi --}}
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <a href="{{ route('logout') }}" class="btn btn-default btn-flat float-end"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    Sign out
                                </a>
                            </form>
                        </li>
                    </ul>
                </li>
            @endauth
        </ul>
    </div>
</nav>
