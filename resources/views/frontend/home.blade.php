@extends('frontend.layout')
@section('title', 'Home')
@section('content')

<main class="home">

    {{-- Flash message --}}
    @if (Session::has('message'))
        <div class="container pt-4">
            <div class="alert alert-success text-center" role="alert">
                {{ Session::get('message') }}
            </div>
        </div>
    @endif

    {{-- ── NEW PRODUCTS ── --}}
    <section class="py-4 py-md-5">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h3 class="main-title mb-4">NEW PRODUCTS</h3>
                </div>
            </div>
            <div class="row g-3 g-md-4">
                @foreach ($newProducts as $newProductValue)
                    <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                        <figure>
                            <div class="thumbnail">
                                @if ($newProductValue->sale_price > 0)
                                    <div class="status">Promo</div>
                                @endif

                                {{-- ♥ Heart button --}}
                                <button
                                    class="fav-heart-btn {{ $newProductValue->is_fav ? 'active' : '' }}"
                                    data-product="{{ $newProductValue->id }}"
                                    data-auth="{{ Auth::check() ? '1' : '0' }}"
                                    onclick="toggleFav(this)"
                                    title="{{ $newProductValue->is_fav ? 'Remove from favorites' : 'Add to favorites' }}">
                                    <i class="{{ $newProductValue->is_fav ? 'fa-solid' : 'fa-regular' }} fa-heart"></i>
                                </button>

                                <a href="/product/{{ $newProductValue->slug }}">
                                    <img src="/uploads/{{ $newProductValue->thumbnail }}"
                                         alt="{{ $newProductValue->name }}" loading="lazy">
                                </a>
                            </div>
                            <div class="detail mt-2">
                                <div class="price-list">
                                    @if ($newProductValue->sale_price > 0)
                                        <div class="regular-price"><s>US {{ $newProductValue->regular_price }}</s></div>
                                        <div class="sale-price">US {{ $newProductValue->sale_price }}</div>
                                    @else
                                        <div class="price">US {{ $newProductValue->regular_price }}</div>
                                    @endif
                                </div>
                                <h5 class="title">{{ $newProductValue->name }}</h5>
                            </div>
                        </figure>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ── PROMOTION PRODUCTS ── --}}
    <section class="py-4 py-md-5">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h3 class="main-title mb-4">PROMOTION PRODUCTS</h3>
                </div>
            </div>
            <div class="row g-3 g-md-4">
                @foreach ($promotionPro as $promotionProductValue)
                    <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                        <figure>
                            <div class="thumbnail">
                                @if ($promotionProductValue->sale_price > 0)
                                    <div class="status">Promo</div>
                                @endif

                                {{-- ♥ Heart button --}}
                                <button
                                    class="fav-heart-btn {{ $promotionProductValue->is_fav ? 'active' : '' }}"
                                    data-product="{{ $promotionProductValue->id }}"
                                    data-auth="{{ Auth::check() ? '1' : '0' }}"
                                    onclick="toggleFav(this)"
                                    title="{{ $promotionProductValue->is_fav ? 'Remove from favorites' : 'Add to favorites' }}">
                                    <i class="{{ $promotionProductValue->is_fav ? 'fa-solid' : 'fa-regular' }} fa-heart"></i>
                                </button>

                                <a href="/product/{{ $promotionProductValue->slug }}">
                                    <img src="/uploads/{{ $promotionProductValue->thumbnail }}"
                                         alt="{{ $promotionProductValue->name }}" loading="lazy">
                                </a>
                            </div>
                            <div class="detail mt-2">
                                <div class="price-list">
                                    @if ($promotionProductValue->sale_price > 0)
                                        <div class="regular-price"><s>US {{ $promotionProductValue->regular_price }}</s></div>
                                        <div class="sale-price">US {{ $promotionProductValue->sale_price }}</div>
                                    @else
                                        <div class="price">US {{ $promotionProductValue->regular_price }}</div>
                                    @endif
                                </div>
                                <h5 class="title">{{ $promotionProductValue->name }}</h5>
                            </div>
                        </figure>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ── POPULAR PRODUCTS ── --}}
    <section class="py-4 py-md-5">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h3 class="main-title mb-4">POPULAR PRODUCTS</h3>
                </div>
            </div>
            <div class="row g-3 g-md-4">
                @foreach ($popularProduct as $popularProductValue)
                    <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                        <figure>
                            <div class="thumbnail">
                                @if ($popularProductValue->sale_price > 0)
                                    <div class="status">Promo</div>
                                @endif

                                {{-- ♥ Heart button --}}
                                <button
                                    class="fav-heart-btn {{ $popularProductValue->is_fav ? 'active' : '' }}"
                                    data-product="{{ $popularProductValue->id }}"
                                    data-auth="{{ Auth::check() ? '1' : '0' }}"
                                    onclick="toggleFav(this)"
                                    title="{{ $popularProductValue->is_fav ? 'Remove from favorites' : 'Add to favorites' }}">
                                    <i class="{{ $popularProductValue->is_fav ? 'fa-solid' : 'fa-regular' }} fa-heart"></i>
                                </button>

                                <a href="/product/{{ $popularProductValue->slug }}">
                                    <img src="/uploads/{{ $popularProductValue->thumbnail }}"
                                         alt="{{ $popularProductValue->name }}" loading="lazy">
                                </a>
                            </div>
                            <div class="detail mt-2">
                                <div class="price-list">
                                    @if ($popularProductValue->sale_price > 0)
                                        <div class="regular-price"><s>US {{ $popularProductValue->regular_price }}</s></div>
                                        <div class="sale-price">US {{ $popularProductValue->sale_price }}</div>
                                    @else
                                        <div class="price">US {{ $popularProductValue->regular_price }}</div>
                                    @endif
                                </div>
                                <h5 class="title">{{ $popularProductValue->name }}</h5>
                            </div>
                        </figure>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

</main>
@endsection