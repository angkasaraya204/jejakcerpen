<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
      <a class="sidebar-brand brand-logo" href=""><img src="{{ asset('assets/images/logos.svg') }}" alt="logo" style="width: 369px; height: 28px;"/></a>
      <a class="sidebar-brand brand-logo-mini" href=""><img src="{{ asset('assets/images/logo-mini.svg') }}" alt="logo" /></a>
    </div>
    <ul class="nav">
      <li class="nav-item profile">
        <div class="profile-desc">
          <div class="profile-pic">
            <div class="count-indicator">
              <img class="img-xs rounded-circle " src="{{ asset('assets/images/faces/face15.jpg') }}" alt="">
              <span class="count bg-success"></span>
            </div>
            <div class="profile-name">
              <h5 class="mb-0 font-weight-normal">{{ Auth::user()->name }}</h5>
            </div>
          </div>
        </div>
      </li>
      <li class="nav-item nav-category">
        <span class="nav-link">Navigation</span>
      </li>

      <li class="nav-item menu-items {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
          <span class="menu-icon">
            <i class="mdi mdi-speedometer"></i>
          </span>
          <span class="menu-title">Dashboard</span>
        </a>
      </li>

      <li class="nav-item menu-items {{ (request()->routeIs('stories.index') || request()->routeIs('comments.index')) }}">
        <a class="nav-link" data-toggle="collapse" href="#admin-moderasi" aria-expanded="{{ (request()->routeIs('stories.index') || request()->routeIs('comments.index')) }}" aria-controls="admin-moderasi">
          <span class="menu-icon">
            <i class="mdi mdi-laptop"></i>
          </span>
          <span class="menu-title">Moderasi</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse {{ (request()->routeIs('stories.index') || request()->routeIs('comments.index')) }}" id="admin-moderasi">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item">
              <a class="nav-link {{ request()->routeIs('stories.index') ? 'active' : '' }}" href="{{ route('stories.index') }}">Cerita</a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ request()->routeIs('comments.index') ? 'active' : '' }}" href="{{ route('comments.index') }}">Komentar</a>
            </li>
          </ul>
        </div>
      </li>

      <li class="nav-item menu-items {{ request()->routeIs('users.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('users.index') }}">
          <span class="menu-icon">
            <i class="mdi mdi-account-group"></i>
          </span>
          <span class="menu-title">Pengguna</span>
        </a>
      </li>
      <li class="nav-item menu-items {{ request()->routeIs('story-selections.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('story-selections.index') }}">
          <span class="menu-icon">
            <i class="mdi mdi-star-circle"></i>
          </span>
          <span class="menu-title">Seleksi Cerita</span>
        </a>
      </li>
      <li class="nav-item menu-items {{ request()->routeIs('categories.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('categories.index') }}">
          <span class="menu-icon">
            <i class="mdi mdi-view-grid"></i>
          </span>
          <span class="menu-title">Kategori</span>
        </a>
      </li>
      <li class="nav-item menu-items {{ request()->routeIs('reports.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('reports.index') }}">
        <span class="menu-icon">
            <i class="mdi mdi-flag-variant"></i>
          </span>
          <span class="menu-title">Laporan</span>
        </a>
      </li>

      <li class="nav-item menu-items">
        <form method="POST" action="{{ route('logout') }}">
        @csrf
            <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                <span class="menu-title btn btn-danger w-100"><i class="mdi mdi-logout"></i>Keluar</span>
            </a>
        </form>
      </li>
    </ul>
</nav>
