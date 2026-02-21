@extends('frontend.layout')
@section('title')
    Product Detail
@endsection
@section('content')

<style>
    .product-detail-section {
        padding: 2rem 0 3rem;
        background: #f5f5f5;
    }

    /* ── Product image ── */
    .product-image-wrap {
        background: #fff;
        border-radius: 6px;
        overflow: hidden;
        box-shadow: 0 1px 6px rgba(0,0,0,0.07);
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 420px;
    }

    .product-image-wrap img {
        width: 100%;
        height: 420px;
        object-fit: contain;
        display: block;
        background: #fff;
    }

    @media (max-width: 767px) {
        .product-image-wrap { min-height: 280px; }
        .product-image-wrap img { height: 280px; }
    }

    @media (min-width: 768px) and (max-width: 991px) {
        .product-image-wrap { min-height: 340px; }
        .product-image-wrap img { height: 340px; }
    }

    /* ── Product detail card ── */
    .product-detail-card {
        background: #fff;
        border-radius: 6px;
        box-shadow: 0 1px 6px rgba(0,0,0,0.07);
        padding: 1.75rem;
        height: 100%;
    }

    .product-detail-card .product-title {
        font-size: 1.3rem;
        font-weight: 800;
        color: #222;
        margin: 0.5rem 0 1rem;
        line-height: 1.3;
    }

    @media (max-width: 575px) {
        .product-detail-card .product-title { font-size: 1.1rem; }
        .product-detail-card { padding: 1.25rem; }
    }

    /* ── Pricing ── */
    .price-list {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        margin-bottom: 0.25rem;
    }

    .regular-price { color: #aaa; font-size: 0.95rem; }
    .sale-price    { color: #e74c3c; font-weight: 700; font-size: 1.2rem; }
    .price         { color: #222; font-weight: 700; font-size: 1.2rem; }

    /* ── Attributes ── */
    .attr-group { margin-top: 1.1rem; }

    .attr-group .attr-label,
    .description-box .attr-label {
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: #888;
        margin-bottom: 6px;
        display: block;
    }

    .attr-group .attr-value {
        font-size: 0.92rem;
        color: #333;
        font-weight: 500;
    }

    /* ── Add to cart ── */
    .add-to-cart-form {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        flex-wrap: wrap;
        margin-top: 1.4rem;
    }

    .add-to-cart-form input[type="number"] {
        width: 75px;
        height: 44px;
        font-size: 0.95rem;
        text-align: center;
        border: 1.5px solid #ddd;
        border-radius: 4px;
        padding: 0 8px;
    }

    .add-to-cart-form input[type="number"]:focus {
        outline: none;
        border-color: #222;
    }

    .btn-add-cart {
        height: 44px;
        padding: 0 1.5rem;
        background: #222;
        color: #fff;
        font-weight: 700;
        font-size: 0.85rem;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background 0.2s;
        white-space: nowrap;
    }

    .btn-add-cart:hover { background: #e74c3c; }

    /* ── Favourite button (detail page — inline beside title) ── */
    .btn-fav-detail {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #f5f5f5;
        border: 1.5px solid #ddd;
        border-radius: 4px;
        padding: 0 14px;
        height: 44px;
        font-size: 0.85rem;
        font-weight: 700;
        color: #555;
        cursor: pointer;
        transition: all 0.15s;
        white-space: nowrap;
    }

    .btn-fav-detail:hover,
    .btn-fav-detail.active {
        background: #fff0f0;
        border-color: #e74c3c;
        color: #e74c3c;
    }

    .btn-fav-detail i { font-size: 1rem; }

    @media (max-width: 400px) {
        .add-to-cart-form input[type="number"] { width: 60px; }
        .btn-add-cart { padding: 0 1rem; font-size: 0.8rem; }
        .btn-fav-detail { padding: 0 10px; font-size: 0.8rem; }
    }

    /* ── Description ── */
    .description-box {
        margin-top: 1.25rem;
        padding-top: 1.25rem;
        border-top: 1px solid #f0f0f0;
    }

    .description-box p {
        font-size: 0.9rem;
        color: #555;
        line-height: 1.7;
        margin: 0;
    }

    /* ── Related section ── */
    .section-divider { margin: 2.5rem 0 1.5rem; }

    .section-divider h3 {
        font-size: 1rem;
        font-weight: 800;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        border-bottom: 2px solid #222;
        padding-bottom: 8px;
        display: inline-block;
        margin: 0;
    }

    .related-section {
        padding: 0 0 4rem;
        background: #f5f5f5;
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
        height: 200px;
        object-fit: contain;
        display: block;
        background: #f8f8f8;
        transition: transform 0.3s ease;
    }

    figure .thumbnail img:hover { transform: scale(1.04); }

    @media (max-width: 575px) {
        figure .thumbnail img { height: 160px; }
    }

    @media (min-width: 992px) {
        figure .thumbnail img { height: 220px; }
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

    /* ── Heart button (related product cards) ── */
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
</style>

<main>

    {{-- ── PRODUCT DETAIL ── --}}
    <section class="product-detail-section">
        <div class="container">
            <div class="row g-3 g-md-4 align-items-start">

                {{-- Image --}}
                <div class="col-12 col-md-5">
                    <div class="product-image-wrap">
                        <img src="/uploads/{{ $product[0]->thumbnail }}" alt="{{ $product[0]->name }}">
                    </div>
                </div>

                {{-- Info --}}
                <div class="col-12 col-md-7">
                    <div class="product-detail-card">

                        <div class="price-list">
                            @if ($product[0]->sale_price > 0)
                                <div class="regular-price"><s>US {{ $product[0]->regular_price }}</s></div>
                                <div class="sale-price">US {{ $product[0]->sale_price }}</div>
                            @else
                                <div class="price">US {{ $product[0]->regular_price }}</div>
                            @endif
                        </div>

                        <h1 class="product-title">{{ $product[0]->name }}</h1>

                        <div class="attr-group">
                            <span class="attr-label">Color Available</span>
                            <div class="attr-value">{{ $product[0]->attribute_color }}</div>
                        </div>

                        <div class="attr-group">
                            <span class="attr-label">Size Available</span>
                            <div class="attr-value">{{ $product[0]->attribute_size }}</div>
                        </div>

                        {{-- ── Add to cart + Favourite ── --}}
                        @php
                            $userId        = Auth::check() ? Auth::user()->id : 0;
                            $isDetailFav   = in_array($product[0]->id, $favIds ?? []);
                        @endphp

                        <form method="post" action="/add-cart" class="add-to-cart-form">
                            @csrf
                            <input type="hidden" value="{{ $product[0]->id }}" name="proId">
                            <input type="hidden" value="{{ $userId }}" name="userId">
                            <input type="number" class="form-control" value="1" min="1" name="qty">
                            <button type="submit" class="btn-add-cart">
                                <i class="fa-solid fa-cart-plus me-1"></i> Add to Cart
                            </button>

                            {{-- ♥ Favourite button (inline with cart) --}}
                            <button type="button"
                                class="btn-fav-detail {{ $isDetailFav ? 'active' : '' }}"
                                data-product="{{ $product[0]->id }}"
                                data-auth="{{ Auth::check() ? '1' : '0' }}"
                                onclick="toggleFav(this)"
                                title="{{ $isDetailFav ? 'Remove from favorites' : 'Add to favorites' }}">
                                <i class="{{ $isDetailFav ? 'fa-solid' : 'fa-regular' }} fa-heart"></i>
                                {{ $isDetailFav ? 'Saved' : 'Favorite' }}
                            </button>
                        </form>

                        <div class="description-box">
                            <span class="attr-label">Description</span>
                            <p>{{ $product[0]->description }}</p>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ── RELATED PRODUCTS ── --}}
    <section class="related-section">
        <div class="container">

            <div class="section-divider">
                <h3>Related Products</h3>
            </div>

            <div class="row g-3">
                @foreach ($relatedProduct as $relatedProductValue)
                    @php $isRelFav = in_array($relatedProductValue->id, $favIds ?? []); @endphp
                    <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                        <figure>
                            <div class="thumbnail">
                                @if ($relatedProductValue->sale_price > 0)
                                    <div class="status">Promo</div>
                                @endif

                                {{-- ♥ Heart button --}}
                                <button
                                    class="fav-heart-btn {{ $isRelFav ? 'active' : '' }}"
                                    data-product="{{ $relatedProductValue->id }}"
                                    data-auth="{{ Auth::check() ? '1' : '0' }}"
                                    onclick="toggleFav(this)"
                                    title="{{ $isRelFav ? 'Remove from favorites' : 'Add to favorites' }}">
                                    <i class="{{ $isRelFav ? 'fa-solid' : 'fa-regular' }} fa-heart"></i>
                                </button>

                                <a href="/product/{{ $relatedProductValue->slug }}">
                                    <img src="/uploads/{{ $relatedProductValue->thumbnail }}"
                                         alt="{{ $relatedProductValue->name }}" loading="lazy">
                                </a>
                            </div>
                            <div class="detail">
                                <div class="price-list">
                                    @if ($relatedProductValue->sale_price > 0)
                                        <div class="regular-price"><s>US {{ $relatedProductValue->regular_price }}</s></div>
                                        <div class="sale-price">US {{ $relatedProductValue->sale_price }}</div>
                                    @else
                                        <div class="price">US {{ $relatedProductValue->regular_price }}</div>
                                    @endif
                                </div>
                                <h5 class="title">{{ $relatedProductValue->name }}</h5>
                            </div>
                        </figure>
                    </div>
                @endforeach
            </div>

        </div>
    </section>

</main>

@endsection