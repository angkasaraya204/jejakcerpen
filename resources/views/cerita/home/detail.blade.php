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
    <style>
        :root {
            --primary-color: #5271ff;
            --secondary-color: #f0f4ff;
            --accent-color: #ff7752;
            --text-color: #333;
            --bg-color: #fff;
            --card-bg: #fff;
            --border-color: #e0e0e0;
            --header-bg: #fff;
            --footer-bg: #f8f9fa;
            --transition: all 0.3s ease;
        }

        [data-bs-theme="dark"] {
            --primary-color: #6e86ff;
            --secondary-color: #222;
            --accent-color: #ff8c6b;
            --text-color: #e0e0e0;
            --bg-color: #121212;
            --card-bg: #1e1e1e;
            --border-color: #444;
            --header-bg: #1a1a1a;
            --footer-bg: #1a1a1a;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-color);
            transition: var(--transition);
        }

        .navbar {
            background-color: var(--header-bg);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: var(--transition);
        }

        .sidebar {
            width: 280px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: -280px;
            background-color: var(--card-bg);
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            z-index: 1050;
            transition: 0.4s;
            padding-top: 60px;
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
            display: none;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-menu li {
            padding: 12px 24px;
            border-bottom: 1px solid var(--border-color);
            transition: var(--transition);
        }

        .sidebar-menu li:hover {
            background-color: var(--secondary-color);
        }

        .sidebar-menu a {
            color: var(--text-color);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            margin-bottom: 24px;
            transition: var(--transition);
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .category-card {
            padding: 10px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
        }

        .category-card:hover {
            background-color: var(--secondary-color);
        }

        .category-icon {
            font-size: 32px;
            margin-bottom: 12px;
            color: var(--primary-color);
        }

        .story-card {
            position: relative;
        }

        .story-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px;
            border-bottom: 1px solid var(--border-color);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        .dropdown-toggle::after {
            display: none;
        }

        .story-content {
            padding: 16px;
        }

        .story-title {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 8px;
            color: var(--text-color);
        }

        .story-meta {
            font-size: 14px;
            color: #777;
            margin-bottom: 12px;
        }

        .badge-category {
            background-color: var(--secondary-color);
            color: var(--primary-color);
            font-weight: 500;
            border-radius: 20px;
            padding: 5px 12px;
            display: inline-block;
            margin-bottom: 12px;
        }

        .story-text {
            margin-bottom: 16px;
            line-height: 1.6;
        }

        .read-more {
            color: var(--primary-color);
            font-weight: 600;
            text-decoration: none;
        }

        .read-more:hover {
            text-decoration: underline;
        }

        .story-footer {
            padding: 12px 16px;
            border-top: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .vote-buttons {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .vote-btn {
            background: none;
            border: none;
            display: flex;
            align-items: center;
            gap: 8px;
            color: #777;
            font-weight: 500;
            transition: var(--transition);
            cursor: pointer;
            padding: 5px 10px;
            border-radius: 20px;
        }

        .upvote:hover {
            color: #4CAF50;
            background-color: rgba(76, 175, 80, 0.1);
        }

        .downvote:hover {
            color: #F44336;
            background-color: rgba(244, 67, 54, 0.1);
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: #4262e6;
            border-color: #4262e6;
        }

        .trending-badge {
            position: absolute;
            top: 16px;
            right: 16px;
            background-color: var(--accent-color);
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            z-index: 1;
        }

        /* Footer */
        footer {
            background-color: var(--footer-bg);
            padding: 40px 0;
            margin-top: 60px;
            border-top: 1px solid var(--border-color);
            transition: var(--transition);
        }

        .footer-links {
            list-style: none;
            padding: 0;
        }

        .footer-links li {
            margin-bottom: 12px;
        }

        .footer-links a {
            color: var(--text-color);
            text-decoration: none;
            transition: var(--transition);
        }

        .footer-links a:hover {
            color: var(--primary-color);
        }

        .social-links {
            display: flex;
            gap: 16px;
            margin-top: 20px;
        }

        .social-links a {
            color: var(--text-color);
            font-size: 20px;
            transition: var(--transition);
        }

        .social-links a:hover {
            color: var(--primary-color);
            transform: translateY(-3px);
        }

        /* Dark mode toggle */
        .dark-mode-toggle {
            width: 56px;
            height: 28px;
            border-radius: 14px;
            background-color: #ddd;
            position: relative;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 6px;
        }

        .dark-mode-toggle.active {
            background-color: var(--primary-color);
        }

        .toggle-circle {
            position: absolute;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background-color: white;
            left: 3px;
            transition: var(--transition);
        }

        .dark-mode-toggle.active .toggle-circle {
            left: 30px;
        }

        .toggle-icons {
            font-size: 14px;
            color: #333;
        }

        .toggle-icons.moon {
            color: white;
        }

        /* Comments */
        .comment {
            padding: 16px;
            border-bottom: 1px solid var(--border-color);
        }

        .comment-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .comment-user {
            font-weight: 600;
        }

        .comment-time {
            color: #777;
            font-size: 14px;
        }

        .comment-body {
            margin-bottom: 12px;
        }

        .comment-reply {
            padding-left: 24px;
            border-left: 3px solid var(--primary-color);
            margin-top: 12px;
            background-color: rgba(82, 113, 255, 0.05);
            border-radius: 0 12px 12px 0;
        }

        .reply-form {
            margin-top: 12px;
        }

        /* Animations */
        <blade keyframes|%20fadeIn%20%7B>from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
        }

        .fade-in {
            animation: fadeIn 0.5s ease forwards;
        }

        <blade keyframes|%20slideUp%20%7B>from {
            transform: translateY(20px);
            opacity: 0;
        }

        to {
            transform: translateY(0);
            opacity: 1;
        }
        }

        .slide-up {
            animation: slideUp 0.5s ease forwards;
        }

        /* Detail Page Styles */
        .story-detail {
            background-color: var(--card-bg);
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }

        .story-detail-header {
            margin-bottom: 24px;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 20px;
        }

        .story-detail-meta {
            display: flex;
            justify-content: space-between;
            margin-bottom: 16px;
        }

        .comment-form {
            margin: 30px 0;
        }

        .comment-list {
            margin-top: 30px;
        }

    </style>
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
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li>
                                    <a class="dropdown-item" href="{{ route('stories.create') }}">
                                        <i class="fas fa-cog me-2"></i> Buat Cerita
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                        <i class="fas fa-cog me-2"></i> Pengaturan
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
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
                    <a href="#">
                        <i class="fas fa-home"></i>
                        Beranda
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fas fa-fire"></i>
                        Trending
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fas fa-tags"></i>
                        Kategori
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fas fa-bookmark"></i>
                        Disimpan
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fas fa-plus-circle"></i>
                        Tulis Cerita
                    </a>
                </li>
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
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" onclick="hideDetail()">Beranda</a></li>
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
                            <img src="/api/placeholder/40/40" alt="User Avatar" class="avatar me-3">
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

                    <div class="story-content mb-5">
                        <p>{!! nl2br(e($story->content)) !!}</p>
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
    <script>
        // Sidebar Toggle
        document.getElementById('sidebarToggle').addEventListener('click', function () {
            document.getElementById('sidebar').classList.toggle('active');
            document.getElementById('sidebarOverlay').style.display = document.getElementById('sidebar')
                .classList.contains('active') ? 'block' : 'none';
        });

        document.getElementById('sidebarOverlay').addEventListener('click', function () {
            document.getElementById('sidebar').classList.remove('active');
            this.style.display = 'none';
        });

        // Dark Mode Toggle
        const darkModeToggle = document.getElementById('darkModeToggle');
        const html = document.documentElement;

        darkModeToggle.addEventListener('click', function () {
            this.classList.toggle('active');

            if (this.classList.contains('active')) {
                html.setAttribute('data-bs-theme', 'dark');
                localStorage.setItem('theme', 'dark');
            } else {
                html.setAttribute('data-bs-theme', 'light');
                localStorage.setItem('theme', 'light');
            }
        });

        // Check for saved theme preference
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme === 'dark') {
            darkModeToggle.classList.add('active');
            html.setAttribute('data-bs-theme', 'dark');
        }

        // Toggle Reply Forms
        function toggleReplyForm(formId) {
            const form = document.getElementById(formId);
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
        }

        // Show/Hide Detail View
        function showDetail() {
            document.getElementById('mainContent').style.display = 'none';
            document.getElementById('detailView').style.display = 'block';
            window.scrollTo(0, 0);
        }

        function hideDetail() {
            document.getElementById('mainContent').style.display = 'block';
            document.getElementById('detailView').style.display = 'none';
            window.scrollTo(0, 0);
        }

        // Add animations to elements when scrolling
        document.addEventListener('DOMContentLoaded', function () {
            const animateElements = document.querySelectorAll('.fade-in, .slide-up');

            function checkScroll() {
                animateElements.forEach(element => {
                    const elementTop = element.getBoundingClientRect().top;
                    const elementVisible = 150;

                    if (elementTop < window.innerHeight - elementVisible) {
                        element.style.opacity = 1;
                        element.style.transform = 'translateY(0)';
                    }
                });
            }

            // Initial check
            checkScroll();

            // Check on scroll
            window.addEventListener('scroll', checkScroll);
        });

    </script>
</body>

</html>
