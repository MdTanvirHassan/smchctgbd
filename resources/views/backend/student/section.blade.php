@extends('backend.layouts.app')

@section('contents')
<style>
    /* Soft, subtle borders for a cleaner look */
    .table td,
    .table th {
        border-color: rgba(0, 0, 0, 0.05) !important;
    }

    .card {
        border: 1px solid rgba(0, 0, 0, 0.05) !important;
    }

    .card-header {
        height: 65px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05) !important;
    }
</style>

<div class="container mt-4">
    <div class="card border-0 shadow-sm rounded">
        <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center py-3">
            <div class="d-flex align-items-center gap-2">
                <div class="bg-primary bg-opacity-10 text-dark rounded d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <h6 class="mb-0 fw-bold">Section</h6>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <form action="{{ route('class.store') }}" method="POST">
                        @csrf
                        <div class="border-0 mb-4">
                            <h6 class="text-muted fw-semibold" id="addNoticeModalLabel">Add New Class</h6>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Class Name</label>
                            <input name="name" class="form-control form-control-sm" rows="3" required></input>
                        </div>
                        <div class="border-0">
                            <button type="submit" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-save"></i> Save
                            </button>
                        </div>
                    </form>
                </div>
                <div class="col-md-8">
                    <div class="table-responsive">
                        <table class="table mb-0 align-middle">
                            <thead class="table-light">
                                <tr class="text-uppercase text-muted small fw-semibold" style="letter-spacing: 0.05em;">
                                    <th class="py-2">SL</th>
                                    <th class="py-2">Class</th>
                                    <th class="text-end py-2">Action</th>
                                </tr>
                            </thead>

                            <tbody class="small text-muted">
                                @foreach($classs as $class)
                                <tr>
                                    <td>1</td>
                                    <td>{{ $class->name }}</td>

                                    <td class="text-end">
                                        <!-- Edit button -->
                                        <button
                                            type="button"
                                            class="btn btn-soft-primary btn-sm rounded-2"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editClassModal"
                                            data-action="{{ route('class.update', $class->id) }}"
                                            data-name="{{ $class->name }}"
                                            title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        <!-- Delete button -->
                                        <form action="{{ route('class.destroy', $class->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this class?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-soft-danger btn-sm rounded-2" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>

                                    </td>
                                </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="editClassModal" tabindex="-1" aria-labelledby="editClassModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editClassForm" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Class</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Class Name</label>
                        <input type="text" id="edit_name" name="name" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
@section('scripts')
<script>
    $(document).ready(function() {
        $('#editClassModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var actionUrl = button.data('action');
            var name = button.data('name');

            $('#editClassForm').attr('action', actionUrl);
            $('#edit_name').val(name);
        });
    });
</script>
@endsection