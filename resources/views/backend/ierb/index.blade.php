@extends('backend.layouts.app')

@section('contents')
<div class="container mt-4">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded mb-4">
        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
            <div class="d-flex align-items-center gap-2">
                <div class="bg-primary bg-opacity-10 text-dark rounded d-flex align-items-center justify-content-center"
                    style="width: 32px; height: 32px;"><i class="fas fa-users"></i></div>
                <h6 class="mb-0 fw-bold">IERB Members</h6>
            </div>
            <button class="btn btn-soft-primary btn-sm rounded-pill" data-bs-toggle="modal"
                data-bs-target="#addMemberModal"><i class="fas fa-plus"></i> Add New</button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table mb-0 align-middle">
                    <thead class="table-light">
                        <tr class="text-uppercase text-muted small fw-semibold">
                            <th>SL.</th>
                            <th>Order</th>
                            <th>Name and Affiliation</th>
                            <th>Role / Designation</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody class="small text-muted">
                        @forelse($members as $member)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $member->sort_order }}</td>
                                <td>{{ $member->name_affiliation }}</td>
                                <td>{{ $member->role }}</td>
                                <td class="text-end">
                                    <button type="button" class="btn btn-soft-primary btn-sm rounded-2 btn-edit-member"
                                        data-action="{{ route('ierb_member.update', $member->id) }}"
                                        data-bs-toggle="modal" data-bs-target="#editMemberModal"
                                        data-name_affiliation="{{ $member->name_affiliation }}"
                                        data-role="{{ $member->role }}"
                                        data-sort_order="{{ $member->sort_order }}" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <form action="{{ route('ierb_member.destroy', $member->id) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-soft-danger btn-sm rounded-2" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">No members found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded">
        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
            <div class="d-flex align-items-center gap-2">
                <div class="bg-primary bg-opacity-10 text-dark rounded d-flex align-items-center justify-content-center"
                    style="width: 32px; height: 32px;"><i class="fas fa-clipboard-list"></i></div>
                <h6 class="mb-0 fw-bold">IERB Activities</h6>
            </div>
            <button class="btn btn-soft-primary btn-sm rounded-pill" data-bs-toggle="modal"
                data-bs-target="#addActivityModal"><i class="fas fa-plus"></i> Add New</button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table mb-0 align-middle">
                    <thead class="table-light">
                        <tr class="text-uppercase text-muted small fw-semibold">
                            <th>SL.</th>
                            <th>Topics</th>
                            <th>Principal Investigator</th>
                            <th>Date</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody class="small text-muted">
                        @forelse($activities as $activity)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $activity->topic }}</td>
                                <td>{{ $activity->principal_investigator }}</td>
                                <td>{{ \Carbon\Carbon::parse($activity->activity_date)->format('d.m.Y') }}</td>
                                <td class="text-end">
                                    <button type="button" class="btn btn-soft-primary btn-sm rounded-2 btn-edit-activity"
                                        data-action="{{ route('ierb_activity.update', $activity->id) }}"
                                        data-bs-toggle="modal" data-bs-target="#editActivityModal"
                                        data-topic="{{ $activity->topic }}"
                                        data-principal_investigator="{{ $activity->principal_investigator }}"
                                        data-activity_date="{{ $activity->activity_date }}" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <form action="{{ route('ierb_activity.destroy', $activity->id) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-soft-danger btn-sm rounded-2" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">No activities found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Member Modal -->
