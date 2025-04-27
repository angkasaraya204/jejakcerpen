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

    <!-- Main Content -->
    <div class="container py-5" id="mainContent">
        <!-- Categories Section -->
        <div class="row mb-4 slide-up">
            <div class="col-12">
                <h4 class="mb-3 fw-bold">Kategori Populer</h4>
            </div>
            <div class="col-lg-12">
                <div class="row g-3">
                    <div class="col-4 col-md-2">
                        <div class="category-card card h-100">
                            <div class="card-body p-2">
                                <a href="{{ route('stories.index') }}"
                                    class="{{ request()->missing('category') ? 'text-white' : '' }}">
                                    <i class="fas fa-heart category-icon"></i>
                                    <h6 class="mb-0">Semua</h6>
                                </a>
                            </div>
                        </div>
                    </div>
                    @foreach($categories as $category)
                        <div class="col-4 col-md-2">
                            <div class="category-card card h-100">
                                <div class="card-body p-2">
                                    <a href="{{ route('stories.index', ['category' => $category->slug]) }}"
                                        class="{{ request('category') == $category->slug ? 'bg-blue-500 text-white' : '' }}">
                                        <i class="fas fa-heart category-icon"></i>
                                        <h6 class="mb-0">{{ $category->name }}</h6>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Main Content Sections -->
        <div class="row">
            <!-- Left Content - Stories -->
            <div class="col-lg-9">
                <h4 class="mb-4 fw-bold">Cerita Terbaru</h4>

                <!-- Story Card 1 - Trending -->
                @if($stories->count() > 0)
                    <div class="card story-card fade-in">
                        @foreach($stories as $story)
                            <div class="story-header">
                                <div class="user-info">
                                    <img src="/api/placeholder/40/40" alt="User Avatar" class="avatar">
                                    <div>
                                        <div class="fw-bold">Rina Wijaya</div>
                                        <div class="text-muted small">2 jam yang lalu</div>
                                    </div>
                                </div>
                                <div class="dropdown">
                                    <span class="badge bg-danger rounded-pill me-2">
                                        <i class="fas fa-fire me-1"></i> Trending
                                    </span>
                                    <button class="btn btn-sm" type="button" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="#"><i class="fas fa-bookmark me-2"></i>
                                                Simpan</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="fas fa-ban me-2"></i>
                                                Laporkan</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="story-content">
                                <span class="badge-category">{{ $story->category->name }}</span>
                                <a href="{{ route('stories.show', $story) }}">
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
                                    <span>{{ $story->published_at->format('d M Y, H:i') }}</span>
                                </div>
                                <div class="story-text">
                                    <p>{{ Str::limit(strip_tags($story->content), 200) }}</p>
                                </div>
                                <a href="{{ route('stories.show', $story) }}" class="read-more"
                                    onclick="showDetail()">Baca selengkapnya <i class="fas fa-arrow-right ms-1"></i></a>
                            </div>
                            <div class="story-footer">
                                <div class="vote-buttons">
                                    <form action="{{ route('stories.vote', $story) }}"
                                        method="POST">
                                        @csrf
                                        <input type="hidden" name="vote_type" value="like">
                                        <button class="vote-btn upvote">
                                            <i class="fas fa-thumbs-up"></i>
                                            <span>{{ $story->votes()->where('vote_type', 'like')->count() }}</span>
                                        </button>
                                    </form>
                                    <form action="{{ route('stories.vote', $story) }}"
                                        method="POST">
                                        @csrf
                                        <input type="hidden" name="vote_type" value="dislike">
                                        <button class="vote-btn downvote">
                                            <i class="fas fa-thumbs-down"></i>
                                            <span>{{ $story->votes()->where('vote_type', 'dislike')->count() }}</span>
                                        </button>
                                    </form>
                                </div>
                                <div>
                                    <span class="text-muted">
                                        <i class="fas fa-comment me-1"></i> {{ $story->comments->count() }} Komentar
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-600">Belum ada cerita tersedia.</p>
                @endif
            </div>

            <!-- Right Sidebar - Trending -->
            <div class="col-lg-3">
                <div class="card mb-4 fade-in">
                    <div class="card-header bg-transparent">
                        <h5 class="mb-0"><i class="fas fa-fire text-danger me-2"></i>Cerita Trending</h5>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            @forelse($trendingStories as $index => $trendingStory)
                                <li
                                    class="list-group-item d-flex justify-content-between align-items-center border-0 border-bottom">
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

                <div class="card mb-4 fade-in">
                    <div class="card-header bg-transparent">
                        <h5 class="mb-0"><i class="fas fa-tags me-2 text-primary"></i>Kategori Populer</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            @forelse($popularCategories as $popularCategory)
                                <a href="{{ route('stories.index', ['category' => $popularCategory->slug]) }}"
                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                    {{ $popularCategory->name }}
                                    <span
                                        class="badge bg-primary rounded-pill">{{ $popularCategory->stories_count }}</span>
                                </a>
                            @empty
                                <div class="list-group-item">
                                    <p class="mb-0 text-muted">Belum ada kategori populer.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="card mb-4 fade-in">
                    <div class="card-header bg-transparent">
                        <h5 class="mb-0"><i class="fas fa-users me-2 text-success"></i>Penulis Populer</h5>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            @forelse($popularAuthors as $author)
                                <li class="list-group-item d-flex align-items-center border-0 border-bottom py-3">
                                    <img src="/api/placeholder/32/32" alt="User" class="rounded-circle me-3">
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
