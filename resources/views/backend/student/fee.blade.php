@extends('backend.layouts.app')

@section('contents')
<style>
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
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <h6 class="mb-0 fw-bold">Fees</h6>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <!-- Add New Fee -->
                <div class="col-md-4">
                    <form action="{{ route('fee.store') }}" method="POST">
                        @csrf
                        <div class="border-0 mb-4">
                            <h6 class="text-muted fw-semibold">Add New Fee</h6>
                        </div>
                        <div class="row">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Class</label>
                                <select name="class_id" class="form-control form-control-sm" required>
                                    <option value="">-- Select Class --</option>
                                    @foreach($classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Total Seats</label>
                                <input type="number" name="total_seats" class="form-control form-control-sm" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Admission Fee</label>
                                <input type="number" name="admission_fee" class="form-control form-control-sm" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Monthly Fee</label>
                                <input type="number" name="monthly_fee" class="form-control form-control-sm" required>
                            </div>
                        </div>
                        <div class="border-0">
                            <button type="submit" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-save"></i> Save
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Fee List -->
                <div class="col-md-8">
                    <div class="table-responsive">
                        <table class="table mb-0 align-middle">
                            <thead class="table-light">
                                <tr class="text-uppercase text-muted small fw-semibold" style="letter-spacing: 0.05em;">
                                    <th class="py-2">SL.</th>
                                    <th class="py-2">Class</th>
                                    <th class="py-2">Total Seats</th>
                                    <th class="py-2">Admission Fee</th>
                                    <th class="py-2">Monthly Fee</th>
                                    <th class="text-end py-2">Action</th>
                                </tr>
                            </thead>
                            <tbody class="small text-muted">
                                @foreach($fees as $key => $fee)
                                <tr>
                                    <td>{{ $fees->firstItem() + $key }}</td>
                                    <td>{{ $fee->class->name ?? '-' }}</td>
                                    <td>{{ $fee->total_seats }}</td>
                                    <td>{{ number_format($fee->admission_fee, 2) }}</td>
                                    <td>{{ number_format($fee->monthly_fee, 2) }}</td>
                                    <td class="text-end">
                                        <!-- Edit button -->
                                        <button
                                            type="button"
                                            class="btn btn-soft-primary btn-sm rounded-2"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editFeeModal"
                                            data-action="{{ route('fee.update', $fee->id) }}"
                                            data-class="{{ $fee->class_id }}"
                                            data-admission="{{ $fee->admission_fee }}"
                                            data-monthly="{{ $fee->monthly_fee }}"
                                            data-seats="{{ $fee->total_seats }}"
                                            title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>


                                        <!-- Delete button -->
                                        <form action="{{ route('fee.destroy', $fee->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this fee?');">
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

                    <!-- Pagination -->
                    <div class="mt-3">
                        {{ $fees->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Fee Modal -->
<div class="modal fade" id="editFeeModal" tabindex="-1" aria-labelledby="editFeeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editFeeForm" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Fee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body row">
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Class</label>
                        <select id="edit_class_id" name="class_id" class="form-control" required>
                            <option value="">Select Class</option>
                            @foreach($classes as $class)
                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Total Seats</label>
                        <input type="number" id="edit_total_seats" name="total_seats" class="form-control" required>
                    </div>

                    <div class="mb-3 col-md-6">
                        <label class="form-label">Admission Fee</label>
                        <input type="number" id="edit_admission_fee" name="admission_fee" class="form-control" required>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Monthly Fee</label>
                        <input type="number" id="edit_monthly_fee" name="monthly_fee" class="form-control" required>
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
        $('#editFeeModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var actionUrl = button.data('action');
            var classId = button.data('class');
            var admission = button.data('admission');
            var monthly = button.data('monthly');

            $('#editFeeForm').attr('action', actionUrl);
            $('#edit_total_seats').val(button.data('seats'));
            $('#edit_class_id').val(classId);
            $('#edit_admission_fee').val(admission);
            $('#edit_monthly_fee').val(monthly);
        });
    });
</script>
@endsection