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

      @hasanyrole(['admin','user'])
      <li class="nav-item menu-items {{ url()->current() == route('dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
          <span class="menu-icon">
            <i class="mdi mdi-speedometer"></i>
          </span>
          <span class="menu-title">Dashboard</span>
        </a>
      </li>
      <li class="nav-item menu-items {{ request()->routeIs('stories.*', 'comments.*') ? 'active' : '' }}">
        <a class="nav-link" data-toggle="collapse" href="#moderasi" aria-expanded="false" aria-controls="moderasi">
          <span class="menu-icon">
            <i class="mdi mdi-laptop"></i>
          </span>
          <span class="menu-title">Moderasi</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="moderasi">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="{{ route('stories.index') }}">Cerita</a></li>
            <li class="nav-item"> <a class="nav-link" href="{{ route('comments.index') }}">Komentar</a></li>
          </ul>
        </div>
      </li>
      @endhasanyrole

      @role('moderator')
      <li class="nav-item menu-items {{ url()->current() == route('dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
          <span class="menu-icon">
            <i class="mdi mdi-speedometer"></i>
          </span>
          <span class="menu-title">Dashboard</span>
        </a>
      </li>
      <li class="nav-item menu-items {{ url()->current() == route('stories.index') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('stories.index') }}">
          <span class="menu-icon">
            <i class="mdi mdi-speedometer"></i>
          </span>
          <span class="menu-title">Laporan</span>
        </a>
      </li>
      @endrole

      @role('admin')
      <li class="nav-item menu-items {{ url()->current() == route('users.index') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('users.index') }}">
          <span class="menu-icon">
            <i class="mdi mdi-speedometer"></i>
          </span>
          <span class="menu-title">Pengguna</span>
        </a>
      </li>
      <li class="nav-item menu-items {{ url()->current() == route('categories.index') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('categories.index') }}">
          <span class="menu-icon">
            <i class="mdi mdi-speedometer"></i>
          </span>
          <span class="menu-title">Kategori</span>
        </a>
      </li>
      @endrole

      @role('user')
      <li class="nav-item menu-items {{ url()->current() == route('stories.trending') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('stories.trending') }}">
          <span class="menu-icon">
            <i class="mdi mdi-speedometer"></i>
          </span>
          <span class="menu-title">Trending</span>
        </a>
      </li>
      <li class="nav-item menu-items {{ request()->routeIs('storie.*', 'comment.*') ? 'active' : '' }}">
        <a class="nav-link" data-toggle="collapse" href="#melaporkan" aria-expanded="false" aria-controls="melaporkan">
          <span class="menu-icon">
            <i class="mdi mdi-laptop"></i>
          </span>
          <span class="menu-title">Melaporkan</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="melaporkan">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="{{ route('storie.melaporkan') }}">Cerita</a></li>
            <li class="nav-item"> <a class="nav-link" href="{{ route('comment.melaporkan') }}">Komentar</a></li>
          </ul>
        </div>
      </li>
      <li class="nav-item menu-items {{ request()->routeIs('storie.*', 'comment.*') ? 'active' : '' }}">
        <a class="nav-link" data-toggle="collapse" href="#dilaporkan" aria-expanded="false" aria-controls="dilaporkan">
          <span class="menu-icon">
            <i class="mdi mdi-laptop"></i>
          </span>
          <span class="menu-title">Dilaporkan</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="dilaporkan">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="{{ route('storie.dilaporkan') }}">Cerita</a></li>
            <li class="nav-item"> <a class="nav-link" href="{{ route('comment.dilaporkan') }}">Komentar</a></li>
          </ul>
        </div>
      </li>
      @endrole
    </ul>
  </nav>
