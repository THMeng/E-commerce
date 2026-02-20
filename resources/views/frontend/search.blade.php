@extends('frontend.layout')
@section('title')
    Search
@endsection
@section('content')

<style>
    .search-section {
        padding: 2rem 0 4rem;
        background: #f5f5f5;
        min-height: 70vh;
    }

    .search-bar-wrap {
        background: #fff;
        border-radius: 6px;
        box-shadow: 0 1px 6px rgba(0,0,0,0.07);
        padding: 1.25rem 1.5rem;
        margin-bottom: 2rem;
    }

    .search-bar-wrap form {
        display: flex;
        gap: 10px;
    }

    .search-bar-wrap input {
        flex: 1;
        border: 1.5px solid #e0e0e0;
        border-radius: 4px;
        padding: 0.65rem 1rem;
        font-size: 0.9rem;
        color: #333;
        transition: border-color 0.15s;
    }

    .search-bar-wrap input:focus {
        outline: none;
        border-color: #222;
    }

    .search-bar-wrap button {
        padding: 0.65rem 1.5rem;
        background: #222;
        color: #fff;
        font-weight: 700;
        font-size: 0.85rem;
        letter-spacing: 0.06em;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        white-space: nowrap;
        transition: background 0.2s;
    }

    .search-bar-wrap button:hover { background: #e74c3c; }

    .result-title {
        font-size: 0.85rem;
        font-weight: 800;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        border-bottom: 2px solid #222;
        padding-bottom: 8px;
        display: inline-block;
        margin-bottom: 1.25rem;
        color: #222;
    }

    .result-count {
        font-size: 0.78rem;
        color: #999;
        font-weight: 400;
        margin-left: 8px;
        letter-spacing: 0;
        text-transform: none;
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
        object-fit: cover;
        display: block;
        transition: transform 0.3s ease;
    }

    figure .thumbnail img:hover { transform: scale(1.04); }

    @media (max-width: 575px) {
        figure .thumbnail img { height: 165px; }
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

    figure .detail { padding: 0.5rem 0 0.25rem; }

    figure .detail .title {
        font-size: 0.88rem;
        font-weight: 600;
        color: #222;
        margin: 4px 0 0;
        line-height: 1.3;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .empty-state {
        text-align: center;
        padding: 4rem 1rem;
        background: #fff;
        border-radius: 6px;
        box-shadow: 0 1px 5px rgba(0,0,0,0.06);
    }

    .empty-state i { font-size: 3rem; color: #ddd; margin-bottom: 1rem; display: block; }
    .empty-state h5 { font-weight: 700; color: #555; margin-bottom: 0.35rem; }
    .empty-state p { font-size: 0.85rem; color: #aaa; margin: 0; }

    .keyword-tag {
        display: inline-block;
        background: #f0f0f0;
        border-radius: 4px;
        padding: 2px 10px;
        font-size: 0.85rem;
        font-weight: 700;
        color: #222;
        margin-left: 4px;
    }
</style>

<main>
    <section class="search-section">
        <div class="container">

            {{-- Search bar --}}
            <div class="search-bar-wrap">
                <form action="/search" method="get">
                    <input type="search" name="s"
                           placeholder="Search products..."
                           value="{{ $keyword }}" autofocus>
                    <button type="submit">
                        <i class="fa-solid fa-magnifying-glass me-1"></i> Search
                    </button>
                </form>
            </div>

            @if (!$keyword)
                <div class="empty-state">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <h5>Start searching</h5>
                    <p>Type a product name or keyword above to get started.</p>
                </div>

            @elseif ($products->isEmpty())
                <div class="empty-state">
                    <i class="fa-solid fa-face-frown"></i>
                    <h5>No results for <span class="keyword-tag">{{ $keyword }}</span></h5>
                    <p>Try a different keyword or check your spelling.</p>
                </div>

            @else
                <h3 class="result-title">
                    Results
                    <span class="result-count">{{ $products->count() }} product(s) found for "{{ $keyword }}"</span>
                </h3>

                <div class="row g-3">
                    @foreach ($products as $productVal)
                        <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                            <figure>
                                <div class="thumbnail">
                                    @if ($productVal->sale_price > 0)
                                        <div class="status">Promo</div>
                                    @endif
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
                    @endforeach
                </div>
            @endif

        </div>
    </section>
</main>

@endsection