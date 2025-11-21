@extends('backend.layouts.app')

@section('contents')
    @include('backend.inc.table_css')
    <div class="container mt-4">
        <div class="card border-0 shadow-sm rounded">
            <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center py-3">
                <div class="d-flex align-items-center gap-2">
                    <div class="bg-primary bg-opacity-10 text-dark rounded d-flex align-items-center justify-content-center"
                        style="width: 32px; height: 32px;">
                        <i class="fas fa-link"></i>
                    </div>
                    <h6 class="mb-0 fw-bold">Admission Links Management</h6>
                </div>
                <a href="{{ route('admission_links.create') }}" class="btn btn-soft-primary btn-sm rounded-pill">
                    <i class="fas fa-plus"></i> Add New Link
                </a>
            </div>

            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Search -->
                <div class="row g-2 mb-3 align-items-center">
                    <div class="col-md-4 col-sm-12">
                        <input type="text" id="linkSearch" class="form-control form-control-sm"
                            placeholder="🔍 Search links...">
                    </div>
                </div>

                <!-- Links Table -->
                <div class="table-responsive">
                    <table id="table-data" class="table mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>SL.</th>
                                <th>Title</th>
                                <th>Link URL</th>
                                <th>Duration</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody id="linkTableBody">
                            @forelse($admissionLinks as $index => $link)
                                <tr class="link-row" data-title="{{ strtolower($link->title) }}">
                                    <td>{{ $admissionLinks->firstItem() + $index }}</td>
                                    <td>
                                        <strong class="text-primary">{{ $link->title }}</strong>
                                        @if($link->description)
                                            <br><small class="text-muted">{{ \Illuminate\Support\Str::limit($link->description, 60) }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ $link->link_url }}" target="_blank" class="text-decoration-none">
                                            <i class="fas fa-external-link-alt me-1"></i>
                                            {{ \Illuminate\Support\Str::limit($link->link_url, 40) }}
                                        </a>
                                    </td>
                                    <td>
                                        @if($link->start_date || $link->end_date)
                                            @if($link->start_date)
                                                <small class="text-muted">From: {{ \Carbon\Carbon::parse($link->start_date)->format('M d, Y') }}</small><br>
                                            @endif
                                            @if($link->end_date)
                                                <small class="text-muted">To: {{ \Carbon\Carbon::parse($link->end_date)->format('M d, Y') }}</small>
                                            @endif
                                        @else
                                            <span class="text-muted">No duration set</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($link->is_published)
                                            <span class="badge bg-success">Published</span>
                                        @else
                                            <span class="badge bg-danger">Unpublished</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $link->created_at->format('M d, Y') }}</small>
                                    </td>
                                    <td class="text-end">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admission_links.edit', $link->id) }}" 
                                               class="btn btn-soft-primary btn-sm" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{ route('admission_links.toggle_status', $link->id) }}" 
                                               class="btn btn-soft-{{ $link->is_published ? 'warning' : 'success' }} btn-sm" 
                                               title="{{ $link->is_published ? 'Unpublish' : 'Publish' }}">
                                                <i class="fas fa-{{ $link->is_published ? 'eye-slash' : 'eye' }}"></i>
                                            </a>
                                            <form action="{{ route('admission_links.destroy', $link->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-soft-danger btn-sm"
                                                    onclick="return confirm('Are you sure you want to delete this admission link?')"
                                                    title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <p class="text-muted">No admission links found. <a href="{{ route('admission_links.create') }}">Create your first link</a></p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($admissionLinks->hasPages())
                    <div class="d-flex justify-content-center mt-3">
                        {{ $admissionLinks->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        // Search functionality
        document.getElementById('linkSearch').addEventListener('keyup', function() {
            const searchValue = this.value.toLowerCase();
            const rows = document.querySelectorAll('#linkTableBody .link-row');
            
            rows.forEach(row => {
                const title = row.getAttribute('data-title');
                if (title.includes(searchValue)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
@endsection
