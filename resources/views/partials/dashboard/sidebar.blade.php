@php
$dashboardRoute = auth()->user()->hasRole('admin') ? 'admin.dashboard' : 'seller.dashboard';
@endphp
<aside id="sidebar-wrapper">
    <div class="sidebar-brand my-3">
        <img src="{{ asset('images/J-Coffee.png') }}" class="rounded-circle" style="height: 80px;" alt="{{ config('app.name') }}">
        <br>
        <a href="{{ route($dashboardRoute) }}" class="mb-2">{{ config('app.name') }}</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
        <a href="{{ route($dashboardRoute) }}">JC</a>
    </div>
    <ul class="sidebar-menu">
        <li class="menu-header">Dashboard</li>
        <li class="{{ request()->routeIs($dashboardRoute) ? 'active' : '' }}">
            <a class="nav-link" href="{{ route($dashboardRoute) }}">
                <i class="fas fa-columns"></i> <span>Dashboard</span>
            </a>
        </li>

        @can('manage all users')
        <li class="menu-header">Users</li>
        <li class="{{ request()->routeIs('admin.users.index') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.users.index') }}"><i class="fas fa-users"></i> <span>Users</span></a>
        </li>
        @endcan

        @can('manage all communities')
            <li class="menu-header">Communities</li>
            <li class="{{ request()->routeIs('admin.communities.index') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.communities.index') }}"><i class="fas fa-comments"></i> <span>Communities</span></a>
            </li>
            <li class="{{ request()->routeIs('admin.events.index') ? 'active' : '' }}">
                <a href="{{route('admin.events.index')}}" class="nav-link"><i class="fas fa-calendar-week"></i> <span>Events</span></a>
            </li>
            <li class="{{ request()->routeIs('admin.proposals.index') ? 'active' : '' }}">
                <a href="{{route('admin.proposals.index')}}" class="nav-link"><i class="fas fa-check"></i> <span>Community Proposals</span></a>
            </li>
        @endcan

        @can('manage all stores')
            <li class="menu-header">Stores</li>
            <li class="{{request()->routeIs('admin.stores.index') ? 'active' : ''}}">
                <a href="{{route('admin.stores.index')}}" class="nav-link"><i class="fas fa-store"></i> <span>Stores</span></a>
            </li>
            <li class="{{request()->routeIs('admin.products.index') ? 'active' : ''}}">
                <a href="{{route('admin.products.index')}}" class="nav-link"><i class="fas fa-box"></i> <span>Products</span></a>
            </li>
            <li class="{{request()->routeIs('admin.payments.index') ? 'active' : ''}}">
                <a href="{{route('admin.payments.index')}}" class="nav-link"><i class="fas fa-file-invoice-dollar"></i> <span>Payments</span></a>
            </li>
            <li class="{{request()->routeIs('admin.withdrawals.index') ? 'active' : ''}}">
                <a href="{{route('admin.withdrawals.index')}}" class="nav-link"><i class="fas fa-money-bill-wave"></i> <span>Withdrawals</span></a>
            </li>
        @endcan

        @role('seller')
            <li class="menu-header">Toko</li>
            <li class="{{request()->routeIs('seller.store.index') ? 'active' : ''}}">
                <a href="{{route('seller.store.index')}}" class="nav-link"><i class="fas fa-store"></i> <span>Toko</span></a>
            </li>
            <li class="{{request()->routeIs('seller.products.index') ? 'active' : ''}}">
                <a href="{{route('seller.products.index')}}" class="nav-link"><i class="fas fa-box"></i> <span>Produk</span></a>
            </li>
            <li class="{{request()->routeIs('seller.orders.index') ? 'active' : ''}}">
                <a href="{{route('seller.orders.index')}}" class="nav-link"><i class="fas fa-shopping-cart"></i> <span>Pesanan</span></a>
            </li>
            <li class="{{request()->routeIs('seller.withdrawals.index') ? 'active' : ''}}">
                <a href="{{route('seller.withdrawals.index')}}" class="nav-link"><i class="fas fa-money-bill-wave"></i> <span>Pencairan Dana</span></a>
            </li>
            <li class="menu-header">Komunitas</li>
            <li class="{{request()->routeIs('seller.community.index') ? 'active' : ''}}">
                <a href="{{route('seller.community.index')}}" class="nav-link"><i class="fas fa-comments"></i> <span>Komunitas Saya</span></a>
            </li>
            <li class="{{ request()->routeIs('seller.events.index') ? 'active' : '' }}">
                <a href="{{route('seller.events.index')}}" class="nav-link"><i class="fas fa-calendar-week"></i> <span>Kegiatan</span></a>
            </li>
            <li class="{{request()->routeIs('seller.community.edit') ? 'active' : ''}}">
                <a href="{{route('seller.community.edit')}}" class="nav-link"><i class="fas fa-edit"></i> <span>Ubah Informasi</span></a>
            </li>
        @endrole
    </ul>
    <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
        <a href="{{ url('/') }}" class="btn btn-primary btn-lg btn-block btn-icon-split">
            <i class="fas fa-home"></i> Home
        </a>
    </div>
</aside>
