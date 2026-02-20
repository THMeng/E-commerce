@extends('frontend.layout')
@section('title')
    News Blog
@endsection
@section('content')
    <main class="shop news-blog">
        <section>
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h3 class="main-title">
                            NEWS BLOG
                        </h3>
                    </div>
                </div>
                <div class="row">
                    @for ($i = 0; $i < 8; $i++)
                        <div class="col-3">
                            <figure>
                                <div class="thumbnail">
                                    <a href="/article">
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