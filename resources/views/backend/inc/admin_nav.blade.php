<div class="d-flex align-items-center">
    <button class="toggle-btn d-lg-none">
        <i class="fas fa-bars"></i>
    </button>
    <h5 class="mb-0 ms-3">{{get_setting('school_name')}}</h5>
</div>

<div class="d-flex align-items-center">
    <div class="topbar-actions me-4">
        <a href="{{route('home')}}" class="btn" title="Browse Website">
            <i class="fas fa-external-link-alt"></i>
        </a>
        <a href="{{route('cache')}}" class="btn" title="Clear Cache">
            <i class="fas fa-sync-alt"></i>
        </a>
    </div>

    <div class="dropdown">
        <div class="user-profile dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"
            style="cursor:pointer;">
            <div class="user-avatar bg-white">
                <img src="{{ asset('public/assets/icons/user.png') }}" class="img-fluid" alt="User Avatar">
            </div>
            <div class="user-info">
                <h6 class="user-name mb-0">{{ Auth::user()->name }}</h6>
            </div>
            <i class="fas fa-chevron-down"></i>
        </div>
        <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Profile</a></li>
            <li>
                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                    <i class="fas fa-cog me-2"></i>Change Password
                </a>
            </li>

            <li>
                <hr class="dropdown-divider" />
            </li>
            <li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
                <a class="dropdown-item" href="#"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                </a>
            </li>
        </ul>
    </div>

    <!-- Change Password Modal -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="changePasswordForm" action="{{ route('change.password.update') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <!-- Error Message -->
                        <div id="passwordError" class="alert alert-danger d-none"></div>
                        <!-- Success Message -->
                        <div id="passwordSuccess" class="alert alert-success d-none"></div>

                        <div class="mb-3">
                            <label for="current_password" class="form-label">Current Password</label>
                            <input type="password" name="current_password" id="current_password" class="form-control"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="new_password" class="form-label">New Password</label>
                            <input type="password" name="new_password" id="new_password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                            <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                                class="form-control" required>
                        </div>

                        <!-- Custom Loader -->
                        <div id="passwordLoader" class="d-none text-center my-2">
                            <div class="loader"></div>
                            <div>Updating...</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .loader {
            width: 48px;
            height: 48px;
            border: 3px solid #000000ff;
            border-radius: 50%;
            display: inline-block;
            position: relative;
            box-sizing: border-box;
            animation: rotation 1s linear infinite;
        }

        .loader::after {
            content: '';
            box-sizing: border-box;
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            width: 56px;
            height: 56px;
            border-radius: 50%;
            border: 3px solid;
            border-color: #3498db transparent;
        }

        @keyframes rotation {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('changePasswordForm');
            const loader = document.getElementById('passwordLoader');
            const submitBtn = form.querySelector('button[type="submit"]');
            const modalEl = document.getElementById('changePasswordModal');

            // Ensure loader is hidden on page load
            loader.classList.add('d-none');

            form.addEventListener('submit', function () {
                // Show loader and disable submit button
                loader.classList.remove('d-none');
                submitBtn.disabled = true;
            });

            // Reset loader and form when modal is closed
            modalEl.addEventListener('hidden.bs.modal', function () {
                loader.classList.add('d-none');
                submitBtn.disabled = false;
                form.reset();
            });
        });
    </script>
</div>
<style>
    .modal-backdrop {
        --bs-backdrop-zindex: 0;
        /* or any other value */
        z-index: 0;
        /* or any low value */
    }
</style>
<script>
    document.getElementById('changePasswordForm').addEventListener('submit', function (e) {
        e.preventDefault();

        let form = this;
        let formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value
            },
            body: formData
        })
            .then(res => res.json())
            .then(data => {
                let errorBox = document.getElementById('passwordError');
                let successBox = document.getElementById('passwordSuccess');

                errorBox.classList.add('d-none');
                successBox.classList.add('d-none');

                if (data.status === 'error') {
                    errorBox.textContent = data.message;
                    errorBox.classList.remove('d-none');
                } else {
                    successBox.textContent = data.message;
                    successBox.classList.remove('d-none');
                    form.reset();
                    setTimeout(() => {
                        bootstrap.Modal.getInstance(document.getElementById('changePasswordModal')).hide();
                    }, 1500);
                }
            })
            .catch(err => console.error(err));
    });
</script>