<div class="modal fade" id="addMemberModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded border-0 shadow-sm">
            <form class="needs-validation" action="{{ route('ierb_member.store') }}" method="POST" novalidate>
                @csrf
                <div class="modal-header border-0">
                    <h6 class="modal-title"><i class="fas fa-user-plus me-1"></i> Add IERB Member</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body small text-muted">
                    <div class="mb-3">
                        <label class="form-label">Name and Affiliation <span class="text-danger">*</span></label>
                        <input type="text" name="name_affiliation" class="form-control" required>
                        <div class="invalid-feedback">Please enter name and affiliation.</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Role / Designation <span class="text-danger">*</span></label>
                        <input type="text" name="role" class="form-control" required>
                        <div class="invalid-feedback">Please enter role or designation.</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Order</label>
                        <input type="number" name="sort_order" class="form-control" min="0" value="0">
                        <small class="text-muted">Smaller number shows first.</small>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-outline-primary btn-sm">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Member Modal -->
<div class="modal fade" id="editMemberModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded border-0 shadow-sm">
            <form id="editMemberForm" class="needs-validation" method="POST" novalidate>
                @csrf
                @method('PUT')
                <div class="modal-header border-0">
                    <h6 class="modal-title">Edit IERB Member</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body small text-muted">
                    <div class="mb-3">
                        <label class="form-label">Name and Affiliation <span class="text-danger">*</span></label>
                        <input type="text" name="name_affiliation" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Role / Designation <span class="text-danger">*</span></label>
                        <input type="text" name="role" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Order</label>
                        <input type="number" name="sort_order" class="form-control" min="0">
                        <small class="text-muted">Smaller number shows first.</small>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-outline-primary btn-sm">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Activity Modal -->
<div class="modal fade" id="addActivityModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded border-0 shadow-sm">
            <form class="needs-validation" action="{{ route('ierb_activity.store') }}" method="POST" novalidate>
                @csrf
                <div class="modal-header border-0">
                    <h6 class="modal-title"><i class="fas fa-plus me-1"></i> Add IERB Activity</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body small text-muted">
                    <div class="mb-3">
                        <label class="form-label">Topics <span class="text-danger">*</span></label>
                        <textarea name="topic" class="form-control" rows="3" required></textarea>
                        <div class="invalid-feedback">Please enter topic.</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Principal Investigator <span class="text-danger">*</span></label>
                        <input type="text" name="principal_investigator" class="form-control" required>
                        <div class="invalid-feedback">Please enter principal investigator.</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Date <span class="text-danger">*</span></label>
                        <input type="date" name="activity_date" class="form-control" required>
                        <div class="invalid-feedback">Please select date.</div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-outline-primary btn-sm">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Activity Modal -->
<div class="modal fade" id="editActivityModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded border-0 shadow-sm">
            <form id="editActivityForm" class="needs-validation" method="POST" novalidate>
                @csrf
                @method('PUT')
                <div class="modal-header border-0">
                    <h6 class="modal-title">Edit IERB Activity</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body small text-muted">
                    <div class="mb-3">
                        <label class="form-label">Topics <span class="text-danger">*</span></label>
                        <textarea name="topic" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Principal Investigator <span class="text-danger">*</span></label>
                        <input type="text" name="principal_investigator" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Date <span class="text-danger">*</span></label>
                        <input type="date" name="activity_date" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-outline-primary btn-sm">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.querySelectorAll('.btn-edit-member').forEach(button => {
        button.addEventListener('click', function () {
            const form = document.getElementById('editMemberForm');
            form.action = this.dataset.action;
            form.querySelector('input[name="name_affiliation"]').value = this.dataset.name_affiliation || '';
            form.querySelector('input[name="role"]').value = this.dataset.role || '';
            form.querySelector('input[name="sort_order"]').value = this.dataset.sort_order || 0;
        });
    });

    document.querySelectorAll('.btn-edit-activity').forEach(button => {
        button.addEventListener('click', function () {
            const form = document.getElementById('editActivityForm');
            form.action = this.dataset.action;
            form.querySelector('textarea[name="topic"]').value = this.dataset.topic || '';
            form.querySelector('input[name="principal_investigator"]').value = this.dataset.principal_investigator || '';
            form.querySelector('input[name="activity_date"]').value = this.dataset.activity_date || '';
        });
    });
</script>
@endsection
