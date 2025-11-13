@extends('backend.layouts.app')

@section('contents')
    <style>
        /* Count box numbers */
        .count-number {
            font-size: 2.5rem;
            font-weight: bold;
        }

        /* Notice board */
        .notice-board {
            margin-top: 2rem;
            padding: 1.5rem;
            background: rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .notice-list {
            max-height: 300px;
            overflow-y: auto;
            overflow-x: hidden !important;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .notice-list li {
            padding: 10px 12px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            transition: background 0.3s, transform 0.2s;
            border-radius: 8px;
        }

        .notice-list li:hover {
            background: rgba(255, 255, 255, 0.5);
            transform: translateX(4px);
            cursor: pointer;
        }

        /* Glass card style */
        .glass-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
            color: #2c3e50;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        /* Hover effect */
        .glass-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }

        /* Icon style (outline look) */
        .glass-icon {
            font-size: 2.8rem;
            border-radius: 50%;
            padding: 0.8rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Text section */
        .glass-text {
            text-align: right;
        }

        /* Number */
        .count-number {
            font-size: 2rem;
            font-weight: bold;
            margin: 0;
        }
    </style>

    <div class="container py-4">

        <div class="row g-4">
            <!-- Teachers -->
            <div class="col-md-4">
                <div class="glass-card">
                    <div class="glass-icon text-primary">
                        <i class="far fa-user"></i>
                    </div>
                    <div class="glass-text">
                        <h5 class="mb-1">মোট শিক্ষক</h5>
                        <p class="count-number">{{ $teacher }}</p>
                    </div>
                </div>
            </div>

            <!-- Students -->
            <div class="col-md-4">
                <div class="glass-card">
                    <div class="glass-icon text-success">
                        <i class="far fa-user-circle"></i>
                    </div>
                    <div class="glass-text">
                        <h5 class="mb-1">মোট শিক্ষার্থী</h5>
                        <p class="count-number">{{ $student }}</p>
                    </div>
                </div>
            </div>

            <!-- Notices -->
            <div class="col-md-4">
                <div class="glass-card">
                    <div class="glass-icon text-danger">
                        <i class="far fa-bell"></i>
                    </div>
                    <div class="glass-text">
                        <h5 class="mb-1">নতুন নোটিশ</h5>
                        <p class="count-number">{{ $notices->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notice Board -->
        <div class="notice-board mt-5">
            <h4 class="mb-3">নোটিশ বোর্ড</h4>
            <ul class="notice-list">
                @forelse($notices as $notice)
                    <li class="d-flex justify-content-between align-items-center">
                        <span>
                            {{ $notice->title ?? $notice->name ?? $notice->subject ?? 'Untitled Notice' }}
                        </span>
                        <div>
                            @if($notice->start_date)
                                <span class="text-muted"
                                    style="font-size: small;">{{ \Carbon\Carbon::parse($notice->start_date)->format('d M Y') }}</span>
                            @endif
                            @if($notice->end_date)
                                <span class="text-muted"
                                    style="font-size: small;">{{ \Carbon\Carbon::parse($notice->end_date)->format('d M Y') }}</span>
                            @endif
                        </div>
                    </li>
                @empty
                    <li>কোন নোটিশ পাওয়া যায়নি</li>
                @endforelse
            </ul>
        </div>

    </div>
@endsection