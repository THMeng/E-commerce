<!DOCTYPE html>
<html lang="en">
    <head>
        <title>@yield('title')</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link href="{{ url('css/frontend/theme.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

        <style>
            /* ── Base ── */
            *, *::before, *::after { box-sizing: border-box; }

            body {
                overflow-x: hidden;
            }

            /* ── Navbar ── */
            .navbar {
                padding-top: 0.75rem;
                padding-bottom: 0.75rem;
            }

            .navbar-brand img {
                max-width: 140px;
                height: auto;
            }

            /* Search bar full-width on mobile */
            .navbar .search-form {
                width: 100%;
                justify-content: center;
            }

            .navbar .search-form input {
                max-width: 100%;
                width: 100%;
            }

            @media (min-width: 992px) {
                .navbar-brand img {
                    max-width: 180px;
                }
                .navbar .search-form {
                    width: auto;
                }
                .navbar .search-form input {
                    max-width: 250px;
                    width: 250px;
                }
            }

            /* Collapsed mobile menu spacing */
            .navbar-collapse .navbar-nav .nav-link {
                padding-top: 0.5rem;
                padding-bottom: 0.5rem;
            }

            /* ── Off-canvas sidebar ── */
            .offcanvas.offcanvas-start {
                width: 280px;
                border-right: none;
                box-shadow: 4px 0 20px rgba(0,0,0,0.15);
            }

            .offcanvas-header {
                border-bottom: 1px solid #efefef;
                padding: 1rem 1.25rem;
                align-items: center;
            }

            .offcanvas-body {
                padding: 0;
                display: flex;
                flex-direction: column;
            }

            /* Nav links */
            .offcanvas-body .sidebar-nav {
                padding: 0.5rem 0;
                flex: 1;
            }

            .offcanvas-body .sidebar-nav a {
                display: block;
                padding: 0.85rem 1.5rem;
                font-weight: 700;
                font-size: 0.9rem;
                letter-spacing: 0.08em;
                color: #222;
                text-decoration: none;
                border-bottom: 1px solid #f5f5f5;
                transition: background 0.15s, color 0.15s;
            }

            .offcanvas-body .sidebar-nav a:hover {
                background: #f8f8f8;
                color: #e74c3c;
            }

            /* Search inside sidebar */
            .offcanvas-body .sidebar-search {
                padding: 1rem 1.25rem;
                border-bottom: 1px solid #f0f0f0;
            }

            .offcanvas-body .sidebar-search .input-group input {
                border-right: none;
                font-size: 0.85rem;
            }

            .offcanvas-body .sidebar-search .input-group button {
                border-left: none;
                background: #fff;
                border-color: #dee2e6;
                color: #444;
            }

            .offcanvas-body .sidebar-search .input-group button:hover {
                background: #222;
                color: #fff;
                border-color: #222;
            }

            /* Auth section at bottom */
            .offcanvas-body .sidebar-auth {
                padding: 1rem 1.25rem;
                border-top: 1px solid #efefef;
                margin-top: auto;
            }

            .offcanvas-body .sidebar-auth a {
                display: flex;
                align-items: center;
                gap: 8px;
                padding: 0.6rem 0;
                font-weight: 700;
                font-size: 0.85rem;
                letter-spacing: 0.08em;
                color: #222;
                text-decoration: none;
                transition: color 0.15s;
            }

            .offcanvas-body .sidebar-auth a:hover {
                color: #e74c3c;
            }

            /* ── Product cards ── */
            figure {
                margin: 0;
            }

            figure .thumbnail {
                position: relative;
                overflow: hidden;
                background: #f8f8f8;
                border-radius: 4px;
            }

            figure .thumbnail img {
                width: 100%;
                height: 220px;
                object-fit: contain;
                display: block;
                transition: transform 0.3s ease;
                background: #f8f8f8;
            }

            figure .thumbnail img:hover {
                transform: scale(1.04);
            }

            /* Adjust image height per breakpoint */
            @media (max-width: 575px) {
                figure .thumbnail img { height: 200px; object-fit: contain; }
            }

            @media (min-width: 576px) and (max-width: 767px) {
                figure .thumbnail img { height: 210px; object-fit: contain; }
            }

            @media (min-width: 992px) {
                figure .thumbnail img { height: 240px; object-fit: contain; }
            }

            /* Promotion badge */
            figure .thumbnail .status {
                position: absolute;
                top: 10px;
                left: 10px;
                background: #e74c3c;
                color: #fff;
                font-size: 0.7rem;
                font-weight: 700;
                letter-spacing: 0.05em;
                padding: 3px 8px;
                border-radius: 3px;
                z-index: 1;
                text-transform: uppercase;
            }

            /* ── Pricing ── */
            .price-list {
                display: flex;
                align-items: center;
                gap: 8px;
                flex-wrap: wrap;
                margin-bottom: 4px;
            }

            .regular-price {
                color: #999;
                font-size: 0.85rem;
            }

            .sale-price {
                color: #e74c3c;
                font-weight: 700;
                font-size: 0.95rem;
            }

            .price {
                color: #222;
                font-weight: 700;
                font-size: 0.95rem;
            }

            figure .detail .title {
                font-size: 0.9rem;
                margin: 0;
                line-height: 1.3;
                color: #222;
            }

            /* ── Section titles ── */
            .main-title {
                font-size: 1.1rem;
                font-weight: 800;
                letter-spacing: 0.08em;
                border-bottom: 2px solid #222;
                padding-bottom: 8px;
                display: inline-block;
            }

            @media (min-width: 768px) {
                .main-title { font-size: 1.25rem; }
            }

            /* ── Cart icon ── */
            .cart-icon-wrap {
                position: relative;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                color: #222;
                font-size: 1.2rem;
                padding: 4px 8px;
                text-decoration: none;
                transition: color 0.15s;
            }

            .cart-icon-wrap:hover {
                color: #e74c3c;
            }

            .cart-badge {
                position: absolute;
                top: -2px;
                right: 0px;
                background: #e74c3c;
                color: #fff;
                font-size: 0.6rem;
                font-weight: 700;
                min-width: 17px;
                height: 17px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                line-height: 1;
                padding: 0 3px;
            }

            /* ── Live search ── */
            .live-search-wrap {
                position: relative;
                width: 260px;
            }

            .live-search-input-wrap {
                position: relative;
                display: flex;
                align-items: center;
            }

            .live-search-input {
                width: 100%;
                height: 38px;
                border: 1.5px solid #ddd;
                border-radius: 4px;
                padding: 0 36px 0 12px;
                font-size: 0.85rem;
                color: #333;
                background: #fff;
                transition: border-color 0.15s;
                outline: none;
            }

            .live-search-input:focus {
                border-color: #222;
            }

            .live-search-icon {
                position: absolute;
                right: 10px;
                color: #aaa;
                font-size: 0.85rem;
                pointer-events: none;
            }

            .live-search-spinner {
                position: absolute;
                right: 10px;
                width: 14px;
                height: 14px;
                border: 2px solid #ddd;
                border-top-color: #222;
                border-radius: 50%;
                animation: spin 0.6s linear infinite;
            }

            @keyframes spin { to { transform: rotate(360deg); } }

            .live-search-dropdown {
                position: absolute;
                top: calc(100% + 6px);
                left: 0;
                right: 0;
                background: #fff;
                border: 1.5px solid #eee;
                border-radius: 6px;
                box-shadow: 0 8px 24px rgba(0,0,0,0.12);
                z-index: 9999;
                max-height: 380px;
                overflow-y: auto;
                display: none;
            }

            .live-search-dropdown.show { display: block; }

            .ls-item {
                display: flex;
                align-items: center;
                gap: 10px;
                padding: 8px 12px;
                text-decoration: none;
                color: #222;
                border-bottom: 1px solid #f5f5f5;
                transition: background 0.12s;
            }

            .ls-item:last-child { border-bottom: none; }
            .ls-item:hover { background: #f8f8f8; }

            .ls-item img {
                width: 42px;
                height: 42px;
                object-fit: cover;
                border-radius: 4px;
                flex-shrink: 0;
            }

            .ls-item .ls-info { flex: 1; min-width: 0; }

            .ls-item .ls-name {
                font-size: 0.85rem;
                font-weight: 600;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .ls-item .ls-price {
                font-size: 0.75rem;
                color: #e74c3c;
                font-weight: 700;
                margin-top: 2px;
            }

            .ls-item .ls-price.no-sale { color: #888; font-weight: 500; }

            .ls-empty {
                padding: 1.25rem;
                text-align: center;
                font-size: 0.85rem;
                color: #aaa;
            }

            /* Sidebar search full-width */
            .sidebar-search .live-search-wrap { width: 100%; }

            /* ── Footer ── */
            footer {
                font-size: 0.85rem;
            }
        </style>
    </head>
    <body>
        
        <header class="border-bottom">
            <nav class="navbar navbar-light bg-white py-3">
                <div class="container">

                    {{-- Hamburger (visible on all sizes below lg) --}}
                    <button class="navbar-toggler border-0 d-lg-none me-2" type="button"
                            data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu"
                            aria-controls="sidebarMenu" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <a class="navbar-brand logo" href="/">
                        <img src="../uploads/{{$logo[0]->thumbnail}}" class="img-fluid" alt="Logo">
                    </a>

                    {{-- Desktop nav links (hidden on mobile) --}}
                    <div class="d-none d-lg-flex align-items-center flex-grow-1 ms-4">
                        <ul class="navbar-nav me-auto flex-row gap-2">
                            <li class="nav-item">
                                <a class="nav-link px-3 text-dark fw-bold" href="/">HOME</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link px-3 text-dark fw-bold" href="shop">SHOP</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link px-3 text-dark fw-bold" href="news">NEWS</a>
                            </li>
                        </ul>

                        {{-- Live search --}}
                        <div class="live-search-wrap me-4" id="desktopSearch">
                            <div class="live-search-input-wrap">
                                <input type="search" id="desktopSearchInput" class="live-search-input" placeholder="SEARCH HERE" autocomplete="off">
                                <i class="fa-solid fa-magnifying-glass live-search-icon"></i>
                                <div class="live-search-spinner d-none" id="desktopSpinner"></div>
                            </div>
                            <div class="live-search-dropdown" id="desktopDropdown"></div>
                        </div>

                        <ul class="navbar-nav align-items-center flex-row gap-1">
                            @if (Auth::check())
                                @php
                                    $cartCount = DB::table('cart')
                                        ->join('cart_items', 'cart.id', '=', 'cart_items.cart_id')
                                        ->where('cart.user_id', Auth::user()->id)
                                        ->where('cart_items.status', 0)
                                        ->count();
                                @endphp
                                <li class="nav-item">
                                    <a href="/my-order" class="cart-icon-wrap" title="My Orders">
                                        <i class="fa-solid fa-bag-shopping"></i>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/cart-item" class="cart-icon-wrap" title="My Cart">
                                        <i class="fa-solid fa-cart-shopping"></i>
                                        @if ($cartCount > 0)
                                            <span class="cart-badge">{{ $cartCount > 99 ? '99+' : $cartCount }}</span>
                                        @endif
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link px-3 text-dark fw-bold" href="/logout/{{Auth::user()->id}}">LOG-OUT</a>
                                </li>
                            @else
                                <li class="nav-item">
                                    <a class="nav-link px-3 text-dark fw-bold" href="/signin">LOG-IN</a>
                                </li>
                            @endif
                        </ul>
                    </div>

                    {{-- Mobile: order + cart icons (auth handled inside sidebar) --}}
                    <div class="d-flex d-lg-none align-items-center ms-auto gap-1">
                        @if (Auth::check())
                            @php
                                $cartCountMobile = DB::table('cart')
                                    ->join('cart_items', 'cart.id', '=', 'cart_items.cart_id')
                                    ->where('cart.user_id', Auth::user()->id)
                                    ->where('cart_items.status', 0)
                                    ->count();
                            @endphp
                            <a href="/my-order" class="cart-icon-wrap" title="My Orders">
                                <i class="fa-solid fa-bag-shopping"></i>
                            </a>
                            <a href="/cart-item" class="cart-icon-wrap" title="My Cart">
                                <i class="fa-solid fa-cart-shopping"></i>
                                @if ($cartCountMobile > 0)
                                    <span class="cart-badge">{{ $cartCountMobile > 99 ? '99+' : $cartCountMobile }}</span>
                                @endif
                            </a>
                        @endif
                    </div>

                </div>
            </nav>
        </header>

        {{-- ── Off-canvas Sidebar (mobile) ── --}}
        <div class="offcanvas offcanvas-start" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
            <div class="offcanvas-header">
                <a href="/" class="text-decoration-none">
                    <img src="../uploads/{{$logo[0]->thumbnail}}" alt="Logo" style="max-height: 28px; width: auto;">
                </a>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">

                {{-- Nav links --}}
                <div class="sidebar-nav">
                    <a href="/">HOME</a>
                    <a href="shop">SHOP</a>
                    <a href="news">NEWS</a>
                </div>

                {{-- Live search (sidebar) --}}
                <div class="sidebar-search">
                    <div class="live-search-wrap" id="sidebarSearch">
                        <div class="live-search-input-wrap">
                            <input type="search" id="sidebarSearchInput" class="live-search-input" placeholder="SEARCH HERE" autocomplete="off">
                            <i class="fa-solid fa-magnifying-glass live-search-icon"></i>
                        </div>
                        <div class="live-search-dropdown" id="sidebarDropdown"></div>
                    </div>
                </div>

                {{-- Auth --}}
                <div class="sidebar-auth">
                    @if (Auth::check())
                        @php
                            $sidebarCartCount = DB::table('cart')
                                ->join('cart_items', 'cart.id', '=', 'cart_items.cart_id')
                                ->where('cart.user_id', Auth::user()->id)
                                ->where('cart_items.status', 0)
                                ->count();
                        @endphp
                        <a href="/my-order">
                            <i class="fa-solid fa-bag-shopping"></i> MY ORDERS
                        </a>
                        <a href="/cart-item">
                            <i class="fa-solid fa-cart-shopping"></i>
                            MY CART
                            @if ($sidebarCartCount > 0)
                                <span style="background:#e74c3c;color:#fff;font-size:0.65rem;font-weight:700;padding:2px 6px;border-radius:10px;margin-left:4px;">
                                    {{ $sidebarCartCount }}
                                </span>
                            @endif
                        </a>
                        <a href="/logout/{{Auth::user()->id}}"><i class="fa-solid fa-right-from-bracket"></i> LOG-OUT</a>
                    @else
                        <a href="/signin"><i class="fa-solid fa-right-to-bracket"></i> LOG-IN</a>
                    @endif
                </div>

            </div>
        </div>

        @yield('content')

        <footer class="text-center py-4 mt-4 border-top">
            <span class="text-muted">
                AllRight Received @ {{ date('Y') }}
            </span>
        </footer>

    </body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    (function () {
        // Generic live search initializer
        function initLiveSearch(inputId, dropdownId, spinnerId) {
            const input    = document.getElementById(inputId);
            const dropdown = document.getElementById(dropdownId);
            const spinner  = spinnerId ? document.getElementById(spinnerId) : null;

            if (!input || !dropdown) return;

            let debounceTimer;

            input.addEventListener('input', function () {
                const keyword = this.value.trim();

                clearTimeout(debounceTimer);
                dropdown.classList.remove('show');
                dropdown.innerHTML = '';

                if (keyword.length < 2) return;

                // Show spinner
                if (spinner) { spinner.classList.remove('d-none'); }
                input.nextElementSibling && input.nextElementSibling.classList.add('d-none');

                debounceTimer = setTimeout(function () {
                    fetch('/search-ajax?s=' + encodeURIComponent(keyword))
                        .then(res => res.json())
                        .then(data => {
                            if (spinner) spinner.classList.add('d-none');

                            if (!data.length) {
                                dropdown.innerHTML = '<div class="ls-empty">No products found for "' + keyword + '"</div>';
                            } else {
                                dropdown.innerHTML = data.map(p => `
                                    <a href="/product/${p.slug}" class="ls-item">
                                        <img src="/uploads/${p.thumbnail}" alt="${p.name}">
                                        <div class="ls-info">
                                            <div class="ls-name">${p.name}</div>
                                            <div class="ls-price ${p.sale_price > 0 ? '' : 'no-sale'}">
                                                ${p.sale_price > 0
                                                    ? 'US ' + p.sale_price
                                                    : 'US ' + p.regular_price}
                                            </div>
                                        </div>
                                    </a>`).join('');
                            }
                            dropdown.classList.add('show');
                        })
                        .catch(() => {
                            if (spinner) spinner.classList.add('d-none');
                        });
                }, 300);
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function (e) {
                if (!input.closest('.live-search-wrap').contains(e.target)) {
                    dropdown.classList.remove('show');
                }
            });
        }

        initLiveSearch('desktopSearchInput', 'desktopDropdown', 'desktopSpinner');
        initLiveSearch('sidebarSearchInput', 'sidebarDropdown', null);
    })();
    </script>
</html>