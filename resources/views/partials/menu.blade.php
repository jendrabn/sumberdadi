@php
  $dashboardRoute = auth()->user()->hasRole('admin') ? 'admin.dashboard' : 'seller.dashboard';
@endphp

<li class="nav-header">Dashboard</li>
<li class="nav-item">
  <a class="nav-link {{ request()->routeIs($dashboardRoute) ? 'active' : '' }}"
    href="{{ route($dashboardRoute) }}">
    <i class="nav-icon fas fa-columns"></i>
    <p>Dashboard</p>
  </a>
</li>

@can('manage all users')
  <li class="nav-header">Users</li>
  <li class="nav-item">
    <a class="nav-link {{ request()->routeIs('admin.users.index') ? 'active' : '' }}"
      href="{{ route('admin.users.index') }}">
      <i class="nav-icon fas fa-users"></i>
      <p>Users</p>
    </a>
  </li>
@endcan

@can('manage all communities')
  <li class="nav-header">Communities</li>
  <li class="nav-item">
    <a class="nav-link {{ request()->routeIs('admin.communities.index') ? 'active' : '' }}"
      href="{{ route('admin.communities.index') }}">
      <i class="nav-icon fas fa-comments"></i>
      <p>Communities</p>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ request()->routeIs('admin.events.index') ? 'active' : '' }}"
      href="{{ route('admin.events.index') }}">
      <i class="nav-icon fas fa-calendar-week"></i>
      <p>Events</p>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ request()->routeIs('admin.proposals.index') ? 'active' : '' }}"
      href="{{ route('admin.proposals.index') }}">
      <i class="nav-icon fas fa-check"></i>
      <p>Community Proposals</p>
    </a>
  </li>
@endcan

@can('manage all stores')
  <li class="nav-header">Stores</li>
  <li class="nav-item">
    <a class="nav-link {{ request()->routeIs('admin.stores.index') ? 'active' : '' }}"
      href="{{ route('admin.stores.index') }}">
      <i class="nav-icon fas fa-store"></i>
      <p>Stores</p>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link  {{ request()->routeIs('admin.products.index') ? 'active' : '' }}"
      href="{{ route('admin.products.index') }}">
      <i class="nav-icon fas fa-box"></i>
      <p>Products</p>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ request()->routeIs('admin.payments.index') ? 'active' : '' }}"
      href="{{ route('admin.payments.index') }}">
      <i class="nav-icon fas fa-file-invoice-dollar"></i>
      <p>Payments</p>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ request()->routeIs('admin.withdrawals.index') ? 'active' : '' }}"
      href="{{ route('admin.withdrawals.index') }}">
      <i class="nav-icon fas fa-money-bill-wave"></i>
      <p>Withdrawals</p>
    </a>
  </li>
@endcan

@role('seller')
  <li class="nav-header">Toko</li>
  <li class="nav-item">
    <a class="nav-link {{ request()->routeIs('seller.store.index') ? 'active' : '' }}"
      href="{{ route('seller.store.index') }}">
      <i class="nav-icon fas fa-store"></i>
      <p>Toko</p>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ request()->routeIs('seller.products.index') ? 'active' : '' }}"
      href="{{ route('seller.products.index') }}">
      <i class="nav-icon fas fa-box"></i>
      <p>Produk</p>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ request()->routeIs('seller.orders.index') ? 'active' : '' }}"
      href="{{ route('seller.orders.index') }}">
      <i class="nav-icon fas fa-shopping-cart"></i>
      <p>Pesanan</p>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ request()->routeIs('seller.withdrawals.index') ? 'active' : '' }}"
      href="{{ route('seller.withdrawals.index') }}">
      <i class="nav-icon fas fa-money-bill-wave"></i>
      <p>Pencairan Dana</p>
    </a>
  </li>
  <li class="nav-header">Komunitas</li>
  <li class="nav-item">
    <a class="nav-link {{ request()->routeIs('seller.community.index') ? 'active' : '' }}"
      href="{{ route('seller.community.index') }}">
      <i class="nav-icon fas fa-comments"></i>
      <p>Komunitas Saya</p>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ request()->routeIs('seller.events.index') ? 'active' : '' }}"
      href="{{ route('seller.events.index') }}">
      <i class="nav-icon fas fa-calendar-week"></i>
      <p>Kegiatan</p>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ request()->routeIs('seller.community.edit') ? 'active' : '' }}"
      href="{{ route('seller.community.edit') }}">
      <i class="nav-icon fas fa-edit"></i>
      <p>Ubah Informasi</p>
    </a>
  </li>
@endrole
