@php use Illuminate\Support\Str; @endphp
@extends('layouts.app')

@section('content')
    <div class="row g-4 align-items-center mb-5 fade-rise">
        <div class="col-lg-6">
            <div class="glass rounded-4 p-4">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-2 rounded-pill badge-soft mb-3">
                    <i class="bi bi-lightning-charge-fill text-info"></i>
                    Real-time IQ pulse with adaptive quizzes
                </div>
                <h1 class="display-5 fw-bold mb-3">
                    Challenge your mind with <span class="gradient-text">IQInsight</span>
                </h1>
                <p class="text-secondary lead mb-4">
                    Logical, graphical, math, sequences, memory and more. Fresh games every run, responsive UI,
                    instant scoring, and an admin panel to keep track of every move.
                </p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="{{ route('quizzes.index') }}" class="btn btn-accent btn-lg px-4">
                        Start a new game
                    </a>
                    <a href="{{ route('leaderboard') }}" class="btn btn-outline-light btn-lg px-4">
                        View leaderboard
                    </a>
                </div>
                @guest
                    <div class="alert alert-info mt-4 mb-0">
                        <i class="bi bi-lock-fill me-2"></i> Please login or sign up before playing to save your IQ rank.
                    </div>
                @endguest
            </div>
        </div>
        <div class="col-lg-6 fade-rise">
            <div class="row g-3">
                @foreach ($categories as $category)
                    <div class="col-6">
                        <div class="card rounded-4 border-0 p-3 h-100">
                            <div class="d-flex align-items-center mb-2">
                                <span class="badge text-bg-dark border border-secondary me-2">New</span>
                                <span class="text-secondary text-uppercase small">{{ $category }}</span>
                            </div>
                            <h5 class="fw-semibold text-white mb-2">{{ ucfirst($category) }} Arena</h5>
                            <p class="text-secondary small mb-0">Sharpen in {{ $category }} with rotating puzzles.</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="mb-5 fade-rise">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-semibold mb-0">Fresh drops</h4>
            <a href="{{ route('quizzes.index') }}" class="text-secondary small">See all quizzes</a>
        </div>
        <div class="row g-3">
            @foreach ($fresh as $quiz)
                <div class="col-md-6 col-lg-4">
                    <div class="card rounded-4 h-100 p-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="badge badge-soft text-uppercase">{{ $quiz->category }}</span>
                            <span class="text-secondary small">{{ ucfirst($quiz->difficulty) }}</span>
                        </div>
                        <h5 class="fw-semibold">{{ $quiz->title }}</h5>
                        <p class="text-secondary small mb-3">{{ Str::limit($quiz->description, 90) }}</p>
                        <div class="d-flex align-items-center justify-content-between text-secondary small mb-3">
                            <span><i class="bi bi-question-circle"></i> {{ $quiz->question_count ?: ($quiz->questions_count ?? $quiz->questions()->count()) }} Qs</span>
                            <span><i class="bi bi-clock-history"></i> {{ $quiz->time_limit_seconds ?? 0 }}s</span>
                        </div>
                        <a href="{{ route('quizzes.show', $quiz) }}" class="btn btn-outline-light btn-sm w-100">
                            Play this quiz
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="row g-3 align-items-center fade-rise mb-5">
        <div class="col-lg-6">
            <div class="card rounded-4 p-4 h-100">
                <h4 class="fw-semibold mb-3">Featured arenas</h4>
                @forelse ($featured as $quiz)
                    <div class="d-flex align-items-center justify-content-between py-2 border-bottom border-dark">
                        <div>
                            <div class="text-white fw-semibold">{{ $quiz->title }}</div>
                            <div class="text-secondary small text-uppercase">{{ $quiz->category }} | {{ $quiz->difficulty }}</div>
                        </div>
                        <a href="{{ route('quizzes.show', $quiz) }}" class="btn btn-sm btn-accent">Play</a>
                    </div>
                @empty
                    <p class="text-secondary mb-0">No featured quizzes yet.</p>
                @endforelse
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card rounded-4 p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="fw-semibold mb-0">Live leaderboard pulse</h4>
                    <span class="badge text-bg-success">Real-time</span>
                </div>
                <div class="list-group list-group-flush">
                    @forelse ($topAttempts as $attempt)
                        <div class="list-group-item bg-transparent text-white d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fw-semibold">{{ $attempt->user->name ?? 'Anonymous' }}</div>
                                <small class="text-secondary">{{ $attempt->quiz->title ?? 'Quiz' }}</small>
                            </div>
                            <div class="text-end">
                                <div class="fw-bold text-info">{{ $attempt->percentage }}%</div>
                                <small class="text-secondary">Score: {{ $attempt->score }}/{{ $attempt->max_score }}</small>
                            </div>
                        </div>
                    @empty
                        <p class="text-secondary mb-0">Play a quiz to appear here.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div class="text-center fade-rise">
        <div class="glass rounded-4 p-4 d-inline-block">
            <h4 class="fw-semibold mb-2">Ready for your next IQ check?</h4>
            <p class="text-secondary mb-3">Pick a category, play a fresh quiz, and watch your leaderboard position update instantly.</p>
            <a href="{{ route('quizzes.index') }}" class="btn btn-accent px-4">Find my next game</a>
        </div>
    </div>
@endsection
