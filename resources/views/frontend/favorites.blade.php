@extends('frontend.layout')
@section('title', 'My Favorites')
@section('content')

<style>
    .fav-section {
        padding: 2rem 0 4rem;
        background: #f5f5f5;
        min-height: 70vh;
    }

    .fav-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
    }

    .fav-title {
        font-size: 1rem;
        font-weight: 800;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        border-bottom: 2.5px solid #222;
        padding-bottom: 5px;
        display: inline-block;
    }

    .fav-count {
        font-size: 0.78rem;
        color: #aaa;
        font-weight: 600;
    }

    /* Product card */
    .fav-card {
        background: #fff;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 1px 6px rgba(0,0,0,0.06);
        transition: box-shadow 0.2s;
        position: relative;
    }

    .fav-card:hover { box-shadow: 0 4px 16px rgba(0,0,0,0.1); }

    .fav-card .thumb {
        position: relative;
        overflow: hidden;
        background: #f8f8f8;
    }

    .fav-card .thumb img {
        width: 100%;
        height: 210px;
        object-fit: contain;
        background: #f8f8f8;
        display: block;
        transition: transform 0.35s ease;
    }

    .fav-card:hover .thumb img { transform: scale(1.04); }

    .fav-card .promo-badge {
        position: absolute;
        top: 8px; left: 8px;
        background: #e74c3c;
        color: #fff;
        font-size: 0.62rem;
        font-weight: 800;
        padding: 3px 8px;
        border-radius: 3px;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    /* Remove heart button */
    .fav-remove-btn {
        position: absolute;
        top: 8px; right: 8px;
        width: 32px; height: 32px;
        background: #fff;
        border: none;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #e74c3c;
        font-size: 0.95rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.12);
        cursor: pointer;
        transition: background 0.15s, transform 0.15s;
        z-index: 2;
        text-decoration: none;
    }

    .fav-remove-btn:hover {
        background: #e74c3c;
        color: #fff;
        transform: scale(1.1);
    }

    .fav-card .info {
        padding: 0.75rem;
    }

    .fav-card .info .price-list {
        display: flex;
        align-items: center;
        gap: 6px;
        flex-wrap: wrap;
        margin-bottom: 4px;
    }

    .fav-card .info .pname {
        font-size: 0.86rem;
        font-weight: 600;
        color: #222;
        line-height: 1.35;
        margin-bottom: 0.6rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .fav-card .info .btn-shop {
        display: block;
        text-align: center;
        padding: 0.45rem 0;
        background: #222;
        color: #fff;
        font-size: 0.74rem;
        font-weight: 800;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        border-radius: 4px;
        text-decoration: none;
        transition: background 0.15s;
    }

    .fav-card .info .btn-shop:hover { background: #e74c3c; }

    /* Empty state */
    .fav-empty {
        text-align: center;
        padding: 4rem 1rem;
        background: #fff;
        border-radius: 8px;
    }

    .fav-empty i {
        font-size: 3.5rem;
        color: #eee;
        margin-bottom: 1rem;
        display: block;
    }

    .fav-empty h5 {
        font-size: 1rem;
        font-weight: 800;
        color: #333;
        margin-bottom: 0.5rem;
    }

    .fav-empty p {
        font-size: 0.85rem;
        color: #aaa;
        margin-bottom: 1.25rem;
    }

    .fav-empty a {
        display: inline-block;
        padding: 0.55rem 1.5rem;
        background: #222;
        color: #fff;
        font-size: 0.78rem;
        font-weight: 800;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        border-radius: 4px;
        text-decoration: none;
        transition: background 0.15s;
    }

    .fav-empty a:hover { background: #e74c3c; }

    .regular-price { color: #bbb; font-size: 0.8rem; text-decoration: line-through; }
    .sale-price    { color: #e74c3c; font-weight: 700; font-size: 0.9rem; }
    .price         { color: #222; font-weight: 700; font-size: 0.9rem; }

    @media (max-width: 575px) {
        .fav-card .thumb img { height: 170px; }
    }

    /* ── Alertify overrides ── */
    .ajs-header {
        font-weight: 800 !important;
        font-size: 1rem !important;
        color: #222 !important;
    }

    .ajs-body .ajs-content {
        font-size: 0.88rem !important;
        color: #555 !important;
        line-height: 1.5 !important;
    }

    .ajs-footer .ajs-button.ajs-ok {
        background: #e74c3c !important;
        color: #fff !important;
        font-weight: 700 !important;
        border-radius: 4px !important;
        text-transform: uppercase !important;
        font-size: 0.8rem !important;
        letter-spacing: 0.04em !important;
        border: none !important;
        padding: 8px 16px !important;
    }

    .ajs-footer .ajs-button.ajs-cancel {
        background: #f0f0f0 !important;
        color: #333 !important;
        font-weight: 700 !important;
        border-radius: 4px !important;
        text-transform: uppercase !important;
        font-size: 0.8rem !important;
        letter-spacing: 0.04em !important;
        border: none !important;
        padding: 8px 16px !important;
    }

    .ajs-footer .ajs-button.ajs-ok:hover     { background: #c0392b !important; }
    .ajs-footer .ajs-button.ajs-cancel:hover { background: #ddd !important; }
    .ajs-dialog { border-radius: 8px !important; overflow: hidden !important; }

    @media (max-width: 575px) {
        .ajs-dialog { margin: 0 1rem !important; }
    }
</style>

<main>
    <section class="fav-section">
        <div class="container">

            <div class="fav-header">
                <span class="fav-title">My Favorites</span>
                <span class="fav-count">{{ count($favorites) }} item{{ count($favorites) != 1 ? 's' : '' }}</span>
            </div>

            @if (count($favorites) > 0)
                <div class="row g-3">
                    @foreach ($favorites as $fav)
                        <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                            <div class="fav-card">

                                {{-- Remove button --}}
                                <a href="javascript:void(0)"
                                   class="fav-remove-btn"
                                   title="Remove from favorites"
                                   data-url="/favorite/remove/{{ $fav->id }}"
                                   onclick="confirmRemoveFav(this)">
                                    <i class="fa-solid fa-heart"></i>
                                </a>

                                <div class="thumb">
                                    @if ($fav->sale_price > 0)
                                        <span class="promo-badge">Sale</span>
                                    @endif
                                    <a href="/product/{{ $fav->slug }}">
                                        <img src="/uploads/{{ $fav->thumbnail }}"
                                             alt="{{ $fav->name }}" loading="lazy">
                                    </a>
                                </div>

                                <div class="info">
                                    <div class="price-list">
                                        @if ($fav->sale_price > 0)
                                            <span class="regular-price"><s>US {{ $fav->regular_price }}</s></span>
                                            <span class="sale-price">US {{ $fav->sale_price }}</span>
                                        @else
                                            <span class="price">US {{ $fav->regular_price }}</span>
                                        @endif
                                    </div>
                                    <div class="pname">{{ $fav->name }}</div>
                                    <a href="/product/{{ $fav->slug }}" class="btn-shop">
                                        View Product
                                    </a>
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>

            @else
                <div class="fav-empty">
                    <i class="fa-regular fa-heart"></i>
                    <h5>No favorites yet</h5>
                    <p>Tap the heart icon on any product to save it here.</p>
                    <a href="/shop">Browse Shop</a>
                </div>
            @endif

        </div>
    </section>
</main>

{{-- Alertify --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/alertify.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/themes/default.min.css">
<script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/alertify.min.js"></script>

<script>
    function confirmRemoveFav(el) {
        var url = el.getAttribute('data-url');
        alertify.confirm(
            'Remove Favorite',
            'Are you sure you want to remove this product from your favorites?',
            function () {
                window.location.href = url;
            },
            function () {
                alertify.error('Not removed.');
            }
        ).set({
            labels: { ok: 'Yes, Remove', cancel: 'Keep' },
            defaultFocus: 'cancel'
        });
    }
</script>

@endsection