<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('site-title') — Admin</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="{{ url('backend/vendor/fonts/boxicons.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ url('backend/vendor/css/core.css') }}" />
    <link rel="stylesheet" href="{{ url('backend/vendor/css/theme-default.css') }}" />
    <link rel="stylesheet" href="{{ url('backend/css/demo.css') }}" />
    <link rel="stylesheet" href="{{ url('backend/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

    <!-- Select2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

    <script src="{{ url('backend/vendor/js/helpers.js') }}"></script>
    <script src="{{ url('backend/js/config.js') }}"></script>

    <style>
        /* ── Base ── */
        *, *::before, *::after { box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: #f4f5fb;
            overflow-x: hidden;
        }

        /* ── Sidebar ── */
        #layout-menu {
            background: #fff !important;
            border-right: none !important;
            box-shadow: 2px 0 12px rgba(0,0,0,0.06);
            transition: width 0.3s ease;
        }

        /* Brand */
        .app-brand {
            padding: 1.2rem 1.5rem !important;
            border-bottom: 1px solid #f0f0f0 !important;
        }

        .app-brand-logo {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar-logo {
            height: 36px;
            width: auto;
            object-fit: contain;
        }

        .app-brand-text {
            color: #fff !important;
            font-size: 1rem !important;
            font-weight: 800 !important;
            letter-spacing: 0.06em !important;
        }

        /* Menu items */
        .menu-inner > .menu-item > .menu-link {
            color: #555 !important;
            border-radius: 8px !important;
            margin: 2px 12px !important;
            padding: 0.6rem 1rem !important;
            transition: all 0.15s !important;
            font-size: 0.88rem !important;
            font-weight: 500 !important;
        }

        .menu-inner > .menu-item > .menu-link:hover,
        .menu-inner > .menu-item.active > .menu-link {
            background: #f5f5f5 !important;
            color: #222 !important;
        }

        .menu-inner > .menu-item.active > .menu-link {
            background: #222 !important;
            color: #fff !important;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15) !important;
        }

        .menu-icon { color: #aaa !important; }

        .menu-inner > .menu-item.active > .menu-link .menu-icon,
        .menu-inner > .menu-item > .menu-link:hover .menu-icon {
            color: #222 !important;
        }

        /* Submenu */
        .menu-sub {
            background: #f8f8f8 !important;
            border-radius: 6px !important;
            margin: 0 12px !important;
            padding: 4px 0 !important;
        }

        .menu-sub .menu-item .menu-link {
            color: #666 !important;
            font-size: 0.83rem !important;
            padding: 0.45rem 1rem 0.45rem 2.5rem !important;
            border-radius: 6px !important;
            transition: all 0.15s !important;
        }

        .menu-sub .menu-item .menu-link:hover {
            color: #222 !important;
            background: #efefef !important;
        }

        /* Menu section label */
        .menu-header {
            color: #bbb !important;
            font-size: 0.68rem !important;
            letter-spacing: 0.1em !important;
            text-transform: uppercase !important;
            padding: 1rem 1.5rem 0.3rem !important;
            font-weight: 700 !important;
        }

        /* Order badge */
        .order-badge {
            background: #e74c3c;
            color: #fff;
            font-size: 0.65rem;
            font-weight: 800;
            min-width: 20px;
            height: 20px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0 5px;
            margin-left: 8px;
        }

        /* Toggle arrow */
        .menu-arrow {
            color: #ccc !important;
        }

        /* ── Navbar ── */
        #layout-navbar {
            background: #fff !important;
            border-bottom: 1px solid #eee !important;
            box-shadow: 0 1px 8px rgba(0,0,0,0.05) !important;
            padding: 0.75rem 1.5rem !important;
        }

        .page-main-title {
            font-size: 1rem !important;
            font-weight: 700 !important;
            color: #222 !important;
            letter-spacing: 0.02em !important;
        }

        /* Avatar */
        .avatar img {
            width: 38px !important;
            height: 38px !important;
            object-fit: cover !important;
            border-radius: 50% !important;
            border: 2px solid #eee !important;
            transition: border-color 0.15s !important;
        }

        .avatar img:hover { border-color: #e74c3c !important; }

        /* Dropdown */
        .dropdown-menu {
            border: none !important;
            box-shadow: 0 8px 24px rgba(0,0,0,0.12) !important;
            border-radius: 8px !important;
            padding: 0.5rem !important;
        }

        .dropdown-item {
            border-radius: 6px !important;
            font-size: 0.88rem !important;
            padding: 0.5rem 0.85rem !important;
            color: #444 !important;
            font-weight: 500 !important;
            transition: background 0.12s !important;
        }

        .dropdown-item:hover {
            background: #f5f5f5 !important;
            color: #222 !important;
        }

        .dropdown-item.text-danger:hover {
            background: #fff5f5 !important;
            color: #e74c3c !important;
        }

        /* ── Content area ── */
        .content-wrapper {
            background: #f4f5fb !important;
            padding: 1.5rem !important;
        }

        /* ── Cards ── */
        .card {
            border: none !important;
            border-radius: 10px !important;
            box-shadow: 0 1px 8px rgba(0,0,0,0.06) !important;
        }

        .card-header {
            background: #fff !important;
            border-bottom: 1px solid #f0f0f0 !important;
            border-radius: 10px 10px 0 0 !important;
            padding: 1rem 1.25rem !important;
            font-weight: 700 !important;
            font-size: 0.9rem !important;
        }

        /* ── Tables ── */
        .table {
            font-size: 0.88rem !important;
        }

        .table thead th {
            background: #fafafa !important;
            font-size: 0.72rem !important;
            font-weight: 700 !important;
            letter-spacing: 0.07em !important;
            text-transform: uppercase !important;
            color: #888 !important;
            border-bottom: 2px solid #f0f0f0 !important;
            padding: 0.75rem 1rem !important;
            white-space: nowrap !important;
        }

        .table tbody td {
            padding: 0.75rem 1rem !important;
            vertical-align: middle !important;
            color: #444 !important;
            border-bottom: 1px solid #f8f8f8 !important;
        }

        .table tbody tr:hover { background: #fafafa !important; }

        /* ── Buttons ── */
        .btn-primary {
            background: #222 !important;
            border-color: #222 !important;
            font-weight: 700 !important;
            letter-spacing: 0.04em !important;
            border-radius: 6px !important;
            font-size: 0.85rem !important;
        }

        .btn-primary:hover {
            background: #e74c3c !important;
            border-color: #e74c3c !important;
        }

        .btn-danger {
            background: #e74c3c !important;
            border-color: #e74c3c !important;
            border-radius: 6px !important;
        }

        .btn-danger:hover {
            background: #c0392b !important;
            border-color: #c0392b !important;
        }

        .btn-sm {
            padding: 0.35rem 0.75rem !important;
            font-size: 0.78rem !important;
        }

        /* ── Pagination ── */
        .pagination {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin: 1rem 0 0;
            padding: 0;
            list-style: none;
        }

        .pagination li a,
        .pagination li span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 34px;
            height: 34px;
            padding: 0 8px;
            font-size: 0.82rem;
            font-weight: 700;
            border: 1.5px solid #e0e0e0;
            border-radius: 6px;
            color: #555;
            text-decoration: none;
            background: #fff;
            transition: all 0.15s;
        }

        .pagination li a:hover {
            background: #222;
            color: #fff;
            border-color: #222;
        }

        .pagination li.active a {
            background: #e74c3c;
            color: #fff;
            border-color: #e74c3c;
        }

        .pagination li.disabled span {
            color: #ccc;
            cursor: not-allowed;
        }

        /* ── Form inputs ── */
        .form-control, .form-select {
            border: 1.5px solid #e0e0e0 !important;
            border-radius: 6px !important;
            font-size: 0.88rem !important;
            color: #333 !important;
            transition: border-color 0.15s, box-shadow 0.15s !important;
        }

        .form-control:focus, .form-select:focus {
            border-color: #222 !important;
            box-shadow: 0 0 0 3px rgba(34,34,34,0.08) !important;
        }

        .form-label {
            font-size: 0.78rem !important;
            font-weight: 700 !important;
            letter-spacing: 0.06em !important;
            text-transform: uppercase !important;
            color: #666 !important;
            margin-bottom: 6px !important;
        }

        /* ── Mode switcher ── */
        .mode-switcher {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 0.45rem 0.9rem;
            background: #f5f5f5;
            border: 1.5px solid #e0e0e0;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 700;
            color: #444;
            text-decoration: none;
            transition: all 0.15s;
            white-space: nowrap;
        }

        .mode-switcher:hover {
            background: #222;
            color: #fff;
            border-color: #222;
        }

        .mode-switcher i { font-size: 1rem; }

        @media (max-width: 400px) {
            .mode-switcher { padding: 0.4rem 0.6rem; }
        }

        /* ── Mobile responsive ── */
        @media (max-width: 991px) {
            .content-wrapper { padding: 1rem !important; }

            .table thead th,
            .table tbody td { padding: 0.6rem 0.75rem !important; }

            #layout-navbar { padding: 0.6rem 1rem !important; }
        }

        @media (max-width: 575px) {
            .content-wrapper { padding: 0.75rem !important; }
            .card { border-radius: 8px !important; }
            .page-main-title { font-size: 0.9rem !important; }
        }
    </style>
</head>

<body class="light-style layout-menu-fixed">
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">

        <!-- ── SIDEBAR ── -->
        <aside id="layout-menu" class="layout-menu menu-vertical menu">

            <div class="app-brand demo">
                <a href="/admin" class="app-brand-link app-brand-logo">
                    @php $logo = DB::table('logo')->first(); @endphp
                    @if ($logo)
                        <img src="/uploads/{{ $logo->thumbnail }}" alt="Logo" class="sidebar-logo">
                    @else
                        <span class="app-brand-text">ADMIN</span>
                    @endif
                </a>
                <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                    <i class="bx bx-chevron-left bx-sm align-middle" style="color:#888;"></i>
                </a>
            </div>

            <div class="menu-inner-shadow"></div>

            <ul class="menu-inner py-1">

                {{-- Dashboard --}}
                <li class="menu-item {{ Request::is('admin') ? 'active' : '' }}">
                    <a href="/admin" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-home-circle"></i>
                        <div>Dashboard</div>
                    </a>
                </li>

                {{-- Logo --}}
                <li class="menu-item {{ Request::is('admin/list-logo') || Request::is('admin/add-logo') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons bx bx-image"></i>
                        <div>Logo</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ Request::is('admin/list-logo') ? 'active' : '' }}">
                            <a href="/admin/list-logo" class="menu-link"><div>View Logos</div></a>
                        </li>
                        <li class="menu-item {{ Request::is('admin/add-logo') ? 'active' : '' }}">
                            <a href="/admin/add-logo" class="menu-link"><div>Add Logo</div></a>
                        </li>
                    </ul>
                </li>

                {{-- Products --}}
                <li class="menu-item {{ Request::is('admin/list-product*') || Request::is('admin/add-product') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons bx bx-shopping-bag"></i>
                        <div>Products</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ Request::is('admin/list-product*') ? 'active' : '' }}">
                            <a href="/admin/list-product/" class="menu-link"><div>View Products</div></a>
                        </li>
                        <li class="menu-item {{ Request::is('admin/add-product') ? 'active' : '' }}">
                            <a href="/admin/add-product" class="menu-link"><div>Add Product</div></a>
                        </li>
                    </ul>
                </li>

                {{-- Category --}}
                <li class="menu-item {{ Request::is('admin/list-category') || Request::is('admin/add-category') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons bx bx-category"></i>
                        <div>Category</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ Request::is('admin/list-category') ? 'active' : '' }}">
                            <a href="/admin/list-category" class="menu-link"><div>View Categories</div></a>
                        </li>
                        <li class="menu-item {{ Request::is('admin/add-category') ? 'active' : '' }}">
                            <a href="/admin/add-category" class="menu-link"><div>Add Category</div></a>
                        </li>
                    </ul>
                </li>

                {{-- Attribute --}}
                <li class="menu-item {{ Request::is('admin/list-attribute') || Request::is('admin/add-attribute') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons bx bx-tag"></i>
                        <div>Attribute</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ Request::is('admin/list-attribute') ? 'active' : '' }}">
                            <a href="/admin/list-attribute" class="menu-link"><div>View Attributes</div></a>
                        </li>
                        <li class="menu-item {{ Request::is('admin/add-attribute') ? 'active' : '' }}">
                            <a href="/admin/add-attribute" class="menu-link"><div>Add Attribute</div></a>
                        </li>
                    </ul>
                </li>

                {{-- Orders --}}
                <li class="menu-item {{ Request::is('admin/view-order*') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons bx bx-receipt"></i>
                        <div>Orders</div>
                        @if (isset($orderRow) && $orderRow > 0)
                            <span class="order-badge">{{ $orderRow }}</span>
                        @endif
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ Request::is('admin/view-order') ? 'active' : '' }}">
                            <a href="/admin/view-order" class="menu-link"><div>View Orders</div></a>
                        </li>
                    </ul>
                </li>

                {{-- Log Activity --}}
                <li class="menu-item {{ Request::is('admin/log-activity') ? 'active' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons bx bx-history"></i>
                        <div>Log Activity</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ Request::is('admin/log-activity') ? 'active' : '' }}">
                            <a href="/admin/log-activity" class="menu-link"><div>View Logs</div></a>
                        </li>
                    </ul>
                </li>

            </ul>
        </aside>
        <!-- / Sidebar -->

        <!-- ── CONTENT ── -->
        <div class="layout-page">

            <!-- Navbar -->
            <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
                 id="layout-navbar">

                <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                    <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                        <i class="bx bx-menu bx-sm"></i>
                    </a>
                </div>

                <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">

                    {{-- Page title --}}
                    <div class="navbar-nav align-items-center">
                        <h4 class="page-main-title m-0">
                            @yield('page-main-title')
                        </h4>
                    </div>

                    <ul class="navbar-nav flex-row align-items-center ms-auto gap-2">

                        {{-- ── Admin/Client mode switcher ── --}}
                        <li class="nav-item">
                            <a href="/" target="_blank" class="mode-switcher" title="View client site">
                                <i class="bx bx-store-alt"></i>
                                <span class="d-none d-md-inline">Client Site</span>
                            </a>
                        </li>

                        {{-- User dropdown --}}
                        <li class="nav-item navbar-dropdown dropdown-user dropdown">
                            <a class="nav-link dropdown-toggle hide-arrow d-flex align-items-center gap-2"
                               href="javascript:void(0);" data-bs-toggle="dropdown">
                                <div class="avatar avatar-online">
                                    @if (Auth::user()->profile)
                                        <img src="/uploads/{{ Auth::user()->profile }}" alt="Profile">
                                    @else
                                        <div style="width:38px;height:38px;border-radius:50%;background:#222;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:800;font-size:1rem;">
                                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                        </div>
                                    @endif
                                </div>
                                <span class="d-none d-md-block fw-600" style="font-size:0.85rem;color:#333;font-weight:600;">
                                    {{ Auth::user()->name }}
                                </span>
                            </a>

                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <div class="dropdown-item">
                                        <div class="d-flex align-items-center gap-2">
                                            @if (Auth::user()->profile)
                                                <img src="/uploads/{{ Auth::user()->profile }}" alt="Profile"
                                                     style="width:36px;height:36px;border-radius:50%;object-fit:cover;">
                                            @endif
                                            <div>
                                                <div style="font-weight:700;font-size:0.88rem;color:#222;">{{ Auth::user()->name }}</div>
                                                <div style="font-size:0.75rem;color:#aaa;">Administrator</div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li><div class="dropdown-divider"></div></li>
                                <li>
                                    <a class="dropdown-item text-danger" href="/admin/signout">
                                        <i class="bx bx-power-off me-2"></i> Log Out
                                    </a>
                                </li>
                            </ul>
                        </li>

                    </ul>
                </div>
            </nav>
            <!-- / Navbar -->

            @yield('content')

        </div>
        <!-- / Content -->

    </div>

    <div class="layout-overlay layout-menu-toggle"></div>
</div>

<!-- Core JS -->
<script src="{{ url('backend/vendor/js/bootstrap.js') }}"></script>
<script src="{{ url('backend/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
<script src="{{ url('backend/vendor/js/menu.js') }}"></script>
<script src="{{ url('backend/js/main.js') }}"></script>
<script src="{{ url('backend/js/theme.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ url('backend/js/form-basic-inputs.js') }}"></script>

@yield('scripts')

</body>
</html>