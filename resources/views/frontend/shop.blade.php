@extends('frontend.layout')
@section('title')
    Shop
@endsection
@section('content')

<style>
    /* ── Shop layout ── */
    .shop-section {
        padding: 2rem 0 4rem;
        background: #f5f5f5;
        min-height: 70vh;
    }

    /* ── Filter toggle button (mobile only) ── */
    .filter-toggle-btn {
        display: none;
        align-items: center;
        gap: 8px;
        background: #222;
        color: #fff;
        border: none;
        border-radius: 4px;
        padding: 0.55rem 1.1rem;
        font-size: 0.82rem;
        font-weight: 700;
        letter-spacing: 0.06em;
        cursor: pointer;
        margin-bottom: 1rem;
        text-transform: uppercase;
    }

    @media (max-width: 991px) {
        .filter-toggle-btn { display: flex; }
    }

    /* ── Sidebar filter ── */
    .filter-sidebar {
        background: #fff;
        border-radius: 6px;
        box-shadow: 0 1px 6px rgba(0,0,0,0.07);
        padding: 1.25rem;
    }

    /* Collapsible on mobile */
    @media (max-width: 991px) {
        .filter-sidebar {
            margin-bottom: 1.5rem;
        }
    }

    .filter-sidebar h4.title {
        font-size: 0.8rem;
        font-weight: 800;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: #222;
        border-bottom: 2px solid #222;
        padding-bottom: 6px;
        margin-bottom: 0.85rem;
    }

    .filter-sidebar ul {
        list-style: none;
        padding: 0;
        margin: 0 0 0.5rem;
    }

    .filter-sidebar ul li a {
        display: block;
        padding: 0.45rem 0;
        font-size: 0.85rem;
        color: #444;
        text-decoration: none;
        border-bottom: 1px solid #f5f5f5;
        transition: color 0.15s, padding-left 0.15s;
    }

    .filter-sidebar ul li a:hover {
        color: #e74c3c;
        padding-left: 6px;
    }

    .filter-sidebar ul li a.active {
        color: #e74c3c;
        font-weight: 700;
    }

    /* Price & Promotion filter links */
    .block-filter {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 0.5rem;
    }

    .block-filter a {
        display: inline-block;
        padding: 5px 14px;
        font-size: 0.78rem;
        font-weight: 700;
        letter-spacing: 0.05em;
        border: 1.5px solid #ddd;
        border-radius: 4px;
        color: #444;
        text-decoration: none;
        transition: all 0.15s;
    }

    .block-filter a:hover,
    .block-filter a.active {
        background: #222;
        color: #fff;
        border-color: #222;
    }

    /* ── Product grid ── */
    .product-grid {
        background: #fff;
        border-radius: 6px;
        box-shadow: 0 1px 6px rgba(0,0,0,0.07);
        padding: 1.25rem;
    }

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
        height: 210px;
        object-fit: contain;
        display: block;
        transition: transform 0.3s ease;
        background: #f8f8f8;
    }

    figure .thumbnail img:hover {
        transform: scale(1.04);
    }

    @media (max-width: 575px) {
        figure .thumbnail img { height: 170px; object-fit: contain; }
    }

    @media (min-width: 992px) {
        figure .thumbnail img { height: 230px; object-fit: contain;
    }

    figure .thumbnail .status {
        position: absolute;
        top: 8px;
        left: 8px;
        background: #e74c3c;
        color: #fff;
        font-size: 0.68rem;
        font-weight: 700;
        letter-spacing: 0.05em;
        padding: 3px 8px;
        border-radius: 3px;
        z-index: 1;
        text-transform: uppercase;
    }

    figure .detail {
        padding: 0.5rem 0 0.25rem;
    }

    figure .detail .title {
        font-size: 0.88rem;
        font-weight: 600;
        color: #222;
        margin: 4px 0 0;
        line-height: 1.3;
    }

    /* ── Pagination ── */
    .pagination {
        list-style: none;
        padding: 0;
        margin: 1.5rem 0 0;
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
    }

    .pagination li a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 34px;
        height: 34px;
        font-size: 0.82rem;
        font-weight: 700;
        border: 1.5px solid #ddd;
        border-radius: 4px;
        color: #444;
        text-decoration: none;
        transition: all 0.15s;
    }

    .pagination li a:hover,
    .pagination li a.active {
        background: #222;
        color: #fff;
        border-color: #222;
    }
