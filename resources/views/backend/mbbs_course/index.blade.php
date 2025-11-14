@extends('backend.layouts.app')

@section('contents')
    @include('backend.inc.table_css')
    <div class="container mt-4">
        <div class="card border-0 shadow-sm rounded">
            <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center py-3">
                <div class="d-flex align-items-center gap-2">
                    <div class="bg-primary bg-opacity-10 text-dark rounded d-flex align-items-center justify-content-center"
                        style="width: 32px; height: 32px;">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <h6 class="mb-0 fw-bold">MBBS Course (New Curriculum)</h6>
                </div>
                <a href="{{ route('mbbs-course.create') }}" class="btn btn-soft-primary btn-sm rounded-pill">
                    <i class="fas fa-plus"></i> Add New Category
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

                <!-- 🔍 Search -->
                <div class="row g-2 mb-3 align-items-center">
                    <div class="col-md-4 col-sm-12">
                        <input type="text" id="categorySearch" class="form-control form-control-sm"
                            placeholder="🔍 Search...">
                    </div>
                </div>

                <!-- Categories Tree -->
                <div class="table-responsive">
                    <table id="table-data" class="table mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>SL.</th>
                                <th>Name</th>
                                <th>Parent Category</th>
                                <th>Order</th>
                                <th>Status</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody id="categoryTableBody">
                            @php
                                $sl = 1;
                                function renderCategory($category, $level = 0, &$sl) {
                                    $indent = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $level);
                                    $prefix = $level > 0 ? '<span class="text-muted">├─</span> ' : '';
                            @endphp
                                    <tr class="category-row" data-name="{{ strtolower($category->name) }}" data-level="{{ $level }}">
                                        <td>{{ $sl++ }}</td>
                                        <td>
                                            {!! $indent . $prefix !!}
                                            @if($level == 0)
                                                <strong class="text-primary">{{ $category->name }}</strong>
                                            @else
                                                <strong>{{ $category->name }}</strong>
                                            @endif
                                            @if($category->description)
                                                <br><small class="text-muted">{{ \Illuminate\Support\Str::limit($category->description, 50) }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            @if($category->parent)
                                                <span class="badge bg-info">{{ $category->parent->name }}</span>
                                            @else
                                                <span class="badge bg-success">Root Category</span>
                                            @endif
                                        </td>
                                        <td>{{ $category->order }}</td>
                                        <td>
                                            @if($category->is_active)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('mbbs-course.edit', $category->id) }}" 
                                               class="btn btn-soft-primary btn-sm" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('mbbs-course.destroy', $category->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-soft-danger btn-sm"
                                                    onclick="return confirm('Are you sure you want to delete this category? All child categories will also be deleted.')"
                                                    title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                            @php
                                    // Render children
                                    foreach($category->children as $child) {
                                        renderCategory($child, $level + 1, $sl);
                                    }
                                }
                            @endphp

                            @foreach($categories as $category)
                                @php
                                    renderCategory($category, 0, $sl);
                                @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($categories->isEmpty())
                    <div class="text-center py-5">
                        <p class="text-muted">No categories found. <a href="{{ route('mbbs-course.create') }}">Create your first category</a></p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        // Search functionality
        document.getElementById('categorySearch').addEventListener('keyup', function() {
            const searchValue = this.value.toLowerCase();
            const rows = document.querySelectorAll('#categoryTableBody .category-row');
            
            rows.forEach(row => {
                const name = row.getAttribute('data-name');
                if (name.includes(searchValue)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
@endsection

