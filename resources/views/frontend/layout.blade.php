<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title')</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="{{ url('css/frontend/theme.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* ════════ BASE ════════ */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Segoe UI', system-ui, sans-serif;
            overflow-x: hidden;
            background: #fff;
            color: #222;
        }

        a { text-decoration: none; color: inherit; }

        /* ════════ HEADER ════════ */
        .site-header {
            position: sticky;
            top: 0;
            z-index: 1030;
            background: #fff;
            border-bottom: 1.5px solid #f0f0f0;
            box-shadow: 0 2px 12px rgba(0,0,0,0.05);
        }

        .header-inner {
            display: flex;
            align-items: center;
            gap: 6px;
            height: 62px;
            padding: 0 1rem;
            max-width: 1320px;
            margin: 0 auto;
        }

        .site-logo { flex-shrink: 0; }
        .site-logo img {
            height: 34px;
            width: auto;
            object-fit: contain;
            display: block;
        }

        /* Desktop nav */
        .header-nav {
            display: none;
            align-items: center;
            margin-left: 1.5rem;
        }

        .header-nav a {
            padding: 0 0.9rem;
            font-size: 0.78rem;
            font-weight: 800;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: #222;
            transition: color 0.15s;
            position: relative;
            white-space: nowrap;
        }

        .header-nav a::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0.9rem; right: 0.9rem;
            height: 2px;
            background: #e74c3c;
            transform: scaleX(0);
            transition: transform 0.2s;
        }

        .header-nav a:hover { color: #e74c3c; }
        .header-nav a:hover::after { transform: scaleX(1); }

        .header-spacer { flex: 1; }

        /* Desktop search */
        .header-search {
            display: none;
            width: 240px;
            flex-shrink: 0;
        }

        /* Icon buttons */
        .header-icons { display: flex; align-items: center; gap: 2px; }

        .hicon {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 8px;
            color: #222;
            font-size: 1.1rem;
            transition: background 0.15s, color 0.15s;
        }

        .hicon:hover { background: #f5f5f5; color: #e74c3c; }

        .hicon .nav-avatar {
            width: 30px; height: 30px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #eee;
            transition: border-color 0.15s;
        }

        .hicon:hover .nav-avatar { border-color: #e74c3c; }

        .cart-badge {
            position: absolute;
            top: 4px; right: 4px;
            background: #e74c3c;
            color: #fff;
            font-size: 0.52rem;
            font-weight: 800;
            min-width: 15px; height: 15px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 3px;
        }

        /* Hamburger */
        .header-hamburger {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px; height: 40px;
            background: none;
            border: none;
            color: #222;
            font-size: 1.35rem;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.15s;
            flex-shrink: 0;
            padding: 0;
        }

        .header-hamburger:hover { background: #f5f5f5; }

        /* ── Breakpoints ── */
        @@media (min-width: 992px) {
            .header-inner { height: 70px; padding: 0 2rem; }
            .site-logo img { height: 40px; }
            .header-nav { display: flex; }
            .header-search { display: block; }
            .header-hamburger { display: none; }
        }

        @@media (min-width: 768px) and (max-width: 991px) {
            .header-inner { height: 64px; }
        }

        @@media (max-width: 400px) {
            .header-inner { gap: 4px; padding: 0 0.75rem; }
            .hicon { width: 36px; height: 36px; font-size: 1rem; }
            .site-logo img { height: 28px; }
            .header-hamburger { width: 36px; height: 36px; font-size: 1.2rem; }
        }

        /* ════════ OFFCANVAS SIDEBAR ════════ */
        .offcanvas.offcanvas-start {
            width: 300px;
            border-right: none;
            box-shadow: 6px 0 30px rgba(0,0,0,0.12);
        }

        @@media (max-width: 360px) {
            .offcanvas.offcanvas-start { width: 280px; }
        }

        .offcanvas-header {
            padding: 1rem 1.25rem;
            border-bottom: 1px solid #f0f0f0;
        }

        .offcanvas-body {
            padding: 0;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
        }

        .sb-search {
            padding: 0.85rem 1.25rem;
            border-bottom: 1px solid #f0f0f0;
        }

        .sb-nav { padding: 0.25rem 0; }

        .sb-nav a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0.9rem 1.5rem;
            font-size: 0.82rem;
            font-weight: 800;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: #333;
            border-bottom: 1px solid #f5f5f5;
            transition: background 0.15s, color 0.15s, padding-left 0.15s;
        }

        .sb-nav a i { width: 20px; text-align: center; color: #ccc; font-size: 0.95rem; transition: color 0.15s; }
        .sb-nav a:hover { background: #fafafa; color: #e74c3c; padding-left: 1.75rem; }
        .sb-nav a:hover i { color: #e74c3c; }

        .sb-auth {
            padding: 1rem 1.25rem 2rem;
            border-top: 1px solid #f0f0f0;
            margin-top: auto;
        }

        .sb-auth-title {
            font-size: 0.65rem;
            font-weight: 800;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: #bbb;
            margin-bottom: 0.6rem;
        }

        .sb-auth a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0.65rem 0;
            font-size: 0.8rem;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: #333;
            border-bottom: 1px solid #f8f8f8;
            transition: color 0.15s;
        }

        .sb-auth a:last-child { border-bottom: none; }
        .sb-auth a:hover { color: #e74c3c; }
        .sb-auth a i { width: 18px; text-align: center; color: #ccc; font-size: 0.9rem; }

        .sb-cart-count {
            margin-left: auto;
            background: #e74c3c;
            color: #fff;
            font-size: 0.6rem;
            font-weight: 800;
            padding: 2px 7px;
            border-radius: 10px;
        }

        /* ════════ LIVE SEARCH ════════ */
        .live-search-wrap { position: relative; width: 100%; }
        .live-search-input-wrap { position: relative; display: flex; align-items: center; }

        .live-search-input {
            width: 100%;
            height: 38px;
            border: 1.5px solid #e0e0e0;
            border-radius: 6px;
            padding: 0 38px 0 12px;
            font-size: 0.83rem;
            color: #333;
            background: #fafafa;
            outline: none;
            transition: border-color 0.15s, background 0.15s;
        }

        .live-search-input:focus { border-color: #222; background: #fff; }

        .live-search-icon {
            position: absolute;
            right: 11px;
            color: #bbb;
            font-size: 0.82rem;
            pointer-events: none;
        }

        .live-search-spinner {
            position: absolute;
            right: 11px;
            width: 14px; height: 14px;
            border: 2px solid #e0e0e0;
            border-top-color: #222;
            border-radius: 50%;
            animation: lsspin 0.6s linear infinite;
        }

        @@keyframes lsspin { to { transform: rotate(360deg); } }

        .live-search-dropdown {
            position: absolute;
            top: calc(100% + 6px);
            left: 0; right: 0;
            background: #fff;
            border: 1.5px solid #eee;
            border-radius: 8px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.12);
            z-index: 9999;
            max-height: 360px;
            overflow-y: auto;
            display: none;
        }

        .live-search-dropdown.show { display: block; }

        .ls-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            color: #222;
            border-bottom: 1px solid #f5f5f5;
            transition: background 0.12s;
        }

        .ls-item:last-child { border-bottom: none; }
        .ls-item:hover { background: #fafafa; }

        .ls-item img {
            width: 44px; height: 44px;
            object-fit: contain;
            border-radius: 4px;
            background: #f5f5f5;
            flex-shrink: 0;
        }

        .ls-item .ls-info { flex: 1; min-width: 0; }
        .ls-item .ls-name { font-size: 0.84rem; font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .ls-item .ls-price { font-size: 0.74rem; color: #e74c3c; font-weight: 700; margin-top: 2px; }
        .ls-item .ls-price.no-sale { color: #999; font-weight: 500; }
        .ls-empty { padding: 1.25rem; text-align: center; font-size: 0.84rem; color: #bbb; }

        /* ════════ PRODUCT CARDS ════════ */
        figure { margin: 0; }

        figure .thumbnail {
            position: relative;
            overflow: hidden;
            background: #f8f8f8;
            border-radius: 6px;
        }

        figure .thumbnail img {
            width: 100%;
            height: 190px;
            object-fit: contain;
            display: block;
            background: #f8f8f8;
            transition: transform 0.35s ease;
        }

        figure .thumbnail img:hover { transform: scale(1.05); }

        @@media (min-width: 480px)  { figure .thumbnail img { height: 200px; } }
        @@media (min-width: 992px)  { figure .thumbnail img { height: 215px; } }
        @@media (min-width: 1200px) { figure .thumbnail img { height: 235px; } }

        figure .thumbnail .status {
            position: absolute;
            top: 8px; left: 8px;
            background: #e74c3c;
            color: #fff;
            font-size: 0.62rem;
            font-weight: 800;
            letter-spacing: 0.06em;
            padding: 3px 8px;
            border-radius: 3px;
            z-index: 1;
            text-transform: uppercase;
        }

        figure .detail { padding: 0.5rem 0 0.3rem; }

        figure .detail .title {
            font-size: 0.86rem;
            font-weight: 600;
            color: #222;
            line-height: 1.35;
            margin: 4px 0 0;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* ════════ PRICING ════════ */
        .price-list { display: flex; align-items: center; gap: 7px; flex-wrap: wrap; margin-bottom: 2px; }
        .regular-price { color: #bbb; font-size: 0.8rem; text-decoration: line-through; }
        .sale-price    { color: #e74c3c; font-weight: 700; font-size: 0.92rem; }
        .price         { color: #222; font-weight: 700; font-size: 0.92rem; }

        /* ════════ SECTION TITLE ════════ */
        .main-title {
            font-size: 0.95rem;
            font-weight: 800;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            border-bottom: 2.5px solid #222;
            padding-bottom: 6px;
            display: inline-block;
        }

        @@media (min-width: 768px)  { .main-title { font-size: 1.1rem; } }
        @@media (min-width: 1200px) { .main-title { font-size: 1.2rem; } }

        /* ════════ FOOTER ════════ */
        .site-footer {
            background: #111;
            color: rgba(255,255,255,0.55);
            padding: 3rem 0 0;
            margin-top: 3rem;
            font-size: 0.84rem;
        }

        .footer-inner {
            max-width: 1320px;
            margin: 0 auto;
            padding: 0 1.5rem;
            display: grid;
            grid-template-columns: 1fr;
            gap: 2rem;
        }

        @@media (min-width: 576px) { .footer-inner { grid-template-columns: 1fr 1fr; } }
        @@media (min-width: 992px) { .footer-inner { grid-template-columns: 2fr 1fr 1fr 1fr; } }

        .footer-brand img {
            height: 50px;
            width: auto;
            max-width: 160px;
            object-fit: contain;
            margin-bottom: 0.85rem;
            display: block;
            background: #fff;
            border-radius: 6px;
            padding: 6px 10px;
        }

        .footer-brand p {
            font-size: 0.82rem;
            line-height: 1.7;
            color: rgba(255,255,255,0.35);
            margin-bottom: 1rem;
        }

        .footer-socials { display: flex; gap: 8px; }

        .footer-socials a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 34px; height: 34px;
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 6px;
            color: rgba(255,255,255,0.5);
            font-size: 0.88rem;
            transition: background 0.15s, color 0.15s, border-color 0.15s;
        }

        .footer-socials a:hover {
            background: #e74c3c;
            color: #fff;
            border-color: #e74c3c;
        }

        .footer-col-title {
            font-size: 0.68rem;
            font-weight: 800;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: #fff;
            margin-bottom: 1rem;
        }

        .footer-col ul { list-style: none; padding: 0; }
        .footer-col ul li { margin-bottom: 0.55rem; }

        .footer-col ul li a {
            color: rgba(255,255,255,0.45);
            font-size: 0.82rem;
            transition: color 0.15s, padding-left 0.15s;
            display: inline-block;
        }

        .footer-col ul li a:hover { color: #fff; padding-left: 4px; }

        .footer-bottom {
            max-width: 1320px;
            margin: 2.5rem auto 0;
            padding: 1.25rem 1.5rem;
            border-top: 1px solid rgba(255,255,255,0.07);
            text-align: center;
            font-size: 0.76rem;
            color: rgba(255,255,255,0.25);
        }

        /* ════════ GLOBAL MOBILE ════════ */
        @@media (max-width: 575px) {
            .container { padding-left: 1rem; padding-right: 1rem; }
        }
    </style>
</head>
<body>

    {{-- ══ ADMIN BAR ══ --}}
    @if (Auth::check() && Auth::user()->is_admin)
    @php $pendingCount = DB::table('order')->where('status','pending')->count(); @endphp
    <style>
        #admin-bar {
            position: fixed;
            bottom: 0; left: 0;
            width: 100%; height: 48px;
            background: #111;
            border-top: 3px solid #e74c3c;
            z-index: 999999;
            display: flex;
            align-items: center;
            font-family: 'Segoe UI', sans-serif;
        }

        .abar-left {
            display: flex;
            align-items: center;
            height: 100%;
            flex: 1;
            overflow-x: auto;
            scrollbar-width: none;
            min-width: 0;
        }

        .abar-left::-webkit-scrollbar { display: none; }

        .abar-brand {
            display: flex;
            align-items: center;
            gap: 7px;
            padding: 0 12px;
            height: 100%;
            border-right: 1px solid rgba(255,255,255,0.1);
            flex-shrink: 0;
            color: #e74c3c;
            font-size: 0.68rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            white-space: nowrap;
        }

        @@keyframes abarpulse {
            0%,100% { opacity:1; transform:scale(1); }
            50%      { opacity:0.4; transform:scale(0.85); }
        }

        .abar-dot {
            width: 7px; height: 7px;
            background: #e74c3c;
            border-radius: 50%;
            flex-shrink: 0;
            animation: abarpulse 1.8s ease-in-out infinite;
        }

        .abar-link {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 0 12px;
            height: 100%;
            color: rgba(255,255,255,0.6);
            font-size: 0.72rem;
            font-weight: 600;
            text-decoration: none;
            border-right: 1px solid rgba(255,255,255,0.06);
            white-space: nowrap;
            transition: background 0.15s, color 0.15s;
            flex-shrink: 0;
        }

        .abar-link:hover { background: rgba(255,255,255,0.07); color: #fff; }
        .abar-link i { font-size: 0.88rem; }

        .abar-badge {
            background: #e74c3c; color: #fff;
            font-size: 0.58rem; font-weight: 800;
            padding: 1px 5px; border-radius: 8px; margin-left: 2px;
        }

        /* Back to Admin — fixed on right, NEVER pushed out */
        .abar-right {
            flex-shrink: 0;
            height: 100%;
            display: flex;
            align-items: stretch;
        }

        .abar-back {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 0 18px;
            height: 100%;
            background: #e74c3c;
            color: #fff !important;
            font-size: 0.72rem;
            font-weight: 800;
            text-decoration: none !important;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            white-space: nowrap;
            transition: background 0.15s;
        }

        .abar-back:hover { background: #c0392b; }
        .abar-back i { font-size: 0.95rem; }

        body { padding-bottom: 48px !important; }

        @@media (max-width: 640px) {
            .abar-brand span { display: none; }
            .abar-link span  { display: none; }
            .abar-link { padding: 0 10px; }
            .abar-back span  { display: none; }
            .abar-back { padding: 0 16px; }
        }

        @@media (max-width: 360px) {
            .abar-link { padding: 0 8px; }
            .abar-back { padding: 0 12px; }
        }
    </style>

    <div id="admin-bar">
        <div class="abar-left">
            <div class="abar-brand">
                <div class="abar-dot"></div>
                <span>Admin Mode</span>
            </div>
            <a href="/admin" class="abar-link">
                <i class="fa-solid fa-gauge-high"></i><span>Dashboard</span>
            </a>
            <a href="/admin/add-product" class="abar-link">
                <i class="fa-solid fa-plus"></i><span>Add Product</span>
            </a>
            <a href="/admin/list-product/" class="abar-link">
                <i class="fa-solid fa-boxes-stacked"></i><span>Products</span>
            </a>
            <a href="/admin/view-order" class="abar-link">
                <i class="fa-solid fa-receipt"></i><span>Orders</span>
                @if ($pendingCount > 0)
                    <span class="abar-badge">{{ $pendingCount }}</span>
                @endif
            </a>
            <a href="/admin/list-category" class="abar-link">
                <i class="fa-solid fa-layer-group"></i><span>Categories</span>
            </a>
        </div>

        <div class="abar-right">
            <a href="/admin" class="abar-back">
                <i class="fa-solid fa-arrow-right-to-bracket"></i>
                <span>Back to Admin</span>
            </a>
        </div>
    </div>
    @endif

    {{-- ══ HEADER ══ --}}
    <header class="site-header">
        <div class="header-inner">

            <button class="header-hamburger" type="button"
                    data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu"
                    aria-label="Open menu">
                <i class="fa-solid fa-bars"></i>
            </button>

            <a class="site-logo" href="/">
                <img src="../uploads/{{ $logo[0]->thumbnail }}" alt="Logo">
            </a>

            <nav class="header-nav">
                <a href="/">Home</a>
                <a href="/shop">Shop</a>
                <a href="/news">News</a>
            </nav>

            <div class="header-spacer"></div>

            <div class="header-search">
                <div class="live-search-wrap" id="desktopSearch">
                    <div class="live-search-input-wrap">
                        <input type="search" id="desktopSearchInput"
                               class="live-search-input"
                               placeholder="Search products…"
                               autocomplete="off">
                        <i class="fa-solid fa-magnifying-glass live-search-icon"></i>
                        <div class="live-search-spinner d-none" id="desktopSpinner"></div>
                    </div>
                    <div class="live-search-dropdown" id="desktopDropdown"></div>
                </div>
            </div>

            <div class="header-icons">
                @if (Auth::check())
                    @php
                        $cartCount = DB::table('cart')
                            ->join('cart_items', 'cart.id', '=', 'cart_items.cart_id')
                            ->where('cart.user_id', Auth::user()->id)
                            ->where('cart_items.status', 0)
                            ->count();
                    @endphp
                    <a href="/profile" class="hicon" title="My Profile">
                        @if (Auth::user()->profile && Auth::user()->profile != '')
                            <img src="/uploads/{{ Auth::user()->profile }}" class="nav-avatar" alt="Profile">
                        @else
                            <i class="fa-solid fa-circle-user"></i>
                        @endif
                    </a>
                    <a href="/my-order" class="hicon" title="My Orders">
                        <i class="fa-solid fa-bag-shopping"></i>
                    </a>
                    <a href="/cart-item" class="hicon" title="My Cart">
                        <i class="fa-solid fa-cart-shopping"></i>
                        @if ($cartCount > 0)
                            <span class="cart-badge">{{ $cartCount > 99 ? '99+' : $cartCount }}</span>
                        @endif
                    </a>
                    <a href="/logout/{{ Auth::user()->id }}"
                       class="hicon d-none d-lg-inline-flex" title="Log Out">
                        <i class="fa-solid fa-right-from-bracket"></i>
                    </a>
                @else
                    <a href="/signin" class="hicon d-none d-lg-inline-flex" title="Log In">
                        <i class="fa-solid fa-right-to-bracket"></i>
                    </a>
                @endif
            </div>

        </div>
    </header>

    {{-- ══ SIDEBAR ══ --}}
    <div class="offcanvas offcanvas-start" tabindex="-1" id="sidebarMenu">
        <div class="offcanvas-header">
            <a href="/">
                <img src="../uploads/{{ $logo[0]->thumbnail }}"
                     alt="Logo" style="height:30px;width:auto;">
            </a>
            <button type="button" class="btn-close ms-auto"
                    data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>

        <div class="offcanvas-body">

            <div class="sb-search">
                <div class="live-search-wrap" id="sidebarSearch">
                    <div class="live-search-input-wrap">
                        <input type="search" id="sidebarSearchInput"
                               class="live-search-input"
                               placeholder="Search products…"
                               autocomplete="off">
                        <i class="fa-solid fa-magnifying-glass live-search-icon"></i>
                    </div>
                    <div class="live-search-dropdown" id="sidebarDropdown"></div>
                </div>
            </div>

            <div class="sb-nav">
                <a href="/"><i class="fa-solid fa-house"></i> Home</a>
                <a href="/shop"><i class="fa-solid fa-store"></i> Shop</a>
                <a href="/news"><i class="fa-solid fa-newspaper"></i> News</a>
            </div>

            <div class="sb-auth">
                @if (Auth::check())
                    @php
                        $sidebarCartCount = DB::table('cart')
                            ->join('cart_items', 'cart.id', '=', 'cart_items.cart_id')
                            ->where('cart.user_id', Auth::user()->id)
                            ->where('cart_items.status', 0)
                            ->count();
                    @endphp
                    <div class="sb-auth-title">My Account</div>
                    <a href="/profile"><i class="fa-solid fa-circle-user"></i> My Profile</a>
                    <a href="/my-order"><i class="fa-solid fa-bag-shopping"></i> My Orders</a>
                    <a href="/cart-item">
                        <i class="fa-solid fa-cart-shopping"></i> My Cart
                        @if ($sidebarCartCount > 0)
                            <span class="sb-cart-count">{{ $sidebarCartCount }}</span>
                        @endif
                    </a>
                    <a href="/logout/{{ Auth::user()->id }}">
                        <i class="fa-solid fa-right-from-bracket"></i> Log Out
                    </a>
                @else
                    <div class="sb-auth-title">Account</div>
                    <a href="/signin"><i class="fa-solid fa-right-to-bracket"></i> Log In</a>
                    <a href="/signup"><i class="fa-solid fa-user-plus"></i> Register</a>
                @endif
            </div>

        </div>
    </div>

    @yield('content')

    {{-- ══ FOOTER ══ --}}
    <footer class="site-footer">
        <div class="footer-inner">

            <div class="footer-brand">
                <img src="/uploads/{{ $logo[0]->thumbnail }}" alt="Logo">
                <p>Your favourite fashion destination.<br>Quality styles delivered to your door.</p>
                <div class="footer-socials">
                    <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#"><i class="fa-brands fa-tiktok"></i></a>
                </div>
            </div>

            <div class="footer-col">
                <div class="footer-col-title">Shop</div>
                <ul>
                    <li><a href="/shop">All Products</a></li>
                    <li><a href="/shop?promotion=true">On Sale</a></li>
                    <li><a href="/shop?price=max">Premium</a></li>
                    <li><a href="/shop?price=min">Budget Picks</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <div class="footer-col-title">Account</div>
                <ul>
                    @if (Auth::check())
                        <li><a href="/profile">My Profile</a></li>
                        <li><a href="/my-order">My Orders</a></li>
                        <li><a href="/cart-item">My Cart</a></li>
                        <li><a href="/logout/{{ Auth::user()->id }}">Log Out</a></li>
                    @else
                        <li><a href="/signin">Log In</a></li>
                        <li><a href="/signup">Register</a></li>
                    @endif
                </ul>
            </div>

            <div class="footer-col">
                <div class="footer-col-title">Navigate</div>
                <ul>
                    <li><a href="/">Home</a></li>
                    <li><a href="/shop">Shop</a></li>
                    <li><a href="/news">News</a></li>
                </ul>
            </div>

        </div>

        <div class="footer-bottom">
            &copy; {{ date('Y') }} All Rights Reserved.
        </div>
    </footer>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
(function () {
    function initLiveSearch(inputId, dropdownId, spinnerId) {
        const input    = document.getElementById(inputId);
        const dropdown = document.getElementById(dropdownId);
        const spinner  = spinnerId ? document.getElementById(spinnerId) : null;
        if (!input || !dropdown) return;

        let timer;

        input.addEventListener('input', function () {
            const kw = this.value.trim();
            clearTimeout(timer);
            dropdown.classList.remove('show');
            dropdown.innerHTML = '';
            if (kw.length < 2) return;
            if (spinner) spinner.classList.remove('d-none');

            timer = setTimeout(function () {
                fetch('/search-ajax?s=' + encodeURIComponent(kw))
                    .then(r => r.json())
                    .then(data => {
                        if (spinner) spinner.classList.add('d-none');
                        dropdown.innerHTML = data.length
                            ? data.map(p => `
                                <a href="/product/${p.slug}" class="ls-item">
                                    <img src="/uploads/${p.thumbnail}" alt="${p.name}">
                                    <div class="ls-info">
                                        <div class="ls-name">${p.name}</div>
                                        <div class="ls-price ${p.sale_price > 0 ? '' : 'no-sale'}">
                                            US ${p.sale_price > 0 ? p.sale_price : p.regular_price}
                                        </div>
                                    </div>
                                </a>`).join('')
                            : `<div class="ls-empty">No results for "${kw}"</div>`;
                        dropdown.classList.add('show');
                    })
                    .catch(() => { if (spinner) spinner.classList.add('d-none'); });
            }, 300);
        });

        document.addEventListener('click', function (e) {
            const wrap = input.closest('.live-search-wrap');
            if (wrap && !wrap.contains(e.target)) dropdown.classList.remove('show');
        });
    }

    initLiveSearch('desktopSearchInput', 'desktopDropdown', 'desktopSpinner');
    initLiveSearch('sidebarSearchInput', 'sidebarDropdown', null);
})();
</script>
</html>