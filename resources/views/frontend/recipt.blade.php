@extends('frontend.layout')
@section('title')
    Receipt
@endsection
@section('content')

<style>
    /* ── Page ── */
    .receipt-section {
        padding: 2rem 0 4rem;
        background: #f5f5f5;
        min-height: 80vh;
    }

    /* ── Receipt card ── */
    .receipt-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 24px rgba(0,0,0,0.09);
        overflow: hidden;
        max-width: 520px;
        width: 100%;
        margin: 0 auto;
    }

    /* ── Header ── */
    .receipt-header {
        background: #222;
        padding: 2rem 1.75rem 1.5rem;
        text-align: center;
        position: relative;
    }

    .receipt-header .order-no {
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: rgba(255,255,255,0.55);
        margin-bottom: 0.75rem;
    }

    .receipt-header .check-icon {
        width: 54px;
        height: 54px;
        background: #2ecc71;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        font-size: 1.4rem;
        color: #fff;
    }

    .receipt-header h2 {
        font-size: 1.15rem;
        font-weight: 800;
        color: #fff;
        letter-spacing: 0.03em;
        margin: 0;
    }

    .receipt-header p {
        font-size: 0.82rem;
        color: rgba(255,255,255,0.55);
        margin: 0.4rem 0 0;
    }

    /* ── Notch divider ── */
    .receipt-notch {
        display: flex;
        align-items: center;
        background: #f5f5f5;
    }

    .receipt-notch .notch-circle {
        width: 22px;
        height: 22px;
        background: #f5f5f5;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .receipt-notch .notch-line {
        flex: 1;
        border-top: 2px dashed #e0e0e0;
        margin: 0 4px;
    }

    /* ── Body ── */
    .receipt-body {
        padding: 1.5rem 1.75rem;
    }

    .receipt-body .section-label {
        font-size: 0.72rem;
        font-weight: 800;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: #aaa;
        margin-bottom: 1rem;
    }

    /* ── Order items ── */
    .order-item {
        display: flex;
        align-items: center;
        gap: 0.85rem;
        padding: 0.75rem 0;
        border-bottom: 1px solid #f5f5f5;
    }

    .order-item:last-of-type {
        border-bottom: none;
    }

    .order-item img {
        width: 56px;
        height: 56px;
        object-fit: cover;
        border-radius: 6px;
        flex-shrink: 0;
    }

    .order-item .item-info {
        flex: 1;
        min-width: 0;
    }

    .order-item .item-name {
        font-size: 0.88rem;
        font-weight: 700;
        color: #222;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .order-item .item-qty {
        font-size: 0.78rem;
        color: #999;
        margin-top: 2px;
    }

    .order-item .item-total {
        font-size: 0.92rem;
        font-weight: 700;
        color: #222;
        white-space: nowrap;
    }

    /* ── Total ── */
    .receipt-total {
        background: #f9f9f9;
        border-radius: 6px;
        padding: 1rem 1.25rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 1rem;
    }

    .receipt-total .total-label {
        font-size: 0.85rem;
        font-weight: 700;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        color: #888;
    }

    .receipt-total .total-amount {
        font-size: 1.2rem;
        font-weight: 800;
        color: #222;
    }

    /* ── Done button ── */
    .btn-done {
        display: block;
        width: 100%;
        margin-top: 1.25rem;
        padding: 0.85rem;
        background: #222;
        color: #fff;
        font-weight: 700;
        font-size: 0.88rem;
        letter-spacing: 0.07em;
        text-transform: uppercase;
        border-radius: 6px;
        text-align: center;
        text-decoration: none;
        transition: background 0.2s;
    }

    .btn-done:hover {
        background: #2ecc71;
        color: #fff;
    }

    /* ── Responsive ── */
    @media (max-width: 575px) {
        .receipt-body { padding: 1.25rem 1rem; }
        .receipt-header { padding: 1.5rem 1rem 1.25rem; }
        .receipt-header h2 { font-size: 1rem; }
        .order-item img { width: 46px; height: 46px; }
        .order-item .item-name { font-size: 0.82rem; }
        .receipt-total .total-amount { font-size: 1.05rem; }
    }
</style>

<main>
    <section class="receipt-section">
        <div class="container">
            <div class="receipt-card">

                {{-- ── Header ── --}}
                <div class="receipt-header">
                    <div class="order-no">Order #{{ session('orderId') }}</div>
                    <div class="check-icon">
                        <i class="fa-solid fa-check"></i>
                    </div>
                    <h2>Thank you for your order!</h2>
                    <p>Your order has been placed successfully.</p>
                </div>

                {{-- ── Notch ── --}}
                <div class="receipt-notch">
                    <div class="notch-circle"></div>
                    <div class="notch-line"></div>
                    <div class="notch-circle"></div>
                </div>

                {{-- ── Body ── --}}
                <div class="receipt-body">

                    <div class="section-label">Payment Summary</div>

                    {{-- Order items --}}
                    @if (session('orderItems'))
                        @foreach (session('orderItems') as $orderVal)
                            <div class="order-item">
                                <img src="/uploads/{{ $orderVal->thumbnail }}" alt="{{ $orderVal->name }}">
                                <div class="item-info">
                                    <div class="item-name">{{ $orderVal->name }}</div>
                                    <div class="item-qty">{{ $orderVal->price }} $ × {{ $orderVal->quantity }}</div>
                                </div>
                                <div class="item-total">{{ $orderVal->total }} $</div>
                            </div>
                        @endforeach
                    @endif

                    {{-- Total --}}
                    <div class="receipt-total">
                        <span class="total-label">Total</span>
                        <span class="total-amount">{{ session('totalAmount') }} $</span>
                    </div>

                    {{-- Done button --}}
                    <a href="/" class="btn-done">
                        <i class="fa-solid fa-house me-1"></i> Back to Home
                    </a>

                </div>
            </div>
        </div>
    </section>
</main>

@endsection