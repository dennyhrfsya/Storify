@php
    $permissions = \App\Models\Permission::where('role', Auth::user()->role)
        ->get()
        ->keyBy('module');
    $isInventoriActive =
        request()->routeIs('aset.*') || request()->routeIs('peminjaman.*') || request()->routeIs('pengembalian.*');
    $isStokActive = request()->routeIs('stok.*') || request()->routeIs('transaksi.*');
@endphp

<!-- Sidebar atau Navigasi-->
<aside class="dx-sidebar">
    <a id="closeBtn"
        class="d-flex w-100 justify-content-center dx-text-abu-terang dx-text-sm dx-py-5 align-items-center hover:dx-no-underline hover:dx-text-abu-terang">
        <img src="{{ asset('images/left-arrow-dx-white.svg') }}">
        <span class="dx-block dx-pl-2">Tutup</span>
    </a>

    <ul class="dx-sidebar-nav">

        <li>
            <a href="{{ route('dashboard') }}" class="dx-nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                aria-current="{{ request()->routeIs('dashboard') ? 'page' : '' }}">
                <span class="dx-nav-icon bi-house-door"></span><span id="textSidebarHome">Dashboard</span></a>
        </li>

        @if ($permissions['User']?->all)
            <li>
                <a href="{{ route('users.index') }}"
                    class="dx-nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                    <span class="dx-nav-icon bi-people"></span><span id="textSidebarUser">User</span></a>
            </li>
        @endif

        @if ($permissions['Inventori']?->all)
            <li class="dx-has-submenu {{ $isInventoriActive ? 'active' : '' }}">
                <button type="button" class="dx-nav-link dx-menu-trigger {{ $isInventoriActive ? 'active' : '' }}">
                    <div class="d-flex align-items-center">
                        <span class="dx-nav-icon bi-clipboard-data"></span>
                        <span class="dx-menu-text">Inventori</span>
                    </div>
                    <span class="bi bi-chevron-right dx-arrow-icon"></span>
                </button>

                <div class="dx-floating-card">
                    <ul class="dx-submenu-list">
                        <li>
                            <a href="{{ route('aset.index') }}"
                                class="dx-sub-link {{ request()->routeIs('aset.*') ? 'active' : '' }}">Data Master</a>
                        </li>
                        <li><a href="#" class="dx-sub-link">Peminjaman</a></li>
                        <li><a href="#" class="dx-sub-link">Pengembalian</a></li>
                    </ul>
                </div>
            </li>
        @endif

        @if ($permissions['Stok']?->all)
            <li class="dx-has-submenu {{ $isStokActive ? 'active' : '' }}">
                <button type="button" class="dx-nav-link dx-menu-trigger {{ $isStokActive ? 'active' : '' }}">
                    <div class="d-flex align-items-center">
                        <span class="dx-nav-icon bi-file-earmark"></span>
                        <span class="dx-menu-text">Stok</span>
                    </div>
                    <span class="bi bi-chevron-right dx-arrow-icon"></span>
                </button>

                <div class="dx-floating-card">
                    <ul class="dx-submenu-list">
                        <li>
                            <a href="{{ route('stok.index') }}"
                                class="dx-sub-link {{ request()->routeIs('stok.*') ? 'active' : '' }}">Data Master</a>
                        </li>
                        <li><a href="{{ route('transaksi.index') }}"
                                class="dx-sub-link {{ request()->routeIs('transaksi.*') ? 'active' : '' }}">Transaksi</a>
                        </li>
                        <li><a href="#" class="dx-sub-link">Report</a></li>
                    </ul>
                </div>
            </li>
        @endif
    </ul>
</aside>

<!-- Navigasi untuk Hp -->
<nav class="position-fixed bottom-0 w-100 bg-white dx-px-4 dx-z-50 dx-sidebar-ht">
    <ul class="h-100 d-flex justify-content-between align-items-center mb-0 list-unstyled">
        <li>
            <a href="{{ route('dashboard') }}"
                class="dx-nav-link-ht {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <span class="dx-nav-icon-ht bi bi-house-door"></span>
                <span class="dx-text-ht">Dashboard</span>
            </a>
        </li>

        @if ($permissions['User']?->all)
            <li>
                <a href="{{ route('users.index') }}"
                    class="dx-nav-link-ht {{ request()->routeIs('users.*') ? 'active' : '' }}">
                    <span class="dx-nav-icon-ht bi bi-people"></span>
                    <span class="dx-text-ht">User</span>
                </a>
            </li>
        @endif

        @if ($permissions['Inventori']?->all)
            <li class="dx-has-submenu-ht {{ $isInventoriActive ? 'active' : '' }}">
                <button type="button"
                    class="dx-nav-link-ht dx-menu-trigger-ht {{ $isInventoriActive ? 'active' : '' }}">
                    <span class="dx-nav-icon-ht bi bi-clipboard-data"></span>
                    <span class="dx-text-ht">Inventori</span>
                </button>
                <div class="dx-mobile-dropdown">
                    <a href="{{ route('aset.index') }}"
                        class="{{ request()->routeIs('aset.*') ? 'active' : '' }}">Data Master</a>
                    <a href="#">Peminjaman</a>
                    <a href="#">Pengembalian</a>
                </div>
            </li>
        @endif

        @if ($permissions['Stok']?->all)
            <li class="dx-has-submenu-ht {{ $isStokActive ? 'active' : '' }}">
                <button type="button" class="dx-nav-link-ht dx-menu-trigger-ht {{ $isStokActive ? 'active' : '' }}">
                    <span class="dx-nav-icon-ht bi bi-file-earmark"></span>
                    <span class="dx-text-ht">Stok</span>
                </button>
                <div class="dx-mobile-dropdown dx-dropdown-right">
                    <a href="{{ route('stok.index') }}"
                        class="{{ request()->routeIs('stok.*') ? 'active' : '' }}">Data Master</a>
                    <a href="#">Transaksi</a>
                    <a href="#">Report</a>
                </div>
            </li>
        @endif
    </ul>
</nav>
