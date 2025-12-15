<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'IQInsight') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --bg-primary: #0a0a0a;
            --bg-secondary: #121212;
            --bg-tertiary: #1a1a1a;
            --surface-elevated: #1e1e1e;
            --surface-card: #171717;
            --surface-overlay: #252525;
            --text-primary: #ffffff;
            --text-secondary: #a3a3a3;
            --text-tertiary: #737373;
            --text-disabled: #525252;
            --accent-primary: #3b82f6;
            --accent-secondary: #8b5cf6;
            --accent-success: #10b981;
            --accent-warning: #f59e0b;
            --accent-error: #ef4444;
            --accent-info: #06b6d4;
            --border-default: #262626;
            --border-subtle: #1a1a1a;
            --border-strong: #404040;
            --interactive-hover: #2a2a2a;
            --interactive-active: #333333;
            --interactive-focus: #3b82f6;
        }

        * {
            font-family: 'Space Grotesk', 'Segoe UI', sans-serif;
        }

        body {
            background: radial-gradient(circle at 20% 20%, rgba(59, 130, 246, 0.08), transparent 35%),
                        radial-gradient(circle at 80% 0%, rgba(139, 92, 246, 0.07), transparent 30%),
                        var(--bg-primary);
            color: var(--text-primary);
            min-height: 100vh;
        }

        .glass {
            background: linear-gradient(145deg, rgba(30,30,30,0.8), rgba(23,23,23,0.9));
            border: 1px solid var(--border-default);
            box-shadow: 0 25px 60px rgba(0,0,0,0.35);
            backdrop-filter: blur(10px);
        }

        .navbar {
            background: rgba(18, 18, 18, 0.92);
            border-bottom: 1px solid var(--border-default);
        }

        .nav-link, .navbar-brand {
            color: var(--text-primary) !important;
        }

        .nav-link.active {
            color: var(--accent-primary) !important;
        }

        a {
            color: var(--accent-primary);
        }

        .btn-accent {
            background: linear-gradient(120deg, var(--accent-primary), var(--accent-secondary));
            color: #fff;
            border: none;
            box-shadow: 0 10px 30px rgba(59,130,246,0.25);
        }

        .btn-accent:hover {
            transform: translateY(-1px);
            box-shadow: 0 15px 40px rgba(139,92,246,0.3);
        }

        .badge-soft {
            background: var(--surface-overlay);
            color: var(--text-secondary);
            border: 1px solid var(--border-default);
        }

        .card {
            background: var(--surface-card);
            border: 1px solid var(--border-default);
            color: var(--text-primary);
        }

        .card:hover {
            border-color: var(--interactive-focus);
            transform: translateY(-2px);
            transition: all 0.25s ease;
        }

        .hover-shadow:hover {
            background: var(--interactive-hover);
            border-color: var(--interactive-focus) !important;
        }

        .gradient-text {
            background: linear-gradient(120deg, var(--accent-primary), var(--accent-secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .fade-rise {
            opacity: 0;
            transform: translateY(12px);
            transition: all 0.6s ease;
        }

        .fade-rise.in-view {
            opacity: 1;
            transform: translateY(0);
        }

        footer {
            color: var(--text-secondary);
        }
    </style>
    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm">
        <div class="container py-2">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}">
                <span class="gradient-text">IQInsight</span>
            </a>
            <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('quizzes.*') ? 'active' : '' }}" href="{{ route('quizzes.index') }}">Play</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('leaderboard') ? 'active' : '' }}" href="{{ route('leaderboard') }}">Leaderboard</a></li>
                    @auth
                        @if(auth()->user()->is_admin)
                            <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.index') ? 'active' : '' }}" href="{{ route('admin.index') }}">Admin</a></li>
                        @endif
                    @endauth
                </ul>
                <div class="d-flex gap-2">
                    @auth
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge rounded-pill text-bg-dark border border-secondary px-3">{{ auth()->user()->name }}</span>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="btn btn-outline-light btn-sm">Logout</button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">Login</a>
                        <a href="{{ route('register') }}" class="btn btn-accent btn-sm px-3">Sign up</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="container py-4">
        @if (session('status'))
            <div class="alert alert-success glass border-0 fade-rise in-view">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger glass border-0 fade-rise in-view">
                <strong>Heads up:</strong>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="container py-4 border-top border-dark">
        <div class="d-flex justify-content-between align-items-center">
            <div>&copy; {{ now()->year }} IQInsight. Train sharper, faster.</div>
            <div class="small text-secondary">Built with Laravel + Bootstrap.</div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) entry.target.classList.add('in-view');
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.fade-rise').forEach(el => observer.observe(el));
    </script>
    @stack('scripts')
</body>
</html>
