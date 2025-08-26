<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
    <a class="sidebar-brand brand-logo" href=""><img src="{{ asset('assets/images/logo.svg') }}" alt="logo" /></a>
    <a class="sidebar-brand brand-logo-mini" href=""><img src="{{ asset('assets/images/logo-mini.svg') }}" alt="logo" /></a>
  </div>
  <ul class="nav">
    <li class="nav-item profile">
      <div class="profile-desc">
        <div class="profile-pic">
          <div class="count-indicator">
            <img class="img-xs rounded-circle" src="{{ asset('assets/images/faces/face15.jpg') }}" alt="">
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
        <span class="menu-icon"><i class="mdi mdi-speedometer"></i></span>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>

    <li class="nav-item menu-items">
      <a class="nav-link" href="javascript:void(0)" data-toggle="collapse" data-target="#user-moderasi"
         aria-controls="user-moderasi">
        <span class="menu-icon"><i class="mdi mdi-laptop"></i></span>
        <span class="menu-title">Moderasi</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="user-moderasi">
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

    <li class="nav-item menu-items">
      <a class="nav-link" href="{{ route('stories.trending') }}">
        <span class="menu-icon"><i class="mdi mdi-star-circle"></i></span>
        <span class="menu-title">Trending</span>
      </a>
    </li>

    <li class="nav-item menu-items">
      <a class="nav-link" href="javascript:void(0)" data-toggle="collapse" data-target="#melaporkan"
         aria-controls="melaporkan">
        <span class="menu-icon"><i class="mdi mdi-alert-outline"></i></span>
        <span class="menu-title">Melaporkan</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="melaporkan">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('storie.melaporkan') ? 'active' : '' }}" href="{{ route('storie.melaporkan') }}">Cerita</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('comment.melaporkan') ? 'active' : '' }}" href="{{ route('comment.melaporkan') }}">Komentar</a>
          </li>
        </ul>
      </div>
    </li>

    <li class="nav-item menu-items">
      <a class="nav-link" href="javascript:void(0)" data-toggle="collapse" data-target="#dilaporkan"
         aria-controls="dilaporkan">
        <span class="menu-icon"><i class="mdi mdi-flag-outline"></i></span>
        <span class="menu-title">Dilaporkan</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="dilaporkan">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('storie.dilaporkan') ? 'active' : '' }}" href="{{ route('storie.dilaporkan') }}">Cerita</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('comment.dilaporkan') ? 'active' : '' }}" href="{{ route('comment.dilaporkan') }}">Komentar</a>
          </li>
        </ul>
      </div>
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