</style>

<main>
    <section class="shop-section">
        <div class="container">

            {{-- Mobile filter toggle --}}
            <button class="filter-toggle-btn" type="button" data-bs-toggle="collapse" data-bs-target="#filterCollapse" aria-expanded="false">
                <i class="fa-solid fa-sliders"></i> Filter
            </button>

            <div class="row g-3 g-lg-4">

                {{-- ── FILTER SIDEBAR ── --}}
                {{-- Mobile: collapsible; Desktop: always visible --}}
                <div class="col-12 col-lg-3 order-lg-2">
                    <div class="collapse d-lg-block" id="filterCollapse">
                        <div class="filter-sidebar">

                            <h4 class="title">Category</h4>
                            <ul>
                                <li>
                                    <a href="/shop" class="{{ !Request::get('category') && !Request::get('promotion') && !Request::get('price') ? 'active' : '' }}">All</a>
                                </li>
                                @foreach ($category as $cateVal)
                                    <li>
                                        <a href="/shop?category={{ $cateVal->slug }}"
                                           class="{{ Request::get('category') == $cateVal->slug ? 'active' : '' }}">
                                            {{ $cateVal->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>

                            <h4 class="title mt-4">Price</h4>
                            <div class="block-filter mt-2">
                                <a href="/shop?price=max" class="{{ Request::get('price') == 'max' ? 'active' : '' }}">High</a>
                                <a href="/shop?price=min" class="{{ Request::get('price') == 'min' ? 'active' : '' }}">Low</a>
                            </div>

                            <h4 class="title mt-4">Promotion</h4>
                            <div class="block-filter mt-2">
                                <a href="/shop?promotion=true" class="{{ Request::get('promotion') ? 'active' : '' }}">Promotion</a>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- ── PRODUCT GRID ── --}}
                <div class="col-12 col-lg-9 order-lg-1">
                    <div class="product-grid">
                        <div class="row g-3">

                            @foreach ($product as $productVal)
                                <div class="col-6 col-sm-6 col-md-4 col-lg-4">
                                    <figure>
                                        <div class="thumbnail">
                                            @if ($productVal->sale_price > 0)
                                                <div class="status">Promo</div>
                                            @endif
                                            <a href="/product/{{ $productVal->slug }}">
                                                <img src="/uploads/{{ $productVal->thumbnail }}" alt="{{ $productVal->name }}" loading="lazy">
                                            </a>
                                        </div>
                                        <div class="detail">
                                            <div class="price-list">
                                                @if ($productVal->sale_price > 0)
                                                    <div class="regular-price"><s>US {{ $productVal->regular_price }}</s></div>
                                                    <div class="sale-price">US {{ $productVal->sale_price }}</div>
                                                @else
                                                    <div class="price">US {{ $productVal->regular_price }}</div>
                                                @endif
                                            </div>
                                            <h5 class="title">{{ $productVal->name }}</h5>
                                        </div>
                                    </figure>
                                </div>
                            @endforeach

                            {{-- Pagination --}}
                            <div class="col-12">
                                <ul class="pagination">
                                    @if (Request::get('category'))
                                        @for ($i = 1; $i <= $totalPage; $i++)
                                            <li><a href="/shop?category={{ Request::get('category') }}&page={{ $i }}" class="{{ Request::get('page') == $i ? 'active' : '' }}">{{ $i }}</a></li>
                                        @endfor
                                    @elseif (Request::get('promotion'))
                                        @for ($i = 1; $i <= $totalPage; $i++)
                                            <li><a href="/shop?promotion={{ Request::get('promotion') }}&page={{ $i }}" class="{{ Request::get('page') == $i ? 'active' : '' }}">{{ $i }}</a></li>
                                        @endfor
                                    @else
                                        @for ($i = 1; $i <= $totalPage; $i++)
                                            <li><a href="/shop?page={{ $i }}" class="{{ Request::get('page') == $i ? 'active' : '' }}">{{ $i }}</a></li>
                                        @endfor
                                    @endif
                                </ul>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</main>

@endsection