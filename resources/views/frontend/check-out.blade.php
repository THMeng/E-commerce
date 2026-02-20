@extends('frontend.layout')
@section('title')
    Checkout
@endsection
@section('content')

<style>
    /* ── Page ── */
    .checkout-section {
        padding: 2rem 0 4rem;
        background: #f5f5f5;
        min-height: 70vh;
    }

    .checkout-section h2.page-title {
        font-size: 1.2rem;
        font-weight: 800;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        margin-bottom: 1.5rem;
    }

    /* ── Cards ── */
    .checkout-card {
        background: #fff;
        border-radius: 6px;
        box-shadow: 0 1px 6px rgba(0,0,0,0.07);
        overflow: hidden;
        margin-bottom: 1.25rem;
    }

    .checkout-card .card-head {
        padding: 0.9rem 1.25rem;
        background: #fafafa;
        border-bottom: 1px solid #f0f0f0;
        font-size: 0.78rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: #888;
    }

    /* ── Cart table ── */
    .cart-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.88rem;
    }

    .cart-table thead th {
        padding: 0.75rem 1rem;
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.07em;
        color: #888;
        text-transform: uppercase;
        border-bottom: 2px solid #f0f0f0;
        white-space: nowrap;
        background: #fafafa;
    }

    .cart-table tbody tr {
        border-bottom: 1px solid #f5f5f5;
        transition: background 0.12s;
    }

    .cart-table tbody tr:hover { background: #fafafa; }
    .cart-table tbody tr:last-child { border-bottom: none; }

    .cart-table td {
        padding: 0.8rem 1rem;
        vertical-align: middle;
        color: #333;
        font-weight: 500;
    }

    .cart-table td img {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 4px;
        display: block;
    }

    .cart-table .price { font-weight: 700; color: #222; }

    /* Remove button */
    .btn-remove {
        background: #fff;
        border: 1.5px solid #e74c3c;
        color: #e74c3c;
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.04em;
        padding: 4px 10px;
        border-radius: 4px;
        text-decoration: none;
        white-space: nowrap;
        transition: all 0.15s;
    }

    .btn-remove:hover { background: #e74c3c; color: #fff; }

    /* Hide columns on small screens */
    @media (max-width: 575px) {
        .cart-table th.hide-xs,
        .cart-table td.hide-xs { display: none; }
        .cart-table td { padding: 0.65rem 0.6rem; }
        .cart-table td img { width: 48px; height: 48px; }
    }

    @media (max-width: 767px) {
        .cart-table th.hide-sm,
        .cart-table td.hide-sm { display: none; }
    }

    /* ── Summary row ── */
    .summary-card {
        background: #fff;
        border-radius: 6px;
        box-shadow: 0 1px 6px rgba(0,0,0,0.07);
        padding: 1rem 1.25rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
        gap: 8px;
    }

    .summary-card .label {
        font-size: 0.85rem;
        font-weight: 700;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        color: #888;
    }

    .summary-card .amount {
        font-size: 1.2rem;
        font-weight: 800;
        color: #e74c3c;
    }

    /* ── Order form ── */
    .order-form-card {
        background: #fff;
        border-radius: 6px;
        box-shadow: 0 1px 6px rgba(0,0,0,0.07);
        padding: 1.5rem;
    }

    .order-form-card h3 {
        font-size: 0.85rem;
        font-weight: 800;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: #222;
        margin-bottom: 1.25rem;
        padding-bottom: 8px;
        border-bottom: 2px solid #222;
        display: inline-block;
    }

    .order-form-card label {
        font-size: 0.78rem;
        font-weight: 700;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        color: #888;
        margin-bottom: 5px;
        display: block;
    }

    .order-form-card .form-control {
        border: 1.5px solid #e0e0e0;
        border-radius: 4px;
        font-size: 0.9rem;
        padding: 0.6rem 0.85rem;
        color: #333;
        transition: border-color 0.15s;
        width: 100%;
    }

    .order-form-card .form-control:focus {
        outline: none;
        border-color: #222;
        box-shadow: none;
    }

    .order-form-card textarea.form-control {
        resize: vertical;
        min-height: 90px;
    }

    .order-form-card .form-group {
        margin-bottom: 1rem;
    }

    .btn-place-order {
        display: block;
        width: 100%;
        padding: 0.85rem;
        background: #222;
        color: #fff;
        font-weight: 700;
        font-size: 0.88rem;
        letter-spacing: 0.07em;
        text-transform: uppercase;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        margin-top: 0.5rem;
        transition: background 0.2s;
    }

    .btn-place-order:hover { background: #e74c3c; }

    /* ── Empty state ── */
    .empty-cart {
        text-align: center;
        padding: 4rem 1rem;
        background: #fff;
        border-radius: 6px;
        box-shadow: 0 1px 6px rgba(0,0,0,0.07);
    }

    .empty-cart .empty-icon { font-size: 3.5rem; color: #ddd; margin-bottom: 1rem; }
    .empty-cart h4 { font-weight: 700; color: #555; margin-bottom: 0.4rem; }
    .empty-cart p { color: #999; font-size: 0.88rem; margin-bottom: 1.25rem; }
    .empty-cart .btn-shop {
        display: inline-block;
        padding: 0.65rem 1.75rem;
        background: #222;
        color: #fff;
        font-weight: 700;
        font-size: 0.82rem;
        letter-spacing: 0.06em;
        border-radius: 4px;
        text-decoration: none;
        text-transform: uppercase;
        transition: background 0.2s;
    }
    .empty-cart .btn-shop:hover { background: #e74c3c; }
</style>

<main>
    <section class="checkout-section">
        <div class="container">

            <h2 class="page-title">Checkout</h2>

            {{-- Flash message --}}
            @if (Session::has('success'))
                <div class="alert alert-success text-center mb-3">{{ Session::get('success') }}</div>
            @endif

            @if (Request::get('cart_id'))
                <input type="hidden" value="{{ Request::get('cart_id') }}" name="cartId">
            @endif

            @if ($cartItems->isEmpty())
                {{-- Empty state --}}
                <div class="empty-cart">
                    <div class="empty-icon"><i class="fa-solid fa-cart-shopping"></i></div>
                    <h4>Your cart is empty</h4>
                    <p>Add some products before checking out.</p>
                    <a href="/shop" class="btn-shop">Continue Shopping</a>
                </div>

            @else

                <div class="row g-4 align-items-start">

                    {{-- ── LEFT: Cart items + summary ── --}}
                    <div class="col-12 col-lg-7">

                        {{-- Cart table --}}
                        <div class="checkout-card">
                            <div class="card-head">Order Items</div>
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
                                                <td>{{ $cartVal->name }}</td>
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

                        {{-- Total summary --}}
                        <div class="summary-card">
                            <span class="label">Total Amount</span>
                            <span class="amount">{{ $totalAmount }} $</span>
                        </div>

                    </div>

                    {{-- ── RIGHT: Place order form ── --}}
                    <div class="col-12 col-lg-5">
                        <div class="order-form-card">
                            <h3>Shipping Details</h3>
                            <form action="/place-order" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="phone">Phone Number</label>
                                    <input required type="tel" class="form-control" id="phone" name="phone" placeholder="e.g. 012 345 678">
                                </div>
                                <div class="form-group">
                                    <label for="address">Shipping Address</label>
                                    <textarea required name="address" id="address" class="form-control" placeholder="Enter your full shipping address"></textarea>
                                </div>
                                <button type="submit" class="btn-place-order">
                                    <i class="fa-solid fa-bag-shopping me-1"></i> Place Order
                                </button>
                            </form>
                        </div>
                    </div>

                </div>

            @endif

        </div>
    </section>
</main>

@endsection