@extends('frontend.college.layouts.app')

@section('content')
<section class="smart-hero d-flex align-items-center justify-content-center text-center text-white">
    <div class="hero-inner py-4">
        <h1 class="display-4 fw-bold mb-0">Research, Protocol and Institutional Ethical Review Board (IERB)</h1>
    </div>
</section>

<!-- ✅ IERB Section -->
<section class="ierb-section container my-5">
    <div class="row">
        <div class="col-12">
            <!-- IERB Member Table -->
            <div class="card shadow-sm mb-5">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0"><i class="fas fa-users me-2"></i>IERB Member</h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 60%;">Name and Affiliation</th>
                                    <th style="width: 40%;">Role / Designation</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($ierbMembers as $member)
                                    <tr>
                                        <td>{{ $member->name_affiliation }}</td>
                                        <td>{{ $member->role }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center text-muted">No members found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- IERB Activities Table -->
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0"><i class="fas fa-clipboard-list me-2"></i>IERB Activities</h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 8%;">Sl. No.</th>
                                    <th style="width: 50%;">Topics</th>
                                    <th style="width: 25%;">Principal Investigator</th>
                                    <th style="width: 17%;">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($ierbActivities as $activity)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $activity->topic }}</td>
                                        <td>{{ $activity->principal_investigator }}</td>
                                        <td>{{ \Carbon\Carbon::parse($activity->activity_date)->format('d.m.Y') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">No activities found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .ierb-section .table {
        font-size: 0.95rem;
    }
    
    .ierb-section .table thead th {
        font-weight: 600;
        vertical-align: middle;
        text-align: center;
    }
    
    .ierb-section .table tbody td {
        vertical-align: top;
        padding: 12px;
    }
    
    .ierb-section .table tbody tr:hover {
        background-color: #f8f9fa;
    }
    
    .ierb-section .card-header {
        border-bottom: 2px solid rgba(0,0,0,0.1);
    }
    
    @media (max-width: 768px) {
        .ierb-section .table {
            font-size: 0.85rem;
        }
        
        .ierb-section .table tbody td {
            padding: 8px;
        }
    }
</style>

@endsection

