<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <div class="sidebar-brand">
        <a href="{{ route('admin.dashboard') }}" class="brand-link">
            {{-- <img src="..." alt="AdminLTE Logo" class="brand-image opacity-75 shadow"> --}}
            <span class="brand-text fw-light">Cakrawala Trans</span>
            </a>
        </div>
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu"
                data-accordion="false">

                {{-- MENU DASHBOARD --}}
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-speedometer"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                {{-- MENU MANAJEMEN MOBIL --}}
                <li class="nav-item">
                    <a href="{{ route('admin.mobil.index') }}" class="nav-link {{ request()->routeIs('admin.mobil.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-car-front-fill"></i>
                        <p>Manajemen Mobil</p>
                    </a>
                </li>

                {{-- MENU MANAJEMEN PEMESANAN --}}
                <li class="nav-item">
                    <a href="{{ route('admin.bookings.index') }}" class="nav-link {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-journal-text"></i>
                        <p>Manajemen Pemesanan</p>
                    </a>
                </li>

                {{-- MENU LAPORAN --}}
                <li class="nav-item">
                    <a href="{{ route('admin.reports.index') }}" class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-pie-chart-fill"></i>
                        <p>Laporan</p>
                    </a>
                </li>

                {{-- MENU LOGOUT (untuk mobile) --}}
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}" class="nav-link"
                           onclick="event.preventDefault(); this.closest('form').submit();">
                            <i class="nav-icon bi bi-box-arrow-right"></i>
                            <p>Logout</p>
                        </a>
                    </form>
                </li>

            </ul>
            </nav>
    </div>
    </aside>
