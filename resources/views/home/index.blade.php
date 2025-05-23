<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CeritaKita - Platform Berbagi Cerita</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ route('home') }}">
                <i class="fas fa-book-open me-2 text-primary"></i>
                JejakCerita
            </a>
            <div class="d-flex align-items-center">
                <div class="dark-mode-toggle me-3" id="darkModeToggle">
                    <i class="fas fa-sun toggle-icons"></i>
                    <i class="fas fa-moon toggle-icons moon"></i>
                    <div class="toggle-circle"></div>
                </div>
                <button class="navbar-toggler border-0" type="button" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Masuk</a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                @role('user')
                                <li>
                                    <a class="dropdown-item" href="{{ route('stories.create') }}">
                                        <i class="fas fa-plus me-2"></i> Buat Cerita
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                @endrole
                                <li>
                                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                        <i class="fas fa-cog me-2"></i> Pengaturan
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt me-2"></i> Keluar
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="p-4">
            <h5 class="mb-4 fw-bold">Menu</h5>
            <ul class="sidebar-menu">
                <li>
                    <a href="{{ route('home') }}">
                        <i class="fas fa-home"></i>
                        Beranda
                    </a>
                </li>
                <li>
                    <a href="{{ route('stories.create') }}">
                        <i class="fas fa-plus-circle"></i>
                        Tulis Cerita
                    </a>
                </li>
            </ul>
            @auth
            <h5 class="mb-3 fw-bold mt-4">Akun</h5>
            <ul class="sidebar-menu">
                <li>
                    <a href="{{ route('profile.edit') }}">
                        <i class="fas fa-cog"></i>
                        Pengaturan
                    </a>
                </li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <li>
                        <a href="{{ route('logout') }}" class="text-danger"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            <i class="fas fa-sign-out-alt"></i>
                            Keluar
                        </a>
                    </li>
                </form>
            </ul>
            @endauth
        </div>
    </div>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Main Content -->
    <div class="container py-5" id="mainContent">
        <!-- Categories Section (Tabs) -->
        <h4 class="mb-3"><i class="fas fa-tags me-2 text-primary"></i>Kategori Populer</h4>
        <div class="card mb-4 fade-in">
            <div class="card-body">
                <!-- Tabs navigation -->
                <ul class="nav nav-tabs" id="categoryTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="all-categories-tab" data-bs-toggle="tab"
                            data-bs-target="#all-categories" type="button" role="tab" aria-controls="all-categories"
                            aria-selected="true" onclick="loadStoriesByCategory('all')">
                            Semua
                        </button>
                    </li>
                    @foreach($popularCategories as $index => $popularCategory)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="category-{{ $popularCategory->id }}-tab" data-bs-toggle="tab"
                                data-bs-target="#category-{{ $popularCategory->id }}" type="button" role="tab"
                                aria-controls="category-{{ $popularCategory->id }}" aria-selected="false"
                                onclick="loadStoriesByCategory('{{ $popularCategory->slug }}')">
                                {{ $popularCategory->name }}
                                <span
                                    class="badge bg-primary rounded-pill ms-1">{{ $popularCategory->stories_count }}</span>
                            </button>
                        </li>
                    @endforeach
                </ul>

                <!-- Category Description (optional) -->
                <div class="alert alert-light border mb-0">
                    <div class="d-flex">
                        <div class="me-3">
                            <i class="fas fa-lightbulb text-warning fs-4"></i>
                        </div>
                        <div>
                            <p class="mb-0">Pilih kategori untuk melihat cerita berdasarkan topik yang Anda minati.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Sections -->
        <div class="row">
            <!-- Left Content - Stories -->
            <div class="col-lg-9">
                <!-- Tab content -->
                <div class="tab-content" id="categoryTabsContent">
                    <div class="tab-pane fade show active" id="all-categories" role="tabpanel"
                        aria-labelledby="all-categories-tab">

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="mb-0 fw-bold" id="storiesHeading">Cerita Terbaru</h4>
                            <div class="spinner-border text-primary d-none" role="status" id="storiesLoader">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>

                        <div id="storiesContainer">
                            @if($stories->count() > 0)
                                @foreach($stories as $story)
                                    <div class="card story-card fade-in mb-4">
                                        <div class="story-header">

                                            <div class="user-info">
                                                <img src="{{ asset('assets/images/faces/face23.jpg') }}" alt="User Avatar" class="avatar">
                                                <div>
                                                    <div class="fw-bold">
                                                        @if($story->anonymous)
                                                            Anonim
                                                        @else
                                                            {{ optional($story->user)->name ?? 'User' }}
                                                        @endif
                                                    </div>
                                                    <div class="text-muted small">
                                                        {{ $story->created_at->diffForHumans() }}</div>
                                                </div>
                                            </div>
                                            @if(Auth::id() != $story->user_id)
                                                {{-- Alert Section --}}
                                                @if(session('success'))
                                                <div class="alert alert-success">
                                                    {{ session('success') }}
                                                </div>
                                                @endif
                                                @if(session('error'))
                                                <div class="alert alert-danger">
                                                    {{ session('error') }}
                                                </div>
                                                @endif
                                            @endif
                                            <div class="dropdown">
                                                @if($story->votes()->where('vote_type', 'like')->count() > 10)
                                                    <span class="badge bg-danger rounded-pill me-2">
                                                        <i class="fas fa-fire me-1"></i> Trending
                                                    </span>
                                                @endif
                                                <button class="btn btn-sm" type="button" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    @guest
                                                    <li>
                                                        <button @disabled(true) class="dropdown-item">
                                                            <i class="fas fa-user-plus me-2"></i> Ikuti
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <button @disabled(true) class="dropdown-item">
                                                            <i class="fas fa-exclamation-circle me-2"></i> Laporkan
                                                        </button>
                                                    </li>
                                                    @endguest
                                                    @auth
                                                        @role('user')
                                                            @if(Auth::id() === $story->user_id)
                                                                <li>
                                                                    <form action="{{ route('stories.destroy', $story) }}" method="POST">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="dropdown-item text-danger">
                                                                            <i class="fas fa-trash-alt me-2"></i> Hapus
                                                                        </button>
                                                                    </form>
                                                                </li>
                                                            @endif
                                                            @if(Auth::id() != $story->user_id && $story->user_id)
                                                                <li>
                                                                    <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#reportModal-{{ $story->id }}">
                                                                        <i class="fas fa-exclamation-circle me-2"></i> Laporkan
                                                                    </button>
                                                                </li>
                                                                @if(isset($isFollowing[$story->user_id]) && $isFollowing[$story->user_id])
                                                                    <li>
                                                                        <form action="{{ route('dashboard.unfollow', $story->user_id) }}" method="POST">
                                                                            @csrf
                                                                            <button type="submit" class="dropdown-item">
                                                                                <i class="fas fa-user-minus me-2"></i> Berhenti Mengikuti
                                                                            </button>
                                                                        </form>
                                                                    </li>
                                                                @else
                                                                    <li>
                                                                        <form action="{{ route('dashboard.follow', $story->user_id) }}" method="POST">
                                                                            @csrf
                                                                            <button type="submit" class="dropdown-item">
                                                                                <i class="fas fa-user-plus me-2"></i> Ikuti
                                                                            </button>
                                                                        </form>
                                                                    </li>
                                                                @endif
                                                            @endif
                                                        @endrole
                                                        @role('moderator')
                                                            <li>
                                                                <form action="{{ route('stories.destroy', $story) }}" method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="dropdown-item text-danger">
                                                                        <i class="fas fa-trash-alt me-2"></i> Hapus
                                                                    </button>
                                                                </form>
                                                            </li>
                                                        @endrole
                                                    @endauth
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="story-content">
                                            <span class="badge-category">{{ $story->category->name }}</span>
                                            <a href="{{ route('stories.show', $story) }}"
                                                class="text-decoration-none">
                                                <h2 class="story-title">{{ $story->title }}</h2>
                                            </a>
                                            <div class="story-meta">
                                                <span>Ditulis oleh:
                                                    @if($story->anonymous)
                                                        Anonim
                                                    @else
                                                        {{ optional($story->user)->name ?? 'Anonim' }}
                                                    @endif
                                                </span> •
                                                <span>{{ $story->created_at->format('d M Y, H:i') }}</span>
                                            </div>
                                            <div class="story-text">
                                                <p>{{ Str::limit(strip_tags($story->content), 200) }}</p>
                                            </div>
                                            <a href="{{ route('stories.show', $story) }}"
                                                class="read-more">Baca selengkapnya <i
                                                    class="fas fa-arrow-right ms-1"></i></a>
                                        </div>
                                        <div class="story-footer">
                                            <div class="vote-buttons">
                                                <form
                                                    action="{{ route('stories.vote', $story) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    <input type="hidden" name="vote_type" value="upvote">
                                                    <button class="vote-btn upvote">
                                                        <i class="fas fa-arrow-up"></i>
                                                        <span>{{ $story->votes()->where('vote_type', 'upvote')->count() }}</span>
                                                    </button>
                                                </form>
                                                <form
                                                    action="{{ route('stories.vote', $story) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    <input type="hidden" name="vote_type" value="downvote">
                                                    <button class="vote-btn downvote">
                                                        <i class="fas fa-arrow-down"></i>
                                                        <span>{{ $story->votes()->where('vote_type', 'downvote')->count() }}</span>
                                                    </button>
                                                </form>
                                            </div>
                                            <div>
                                                <span class="text-muted">
                                                    <i class="fas fa-comment me-1"></i>
                                                    {{ $story->comments->count() }}
                                                    Komentar
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal -->
                                    <div class="modal fade" id="reportModal-{{ $story->id }}" tabindex="-1" aria-labelledby="reportModalLabel-{{ $story->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <form action="{{ route('reports.store') }}" method="POST" class="modal-content">
                                                @csrf
                                                <input type="hidden" name="reportable_id" value="{{ $story->id }}">
                                                <input type="hidden" name="reportable_type" value="story">

                                                <div class="modal-header">
                                                <h5 class="modal-title" id="reportModalLabel-{{ $story->id }}">Pilih Jenis Laporan</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>

                                                <div class="modal-body">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="reason" id="reasonSpam-{{ $story->id }}" value="Spam" checked>
                                                    <label class="form-check-label" for="reasonSpam-{{ $story->id }}">Spam</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="reason" id="reasonHarassment-{{ $story->id }}" value="Pelecehan / Bullying">
                                                    <label class="form-check-label" for="reasonHarassment-{{ $story->id }}">Pelecehan / Bullying</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="reason" id="reasonPorn-{{ $story->id }}" value="Konten Dewasa">
                                                    <label class="form-check-label" for="reasonPorn-{{ $story->id }}">Konten Dewasa</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="reason" id="reasonOther-{{ $story->id }}" value="Lainnya">
                                                    <label class="form-check-label" for="reasonOther-{{ $story->id }}">Lainnya</label>
                                                </div>
                                                <!-- Jika mau teks bebas saat 'Lainnya', bisa ditambahkan textarea yang muncul via JS -->
                                                <textarea
                                                    name="other_reason"
                                                    id="otherReasonText-{{ $story->id }}"
                                                    class="form-control mt-2 d-none"
                                                    placeholder="Jelaskan alasanmu..."
                                                ></textarea>
                                            </div>

                                            <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-danger">Kirim Laporan</button>
                                            </div>
                                        </form>
                                        </div>
                                    </div>
                                @endforeach

                                <div class="mt-4 d-flex justify-content-center">
                                    {{ $stories->links() }}
                                </div>
                            @else
                                <div class="alert alert-info">
                                    <p class="mb-0">Belum ada cerita tersedia.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    @foreach($popularCategories as $index => $popularCategory)
                        <div class="tab-pane fade" id="category-{{ $popularCategory->id }}" role="tabpanel"
                            aria-labelledby="category-{{ $popularCategory->id }}-tab">

                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="mb-0 fw-bold">Cerita {{ $popularCategory->name }}</h4>
                                <div class="spinner-border text-primary d-none" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>

                            <div id="category-{{ $popularCategory->id }}-container">
                                @php
                                    $categoryStories = App\Models\Story::where('category_id', $popularCategory->id)
                                    ->latest('created_at')
                                    ->paginate(5);
                                @endphp

                                @forelse($categoryStories as $story)
                                    <div class="card story-card fade-in mb-4">
                                        <div class="story-header">
                                            <div class="user-info">
                                                <img src="{{ asset('assets/images/faces/face23.jpg') }}" alt="User Avatar" class="avatar">
                                                <div>
                                                    <div class="fw-bold">
                                                        @if($story->anonymous)
                                                            Anonim
                                                        @else
                                                            {{ optional($story->user)->name ?? 'User' }}
                                                        @endif
                                                    </div>
                                                    <div class="text-muted small">
                                                        {{ $story->created_at->diffForHumans() }}</div>
                                                </div>
                                            </div>
                                            @if(Auth::id() != $story->user_id)
                                                {{-- Alert Section --}}
                                                @if(session('success'))
                                                <div class="alert alert-success">
                                                    {{ session('success') }}
                                                </div>
                                                @endif
                                                @if(session('error'))
                                                <div class="alert alert-danger">
                                                    {{ session('error') }}
                                                </div>
                                                @endif
                                            @endif
                                            <div class="dropdown">
                                                @if($story->votes()->where('vote_type', 'like')->count() > 10)
                                                    <span class="badge bg-danger rounded-pill me-2">
                                                        <i class="fas fa-fire me-1"></i> Trending
                                                    </span>
                                                @endif
                                                <button class="btn btn-sm" type="button" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    @guest
                                                    <li>
                                                        <button @disabled(true) class="dropdown-item">
                                                            <i class="fas fa-user-plus me-2"></i> Ikuti
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <button @disabled(true) class="dropdown-item">
                                                            <i class="fas fa-exclamation-circle me-2"></i> Laporkan
                                                        </button>
                                                    </li>
                                                    @endguest
                                                    @auth
                                                        @role('user')
                                                            @if(Auth::id() === $story->user_id)
                                                                <li>
                                                                    <form action="{{ route('stories.destroy', $story) }}" method="POST">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="dropdown-item text-danger">
                                                                            <i class="fas fa-trash-alt me-2"></i> Hapus
                                                                        </button>
                                                                    </form>
                                                                </li>
                                                            @endif
                                                            @if(Auth::id() != $story->user_id && $story->user_id)
                                                                <li>
                                                                    <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#reportModal-{{ $story->id }}">
                                                                        <i class="fas fa-exclamation-circle me-2"></i> Laporkan
                                                                    </button>
                                                                </li>
                                                                @if(isset($isFollowing[$story->user_id]) && $isFollowing[$story->user_id])
                                                                    <li>
                                                                        <form action="{{ route('dashboard.unfollow', $story->user_id) }}" method="POST">
                                                                            @csrf
                                                                            <button type="submit" class="dropdown-item">
                                                                                <i class="fas fa-user-minus me-2"></i> Berhenti Mengikuti
                                                                            </button>
                                                                        </form>
                                                                    </li>
                                                                @else
                                                                    <li>
                                                                        <form action="{{ route('dashboard.follow', $story->user_id) }}" method="POST">
                                                                            @csrf
                                                                            <button type="submit" class="dropdown-item">
                                                                                <i class="fas fa-user-plus me-2"></i> Ikuti
                                                                            </button>
                                                                        </form>
                                                                    </li>
                                                                @endif
                                                            @endif
                                                        @endrole
                                                        @role('moderator')
                                                            <li>
                                                                <form action="{{ route('stories.destroy', $story) }}" method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="dropdown-item text-danger">
                                                                        <i class="fas fa-trash-alt me-2"></i> Hapus
                                                                    </button>
                                                                </form>
                                                            </li>
                                                        @endrole
                                                    @endauth
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="story-content">
                                            <span class="badge-category">{{ $story->category->name }}</span>
                                            <a href="{{ route('stories.show', $story) }}"
                                                class="text-decoration-none">
                                                <h2 class="story-title">{{ $story->title }}</h2>
                                            </a>
                                            <div class="story-meta">
                                                <span>Ditulis oleh:
                                                    @if($story->anonymous)
                                                        Anonim
                                                    @else
                                                        {{ optional($story->user)->name ?? 'Anonim' }}
                                                    @endif
                                                </span> •
                                                <span>{{ $story->created_at->format('d M Y, H:i') }}</span>
                                            </div>
                                            <div class="story-text">
                                                <p>{{ Str::limit(strip_tags($story->content), 200) }}</p>
                                            </div>
                                            <a href="{{ route('stories.show', $story) }}"
                                                class="read-more">Baca selengkapnya <i
                                                    class="fas fa-arrow-right ms-1"></i></a>
                                        </div>
                                        <div class="story-footer">
                                            <div class="vote-buttons">
                                                <form
                                                    action="{{ route('stories.vote', $story) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    <input type="hidden" name="vote_type" value="upvote">
                                                    <button class="vote-btn upvote">
                                                        <i class="fas fa-arrow-up"></i>
                                                        <span>{{ $story->votes()->where('vote_type', 'upvote')->count() }}</span>
                                                    </button>
                                                </form>
                                                <form
                                                    action="{{ route('stories.vote', $story) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    <input type="hidden" name="vote_type" value="downvote">
                                                    <button class="vote-btn downvote">
                                                        <i class="fas fa-arrow-down"></i>
                                                        <span>{{ $story->votes()->where('vote_type', 'downvote')->count() }}</span>
                                                    </button>
                                                </form>
                                            </div>
                                            <div>
                                                <span class="text-muted">
                                                    <i class="fas fa-comment me-1"></i>
                                                    {{ $story->comments->count() }}
                                                    Komentar
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Move this modal inside the loop to ensure $story is defined -->
                                    <!-- Report Modal for each story -->
                                    <div class="modal fade" id="reportModal-{{ $story->id }}" tabindex="-1" aria-labelledby="reportModalLabel-{{ $story->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <form action="{{ route('reports.store') }}" method="POST" class="modal-content">
                                                @csrf
                                                <input type="hidden" name="story_id" value="{{ $story->id }}">

                                                <div class="modal-header">
                                                <h5 class="modal-title" id="reportModalLabel-{{ $story->id }}">Pilih Jenis Laporan</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>

                                                <div class="modal-body">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="reason" id="reasonSpam-{{ $story->id }}" value="Spam" checked>
                                                    <label class="form-check-label" for="reasonSpam-{{ $story->id }}">Spam</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="reason" id="reasonHarassment-{{ $story->id }}" value="Pelecehan / Bullying">
                                                    <label class="form-check-label" for="reasonHarassment-{{ $story->id }}">Pelecehan / Bullying</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="reason" id="reasonPorn-{{ $story->id }}" value="Konten Dewasa">
                                                    <label class="form-check-label" for="reasonPorn-{{ $story->id }}">Konten Dewasa</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="reason" id="reasonOther-{{ $story->id }}" value="Lainnya">
                                                    <label class="form-check-label" for="reasonOther-{{ $story->id }}">Lainnya</label>
                                                </div>
                                                <textarea
                                                    name="other_reason"
                                                    id="otherReasonText-{{ $story->id }}"
                                                    class="form-control mt-2 d-none"
                                                    placeholder="Jelaskan alasanmu..."
                                                ></textarea>
                                            </div>

                                            <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-danger">Kirim Laporan</button>
                                            </div>
                                        </form>
                                        </div>
                                    </div>
                                @empty
                                    <div class="alert alert-info">
                                        <p class="mb-0">Belum ada cerita untuk kategori {{ $popularCategory->name }}.</p>
                                    </div>
                                @endforelse

                                <div class="mt-4 d-flex justify-content-center">
                                    {{ $categoryStories->links() }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Right Sidebar - Trending -->
            <div class="col-lg-3">
                <h4 class="mb-3"><i class="fas fa-fire text-danger me-2"></i>Cerita Trending</h4>
                <div class="card mb-4 fade-in">
                    <div class="card-body p-0">
                        <ul class="list-group">
                            @forelse($trendingStories as $index => $trendingStory)
                                <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                                    <div>
                                        <span class="badge bg-secondary rounded-pill me-2">{{ $index + 1 }}</span>
                                        <a href="{{ route('stories.show', $trendingStory) }}"
                                            class="text-decoration-none">{{ $trendingStory->title }}</a>
                                    </div>
                                    <span class="badge bg-light text-dark">{{ $trendingStory->votes_count }} <i
                                            class="fas fa-thumbs-up ms-1"></i></span>
                                </li>
                            @empty
                                <li class="list-group-item border-0 border-bottom">
                                    <p class="mb-0 text-muted">Belum ada cerita trending.</p>
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>

                <h4 class="mb-3"><i class="fas fa-users me-2 text-success"></i>Penulis Populer</h4>
                <div class="card mb-4 fade-in">
                    <div class="card-body p-0">
                        <ul class="list-group">
                            @forelse($popularAuthors as $author)
                                <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                                    <div>
                                        <h6 class="mb-0">{{ $author->name }}</h6>
                                        <small class="text-muted">{{ $author->stories_count }} cerita</small>
                                    </div>
                                </li>
                            @empty
                                <li class="list-group-item border-0 border-bottom">
                                    <p class="mb-0 text-muted">Belum ada penulis populer.</p>
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <h5 class="fw-bold mb-4"><i class="fas fa-book-open me-2 text-primary"></i>JejakCerita</h5>
                    <p class="text-muted">Platform berbagi cerita terpopuler di Indonesia. Temukan inspirasi dan bagikan
                        kisahmu dengan ribuan pembaca di seluruh negeri.</p>
                </div>
            </div>
            <div class="border-top mt-4 pt-4 text-center">
                <p class="text-muted small mb-0">Copyright &copy; 2025 JejakCerita | Angkasa Raya (10122184).</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/script.js') }}"></script>
</body>

</html>
