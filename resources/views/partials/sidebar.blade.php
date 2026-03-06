@php
    $permissions = \App\Models\Permission::where('role', Auth::user()->role)
        ->get()
        ->keyBy('module');
@endphp

<!-- Sidebar atau Navigasi-->
<aside class="dx-sidebar">
    <a id="closeBtn"
        class="d-flex w-100 justify-content-center dx-text-abu-terang dx-text-sm dx-py-5 align-items-center  hover:dx-no-underline hover:dx-text-abu-terang">
        <img src="{{ asset('images/left-arrow-dx-white.svg') }}">
        <span class="dx-block dx-pl-2">Tutup</span>
    </a>
    <ul>
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
        @if ($permissions['Inventory']?->all)
            <li>
                <a href="{{ route('aset.index') }}"
                    class="dx-nav-link {{ request()->routeIs('aset.*') ? 'active' : '' }}">
                    <span class="dx-nav-icon bi-clipboard-data"></span><span
                        id="textSidebarInventory">Inventory</span></a>
            </li>
        @endif
        <li>
            <a href="#" class="dx-nav-link">
                <span class="dx-nav-icon bi-file-earmark"></span><span id="textSidebarItem">Item</span></a>
        </li>
    </ul>
</aside>

<!-- Navigasi untuk Mobile -->
<nav class="position-fixed bottom-0 w-100 bg-white dx-px-12 dx-z-50 dx-sidebar-ht">
    <ul class="h-100 d-flex justify-content-between align-items-center">
        <li>
            <a href="{{ route('dashboard') }}"
                class="dx-nav-link-ht {{ request()->routeIs('dashboard') ? 'active' : '' }}" aria-current="page">
                <span class="dx-nav-icon-ht bi bi-house-door"></span>Dashboard</a>
        </li>
        @if ($permissions['User']?->all)
            <li>
                <a href="{{ route('users.index') }}"
                    class="dx-nav-link-ht {{ request()->routeIs('users.*') ? 'active' : '' }}">
                    <span class="dx-nav-icon-ht bi bi-people"></span>User</a>
            </li>
        @endif
        @if ($permissions['Inventory']?->all)
            <li>
                <a href="{{ route('aset.index') }}"
                    class="dx-nav-link-ht {{ request()->routeIs('aset.*') ? 'active' : '' }}">
                    <span class="dx-nav-icon-ht bi bi-clipboard-data"></span>Inventory</a>
            </li>
        @endif
        <li>
            <a href="#" class="dx-nav-link-ht">
                <span class="dx-nav-icon-ht bi bi-file-earmark"></span>Item</a>
        </li>
    </ul>
</nav>
