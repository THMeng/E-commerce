@extends('frontend.layout')
@section('title')
    Search
@endsection
@section('content')
<main class="shop">

    <section>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h3 class="main-title">
                        Product Result
                    </h3>
                </div>
            </div>
            <div class="row">
                @for ($i = 0; $i < 4; $i++)
                    <div class="col-3">
                        <figure>
                            <div class="thumbnail">
                                <div class="status">
                                    Promotion
                                </div>
                                <a href="">
                                    <img src="https://placehold.co/450x670" alt="">
                                </a>
                            </div>
                            <div class="detail">
                                <div class="price-list">
                                    <div class="price d-none">US 10</div>
                                    <div class="regular-price "><strike> US 15</strike></div>
                                    <div class="sale-price ">US 12</div>
                                </div>
                                <h5 class="title">T-Shirt 001</h5>
                            </div>
                        </figure>
                    </div>
                @endfor
            </div>
        </div>

        <div class="container">
            <div class="row mt-5">
                <div class="col-12">
                    <h3 class="main-title">
                        News Result
                    </h3>
                </div>
            </div>
            <div class="row">
                @for ($i = 0; $i < 4; $i++)
                    <div class="col-3">
                        <figure>
                            <div class="thumbnail">
                                <a href="">
                                    <img src="https://placehold.co/300x300" alt="">
                                </a>
                            </div>
                            <div class="detail">
                                <h5 class="title">But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born</h5>
                            </div>
                        </figure>
                    </div>
                @endfor
            </div>
        </div>
    </section>

</main>
@endsection