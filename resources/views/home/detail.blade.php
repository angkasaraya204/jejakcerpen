<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JejakCerita - Platform Berbagi Cerita</title>
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
                                        {{ optional($story->user)->name ?? 'Pengunjung' }}
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
                                        <!-- Tambahkan hidden field -->
                                        <input type="hidden" name="anonymous" value="0">
                                        <label class="form-check-label">
                                            <input type="checkbox" name="anonymous" value="1" class="form-check-input" {{ old('anonymous') ? 'checked' : '' }}>Komentari sebagai anonim
                                        </label>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Kirim Komentar</button>
                                </form>
                            </div>
                        </div>

                        <!-- Comments List -->
                        <div class="comment-list">
                            @forelse($story->comments->where('parent_id', null) as $comment)
                            <div class="card mb-3">
                                <div class="card-body comment">
                                    <div class="comment-header">
                                        <div class="comment-user">
                                            @if($comment->anonymous)
                                                Anonim
                                            @else
                                                {{ optional($comment->user)->name ?? 'Pengunjung' }}
                                            @endif
                                        </div>
                                        <div class="dropdown">
                                            {{ $comment->created_at->diffForHumans() }}
                                            <button class="btn btn-sm" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                @guest
                                                    <li>
                                                        <button @disabled(true) class="dropdown-item">
                                                            <i class="fas fa-exclamation-circle me-2"></i> Laporkan
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <button @disabled(true) class="dropdown-item">
                                                            <i class="fas fa-trash me-2"></i> Hapus
                                                        </button>
                                                    </li>
                                                @endguest
                                                @auth
                                                    @hasanyrole(['moderator', 'user'])
                                                        @if(Auth::id() != $comment->user_id && $comment->user_id)
                                                            <li>
                                                                <button type="button" class="dropdown-item report-button" data-bs-toggle="modal" data-bs-target="#reportCommentModal-{{ $comment->id }}">
                                                                    <i class="fas fa-exclamation-circle me-2"></i> Laporkan
                                                                </button>
                                                            </li>
                                                        @endif
                                                        @if(Auth::id() == $comment->user_id && $comment->user_id)
                                                        <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="inline ml-2" onsubmit="return confirm('Apakah Anda yakin ingin menghapus komentar ini?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <li>
                                                                <button type="submit" class="dropdown-item text-danger">
                                                                    <i class="fas fa-trash me-2"></i> Hapus
                                                                </button>
                                                            </li>
                                                        </form>
                                                        @endif
                                                    @endhasanyrole
                                                @endauth
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="comment-body">
                                        <p>{{ $comment->content }}</p>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <button class="btn btn-sm btn-light" onclick="toggleReplyForm('reply-form-{{ $comment->id }}')">
                                            <i class="fas fa-reply me-1"></i> Balas
                                        </button>
                                    </div>

                                    <!-- Reply Form (Hidden by Default) -->
                                    <div id="reply-form-{{ $comment->id }}" class="reply-form mt-3" style="display: none;">
                                        <form action="{{ route('comments.store', $story) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                            <div class="input-group mb-2">
                                                <input type="text" name="content" class="form-control"
                                                    placeholder="Balas komentar ini...">
                                                <button class="btn btn-primary" type="submit">Balas</button>
                                            </div>
                                            <div class="form-check">
                                                <!-- Tambahkan hidden field -->
                                                <input type="hidden" name="anonymous" value="0">
                                                <label class="form-check-label" for="anonymousReply-{{ $comment->id }}">
                                                    <input type="checkbox" name="anonymous" value="1" class="form-check-input" {{ old('anonymous') ? 'checked' : '' }}  id="anonymousReply-{{ $comment->id }}">Balas sebagai anonim
                                                </label>
                                            </div>
                                        </form>
                                    </div>

                                    <!-- Replies -->
                                    @if($comment->replies->count() > 0)
                                    <div class="comment-reply mt-3">
                                        @foreach($comment->replies as $reply)
                                        <div class="comment-header">
                                            <div class="comment-user">
                                                @if($reply->anonymous)
                                                    Anonim
                                                @else
                                                    {{ optional($reply->user)->name ?? 'Pengunjung' }}
                                                @endif
                                            </div>
                                            <div class="dropdown">
                                                {{ $reply->created_at->diffForHumans() }}
                                                <button class="btn btn-sm" type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    @guest
                                                        <li>
                                                            <button @disabled(true) class="dropdown-item">
                                                                <i class="fas fa-exclamation-circle me-2"></i> Laporkan
                                                            </button>
                                                        </li>
                                                        <li>
                                                            <button @disabled(true) class="dropdown-item">
                                                                <i class="fas fa-trash me-2"></i> Hapus
                                                            </button>
                                                        </li>
                                                    @endguest
                                                    @auth
                                                        @hasanyrole(['moderator', 'user'])
                                                            @if(Auth::id() != $comment->user_id && $comment->user_id)
                                                                <li>
                                                                    <button type="button" class="dropdown-item report-button" data-bs-toggle="modal" data-bs-target="#reportReplyModal-{{ $reply->id }}">
                                                                        <i class="fas fa-exclamation-circle me-2"></i> Laporkan
                                                                    </button>
                                                                </li>
                                                            @endif
                                                            @if(Auth::id() == $comment->user_id && $comment->user_id)
                                                            <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="inline ml-2" onsubmit="return confirm('Apakah Anda yakin ingin menghapus komentar ini?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <li>
                                                                    <button type="submit" class="dropdown-item text-danger">
                                                                        <i class="fas fa-trash me-2"></i> Hapus
                                                                    </button>
                                                                </li>
                                                            </form>
                                                            @endif
                                                        @endhasanyrole
                                                    @endauth
                                                </ul>
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

    <!-- Report Comment Modal -->
    @foreach($story->comments->where('parent_id', null) as $comment)
    <div class="modal fade" id="reportCommentModal-{{ $comment->id }}" tabindex="-1" aria-labelledby="reportCommentModalLabel-{{ $comment->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('reports.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="reportable_id" value="{{ $comment->id }}">
                    <input type="hidden" name="reportable_type" value="comment">

                    <div class="modal-header">
                        <h5 class="modal-title" id="reportCommentModalLabel-{{ $comment->id }}">Laporkan Komentar</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="reason" id="reasonSpamComment-{{ $comment->id }}" value="Spam" checked>
                            <label class="form-check-label" for="reasonSpamComment-{{ $comment->id }}">Spam</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="reason" id="reasonHarassmentComment-{{ $comment->id }}" value="Pelecehan">
                            <label class="form-check-label" for="reasonHarassmentComment-{{ $comment->id }}">Pelecehan</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="reason" id="reasonHateSpeechComment-{{ $comment->id }}" value="Ujaran Kebencian">
                            <label class="form-check-label" for="reasonHateSpeechComment-{{ $comment->id }}">Ujaran Kebencian</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="reason" id="reasonMisinfoComment-{{ $comment->id }}" value="Informasi Palsu">
                            <label class="form-check-label" for="reasonMisinfoComment-{{ $comment->id }}">Informasi Palsu</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="reason" id="reasonViolenceComment-{{ $comment->id }}" value="Kekerasan">
                            <label class="form-check-label" for="reasonViolenceComment-{{ $comment->id }}">Kekerasan</label>
                        </div>
                        {{-- <div class="form-check">
                            <input class="form-check-input" type="radio" name="reason" id="reasonOtherComment-{{ $comment->id }}" value="Lainnya">
                            <label class="form-check-label" for="reasonOtherComment-{{ $comment->id }}">Lainnya</label>
                        </div>
                        <textarea
                            name="other_reason"
                            id="otherReasonText-{{ $story->id }}"
                            class="form-control mt-2 d-none"
                            placeholder="Jelaskan alasanmu..."
                        ></textarea> --}}
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

    <!-- Reply Report Modals -->
    @foreach($story->comments as $comment)
        @foreach($comment->replies ?? [] as $reply)
        <div class="modal fade" id="reportReplyModal-{{ $reply->id }}" tabindex="-1" aria-labelledby="reportReplyModalLabel-{{ $reply->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('reports.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="reportable_id" value="{{ $reply->id }}">
                        <input type="hidden" name="reportable_type" value="comment">

                        <div class="modal-header">
                            <h5 class="modal-title" id="reportReplyModalLabel-{{ $reply->id }}">Laporkan Balasan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="reason" id="reasonSpamReply-{{ $reply->id }}" value="Spam" checked>
                                <label class="form-check-label" for="reasonSpamReply-{{ $reply->id }}">Spam</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="reason" id="reasonHarassmentReply-{{ $reply->id }}" value="Pelecehan">
                                <label class="form-check-label" for="reasonHarassmentReply-{{ $reply->id }}">Pelecehan</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="reason" id="reasonHateSpeechReply-{{ $reply->id }}" value="Ujaran Kebencian">
                                <label class="form-check-label" for="reasonHateSpeechReply-{{ $reply->id }}">Ujaran Kebencian</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="reason" id="reasonMisinfoReply-{{ $reply->id }}" value="Informasi Palsu">
                                <label class="form-check-label" for="reasonMisinfoReply-{{ $reply->id }}">Informasi Palsu</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="reason" id="reasonViolenceReply-{{ $reply->id }}" value="Kekerasan">
                                <label class="form-check-label" for="reasonViolenceReply-{{ $reply->id }}">Kekerasan</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="reason" id="reasonOtherReply-{{ $reply->id }}" value="Lainnya">
                                <label class="form-check-label" for="reasonOtherReply-{{ $reply->id }}">Lainnya</label>
                            </div>
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
    @endforeach

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <h5 class="fw-bold mb-4"><i class="fas fa-book-open me-2 text-primary"></i>JejakCerita</h5>
                    <p class="text-muted">Platform berbagi cerita pendek terpopuler di Indonesia. Temukan inspirasi dan bagikan
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Store the element that had focus before opening the modal
            let previouslyFocusedElement;

            // All modals on the page
            const modals = document.querySelectorAll('.modal');

            modals.forEach(modal => {
                // When modal is about to be shown
                modal.addEventListener('show.bs.modal', function() {
                    // Store the element that currently has focus
                    previouslyFocusedElement = document.activeElement;
                });

                // When modal is hidden
                modal.addEventListener('hidden.bs.modal', function() {
                    // Return focus to the element that had focus before the modal was opened
                    if (previouslyFocusedElement) {
                        previouslyFocusedElement.focus();
                    }
                });

                // Handle keyboard focus loop within the modal
                modal.addEventListener('keydown', function(event) {
                    if (event.key === 'Tab') {
                        // Get all focusable elements in the modal
                        const focusableElements = modal.querySelectorAll(
                            'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
                        );

                        const firstElement = focusableElements[0];
                        const lastElement = focusableElements[focusableElements.length - 1];

                        // If shift key is pressed and focus is on first element, move to last element
                        if (event.shiftKey && document.activeElement === firstElement) {
                            event.preventDefault();
                            lastElement.focus();
                        }
                        // If focus is on last element, move to first element
                        else if (!event.shiftKey && document.activeElement === lastElement) {
                            event.preventDefault();
                            firstElement.focus();
                        }
                    }

                    // Close modal on Escape key
                    if (event.key === 'Escape') {
                        const bsModal = bootstrap.Modal.getInstance(modal);
                        if (bsModal) {
                            bsModal.hide();
                        }
                    }
                });
            });
        });
    </script>
</body>

</html>
