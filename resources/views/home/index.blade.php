<!DOCTYPE html>
<html lang="id" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JejakCerita - Platform Berbagi Cerita</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /*
         * Blok style ini penting untuk mendukung fungsionalitas yang digerakkan oleh script.js,
         * seperti animasi sidebar, dark mode toggle, dan status vote,
         * yang tidak bisa ditangani hanya dengan class Bootstrap statis.
         */
        body {
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* Sidebar & Overlay */
        .sidebar {
            width: 280px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: -280px; /* Posisi awal di luar layar */
            z-index: 1050;
            transition: left 0.4s ease;
            overflow-y: auto;
        }
        .sidebar.active {
            left: 0; /* Posisi aktif di dalam layar */
        }
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1040;
            display: none; /* Diatur oleh JS */
        }

        /* Dark Mode Toggle */
        .dark-mode-toggle .toggle-circle { transition: left 0.3s ease; }
        .dark-mode-toggle.active .toggle-circle { left: 30px !important; }
        [data-bs-theme="light"] .dark-mode-toggle { background-color: #ddd; }
        [data-bs-theme="light"] .dark-mode-toggle.active { background-color: #5271ff !important; }
        [data-bs-theme="dark"] .dark-mode-toggle { background-color: #3e3e3e; }
        [data-bs-theme="dark"] .dark-mode-toggle.active { background-color: #6e86ff !important; }

        /* Card Hover Effect */
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        [data-bs-theme="dark"] .card:hover {
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        /* Vote Buttons State */
        .vote-btn.voted-up {
            color: #4CAF50 !important;
            background-color: rgba(76, 175, 80, 0.1) !important;
        }
        .vote-btn.voted-down {
            color: #F44336 !important;
            background-color: rgba(244, 67, 54, 0.1) !important;
        }

        /* Animations */
        .fade-in {
            opacity: 0; /* Initial state for JS */
        }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    </style>
</head>

<body class="bg-body text-body">
    <nav class="navbar navbar-expand-lg sticky-top bg-body-tertiary shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ route('home') }}">
                <i class="fas fa-book-open me-2 text-primary"></i>
                JejakCerita
            </a>
            <div class="d-flex align-items-center">
                <div class="dark-mode-toggle me-3" id="darkModeToggle" style="width: 56px; height: 28px; border-radius: 14px; position: relative; cursor: pointer; display: flex; align-items: center; justify-content: space-between; padding: 0 6px;">
                    <i class="fas fa-sun toggle-icons" style="color: #333;"></i>
                    <i class="fas fa-moon toggle-icons moon" style="color: white;"></i>
                    <div class="toggle-circle" style="position: absolute; width: 22px; height: 22px; border-radius: 50%; background-color: white; left: 3px;"></div>
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

    @if(session('success'))
        <div class="alert alert-success m-3">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger m-3">
            {{ session('error') }}
        </div>
    @endif

    <div class="sidebar bg-body-tertiary shadow-lg" id="sidebar">
        <div class="p-4">
            <h5 class="mb-4 fw-bold">Menu</h5>
            <ul class="list-group list-group-flush">
                <a href="{{ route('home') }}" class="list-group-item list-group-item-action bg-transparent"><i class="fas fa-home me-2"></i> Beranda</a>
                <a href="{{ route('stories.create') }}" class="list-group-item list-group-item-action bg-transparent"><i class="fas fa-plus-circle me-2"></i> Tulis Cerita</a>
            </ul>
            @auth
            <h5 class="mb-3 fw-bold mt-4">Akun</h5>
            <ul class="list-group list-group-flush">
                <a href="{{ route('profile.edit') }}" class="list-group-item list-group-item-action bg-transparent"><i class="fas fa-cog me-2"></i> Pengaturan</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                     <a href="{{ route('logout') }}" class="list-group-item list-group-item-action bg-transparent text-danger" onclick="event.preventDefault(); this.closest('form').submit();">
                        <i class="fas fa-sign-out-alt me-2"></i> Keluar
                    </a>
                </form>
            </ul>
            @endauth
        </div>
    </div>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="container py-5" id="mainContent">
        <h4 class="mb-3"><i class="fas fa-clock me-2 text-primary"></i>Cerita Terbaru</h4>
        <div class="mb-4 fade-in">
            <div class="mb-3">
                <div class="overflow-auto">
                    <ul class="nav nav-pills flex-nowrap" id="categoryTabs" role="tablist" style="white-space: nowrap;">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active rounded-pill px-4 py-2 fw-bold me-2" id="all-categories-tab" data-bs-toggle="pill" data-bs-target="#all-categories" type="button" role="tab" aria-controls="all-categories" aria-selected="true" style="flex-shrink: 0;">
                                Semua
                            </button>
                        </li>
                        @foreach($allCategories as $category)
                            <li class="nav-item" role="presentation">
                                <button class="nav-link rounded-pill px-4 py-2 fw-bold me-2" id="category-{{ $category->id }}-tab" data-bs-toggle="pill" data-bs-target="#category-{{ $category->id }}" type="button" role="tab" aria-controls="category-{{ $category->id }}" aria-selected="false" style="flex-shrink: 0;">
                                    {{ $category->name }}
                                    <span class="badge bg-primary rounded-pill ms-1">{{ $category->stories_count }}</span>
                                </button>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-9">
                <div class="tab-content" id="categoryTabsContent">
                    <div class="tab-pane fade show active" id="all-categories" role="tabpanel" aria-labelledby="all-categories-tab">

                        <div class="d-flex justify-content-between align-items-center">
                            <div class="spinner-border text-primary d-none" role="status" id="storiesLoader">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>

                        <div id="storiesContainer">
                            @if($stories->count() > 0)
                                @foreach($stories as $story)
                                    <div class="card fade-in mb-4 border-0 shadow-sm bg-body-tertiary" style="border-radius: 12px; transition: all 0.3s ease;">
                                        <div class="d-flex align-items-center justify-content-between p-3 border-bottom">
                                            <div class="d-flex align-items-center gap-3">
                                                <img src="{{ asset('assets/images/faces/face23.jpg') }}" alt="User Avatar" class="rounded-circle" style="width:40px; height:40px; object-fit:cover;">
                                                <div>
                                                    <div class="fw-bold">
                                                        @if($story->anonymous) Anonim @else {{ optional($story->user)->name ?? 'Pengunjung' }} @endif
                                                    </div>
                                                    <div class="text-muted small d-flex align-items-center">
                                                        <span>{{ $story->created_at->diffForHumans() }}</span>
                                                        <span class="ms-3"><i class="fas fa-eye me-1"></i>{{ $story->views_count ?? 0 }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="dropdown">
                                                @if($story->votes()->where('vote_type', 'like')->count() > 10)
                                                    <span class="badge bg-danger rounded-pill me-2"><i class="fas fa-fire me-1"></i> Trending</span>
                                                @endif
                                                <button class="btn btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    @guest
                                                        <li><button disabled class="dropdown-item"><i class="fas fa-user-plus me-2"></i> Ikuti</button></li>
                                                        <li><button disabled class="dropdown-item"><i class="fas fa-exclamation-circle me-2"></i> Laporkan</button></li>
                                                    @endguest
                                                    @auth
                                                        @role('user')
                                                            @if(Auth::id() != $story->user_id && $story->user_id)
                                                                <li><button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#reportModal-{{ $story->id }}"><i class="fas fa-exclamation-circle me-2"></i> Laporkan</button></li>
                                                                @if(isset($isFollowing[$story->user_id]) && $isFollowing[$story->user_id])
                                                                    <li><form action="{{ route('dashboard.unfollow', $story->user_id) }}" method="POST">@csrf<button type="submit" class="dropdown-item"><i class="fas fa-user-minus me-2"></i> Berhenti Mengikuti</button></form></li>
                                                                @else
                                                                    <li><form action="{{ route('dashboard.follow', $story->user_id) }}" method="POST">@csrf<button type="submit" class="dropdown-item"><i class="fas fa-user-plus me-2"></i> Ikuti</button></form></li>
                                                                @endif
                                                            @endif
                                                        @endrole
                                                    @endauth
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="p-3">
                                            <span class="badge rounded-pill bg-primary-subtle text-primary fw-medium px-3 py-2 mb-2">{{ $story->category->name }}</span>
                                            <a href="{{ route('stories.show', $story) }}" class="text-decoration-none">
                                                <h2 class="h5 card-title fw-bold text-body">{{ $story->title }}</h2>
                                            </a>
                                            <div class="small text-muted mb-2">
                                                <span>Ditulis sejak: {{ $story->created_at->format('d M Y') }}</span>
                                            </div>
                                            <div class="mb-3" style="line-height: 1.6;">
                                                <p>{{ Str::limit(strip_tags((new \Parsedown())->text($story->content))) }}</p>
                                            </div>
                                            <a href="{{ route('stories.show', $story) }}" class="text-primary fw-semibold text-decoration-none">Baca selengkapnya <i class="fas fa-arrow-right ms-1"></i></a>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between p-3 border-top">
                                            <div class="d-flex align-items-center gap-3">
                                                <form action="{{ route('stories.vote', $story) }}" method="POST" class="d-inline-flex align-items-center gap-2">
                                                    @csrf
                                                    <input type="hidden" name="vote_type" value="upvote">
                                                    <button type="submit" class="btn btn-sm btn-light rounded-pill vote-btn upvote @if(Auth::check() && $story->userVote && $story->userVote->vote_type == 'upvote') voted-up @endif">
                                                        <i class="fas fa-arrow-up"></i>
                                                        <span>{{ $story->votes()->where('vote_type', 'upvote')->count() }}</span>
                                                    </button>
                                                    <span class="text-muted small">Upvote</span>
                                                </form>
                                                <form action="{{ route('stories.vote', $story) }}" method="POST" class="d-inline-flex align-items-center gap-2">
                                                    @csrf
                                                    <input type="hidden" name="vote_type" value="downvote">
                                                    <button type="submit" class="btn btn-sm btn-light rounded-pill vote-btn downvote @if(Auth::check() && $story->userVote && $story->userVote->vote_type == 'downvote') voted-down @endif">
                                                        <i class="fas fa-arrow-down"></i>
                                                        <span>{{ $story->votes()->where('vote_type', 'downvote')->count() }}</span>
                                                    </button>
                                                    <span class="text-muted small">Downvote</span>
                                                </form>
                                            </div>
                                            <div>
                                                <span class="text-muted"><i class="fas fa-comment me-1"></i>{{ $story->comments->count() }} Komentar</span>
                                            </div>
                                        </div>
                                    </div>

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
                                                    <div class="form-check"><input class="form-check-input" type="radio" name="reason" id="reasonSpam-{{ $story->id }}" value="Spam" checked><label class="form-check-label" for="reasonSpam-{{ $story->id }}">Spam</label></div>
                                                    <div class="form-check"><input class="form-check-input" type="radio" name="reason" id="reasonHarassment-{{ $story->id }}" value="Pelecehan / Bullying"><label class="form-check-label" for="reasonHarassment-{{ $story->id }}">Pelecehan / Bullying</label></div>
                                                    <div class="form-check"><input class="form-check-input" type="radio" name="reason" id="reasonKebencian-{{ $story->id }}" value="Ujaran Kebencian"><label class="form-check-label" for="reasonKebencian-{{ $story->id }}">Ujaran Kebencian</label></div>
                                                    <div class="form-check"><input class="form-check-input" type="radio" name="reason" id="reasonPalsu-{{ $story->id }}" value="Informasi Palsu"><label class="form-check-label" for="reasonPalsu-{{ $story->id }}">Informasi Palsu</label></div>
                                                    <div class="form-check"><input class="form-check-input" type="radio" name="reason" id="reasonKekerasan-{{ $story->id }}" value="Kekerasan"><label class="form-check-label" for="reasonKekerasan-{{ $story->id }}">Kekerasan</label></div>
                                                </div>
                                                <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-danger">Kirim Laporan</button></div>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach

                                <div class="mt-4 d-flex justify-content-center">
                                    {{ $stories->links() }}
                                </div>
                                <div class="text-center mt-2">
                                    <small class="text-muted">
                                        Showing {{ $stories->firstItem() }} to {{ $stories->lastItem() }} of {{ $stories->total() }} results
                                    </small>
                                </div>
                            @else
                                <div class="alert alert-info"><p class="mb-0">Belum ada cerita tersedia.</p></div>
                            @endif
                        </div>
                    </div>

                    @foreach($allCategories as $category)
                        <div class="tab-pane fade" id="category-{{ $category->id }}" role="tabpanel" aria-labelledby="category-{{ $category->id }}-tab">
                            <div class="d-flex justify-content-between align-items-center"><div class="spinner-border text-primary d-none" role="status"><span class="visually-hidden">Loading...</span></div></div>
                            <div id="category-{{ $category->id }}-container">
                                @php
                                    $categoryStories = App\Models\Story::where('category_id', $category->id)->withCount('views')->where('status', 'approved')->latest('created_at')->paginate(5);
                                @endphp
                                @forelse($categoryStories as $story)
                                    <div class="card fade-in mb-4 border-0 shadow-sm bg-body-tertiary" style="border-radius: 12px; transition: all 0.3s ease;">
                                        <div class="d-flex align-items-center justify-content-between p-3 border-bottom">
                                            <div class="d-flex align-items-center gap-3">
                                                <img src="{{ asset('assets/images/faces/face23.jpg') }}" alt="User Avatar" class="rounded-circle" style="width:40px; height:40px; object-fit:cover;">
                                                <div>
                                                    <div class="fw-bold">
                                                        @if($story->anonymous) Anonim @else {{ optional($story->user)->name ?? 'Pengunjung' }} @endif
                                                    </div>
                                                    <div class="text-muted small d-flex align-items-center">
                                                        <span>{{ $story->created_at->diffForHumans() }}</span>
                                                        <span class="ms-3"><i class="fas fa-eye me-1"></i>{{ $story->views_count ?? 0 }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="dropdown">
                                                @if($story->votes()->where('vote_type', 'like')->count() > 10)
                                                    <span class="badge bg-danger rounded-pill me-2"><i class="fas fa-fire me-1"></i> Trending</span>
                                                @endif
                                                <button class="btn btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    @guest
                                                        <li><button disabled class="dropdown-item"><i class="fas fa-user-plus me-2"></i> Ikuti</button></li>
                                                        <li><button disabled class="dropdown-item"><i class="fas fa-exclamation-circle me-2"></i> Laporkan</button></li>
                                                    @endguest
                                                    @auth
                                                        @role('user')
                                                            @if(Auth::id() != $story->user_id && $story->user_id)
                                                                <li><button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#reportModal-{{ $story->id }}"><i class="fas fa-exclamation-circle me-2"></i> Laporkan</button></li>
                                                                @if(isset($isFollowing[$story->user_id]) && $isFollowing[$story->user_id])
                                                                    <li><form action="{{ route('dashboard.unfollow', $story->user_id) }}" method="POST">@csrf<button type="submit" class="dropdown-item"><i class="fas fa-user-minus me-2"></i> Berhenti Mengikuti</button></form></li>
                                                                @else
                                                                    <li><form action="{{ route('dashboard.follow', $story->user_id) }}" method="POST">@csrf<button type="submit" class="dropdown-item"><i class="fas fa-user-plus me-2"></i> Ikuti</button></form></li>
                                                                @endif
                                                            @endif
                                                        @endrole
                                                    @endauth
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="p-3">
                                            <a href="{{ route('stories.show', $story) }}" class="text-decoration-none">
                                                <h2 class="h5 card-title fw-bold text-body">{{ $story->title }}</h2>
                                            </a>
                                            <div class="small text-muted mb-2">
                                                <span>Ditulis sejak: {{ $story->created_at->format('d M Y') }}</span>
                                            </div>
                                            <div class="mb-3" style="line-height: 1.6;">
                                                <p>{{ Str::limit(strip_tags((new \Parsedown())->text($story->content))) }}</p>
                                            </div>
                                            <a href="{{ route('stories.show', $story) }}" class="text-primary fw-semibold text-decoration-none">Baca selengkapnya <i class="fas fa-arrow-right ms-1"></i></a>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between p-3 border-top">
                                            <div class="d-flex align-items-center gap-3">
                                                <form action="{{ route('stories.vote', $story) }}" method="POST" class="d-inline-flex align-items-center gap-2">
                                                    @csrf
                                                    <input type="hidden" name="vote_type" value="upvote">
                                                    <button type="submit" class="btn btn-sm btn-light rounded-pill vote-btn upvote @if(Auth::check() && $story->userVote && $story->userVote->vote_type == 'upvote') voted-up @endif">
                                                        <i class="fas fa-arrow-up"></i>
                                                        <span>{{ $story->votes()->where('vote_type', 'upvote')->count() }}</span>
                                                    </button>
                                                    <span class="text-muted small">Upvote</span>
                                                </form>
                                                <form action="{{ route('stories.vote', $story) }}" method="POST" class="d-inline-flex align-items-center gap-2">
                                                    @csrf
                                                    <input type="hidden" name="vote_type" value="downvote">
                                                    <button type="submit" class="btn btn-sm btn-light rounded-pill vote-btn downvote @if(Auth::check() && $story->userVote && $story->userVote->vote_type == 'downvote') voted-down @endif">
                                                        <i class="fas fa-arrow-down"></i>
                                                        <span>{{ $story->votes()->where('vote_type', 'downvote')->count() }}</span>
                                                    </button>
                                                    <span class="text-muted small">Downvote</span>
                                                </form>
                                            </div>
                                            <div>
                                                <span class="text-muted"><i class="fas fa-comment me-1"></i>{{ $story->comments->count() }} Komentar</span>
                                            </div>
                                        </div>
                                    </div>

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
                                                    <div class="form-check"><input class="form-check-input" type="radio" name="reason" id="reasonSpam-{{ $story->id }}" value="Spam" checked><label class="form-check-label" for="reasonSpam-{{ $story->id }}">Spam</label></div>
                                                    <div class="form-check"><input class="form-check-input" type="radio" name="reason" id="reasonHarassment-{{ $story->id }}" value="Pelecehan / Bullying"><label class="form-check-label" for="reasonHarassment-{{ $story->id }}">Pelecehan / Bullying</label></div>
                                                    <div class="form-check"><input class="form-check-input" type="radio" name="reason" id="reasonPorn-{{ $story->id }}" value="Konten Dewasa"><label class="form-check-label" for="reasonPorn-{{ $story->id }}">Konten Dewasa</label></div>
                                                    <div class="form-check"><input class="form-check-input" type="radio" name="reason" id="reasonOther-{{ $story->id }}" value="Lainnya"><label class="form-check-label" for="reasonOther-{{ $story->id }}">Lainnya</label></div>
                                                    <textarea name="other_reason" id="otherReasonText-{{ $story->id }}" class="form-control mt-2 d-none" placeholder="Jelaskan alasanmu..."></textarea>
                                                </div>
                                                <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-danger">Kirim Laporan</button></div>
                                            </form>
                                        </div>
                                    </div>
                                @empty
                                    <div class="alert alert-info"><p class="mb-0">Belum ada cerita untuk kategori {{ $category->name }}.</p></div>
                                @endforelse
                                <div class="mt-4 d-flex justify-content-center">
                                    {{ $stories->links() }}
                                </div>
                                <div class="text-center mt-2">
                                    <small class="text-muted">
                                        Showing {{ $stories->firstItem() }} to {{ $stories->lastItem() }} of {{ $stories->total() }} results
                                    </small>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-lg-3">
                <h4 class="mb-3"><i class="fas fa-fire text-danger me-2"></i>Cerita Trending</h4>
                <div class="card mb-4 fade-in border-0 shadow-sm bg-body-tertiary" style="border-radius: 12px; transition: all 0.3s ease;">
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            @forelse($trendingStories as $index => $trendingStory)
                                <li class="list-group-item d-flex justify-content-between align-items-center py-3 bg-transparent">
                                    <div>
                                        <span class="badge bg-secondary rounded-pill me-2">{{ $index + 1 }}</span>
                                        <a href="{{ route('stories.show', $trendingStory) }}" class="text-decoration-none text-body">{{ $trendingStory->title }}</a>
                                    </div>
                                    <span class="badge bg-light text-dark">{{ $trendingStory->votes()->where('vote_type', 'upvote')->count() }} <i class="fas fa-thumbs-up ms-1"></i></span>
                                </li>
                            @empty
                                <li class="list-group-item border-0 border-bottom bg-transparent"><p class="mb-0 text-muted">Belum ada cerita trending.</p></li>
                            @endforelse
                        </ul>
                    </div>
                </div>

                <h4 class="mb-3"><i class="fas fa-users me-2 text-success"></i>Penulis Populer</h4>
                <div class="card mb-4 fade-in border-0 shadow-sm bg-body-tertiary" style="border-radius: 12px; transition: all 0.3s ease;">
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            @forelse($popularAuthors as $author)
                                <li class="list-group-item d-flex justify-content-between align-items-center py-3 bg-transparent">
                                    <div>
                                        {{-- MODIFICATION START --}}
                                        <h6 class="mb-0">{{ $author->name ?? 'Anonim' }}</h6>
                                        {{-- MODIFICATION END --}}
                                        <small class="text-muted">{{ $author->stories_count }} cerita</small>
                                    </div>
                                </li>
                            @empty
                                <li class="list-group-item border-0 border-bottom bg-transparent"><p class="mb-0 text-muted">Belum ada penulis populer.</p></li>
                            @endforelse
                        </ul>
                    </div>
                </div>

                <h4 class="mb-3"><i class="fas fa-list-alt me-2 text-success"></i>Kategori Populer</h4>
                <div class="card mb-4 fade-in border-0 shadow-sm bg-body-tertiary" style="border-radius: 12px; transition: all 0.3s ease;">
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            @forelse($popularCategoriesByViews as $index => $category)
                                <a href="{{ route('home', ['category' => $category->slug]) }}" class="list-group-item d-flex justify-content-between align-items-center py-3 bg-transparent">
                                    <div>
                                        <span class="badge bg-secondary rounded-pill me-2">{{ $index + 1 }}</span>
                                        <small class="text-muted">{{ $category->name }}</small>
                                    </div>
                                    <span class="badge bg-light text-dark">{{ number_format($category->total_views) }} kali dibaca</span>
                                </a>
                            @empty
                                <li class="list-group-item border-0 border-bottom bg-transparent"><p class="mb-0 text-muted">Belum ada kategori populer.</p></li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <h4 class="mb-3"><i class="fas fa-chart-line me-2 text-success"></i>Cerita Populer</h4>
        <div class="mb-4 fade-in">
            <div class="mb-3">
                <div class="overflow-auto">
                    <ul class="nav nav-pills flex-nowrap" id="popularTabs" role="tablist" style="white-space: nowrap;">
                        <li class="nav-item" role="presentation"><button class="nav-link active rounded-pill px-4 py-2 fw-bold me-2" id="harian-populer-tab" data-bs-toggle="pill" data-bs-target="#harian-populer" type="button" role="tab" aria-controls="harian-populer" aria-selected="false" style="flex-shrink: 0;">Harian</button></li>
                        <li class="nav-item" role="presentation"><button class="nav-link rounded-pill px-4 py-2 fw-bold me-2" id="mingguan-populer-tab" data-bs-toggle="pill" data-bs-target="#mingguan-populer" type="button" role="tab" aria-controls="mingguan-populer" aria-selected="false" style="flex-shrink: 0;">Mingguan</button></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-lg-9">
            <div class="tab-content" id="popularTabsContent">
                <div class="tab-pane fade show active" id="harian-populer" role="tabpanel" aria-labelledby="harian-populer-tab">
                    <div class="d-flex justify-content-between align-items-center"><div class="spinner-border text-primary d-none" role="status" id="storiesLoader"><span class="visually-hidden">Loading...</span></div></div>
                    <div id="popularDailyContainer">
                        @if($popularStoriesDaily->count() > 0)
                            @foreach($popularStoriesDaily as $story)
                                <div class="card fade-in mb-4 border-0 shadow-sm bg-body-tertiary" style="border-radius: 12px; transition: all 0.3s ease;">
                                    <div class="d-flex align-items-center justify-content-between p-3 border-bottom">
                                        <div class="d-flex align-items-center gap-3">
                                            <img src="{{ asset('assets/images/faces/face23.jpg') }}" alt="User Avatar" class="rounded-circle" style="width:40px; height:40px; object-fit:cover;">
                                            <div>
                                                <div class="fw-bold">
                                                    @if($story->anonymous) Anonim @else {{ optional($story->user)->name ?? 'Pengunjung' }} @endif
                                                </div>
                                                <div class="text-muted small d-flex align-items-center">
                                                    <span>{{ $story->created_at->diffForHumans() }}</span>
                                                    <span class="ms-3"><i class="fas fa-eye me-1"></i>{{ $story->views_count ?? 0 }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="dropdown">
                                            @if($story->votes()->where('vote_type', 'like')->count() > 10)
                                                <span class="badge bg-danger rounded-pill me-2"><i class="fas fa-fire me-1"></i> Trending</span>
                                            @endif
                                            <button class="btn btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                @guest
                                                    <li><button disabled class="dropdown-item"><i class="fas fa-user-plus me-2"></i> Ikuti</button></li>
                                                    <li><button disabled class="dropdown-item"><i class="fas fa-exclamation-circle me-2"></i> Laporkan</button></li>
                                                @endguest
                                                @auth
                                                    @role('user')
                                                        @if(Auth::id() != $story->user_id && $story->user_id)
                                                            <li><button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#reportModal-{{ $story->id }}"><i class="fas fa-exclamation-circle me-2"></i> Laporkan</button></li>
                                                            @if(isset($isFollowing[$story->user_id]) && $isFollowing[$story->user_id])
                                                                <li><form action="{{ route('dashboard.unfollow', $story->user_id) }}" method="POST">@csrf<button type="submit" class="dropdown-item"><i class="fas fa-user-minus me-2"></i> Berhenti Mengikuti</button></form></li>
                                                            @else
                                                                <li><form action="{{ route('dashboard.follow', $story->user_id) }}" method="POST">@csrf<button type="submit" class="dropdown-item"><i class="fas fa-user-plus me-2"></i> Ikuti</button></form></li>
                                                            @endif
                                                        @endif
                                                    @endrole
                                                @endauth
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="p-3">
                                        <span class="badge rounded-pill bg-primary-subtle text-primary fw-medium px-3 py-2 mb-2">{{ $story->category->name }}</span>
                                        <a href="{{ route('stories.show', $story) }}" class="text-decoration-none">
                                            <h2 class="h5 card-title fw-bold text-body">{{ $story->title }}</h2>
                                        </a>
                                        <div class="small text-muted mb-2">
                                            <span>Ditulis sejak: {{ $story->created_at->format('d M Y') }}</span>
                                        </div>
                                        <div class="mb-3" style="line-height: 1.6;">
                                            <p>{{ Str::limit(strip_tags((new \Parsedown())->text($story->content))) }}</p>
                                        </div>
                                        <a href="{{ route('stories.show', $story) }}" class="text-primary fw-semibold text-decoration-none">Baca selengkapnya <i class="fas fa-arrow-right ms-1"></i></a>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between p-3 border-top">
                                        <div class="d-flex align-items-center gap-3">
                                            <form action="{{ route('stories.vote', $story) }}" method="POST" class="d-inline-flex align-items-center gap-2">
                                                @csrf
                                                <input type="hidden" name="vote_type" value="upvote">
                                                <button type="submit" class="btn btn-sm btn-light rounded-pill vote-btn upvote @if(Auth::check() && $story->userVote && $story->userVote->vote_type == 'upvote') voted-up @endif">
                                                    <i class="fas fa-arrow-up"></i>
                                                    <span>{{ $story->votes()->where('vote_type', 'upvote')->count() }}</span>
                                                </button>
                                                <span class="text-muted small">Upvote</span>
                                            </form>
                                            <form action="{{ route('stories.vote', $story) }}" method="POST" class="d-inline-flex align-items-center gap-2">
                                                @csrf
                                                <input type="hidden" name="vote_type" value="downvote">
                                                <button type="submit" class="btn btn-sm btn-light rounded-pill vote-btn downvote @if(Auth::check() && $story->userVote && $story->userVote->vote_type == 'downvote') voted-down @endif">
                                                    <i class="fas fa-arrow-down"></i>
                                                    <span>{{ $story->votes()->where('vote_type', 'downvote')->count() }}</span>
                                                </button>
                                                <span class="text-muted small">Downvote</span>
                                            </form>
                                        </div>
                                        <span class="text-muted"><i class="fas fa-comment me-1"></i>{{ $story->comments->count() }} Komentar</span>
                                    </div>
                                </div>
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
                                                <div class="form-check"><input class="form-check-input" type="radio" name="reason" id="reasonSpam-{{ $story->id }}" value="Spam" checked><label class="form-check-label" for="reasonSpam-{{ $story->id }}">Spam</label></div>
                                                <div class="form-check"><input class="form-check-input" type="radio" name="reason" id="reasonHarassment-{{ $story->id }}" value="Pelecehan / Bullying"><label class="form-check-label" for="reasonHarassment-{{ $story->id }}">Pelecehan / Bullying</label></div>
                                                <div class="form-check"><input class="form-check-input" type="radio" name="reason" id="reasonPorn-{{ $story->id }}" value="Konten Dewasa"><label class="form-check-label" for="reasonPorn-{{ $story->id }}">Konten Dewasa</label></div>
                                                <div class="form-check"><input class="form-check-input" type="radio" name="reason" id="reasonOther-{{ $story->id }}" value="Lainnya"><label class="form-check-label" for="reasonOther-{{ $story->id }}">Lainnya</label></div>
                                                <textarea name="other_reason" id="otherReasonText-{{ $story->id }}" class="form-control mt-2 d-none" placeholder="Jelaskan alasanmu..."></textarea>
                                            </div>
                                            <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-danger">Kirim Laporan</button></div>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="alert alert-info"><p class="mb-0">Belum ada cerita populer hari ini.</p></div>
                        @endif
                    </div>
                </div>

                <div class="tab-pane fade" id="mingguan-populer" role="tabpanel" aria-labelledby="mingguan-populer-tab">
                    <div class="d-flex justify-content-between align-items-center"><div class="spinner-border text-primary d-none" role="status" id="storiesLoader"><span class="visually-hidden">Loading...</span></div></div>
                    <div id="popularWeeklyContainer">
                        @if($popularStoriesWeekly->count() > 0)
                            @foreach($popularStoriesWeekly as $story)
                                <div class="card fade-in mb-4 border-0 shadow-sm bg-body-tertiary" style="border-radius: 12px; transition: all 0.3s ease;">
                                    <div class="d-flex align-items-center justify-content-between p-3 border-bottom">
                                        <div class="d-flex align-items-center gap-3">
                                            <img src="{{ asset('assets/images/faces/face23.jpg') }}" alt="User Avatar" class="rounded-circle" style="width:40px; height:40px; object-fit:cover;">
                                            <div>
                                                <div class="fw-bold">
                                                    @if($story->anonymous) Anonim @else {{ optional($story->user)->name ?? 'Pengunjung' }} @endif
                                                </div>
                                                <div class="text-muted small d-flex align-items-center">
                                                    <span>{{ $story->created_at->diffForHumans() }}</span>
                                                    <span class="ms-3"><i class="fas fa-eye me-1"></i>{{ $story->views_count ?? 0 }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="dropdown">
                                            @if($story->votes()->where('vote_type', 'like')->count() > 10)
                                                <span class="badge bg-danger rounded-pill me-2"><i class="fas fa-fire me-1"></i> Trending</span>
                                            @endif
                                            <button class="btn btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                @guest
                                                    <li><button disabled class="dropdown-item"><i class="fas fa-user-plus me-2"></i> Ikuti</button></li>
                                                    <li><button disabled class="dropdown-item"><i class="fas fa-exclamation-circle me-2"></i> Laporkan</button></li>
                                                @endguest
                                                @auth
                                                    @role('user')
                                                        @if(Auth::id() != $story->user_id && $story->user_id)
                                                            <li><button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#reportModal-{{ $story->id }}"><i class="fas fa-exclamation-circle me-2"></i> Laporkan</button></li>
                                                            @if(isset($isFollowing[$story->user_id]) && $isFollowing[$story->user_id])
                                                                <li><form action="{{ route('dashboard.unfollow', $story->user_id) }}" method="POST">@csrf<button type="submit" class="dropdown-item"><i class="fas fa-user-minus me-2"></i> Berhenti Mengikuti</button></form></li>
                                                            @else
                                                                <li><form action="{{ route('dashboard.follow', $story->user_id) }}" method="POST">@csrf<button type="submit" class="dropdown-item"><i class="fas fa-user-plus me-2"></i> Ikuti</button></form></li>
                                                            @endif
                                                        @endif
                                                    @endrole
                                                @endauth
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="p-3">
                                        <span class="badge rounded-pill bg-primary-subtle text-primary fw-medium px-3 py-2 mb-2">{{ $story->category->name }}</span>
                                        <a href="{{ route('stories.show', $story) }}" class="text-decoration-none">
                                            <h2 class="h5 card-title fw-bold text-body">{{ $story->title }}</h2>
                                        </a>
                                        <div class="small text-muted mb-2">
                                            <span>Ditulis sejak: {{ $story->created_at->format('d M Y') }}</span>
                                        </div>
                                        <div class="mb-3" style="line-height: 1.6;">
                                            <p>{{ Str::limit(strip_tags((new \Parsedown())->text($story->content))) }}</p>
                                        </div>
                                        <a href="{{ route('stories.show', $story) }}" class="text-primary fw-semibold text-decoration-none">Baca selengkapnya <i class="fas fa-arrow-right ms-1"></i></a>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between p-3 border-top">
                                        <div class="d-flex align-items-center gap-3">
                                            <form action="{{ route('stories.vote', $story) }}" method="POST" class="d-inline-flex align-items-center gap-2">
                                                @csrf
                                                <input type="hidden" name="vote_type" value="upvote">
                                                <button type="submit" class="btn btn-sm btn-light rounded-pill vote-btn upvote @if(Auth::check() && $story->userVote && $story->userVote->vote_type == 'upvote') voted-up @endif">
                                                    <i class="fas fa-arrow-up"></i>
                                                    <span>{{ $story->votes()->where('vote_type', 'upvote')->count() }}</span>
                                                </button>
                                                <span class="text-muted small">Upvote</span>
                                            </form>
                                            <form action="{{ route('stories.vote', $story) }}" method="POST" class="d-inline-flex align-items-center gap-2">
                                                @csrf
                                                <input type="hidden" name="vote_type" value="downvote">
                                                <button type="submit" class="btn btn-sm btn-light rounded-pill vote-btn downvote @if(Auth::check() && $story->userVote && $story->userVote->vote_type == 'downvote') voted-down @endif">
                                                    <i class="fas fa-arrow-down"></i>
                                                    <span>{{ $story->votes()->where('vote_type', 'downvote')->count() }}</span>
                                                </button>
                                                <span class="text-muted small">Downvote</span>
                                            </form>
                                        </div>
                                        <div>
                                            <span class="text-muted"><i class="fas fa-comment me-1"></i>{{ $story->comments->count() }} Komentar</span>
                                        </div>
                                    </div>
                                </div>
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
                                                <div class="form-check"><input class="form-check-input" type="radio" name="reason" id="reasonSpam-{{ $story->id }}" value="Spam" checked><label class="form-check-label" for="reasonSpam-{{ $story->id }}">Spam</label></div>
                                                <div class="form-check"><input class="form-check-input" type="radio" name="reason" id="reasonHarassment-{{ $story->id }}" value="Pelecehan / Bullying"><label class="form-check-label" for="reasonHarassment-{{ $story->id }}">Pelecehan / Bullying</label></div>
                                                <div class="form-check"><input class="form-check-input" type="radio" name="reason" id="reasonPorn-{{ $story->id }}" value="Konten Dewasa"><label class="form-check-label" for="reasonPorn-{{ $story->id }}">Konten Dewasa</label></div>
                                                <div class="form-check"><input class="form-check-input" type="radio" name="reason" id="reasonOther-{{ $story->id }}" value="Lainnya"><label class="form-check-label" for="reasonOther-{{ $story->id }}">Lainnya</label></div>
                                                <textarea name="other_reason" id="otherReasonText-{{ $story->id }}" class="form-control mt-2 d-none" placeholder="Jelaskan alasanmu..."></textarea>
                                            </div>
                                            <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-danger">Kirim Laporan</button></div>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="alert alert-info"><p class="mb-0">Belum ada cerita populer minggu ini.</p></div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-body-tertiary mt-5 py-5 border-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <h5 class="fw-bold mb-4"><i class="fas fa-book-open me-2 text-primary"></i>JejakCerita</h5>
                    <p class="text-muted">Platform berbagi cerita pendek terpopuler di Indonesia. Temukan inspirasi dan bagikan kisahmu dengan ribuan pembaca di seluruh negeri.</p>
                </div>
            </div>
            <div class="border-top mt-4 pt-4 text-center">
                <p class="text-muted small mb-0">Copyright &copy; 2025 JejakCerita | Angkasa Raya (10122184).</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/script.js') }}"></script>
</body>

</html>
