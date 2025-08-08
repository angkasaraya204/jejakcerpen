<!DOCTYPE html>
<html lang="id" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JejakCerita - Platform Berbagi Cerita</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .sidebar {
            width: 280px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: -280px;
            z-index: 1050;
            transition: left 0.4s ease;
            overflow-y: auto;
        }
        .sidebar.active {
            left: 0;
        }
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1040;
            display: none !important;
        }

        .dark-mode-toggle .toggle-circle { transition: left 0.3s ease; }
        .dark-mode-toggle.active .toggle-circle { left: 30px !important; }
        [data-bs-theme="light"] .dark-mode-toggle { background-color: #ddd; }
        [data-bs-theme="light"] .dark-mode-toggle.active { background-color: #5271ff !important; }
        [data-bs-theme="dark"] .dark-mode-toggle { background-color: #3e3e3e; }
        [data-bs-theme="dark"] .dark-mode-toggle.active { background-color: #6e86ff !important; }

        .story-content-parsed h1, .story-content-parsed h2, .story-content-parsed h3 { margin-top: 1.5rem; margin-bottom: 1rem; font-weight: 600; }
        .story-content-parsed p { margin-bottom: 1rem; line-height: 1.7; }
        .story-content-parsed ul, .story-content-parsed ol { padding-left: 2rem; margin-bottom: 1rem; }
        .story-content-parsed blockquote { border-left: 4px solid #ccc; padding-left: 1rem; margin-left: 0; font-style: italic; color: #6c757d; }
        .story-content-parsed a { color: var(--bs-link-color); text-decoration: underline; }

        .slide-up {
            animation: slideUp 0.5s ease forwards;
        }
        @keyframes slideUp {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
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
                                <li>
                                    <a class="dropdown-item" href="{{ route('dashboard') }}">
                                        <i class="fas fa-home me-2"></i> Dasbor
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
        <div class="alert alert-success m-3">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger m-3">{{ session('error') }}</div>
    @endif

    <div class="sidebar bg-body-tertiary shadow-lg" id="sidebar">
        <div class="p-4">
            <h5 class="mb-4 fw-bold">Menu</h5>
            <ul class="list-group list-group-flush">
                <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action bg-transparent"><i class="fas fa-home me-2"></i> Dasbor</a>
            </ul>
            @auth
            <h5 class="mb-3 fw-bold mt-4">Akun</h5>
            <ul class="list-group list-group-flush">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                     <a href="{{ route('logout') }}" class="list-group-item list-group-item-action bg-danger" onclick="event.preventDefault(); this.closest('form').submit();">
                        <i class="fas fa-sign-out-alt me-2"></i> Keluar
                    </a>
                </form>
            </ul>
            @endauth
        </div>
    </div>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="container py-5">
        <div class="row">
            <div class="col-lg-9 mx-auto">
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Beranda</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('categories.show', $story->category->slug) }}" class="text-decoration-none">{{ $story->category->name }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($story->title, 30) }}</li>
                    </ol>
                </nav>

                <div class="bg-body-tertiary p-4 p-md-5 mb-4 shadow-sm slide-up" style="border-radius: 12px;">
                    <div class="d-flex align-items-center mb-4">
                        <img src="{{ asset('assets/images/faces/face23.jpg') }}" alt="User Avatar" class="rounded-circle me-3" style="width:48px; height:48px; object-fit:cover;">
                        <div>
                            <div class="fw-bold">
                                @if($story->anonymous) Anonim @else {{ optional($story->user)->name ?? 'Pengunjung' }} @endif
                            </div>
                            <div class="text-muted small">Ditulis sejak: {{ $story->published_at ? $story->published_at->format('d M Y') : $story->created_at->format('d M Y') }}</div>
                        </div>

                        <div class="ms-auto">
                            <button class="btn btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                @guest
                                    <li><button disabled class="dropdown-item"><i class="fas fa-exclamation-circle me-2"></i> Laporkan</button></li>
                                @endguest
                                @auth
                                    @if(Auth::id() != $story->id && $story->id)
                                        <li><button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#reportModal-{{ $story->id }}"><i class="fas fa-exclamation-circle me-2"></i> Laporkan</button></li>
                                    @endif
                                @endauth
                            </ul>
                        </div>
                    </div>
                    <h1 class="mb-4 h2">{{ $story->title }}</h1>
                    <div class="story-content-parsed py-3 border-top border-bottom">
                        {!! (new \Parsedown())->text($story->content) !!}
                    </div>

                    <div class="mt-5">
                        <h4 class="mb-4">Komentar ({{ $story->comments->count() }})</h4>

                        <div class="card mb-4 border-0">
                            <div class="card-body">
                                @if(Auth::check())
                                <form action="{{ route('comments.store', $story) }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="content" class="form-label visually-hidden">Tambahkan Komentar:</label>
                                        <textarea id="content" name="content" class="form-control" rows="3" placeholder="Tulis komentar Anda di sini..." required></textarea>
                                    </div>
                                    <div class="mb-3 form-check">
                                        <input type="hidden" name="anonymous" value="0">
                                        <input type="checkbox" name="anonymous" value="1" class="form-check-input" id="anonymous-comment" {{ old('anonymous') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="anonymous-comment">Komentari sebagai anonim</label>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Kirim Komentar</button>
                                </form>
                                @else
                                    <a href="{{ route('register') }}" class="btn btn-primary">Daftar untuk Berkomentar</a>
                                @endif
                            </div>
                        </div>

                        <div>
                            @forelse($story->comments->where('parent_id', null) as $comment)
                            <div class="card mb-3 border-0 bg-body">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="fw-bold">
                                            @if($comment->anonymous) Anonim @else {{ optional($comment->user)->name ?? 'Pengunjung' }} @endif
                                        </div>
                                        <div class="d-flex align-items-center text-muted small">
                                            {{ $comment->created_at->diffForHumans() }}
                                            <div class="dropdown ms-2">
                                                <button class="btn btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    @auth
                                                        @if(Auth::id() != $comment->user_id)
                                                            <li><button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#reportCommentModal-{{ $comment->id }}"><i class="fas fa-exclamation-circle me-2"></i> Laporkan</button></li>
                                                        @endif
                                                        @if(Auth::id() == $comment->user_id || Auth::user()->hasRole('admin'))
                                                            <li><form action="{{ route('comments.destroy', $comment) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus komentar ini?')">@csrf @method('DELETE')<button type="submit" class="dropdown-item text-danger"><i class="fas fa-trash me-2"></i> Hapus</button></form></li>
                                                        @endif
                                                    @endauth
                                                    @guest
                                                        <li><button disabled class="dropdown-item"><i class="fas fa-exclamation-circle me-2"></i> Laporkan</button></li>
                                                    @endguest
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        <p class="mb-0">{{ $comment->content }}</p>
                                    </div>
                                </div>
                            </div>
                            @empty
                                <p class="text-muted fst-italic">Belum ada komentar. Jadilah yang pertama untuk berkomentar!</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="reportModal-{{ $story->id }}" tabindex="-1" aria-hidden="true">
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
                        <input class="form-check-input" type="radio" name="reason" value="Spam" checked>
                        <label class="form-check-label">Spam</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="reason" value="Pelecehan / Bullying">
                        <label class="form-check-label">Pelecehan / Bullying</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="reason" value="Ujaran Kebencian">
                        <label class="form-check-label">Ujaran Kebencian</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="reason" value="Informasi Palsu">
                        <label class="form-check-label">Informasi Palsu</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="reason" value="Kekerasan">
                        <label class="form-check-label">Kekerasan</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="reason" value="Lainnya">
                        <label class="form-check-label">Lainnya</label>
                    </div>
                    <textarea name="other_reason" id="otherReasonText-{{ $story->id }}" class="form-control mt-2 d-none" placeholder="Jelaskan alasanmu..."></textarea>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-danger">Kirim Laporan</button>
            </div>
            </form>
        </div>
    </div>

    @foreach($story->comments as $comment)
        <div class="modal fade" id="reportCommentModal-{{ $comment->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <form action="{{ route('reports.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="reportable_id" value="{{ $comment->id }}">
                    <input type="hidden" name="reportable_type" value="comment">
                    <div class="modal-header">
                        <h5 class="modal-title">Pilih Jenis Laporan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="reason" value="Spam" checked>
                            <label class="form-check-label">Spam</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="reason" value="Pelecehan / Bullying">
                            <label class="form-check-label">Pelecehan / Bullying</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="reason" value="Ujaran Kebencian">
                            <label class="form-check-label">Ujaran Kebencian</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="reason" value="Informasi Palsu">
                            <label class="form-check-label">Informasi Palsu</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="reason" value="Kekerasan">
                            <label class="form-check-label">Kekerasan</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="reason" value="Lainnya">
                            <label class="form-check-label">Lainnya</label>
                        </div>
                        <textarea name="other_reason" id="otherReasonText-{{ $story->id }}" class="form-control mt-2 d-none" placeholder="Jelaskan alasanmu..."></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Kirim Laporan</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    @endforeach

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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            const modals = document.querySelectorAll('.modal');
            modals.forEach(modal => {
                modal.addEventListener('show.bs.modal', function() {
                    if (sidebarOverlay) {
                        sidebarOverlay.style.display = 'none';
                    }
                });
                modal.addEventListener('hidden.bs.modal', function() {
                });
                modal.addEventListener('keydown', function(event) {
                    if (event.key === 'Tab') {
                        const focusableElements = modal.querySelectorAll('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');
                        const firstElement = focusableElements[0];
                        const lastElement = focusableElements[focusableElements.length - 1];
                        if (event.shiftKey && document.activeElement === firstElement) { event.preventDefault(); lastElement.focus(); }
                        else if (!event.shiftKey && document.activeElement === lastElement) { event.preventDefault(); firstElement.focus(); }
                    }
                    if (event.key === 'Escape') {
                        const bsModal = bootstrap.Modal.getInstance(modal);
                        if (bsModal) { bsModal.hide(); }
                    }
                });
                modal.addEventListener('change', function(event){
                    if (event.target && event.target.name === 'reason') {
                        const otherReasonText = modal.querySelector('textarea[name="other_reason"]');
                        if (event.target.value === 'Lainnya') {
                            otherReasonText.classList.remove('d-none');
                        } else {
                            otherReasonText.classList.add('d-none');
                        }
                    }
                });
            });
        });
    </script>
</body>

</html>
