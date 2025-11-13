<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ get_setting('meta_title', get_setting('site_title', 'Biddaniketon Edu | 4axiz')) }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet" />
    <link rel="shortcut icon" href="{{ asset(get_setting('school_logo', 'favicon.ico')) }}" type="image/x-icon">
    <link rel="icon" href="{{ asset(get_setting('school_logo', 'favicon.ico')) }}" type="image/x-icon">

    <style>
        :root {
            --sidebar-bg: #232734;
            --sidebar-text: #ecf0f1;
            --sidebar-hover: #3498db;
            --topbar-bg: #ffffff;
            --content-bg: #f8f9fa;
            --primary: #3498db;
            --success: #27ae60;
            --warning: #f39c12;
            --danger: #e74c3c;
        }

        /* Soft Button Styles */
        .btn-soft-primary {
            background-color: rgba(13, 110, 253, 0.1);
            color: #0d6efd;
            border: none;
        }

        .btn-soft-primary:hover {
            background-color: rgba(13, 110, 253, 0.15);
            color: #0b5ed7;
        }

        .btn-soft-success {
            background-color: rgba(25, 135, 84, 0.1);
            color: #198754;
            border: none;
        }

        .btn-soft-success:hover {
            background-color: rgba(25, 135, 84, 0.15);
            color: #146c43;
        }

        .btn-soft-danger {
            background-color: rgba(220, 53, 69, 0.1);
            color: #dc3545;
            border: none;
        }

        .btn-soft-danger:hover {
            background-color: rgba(220, 53, 69, 0.15);
            color: #bb2d3b;
        }

        .btn-soft-warning {
            background-color: rgba(255, 193, 7, 0.1);
            color: #ffc107;
            border: none;
        }

        .btn-soft-warning:hover {
            background-color: rgba(255, 193, 7, 0.15);
            color: #d39e00;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
            background: linear-gradient(135deg, #fdf1ff, #eef9ff, #f4fff4);
            min-height: 100vh;
        }

        /* Sidebar styling */
        .sidebar {
            background-color: var(--sidebar-bg);
            color: var(--sidebar-text);
            height: 100vh;
            position: fixed;
            width: 280px;
        }

        .sidebar-brand {
            position: sticky;
            top: 0;
            padding: 15px 12px;
            background-color: var(--sidebar-bg);
        }

        .sidebar-brand img {
            height: 40px;
            margin-left: 22px;

        }

        .sidebar-search {
            padding: 15px;
        }

        .sidebar-search input {
            background-color: rgba(255, 255, 255, 0.1);
            border: none;
            color: white;
            border-radius: 4px;
        }

        .sidebar-search input:focus {
            background-color: rgba(255, 255, 255, 0.15);
            box-shadow: none;
        }

        .sidebar-search input::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        .sidebar-nav {
            height: calc(100vh - 60px);
            /* 60px = height of search bar */
            overflow-y: auto;
            padding: 10px 0;
        }

        .sidebar-nav::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar-nav::-webkit-scrollbar-thumb {
            background-color: rgba(255, 255, 255, 0.3);
            border-radius: 3px;
        }

        .sidebar-nav::-webkit-scrollbar-track {
            background: transparent;
        }

        .nav-item {
            margin: 5px 0;
        }

        .nav-item span {
            font-size: 14px;
            font-weight: 500;
        }

        .nav-link {
            color: var(--sidebar-text);
            padding: 12px 20px;
            border-radius: 4px;
            margin: 0 10px;
            display: flex;
            align-items: center;
            transition: all 0.2s;
            cursor: pointer;
        }

        .nav-link:hover {
            background-color: var(--sidebar-hover) !important;
            color: white;
        }

        .nav-link.active {
            background-color: var(--sidebar-hover) !important;
            color: white;
        }

        .nav-link i {
            width: 25px;
            text-align: center;
            margin-right: 10px;
            font-size: 18px;
        }

        .nav-link .arrow {
            margin-left: auto;
            transition: transform 0.3s;
            transform: rotate(-90deg);
        }

        .nav-link:not(.collapsed) .arrow {
            transform: rotate(0deg);
        }

        .submenu {
            background-color: rgba(0, 0, 0, 0.1);
            border-radius: 4px;
            margin: 5px 15px;
        }

        .submenu h6 {
            padding-left: 30px;
        }

        .submenu .nav-link {
            padding: 8px 15px;
            font-size: 13px;
        }

        /* Topbar styling */
        .topbar {
            background-color: var(--topbar-bg);
            height: 70px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            position: fixed;
            top: 0;
            left: 280px;
            right: 0;
            z-index: 100;
            padding: 0 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .toggle-btn {
            background: none;
            border: none;
            font-size: 20px;
            color: #555;
            cursor: pointer;
        }

        .topbar-actions .btn {
            margin-left: 10px;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background-color: #f1f1f1;
            color: #555;
            transition: all 0.2s;
        }

        .topbar-actions .btn:hover {
            background-color: var(--primary);
            color: white;
        }

        .user-profile {
            display: flex;
            align-items: center;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            margin-right: 10px;
        }

        .user-info {
            margin-right: 15px;
        }

        .user-name {
            font-weight: 600;
            margin: 0;
            font-size: 15px;
        }

        .user-role {
            font-size: 12px;
            color: #777;
            margin: 0;
        }

        /* Main content */
        .main-content {
            /* margin-top: 70px; */
            margin-left: 280px;
            padding: 20px;
            min-height: calc(100vh - 70px);
        }

        .page-header {
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }

        .stat-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            padding: 20px;
            margin-bottom: 20px;
            transition: transform 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-card i {
            font-size: 24px;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
        }

        .stat-card .bi-dashboard {
            background-color: rgba(52, 152, 219, 0.2);
            color: var(--primary);
        }

        .stat-card .bi-files {
            background-color: rgba(46, 204, 113, 0.2);
            color: var(--success);
        }

        .stat-card .bi-people {
            background-color: rgba(155, 89, 182, 0.2);
            color: #9b59b6;
        }

        .stat-card .bi-gear {
            background-color: rgba(241, 196, 15, 0.2);
            color: var(--warning);
        }

        .stat-card h5 {
            font-size: 14px;
            color: #777;
            margin-bottom: 5px;
        }

        .stat-card h2 {
            font-size: 28px;
            font-weight: 700;
        }

        .dashboard-section {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            padding: 25px;
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }

        .recent-activity .activity-item {
            display: flex;
            padding: 15px 0;
            border-bottom: 1px solid #f1f1f1;
        }

        .recent-activity .activity-item:last-child {
            border-bottom: none;
        }

        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: rgba(52, 152, 219, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            color: var(--primary);
            flex-shrink: 0;
        }

        .activity-details h5 {
            margin: 0;
            font-size: 15px;
        }

        .activity-details p {
            margin: 5px 0 0;
            font-size: 13px;
            color: #777;
        }

        .activity-time {
            color: #999;
            font-size: 12px;
            margin-top: 3px;
        }

        .footer {
            text-align: center;
            padding: 20px;
            color: #777;
            font-size: 14px;
            border-top: 1px solid #eee;
            background: white;
            margin-left: 280px;
        }

        /* Responsive adjustments */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .topbar {
                left: 0;
            }

            .main-content {
                margin-left: 0;
            }

            .footer {
                margin-left: 0;
            }
        }

        .dropdown-toggle::after {
            content: none;
        }

        .submenu .nav-link {
            position: relative;
            padding-left: 48px;
            /* space for the icon */
        }

        .submenu .nav-link::before {
            position: absolute;
            content: "";
            height: 8px;
            width: 8px;
            border: 1px solid #575b6a;
            border-radius: 50%;
            top: calc(50% - 4px);
            left: 30px;
            transition: all 0.3s ease;
        }

        .submenu .nav-link:hover::before {
            background-color: #cfd4e6;
            border-color: #575b6a;
            transform: scale(1.2);

        }
    </style>
</head>

<body>
    <div class="sidebar-brand">
        <a href="{{ route('dashboard') }}">
            <img src="{{ asset('/public/assets/icons/biddaniketon-logo.png') }}" alt="Logo"></a>
    </div>
    <!-- Sidebar -->
    <div class="side">
        @include('backend.inc.admin_sidenav')
    </div>
    <!-- Topbar -->
    <div class="topbar">
        @include('backend.inc.admin_nav')
    </div>

    <!-- Main Content -->
    <div class="main-content">
        @yield('contents')
    </div>

    <!-- Footer -->
    <div class="footer">
        <p class="mb-0">© School v1.0 | Designed & Developed by Biddaniketon</p>
    </div>

    <div aria-live="polite" aria-atomic="true" class="position-fixed bottom-0 start-0 p-3" style="z-index: 1100;">

        <div id="commonToast" class="toast align-items-center border-0" role="alert" aria-live="assertive"
            aria-atomic="true" style="transform: translateX(-120%); transition: transform 0.4s ease-in-out;">
            <div class="d-flex">
                <div id="commonToastBody" class="toast-body small text-white">
                    <!-- message will be inserted here -->
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @yield('scripts') <!-- custom scripts come last -->


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toastEl = document.getElementById('commonToast');
            if (!toastEl) return;

            // Map Laravel session keys to Bootstrap bg classes
            const typeClassMap = {
                'success': 'bg-success',
                'error': 'bg-danger',
                'warning': 'bg-warning text-dark',
                'info': 'bg-info text-dark'
            };

            // Laravel flashes passed as JSON in a meta tag or inline script
            // For simplicity, parse from a global JS object injected from Blade:
            const flashMessages = {
                @if(session('success'))
                    success: "{{ session('success') }}",
                @endif
            @if(session('error'))
                error: "{{ session('error') }}",
            @endif
                @if(session('warning'))
                    warning: "{{ session('warning') }}",
                @endif
                @if(session('info'))
                    info: "{{ session('info') }}",
                @endif
            };

        // Find the first flash message type present
        const types = Object.keys(flashMessages);
        if (types.length === 0) return; // no flash, do nothing

        const type = types[0];
        const message = flashMessages[type];

        const toastBody = document.getElementById('commonToastBody');

        // Remove all bg-* classes from toast
        toastEl.className = toastEl.className
            .split(' ')
            .filter(c => !c.startsWith('bg-') && !c.startsWith('text-'))
            .join(' ');

        // Add new bg class for the type
        toastEl.classList.add(typeClassMap[type]);

        // Set text color if needed
        if (typeClassMap[type].includes('text-dark')) {
            toastBody.classList.add('text-dark');
            toastBody.classList.remove('text-white');
        } else {
            toastBody.classList.add('text-white');
            toastBody.classList.remove('text-dark');
        }

        // Set the message text
        toastBody.textContent = message;

        // Slide in
        setTimeout(() => {
            toastEl.style.transform = 'translateX(0)';
        }, 100);

        // Show Bootstrap toast with 4s delay
        const bsToast = new bootstrap.Toast(toastEl, {
            delay: 4000
        });
        bsToast.show();

        // Slide out after hide
        toastEl.addEventListener('hidden.bs.toast', () => {
            toastEl.style.transform = 'translateX(-120%)';
        });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const sidebar = document.querySelector('.sidebar-nav');
            const activeLink = sidebar.querySelector('.nav-link.active');

            if (activeLink) {
                // Scroll sidebar so active link is visible
                sidebar.scrollTop = activeLink.offsetTop - sidebar.offsetTop - sidebar.clientHeight / 2 + activeLink.clientHeight / 2;
            }
        });
    </script>


</body>

</html>