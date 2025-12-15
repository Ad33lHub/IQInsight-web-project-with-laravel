@extends('layouts.app')

@section('content')
    <div class="fade-rise mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <p class="text-secondary mb-1 text-uppercase small">Live rankings</p>
                <h2 class="fw-bold mb-0">Leaderboard</h2>
            </div>
            <a href="{{ route('quizzes.index') }}" class="btn btn-accent">Play a new quiz</a>
        </div>
    </div>

    @auth
        <div class="glass rounded-4 p-3 mb-4 fade-rise">
            @if ($userBest)
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="fw-semibold text-white">Your best pulse: {{ $userBest }}%</div>
                        <div class="text-secondary small">Estimated IQ {{ auth()->user()->iq_score }} | Position {{ $userRank ?? '-' }}</div>
                    </div>
                    <span class="badge text-bg-info">Live</span>
                </div>
            @else
                <div class="text-secondary">Complete a quiz to claim your leaderboard rank.</div>
            @endif
        </div>
    @endauth

    <div class="row g-3 fade-rise">
        <div class="col-lg-7">
            <div class="card rounded-4 p-3 h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-semibold mb-0">Top IQ climbs</h5>
                    <span class="text-secondary small">Best score per user</span>
                </div>
                <div class="table-responsive">
                    <table class="table table-dark table-sm align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>User</th>
                                <th>Best %</th>
                                <th>Score</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($leaders as $index => $row)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $row->user->name ?? 'Unknown' }}</td>
                                    <td class="text-info fw-semibold">{{ $row->best_percentage }}%</td>
                                    <td>{{ $row->best_score }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-secondary">No attempts yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card rounded-4 p-3 h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-semibold mb-0">Recent finishes</h5>
                    <span class="text-secondary small">Live feed</span>
                </div>
                <div class="list-group list-group-flush">
                    @forelse ($recent as $attempt)
                        <div class="list-group-item bg-transparent text-white d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fw-semibold">{{ $attempt->user->name ?? 'Player' }}</div>
                                <small class="text-secondary">{{ $attempt->quiz->title ?? 'Quiz' }}</small>
                            </div>
                            <div class="text-end">
                                <div class="fw-bold text-info">{{ $attempt->percentage }}%</div>
                                <small class="text-secondary">{{ $attempt->finished_at?->diffForHumans() }}</small>
                            </div>
                        </div>
                    @empty
                        <p class="text-secondary mb-0">Play a game to populate the feed.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
