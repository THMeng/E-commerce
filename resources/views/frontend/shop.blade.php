@extends('frontend.layout')
@section('title')
    Shop
@endsection
@section('content')

<style>
    .shop-section {
        padding: 2rem 0 4rem;
        background: #f5f5f5;
        min-height: 70vh;
    }

    /* ── Filter toggle (mobile) ── */
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

    /* ── Sidebar ── */
    .filter-sidebar {
        background: #fff;
        border-radius: 6px;
        box-shadow: 0 1px 6px rgba(0,0,0,0.07);
        padding: 1.25rem;
        margin-bottom: 1.5rem;
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

    .filter-sidebar ul li a:hover { color: #e74c3c; padding-left: 6px; }
    .filter-sidebar ul li a.active { color: #e74c3c; font-weight: 700; }

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

    figure { margin: 0; }

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
        background: #f8f8f8;
        transition: transform 0.3s ease;
    }

    figure .thumbnail img:hover { transform: scale(1.04); }

    @media (max-width: 575px) {
        figure .thumbnail img { height: 170px; }
    }

    @media (min-width: 992px) {
        figure .thumbnail img { height: 230px; }
    }

    figure .thumbnail .status {
        position: absolute;
        top: 8px; left: 8px;
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

    /* ── Heart / Favourite button ── */
    .fav-heart-btn {
        position: absolute;
        top: 8px; right: 8px;
        z-index: 2;
        background: rgba(255,255,255,0.85);
        border: none;
        border-radius: 50%;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: background 0.15s, transform 0.15s;
        padding: 0;
        line-height: 1;
    }

    .fav-heart-btn:hover { background: #fff; transform: scale(1.12); }

    .fav-heart-btn i {
        font-size: 0.95rem;
        color: #bbb;
        transition: color 0.15s;
    }

    .fav-heart-btn.active i,
    .fav-heart-btn:hover i { color: #e74c3c; }

    figure .detail { padding: 0.5rem 0 0.25rem; }

    figure .detail .title {
        font-size: 0.88rem;
        font-weight: 600;
        color: #222;
        margin: 4px 0 0;
        line-height: 1.3;
    }

    /* ── Price ── */
    .price-list { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }
    .regular-price { color: #aaa; font-size: 0.82rem; }
    .sale-price    { color: #e74c3c; font-weight: 700; font-size: 0.92rem; }
    .price         { color: #222; font-weight: 700; font-size: 0.92rem; }

    /* ── Pagination ── */
    .shop-pagination {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin-top: 1.5rem;
        padding: 0;
        list-style: none;
        align-items: center;
    }

    .shop-pagination li a,
    .shop-pagination li span {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 36px;
        height: 36px;
        padding: 0 10px;
        font-size: 0.82rem;
        font-weight: 700;
        border: 1.5px solid #ddd;
        border-radius: 6px;
        color: #444;
        text-decoration: none;
        background: #fff;
        transition: all 0.15s;
        white-space: nowrap;
    }

    .shop-pagination li a:hover {
        background: #222;
        color: #fff;
        border-color: #222;
    }

    .shop-pagination li.active a {
        background: #222;
        color: #fff;
        border-color: #222;
    }

    .shop-pagination li.prev-next a {
        min-width: 44px;
        background: #f5f5f5;
        color: #444;
        border-color: #ddd;
        font-size: 0.78rem;
        letter-spacing: 0.04em;
        text-transform: uppercase;
    }

    .shop-pagination li.prev-next a:hover {
        background: #222;
        color: #fff;
        border-color: #222;
    }

    /* On very small screens shrink pagination a bit */
    @media (max-width: 360px) {
        .shop-pagination li a,
        .shop-pagination li span {
            min-width: 30px;
            height: 30px;
            font-size: 0.75rem;
            padding: 0 6px;
        }
    }
</style>

<main>
    <section class="shop-section">
        <div class="container">

            {{-- Mobile filter toggle --}}
            <button class="filter-toggle-btn" type="button"
                    data-bs-toggle="collapse" data-bs-target="#filterCollapse" aria-expanded="false">
                <i class="fa-solid fa-sliders"></i> Filter
            </button>

            <div class="row g-3 g-lg-4">

                {{-- ── SIDEBAR ── --}}
                <div class="col-12 col-lg-3 order-lg-2">
                    <div class="collapse d-lg-block" id="filterCollapse">
                        <div class="filter-sidebar">

                            <h4 class="title">Category</h4>
                            <ul>
                                <li>
                                    <a href="/shop"
                                       class="{{ !Request::get('category') && !Request::get('promotion') && !Request::get('price') ? 'active' : '' }}">
                                        All
                                    </a>
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
                                <a href="/shop?promotion=true" class="{{ Request::get('promotion') ? 'active' : '' }}">On Sale</a>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- ── PRODUCT GRID ── --}}
                <div class="col-12 col-lg-9 order-lg-1">
                    <div class="product-grid">
                        <div class="row g-3">

                            @forelse ($product as $productVal)
                                @php $isFav = in_array($productVal->id, $favIds ?? []); @endphp
                                <div class="col-6 col-sm-6 col-md-4 col-lg-4">
                                    <figure>
                                        <div class="thumbnail">
                                            @if ($productVal->sale_price > 0)
                                                <div class="status">Promo</div>
                                            @endif

                                            {{-- ♥ Heart button --}}
                                            <button
                                                class="fav-heart-btn {{ $isFav ? 'active' : '' }}"
                                                data-product="{{ $productVal->id }}"
                                                data-auth="{{ Auth::check() ? '1' : '0' }}"
                                                onclick="toggleFav(this)"
                                                title="{{ $isFav ? 'Remove from favorites' : 'Add to favorites' }}">
                                                <i class="{{ $isFav ? 'fa-solid' : 'fa-regular' }} fa-heart"></i>
                                            </button>

                                            <a href="/product/{{ $productVal->slug }}">
                                                <img src="/uploads/{{ $productVal->thumbnail }}"
                                                     alt="{{ $productVal->name }}" loading="lazy">
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
                            @empty
                                <div class="col-12 text-center py-5" style="color:#ccc;">
                                    <i class="fa-solid fa-box-open" style="font-size:2.5rem;margin-bottom:0.75rem;display:block;"></i>
                                    No products found.
                                </div>
                            @endforelse

                            {{-- ── PAGINATION ── --}}
                            @if ($totalPage > 1)
                            <div class="col-12">
                                @php
                                    $currentPage = (int) Request::get('page', 1);
                                    $category    = Request::get('category');
                                    $promotion   = Request::get('promotion');
                                    $price       = Request::get('price');

                                    function shopUrl($page, $category, $promotion, $price) {
                                        $params = ['page' => $page];
                                        if ($category)  $params['category']  = $category;
                                        if ($promotion) $params['promotion'] = $promotion;
                                        if ($price)     $params['price']     = $price;
                                        return '/shop?' . http_build_query($params);
                                    }

                                    $start = max(1, $currentPage - 2);
                                    $end   = min($totalPage, $currentPage + 2);
                                @endphp

                                <ul class="shop-pagination">

                                    {{-- Prev --}}
                                    <li class="prev-next {{ $currentPage <= 1 ? 'disabled' : '' }}">
                                        @if ($currentPage > 1)
                                            <a href="{{ shopUrl($currentPage - 1, $category, $promotion, $price) }}">
                                                <i class="fa-solid fa-chevron-left"></i> Prev
                                            </a>
                                        @else
                                            <span style="opacity:0.4;cursor:default;">
                                                <i class="fa-solid fa-chevron-left"></i> Prev
                                            </span>
                                        @endif
                                    </li>

                                    {{-- First page + ellipsis --}}
                                    @if ($start > 1)
                                        <li class="{{ $currentPage == 1 ? 'active' : '' }}">
                                            <a href="{{ shopUrl(1, $category, $promotion, $price) }}">1</a>
                                        </li>
                                        @if ($start > 2)
                                            <li><span style="border:none;background:none;color:#aaa;">…</span></li>
                                        @endif
                                    @endif

                                    {{-- Page range --}}
                                    @for ($i = $start; $i <= $end; $i++)
                                        <li class="{{ $currentPage == $i ? 'active' : '' }}">
                                            <a href="{{ shopUrl($i, $category, $promotion, $price) }}">{{ $i }}</a>
                                        </li>
                                    @endfor

                                    {{-- Last page + ellipsis --}}
                                    @if ($end < $totalPage)
                                        @if ($end < $totalPage - 1)
                                            <li><span style="border:none;background:none;color:#aaa;">…</span></li>
                                        @endif
                                        <li class="{{ $currentPage == $totalPage ? 'active' : '' }}">
                                            <a href="{{ shopUrl($totalPage, $category, $promotion, $price) }}">{{ $totalPage }}</a>
                                        </li>
                                    @endif

                                    {{-- Next --}}
                                    <li class="prev-next {{ $currentPage >= $totalPage ? 'disabled' : '' }}">
                                        @if ($currentPage < $totalPage)
                                            <a href="{{ shopUrl($currentPage + 1, $category, $promotion, $price) }}">
                                                Next <i class="fa-solid fa-chevron-right"></i>
                                            </a>
                                        @else
                                            <span style="opacity:0.4;cursor:default;">
                                                Next <i class="fa-solid fa-chevron-right"></i>
                                            </span>
                                        @endif
                                    </li>

                                </ul>
                            </div>
                            @endif

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</main>

@endsection