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
                CeritaKita
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
                                <li>
                                    <a class="dropdown-item" href="{{ route('stories.create') }}">
                                        <i class="fas fa-plus me-2"></i> Buat Cerita
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
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
        </div>
    </div>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Detail View (Hidden by Default) -->
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-9 mx-auto">
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" onclick="hideDetail()" class="text-decoration-none">Beranda</a></li>
                        <li class="breadcrumb-item">{{ $story->category->name }}</li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $story->title }}</li>
                    </ol>
                </nav>

                <div class="story-detail slide-up">
                    @if($story->is_sensitive)
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                            <p class="font-bold">Konten Sensitif</p>
                            <p>Cerita ini mengandung konten yang mungkin tidak sesuai untuk semua pembaca.</p>
                        </div>
                    @endif
                    <div class="story-detail-header">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="badge-category">{{ $story->category->name }}</span>
                        </div>

                        <h1 class="mb-3">{{ $story->title }}</h1>

                        <div class="d-flex align-items-center mb-4">
                            <img src="{{ asset('assets/images/faces/face23.jpg') }}" alt="User Avatar" class="avatar me-3">
                            <div>
                                <div class="fw-bold">
                                    @if($story->anonymous)
                                        Anonim
                                    @else
                                        {{ optional($story->user)->name ?? 'Anonim' }}
                                    @endif
                                </div>
                                <div class="text-muted small">{{ $story->published_at ? $story->published_at->format('d M Y, H:i') : $story->created_at->format('d M Y, H:i') }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="story-content">
                        <p>{{ $story->content }}</p>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-5 py-3 border-top border-bottom">
                        <div class="vote-buttons">
                        </div>
                        <div>
                            <button class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-share me-1"></i> Bagikan
                            </button>
                        </div>
                    </div>

                    <!-- Comments Section -->
                    <div class="comment-section">
                        <h3 class="mb-4">Komentar ({{ $story->comments->count() }})</h3>

                        <!-- Comment Form -->
                        <div class="comment-form card mb-4">
                            <div class="card-body">
                                <form action="{{ route('comments.store', $story) }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="content" class="form-label">Tambahkan Komentar:</label>
                                        <textarea id="content" name="content" class="form-control" rows="3"
                                            placeholder="Tulis komentar Anda di sini..."></textarea>
                                    </div>
                                    <div class="mb-3 form-check">
                                        <input type="checkbox" name="anonymous" class="form-check-input">
                                        <label class="form-check-label">Komentari sebagai
                                            anonim</label>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Kirim Komentar</button>
                                </form>
                            </div>
                        </div>

                        <!-- Comments List -->
                        <div class="comment-list">
                            <!-- Comment 1 -->
                            @forelse($story->comments->where('parent_id', null) as $comment)
                            <div class="card mb-3">
                                <div class="card-body comment">
                                    <div class="comment-header">
                                        <div class="comment-user">{{ $comment->anonymous ? 'Anonim' : $comment->user->name ?? 'Pengunjung' }}</div>
                                        <div class="dropdown">
                                            {{ $comment->created_at->diffForHumans() }}
                                            <button class="btn btn-sm" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            @hasanyrole(['user','moderator'])
                                            <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="inline ml-2">
                                                @csrf
                                                @method('DELETE')
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item text-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus komentar ini?')"><i class="fas fa-trash me-2"></i> Hapus</a>
                                                    </li>
                                                </ul>
                                            </form>
                                            @endhasanyrole
                                        </div>
                                    </div>
                                    <div class="comment-body">
                                        <p>{{ $comment->content }}</p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <button class="btn btn-sm btn-light" onclick="toggleReplyForm('reply-form-1')">
                                            <i class="fas fa-reply me-1"></i> Balas
                                        </button>
                                    </div>

                                    <!-- Reply Form (Hidden by Default) -->
                                    <div id="reply-form-1" class="reply-form mt-3" style="display: none;">
                                        <form action="{{ route('comments.store', $story) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                            <div class="input-group mb-2">
                                                <input type="text" name="content" class="form-control"
                                                    placeholder="Balas komentar ini...">
                                                <button class="btn btn-primary" type="submit">Balas</button>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" name="anonymous" class="form-check-input" id="anonymousReply1">
                                                <label class="form-check-label" for="anonymousReply1">Balas sebagai
                                                    anonim</label>
                                            </div>
                                        </form>
                                    </div>

                                    <!-- Replies -->
                                    @if($comment->replies->count() > 0)
                                    <div class="comment-reply mt-3">
                                        @foreach($comment->replies as $reply)
                                        <div class="comment-header">
                                            <div class="comment-user">{{ $reply->anonymous ? 'Anonim' : $reply->user->name ?? 'Pengunjung' }} <span class="badge bg-info text-white ms-1">Penulis</span></div>
                                            <div class="dropdown">
                                                {{ $reply->created_at->diffForHumans() }}
                                                <button class="btn btn-sm" type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                @hasanyrole(['user','moderator'])
                                                <form action="{{ route('comments.destroy', $reply) }}" method="POST" class="inline ml-2">
                                                    @csrf
                                                    @method('DELETE')
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li><a class="dropdown-item text-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus komentar ini?')"><i class="fas fa-trash me-2"></i> Hapus</a>
                                                        </li>
                                                    </ul>
                                                </form>
                                                @endhasanyrole
                                            </div>
                                        </div>
                                        <div class="comment-body mb-4">
                                            <p>{{ $reply->content }}</p>
                                        </div>
                                        @endforeach
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @empty
                                <p class="text-gray-500 italic">Belum ada komentar. Jadilah yang pertama untuk berkomentar!</p>
                            @endforelse
                        </div>
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
                    <h5 class="fw-bold mb-4"><i class="fas fa-book-open me-2 text-primary"></i>CeritaKita</h5>
                    <p class="text-muted">Platform berbagi cerita terpopuler di Indonesia. Temukan inspirasi dan bagikan
                        kisahmu dengan ribuan pembaca di seluruh negeri.</p>
                </div>
            </div>
            <div class="border-top mt-4 pt-4 text-center">
                <p class="text-muted small mb-0">&copy; 2025 JejakCerpen.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/script.js') }}"></script>
</body>

</html>
