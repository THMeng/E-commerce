@extends('frontend.layout')

@section('title')
    My Cart
@endsection

@section('content')

<style>
    /* ── Layout ── */
    .cart-section {
        padding: 2rem 0 4rem;
        background: #f5f5f5;
        min-height: 60vh;
    }

    .cart-section h2.page-title {
        font-size: 1.2rem;
        font-weight: 800;
        letter-spacing: 0.08em;
        margin-bottom: 1.5rem;
        text-transform: uppercase;
    }

    /* ── Card ── */
    .cart-card {
        background: #fff;
        border-radius: 6px;
        box-shadow: 0 1px 6px rgba(0,0,0,0.07);
        overflow: hidden;
    }

    /* ── Table ── */
    .cart-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.9rem;
    }

    .cart-table thead th {
        background: #fafafa;
        border-bottom: 2px solid #eee;
        padding: 0.9rem 1rem;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.07em;
        color: #888;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .cart-table tbody tr {
        border-bottom: 1px solid #f0f0f0;
        transition: background 0.15s;
    }

    .cart-table tbody tr:hover {
        background: #fafafa;
    }

    .cart-table tbody tr:last-child {
        border-bottom: none;
    }

    .cart-table td {
        padding: 0.85rem 1rem;
        vertical-align: middle;
        color: #333;
        font-weight: 500;
    }

    .cart-table td img {
        width: 70px;
        height: 70px;
        object-fit: cover;
        border-radius: 4px;
        display: block;
    }

    .cart-table .product-name {
        font-weight: 600;
        color: #222;
    }

    .cart-table .price {
        font-weight: 700;
        color: #222;
    }

    /* Remove button */
    .btn-remove {
        background: #fff;
        border: 1.5px solid #e74c3c;
        color: #e74c3c;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.05em;
        padding: 5px 12px;
        border-radius: 4px;
        text-decoration: none;
        white-space: nowrap;
        transition: all 0.15s;
    }

    .btn-remove:hover {
        background: #e74c3c;
        color: #fff;
    }

    /* ── Summary card ── */
    .summary-card {
        background: #fff;
        border-radius: 6px;
        box-shadow: 0 1px 6px rgba(0,0,0,0.07);
        padding: 1.25rem 1.5rem;
        margin-top: 1rem;
    }

    .summary-card .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 1rem;
        font-weight: 700;
        color: #222;
    }

    .summary-card .summary-row .amount {
        font-size: 1.1rem;
        color: #e74c3c;
    }

    /* Checkout button */
    .btn-checkout {
        display: block;
        width: 100%;
        margin-top: 1rem;
        padding: 0.8rem;
        background: #222;
        color: #fff;
        font-weight: 700;
        font-size: 0.9rem;
        letter-spacing: 0.06em;
        text-align: center;
        border: none;
        border-radius: 4px;
        text-decoration: none;
        transition: background 0.2s;
        text-transform: uppercase;
    }

    .btn-checkout:hover {
        background: #e74c3c;
        color: #fff;
    }

    /* ── Empty state ── */
    .empty-cart {
        text-align: center;
        padding: 4rem 1rem;
    }

    .empty-cart .empty-icon {
        font-size: 4rem;
        color: #ddd;
        margin-bottom: 1rem;
    }

    .empty-cart h4 {
        font-weight: 700;
        color: #555;
        margin-bottom: 0.5rem;
    }

    .empty-cart p {
        color: #999;
        font-size: 0.9rem;
        margin-bottom: 1.5rem;
    }

    .empty-cart .btn-shop {
        display: inline-block;
        padding: 0.7rem 2rem;
        background: #222;
        color: #fff;
        font-weight: 700;
        font-size: 0.85rem;
        letter-spacing: 0.06em;
        border-radius: 4px;
        text-decoration: none;
        text-transform: uppercase;
        transition: background 0.2s;
    }

    .empty-cart .btn-shop:hover {
        background: #e74c3c;
    }

    /* ── Mobile: hide less-important columns ── */
    @media (max-width: 575px) {
        .cart-table thead th.hide-xs,
        .cart-table tbody td.hide-xs {
            display: none;
        }

        .cart-table td {
            padding: 0.7rem 0.6rem;
        }

        .cart-table td img {
            width: 54px;
            height: 54px;
        }

        .cart-section h2.page-title {
            font-size: 1rem;
        }
    }

    @media (max-width: 767px) {
        .cart-table thead th.hide-sm,
        .cart-table tbody td.hide-sm {
            display: none;
        }
    }
</style>

<main>
    <section class="cart-section">
        <div class="container">

            {{-- Page title --}}
            <h2 class="page-title">My Cart</h2>

            {{-- Flash message --}}
            @if (Session::has('success'))
                <div class="alert alert-success text-center mb-3">{{ Session::get('success') }}</div>
            @endif

            @if ($cartItems->isEmpty())
                {{-- ── EMPTY STATE ── --}}
                <div class="cart-card empty-cart">
                    <div class="empty-icon">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </div>
                    <h4>Your cart is empty</h4>
                    <p>Looks like you haven't added anything yet.</p>
                    <a href="/shop" class="btn-shop">Continue Shopping</a>
                </div>

            @else
                {{-- ── CART TABLE ── --}}
                <div class="cart-card">
                    <div class="table-responsive">
                        <table class="cart-table">
                            <thead>
                                <tr>
                                    <th class="hide-xs">#</th>
                                    <th>Product</th>
                                    <th class="hide-xs">Image</th>
                                    <th class="hide-sm">Qty</th>
                                    <th>Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cartItems as $cartVal)
                                    <tr>
                                        <td class="hide-xs">{{ $cartVal->id }}</td>
                                        <td class="product-name">{{ $cartVal->name }}</td>
                                        <td class="hide-xs">
                                            <img src="/uploads/{{ $cartVal->thumbnail }}" alt="{{ $cartVal->name }}">
                                        </td>
                                        <td class="hide-sm">{{ $cartVal->quantity }}</td>
                                        <td class="price">{{ $cartVal->price }} $</td>
                                        <td>
                                            <a href="/remove-cartitem/{{ $cartVal->id }}" class="btn-remove">Remove</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- ── SUMMARY ── --}}
                <div class="row justify-content-end mt-3">
                    <div class="col-12 col-sm-8 col-md-5 col-lg-4">
                        <div class="summary-card">
                            <div class="summary-row">
                                <span>Total Amount</span>
                                <span class="amount">{{ $totalAmount }} $</span>
                            </div>
                            <a href="/check-out" class="btn-checkout">Proceed to Checkout</a>
                        </div>
                    </div>
                </div>

            @endif

        </div>
    </section>
</main>

@endsection