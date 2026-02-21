@extends('frontend.layout')
@section('title')
    Order Detail
@endsection
@section('content')

<style>
    .order-detail-section {
        padding: 2rem 0 4rem;
        background: #f5f5f5;
        min-height: 70vh;
    }

    .page-title {
        font-size: 1.2rem;
        font-weight: 800;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        margin-bottom: 1.5rem;
    }

    /* ── Info card ── */
    .info-card {
        background: #fff;
        border-radius: 6px;
        box-shadow: 0 1px 6px rgba(0,0,0,0.07);
        padding: 1.25rem 1.5rem;
        margin-bottom: 1.25rem;
    }

    .info-card .info-label {
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 0.09em;
        text-transform: uppercase;
        color: #aaa;
        margin-bottom: 2px;
    }

    .info-card .info-value {
        font-size: 0.88rem;
        font-weight: 600;
        color: #222;
        word-break: break-word;
    }

    /* ── Status badge ── */
    .status-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.04em;
        text-transform: capitalize;
    }

    .status-pending   { background: #fff3cd; color: #856404; }
    .status-confirmed { background: #d1e7dd; color: #0a5c36; }
    .status-delivered { background: #cfe2ff; color: #084298; }
    .status-cancel    { background: #f8d7da; color: #842029; }
    .status-default   { background: #e2e3e5; color: #41464b; }

    /* ── Items card ── */
    .items-card {
        background: #fff;
        border-radius: 6px;
        box-shadow: 0 1px 6px rgba(0,0,0,0.07);
        overflow: hidden;
        margin-bottom: 1.25rem;
    }

    .items-card .card-head {
        padding: 0.85rem 1.25rem;
        background: #fafafa;
        border-bottom: 1px solid #f0f0f0;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: #888;
    }

    /* ── Desktop table ── */
    .items-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.88rem;
    }

    .items-table thead th {
        padding: 0.75rem 1rem;
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.07em;
        color: #888;
        text-transform: uppercase;
        border-bottom: 2px solid #f0f0f0;
        background: #fafafa;
        white-space: nowrap;
    }

    .items-table tbody tr {
        border-bottom: 1px solid #f5f5f5;
        transition: background 0.12s;
    }

    .items-table tbody tr:hover { background: #fafafa; }
    .items-table tbody tr:last-child { border-bottom: none; }

    .items-table td {
        padding: 0.85rem 1rem;
        vertical-align: middle;
        color: #333;
        font-weight: 500;
    }

    .items-table td img {
        width: 58px;
        height: 58px;
        object-fit: contain;
        border-radius: 4px;
        background: #f8f8f8;
        display: block;
    }

    .items-table .price { font-weight: 700; color: #222; }

    /* Hide on tablet */
    @media (min-width: 768px) and (max-width: 991px) {
        .items-table th.hide-md,
        .items-table td.hide-md { display: none; }
    }

    /* ── Mobile item cards ── */
    .item-mobile-card {
        display: flex;
        align-items: center;
        gap: 0.85rem;
        padding: 0.85rem 1rem;
        border-bottom: 1px solid #f5f5f5;
    }

    .item-mobile-card:last-child { border-bottom: none; }

    .item-mobile-card img {
        width: 56px;
        height: 56px;
        object-fit: contain;
        border-radius: 4px;
        background: #f8f8f8;
        flex-shrink: 0;
    }

    .item-mobile-card .item-info {
        flex: 1;
        min-width: 0;
    }

    .item-mobile-card .item-name {
        font-size: 0.85rem;
        font-weight: 700;
        color: #222;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .item-mobile-card .item-meta {
        font-size: 0.75rem;
        color: #999;
        margin-top: 3px;
    }

    .item-mobile-card .item-price {
        font-size: 0.88rem;
        font-weight: 700;
        color: #222;
        white-space: nowrap;
        flex-shrink: 0;
    }

    /* ── Show/hide by breakpoint ── */
    .desktop-table { display: none; }
    .mobile-items  { display: block; }

    @media (min-width: 768px) {
        .desktop-table { display: block; }
        .mobile-items  { display: none; }
    }

    /* ── Action buttons ── */
    .actions-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.75rem;
    }

    .btn-cancel {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 0.7rem 1.5rem;
        background: #e74c3c;
        color: #fff;
        font-weight: 700;
        font-size: 0.85rem;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        border-radius: 4px;
        cursor: pointer;
        transition: background 0.2s;
        border: none;
    }

    .btn-cancel:hover { background: #c0392b; color: #fff; }

    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 0.7rem 1.5rem;
        background: #222;
        color: #fff;
        font-weight: 700;
        font-size: 0.85rem;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        border-radius: 4px;
        text-decoration: none;
        transition: background 0.2s;
    }

    .btn-back:hover { background: #444; color: #fff; }

    /* Full width buttons on mobile */
    @media (max-width: 575px) {
        .actions-bar { flex-direction: column; }
        .btn-back,
        .btn-cancel { width: 100%; justify-content: center; }
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

@php
function statusClass($status) {
    return match(strtolower($status ?? '')) {
        'pending'   => 'status-pending',
        'confirmed' => 'status-confirmed',
        'delivered' => 'status-delivered',
        'cancel'    => 'status-cancel',
        default     => 'status-default',
    };
}
@endphp

<main>
    <section class="order-detail-section">
        <div class="container">

            <h2 class="page-title">Order Detail</h2>

            @if (Session::has('success'))
                <div class="alert alert-success text-center mb-3">{{ Session::get('success') }}</div>
            @endif

            {{-- ── ORDER INFO ── --}}
            <div class="info-card">
                <div class="row g-3">
                    <div class="col-6 col-sm-4 col-md-2">
                        <div class="info-label">Order ID</div>
                        <div class="info-value">#{{ $order[0]->id }}</div>
                    </div>
                    <div class="col-6 col-sm-4 col-md-2">
                        <div class="info-label">Status</div>
                        <div class="info-value">
                            <span class="status-badge {{ statusClass($order[0]->status) }}">
                                {{ $order[0]->status }}
                            </span>
                        </div>
                    </div>
                    <div class="col-6 col-sm-4 col-md-2">
                        <div class="info-label">Total</div>
                        <div class="info-value">{{ $order[0]->total_amount }} $</div>
                    </div>
                    <div class="col-6 col-sm-4 col-md-2">
                        <div class="info-label">Phone</div>
                        <div class="info-value">{{ $order[0]->phone }}</div>
                    </div>
                    <div class="col-12 col-sm-8 col-md-4">
                        <div class="info-label">Address</div>
                        <div class="info-value">{{ $order[0]->address }}</div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="info-label">Date</div>
                        <div class="info-value">{{ \Carbon\Carbon::parse($order[0]->created_at)->format('d M Y, h:i A') }}</div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-8">
                        <div class="info-label">Transaction ID</div>
                        <div class="info-value">{{ $order[0]->transaction_id }}</div>
                    </div>
                </div>
            </div>

            {{-- ── ORDER ITEMS ── --}}
            <div class="items-card">
                <div class="card-head">Order Items</div>

                {{-- Desktop / Tablet table --}}
                <div class="desktop-table">
                    <table class="items-table">
                        <thead>
                            <tr>
                                <th class="hide-md">#</th>
                                <th>Product</th>
                                <th>Image</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <th class="hide-md">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orderItems as $orderItemVal)
                                <tr>
                                    <td class="hide-md">{{ $orderItemVal->id }}</td>
                                    <td>{{ $orderItemVal->name }}</td>
                                    <td><img src="/uploads/{{ $orderItemVal->thumbnail }}" alt="{{ $orderItemVal->name }}"></td>
                                    <td>{{ $orderItemVal->quantity }}</td>
                                    <td class="price">{{ $orderItemVal->price }} $</td>
                                    <td class="hide-md">{{ \Carbon\Carbon::parse($orderItemVal->created_at)->format('d M Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Mobile cards --}}
                <div class="mobile-items">
                    @foreach ($orderItems as $orderItemVal)
                        <div class="item-mobile-card">
                            <img src="/uploads/{{ $orderItemVal->thumbnail }}" alt="{{ $orderItemVal->name }}">
                            <div class="item-info">
                                <div class="item-name">{{ $orderItemVal->name }}</div>
                                <div class="item-meta">
                                    Qty: {{ $orderItemVal->quantity }}
                                    &nbsp;·&nbsp;
                                    {{ \Carbon\Carbon::parse($orderItemVal->created_at)->format('d M Y') }}
                                </div>
                            </div>
                            <div class="item-price">{{ $orderItemVal->price }} $</div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- ── ACTIONS ── --}}
            <div class="actions-bar">
                <a href="/my-order" class="btn-back">
                    <i class="fa-solid fa-arrow-left"></i> Back to Orders
                </a>
                @if ($order[0]->status == 'pending')
                    <button class="btn-cancel" id="cancelOrderBtn"
                            data-url="/cancel-order/{{ $orderItems[0]->order_id }}">
                        <i class="fa-solid fa-xmark"></i> Cancel Order
                    </button>
                @endif
            </div>

        </div>
    </section>
</main>

{{-- Alertify at bottom — after all HTML so DOM is ready --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/alertify.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/themes/default.min.css">
<script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/alertify.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var btn = document.getElementById('cancelOrderBtn');
        if (btn) {
            btn.addEventListener('click', function () {
                var url = this.getAttribute('data-url');
                alertify.confirm(
                    'Cancel Order',
                    'Are you sure you want to cancel this order? This action cannot be undone.',
                    function () {
                        window.location.href = url;
                    },
                    function () {
                        alertify.error('Order was not cancelled.');
                    }
                ).set({
                    labels: { ok: 'Yes, Cancel Order', cancel: 'Keep Order' },
                    defaultFocus: 'cancel'
                });
            });
        }
    });
</script>

@endsection