@extends('frontend.layout')
@section('title')
    My Orders
@endsection
@section('content')

<style>
    .orders-section {
        padding: 2rem 0 4rem;
        background: #f5f5f5;
        min-height: 70vh;
    }

    .orders-section h2.page-title {
        font-size: 1.2rem;
        font-weight: 800;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        margin-bottom: 1.5rem;
    }

    /* ── Card ── */
    .orders-card {
        background: #fff;
        border-radius: 6px;
        box-shadow: 0 1px 6px rgba(0,0,0,0.07);
        overflow: hidden;
    }

    /* ── Table ── */
    .orders-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.88rem;
    }

    .orders-table thead th {
        background: #fafafa;
        border-bottom: 2px solid #eee;
        padding: 0.85rem 1rem;
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.07em;
        color: #888;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .orders-table tbody tr {
        border-bottom: 1px solid #f5f5f5;
        transition: background 0.12s;
    }

    .orders-table tbody tr:hover { background: #fafafa; }
    .orders-table tbody tr:last-child { border-bottom: none; }

    .orders-table td {
        padding: 0.85rem 1rem;
        vertical-align: middle;
        color: #333;
        font-weight: 500;
        font-size: 0.85rem;
    }

    /* ── Status badge ── */
    .status-badge {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.04em;
        text-transform: capitalize;
    }

    .status-pending   { background: #fff3cd; color: #856404; }
    .status-confirmed { background: #d1e7dd; color: #0a5c36; }
    .status-delivered { background: #cfe2ff; color: #084298; }
    .status-cancel    { background: #f8d7da; color: #842029; }
    .status-default   { background: #e2e3e5; color: #41464b; }

    /* ── Action button ── */
    .btn-view {
        display: inline-block;
        padding: 5px 14px;
        background: #222;
        color: #fff;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.05em;
        border-radius: 4px;
        text-decoration: none;
        white-space: nowrap;
        transition: background 0.15s;
    }

    .btn-view:hover { background: #e74c3c; color: #fff; }

    /* ── Mobile cards (shown on xs/sm instead of table) ── */
    .order-mobile-card {
        background: #fff;
        border-radius: 6px;
        box-shadow: 0 1px 5px rgba(0,0,0,0.07);
        padding: 1rem;
        margin-bottom: 0.85rem;
    }

    .order-mobile-card .om-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 0.45rem;
        font-size: 0.83rem;
    }

    .order-mobile-card .om-label {
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 0.07em;
        text-transform: uppercase;
        color: #aaa;
        flex-shrink: 0;
        margin-right: 8px;
    }

    .order-mobile-card .om-value {
        font-weight: 600;
        color: #222;
        text-align: right;
    }

    .order-mobile-card .om-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 0.75rem;
        padding-top: 0.75rem;
        border-top: 1px solid #f0f0f0;
    }

    /* Hide/show per breakpoint */
    .desktop-table { display: none; }
    .mobile-cards  { display: block; }

    @media (min-width: 768px) {
        .desktop-table { display: block; }
        .mobile-cards  { display: none; }
    }

    /* Hide less important cols on tablet */
    @media (min-width: 768px) and (max-width: 991px) {
        .orders-table th.hide-md,
        .orders-table td.hide-md { display: none; }
    }

    /* ── Empty state ── */
    .empty-state {
        text-align: center;
        padding: 4rem 1rem;
        background: #fff;
        border-radius: 6px;
        box-shadow: 0 1px 5px rgba(0,0,0,0.06);
    }

    .empty-state i { font-size: 3rem; color: #ddd; margin-bottom: 1rem; display: block; }
    .empty-state h5 { font-weight: 700; color: #555; margin-bottom: 0.35rem; }
    .empty-state p { font-size: 0.85rem; color: #aaa; margin-bottom: 1.25rem; }
    .empty-state .btn-shop {
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
    .empty-state .btn-shop:hover { background: #e74c3c; }

    /* ── Pagination ── */
    .order-pagination {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 6px;
    }

    .page-btn {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        height: 38px;
        padding: 0 14px;
        font-size: 0.82rem;
        font-weight: 700;
        border: 1.5px solid #ddd;
        border-radius: 4px;
        color: #444;
        text-decoration: none;
        transition: all 0.15s;
        background: #fff;
        white-space: nowrap;
        cursor: pointer;
    }

    /* Prev / Next bigger than number pages */
    .order-pagination li:first-child .page-btn,
    .order-pagination li:last-child .page-btn {
        padding: 0 18px;
        background: #222;
        color: #fff;
        border-color: #222;
    }

    .order-pagination li:first-child .page-btn:hover,
    .order-pagination li:last-child .page-btn:hover {
        background: #e74c3c;
        border-color: #e74c3c;
    }

    .order-pagination li.active .page-btn {
        background: #222;
        color: #fff;
        border-color: #222;
    }

    .order-pagination li a.page-btn:hover {
        background: #f0f0f0;
        border-color: #bbb;
        color: #222;
    }

    .order-pagination li.active a.page-btn:hover {
        background: #222;
        color: #fff;
    }

    .order-pagination li.disabled .page-btn {
        color: #ccc;
        cursor: not-allowed;
        background: #fafafa;
    }

    .order-pagination li:first-child.disabled .page-btn,
    .order-pagination li:last-child.disabled .page-btn {
        background: #ddd;
        color: #aaa;
        border-color: #ddd;
    }

    @media (max-width: 400px) {
        .page-btn { padding: 0 10px; font-size: 0.78rem; height: 34px; }
        .order-pagination li:first-child .page-btn,
        .order-pagination li:last-child .page-btn { padding: 0 12px; }
    }
</style>

@php
function orderStatusClass($status) {
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
    <section class="orders-section">
        <div class="container">

            <h2 class="page-title">My Orders</h2>

            @if (Session::has('success'))
                <div class="alert alert-success text-center mb-3">{{ Session::get('success') }}</div>
            @endif

            @if ($myOrder->total() == 0)
                <div class="empty-state">
                    <i class="fa-solid fa-bag-shopping"></i>
                    <h5>No orders yet</h5>
                    <p>You haven't placed any orders. Start shopping!</p>
                    <a href="/shop" class="btn-shop">Go to Shop</a>
                </div>

            @else

                {{-- ── DESKTOP TABLE (md+) ── --}}
                <div class="desktop-table">
                    <div class="orders-card">
                        <div class="table-responsive">
                            <table class="orders-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th class="hide-md">Phone</th>
                                        <th class="hide-md">Address</th>
                                        <th class="hide-md">Transaction ID</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th class="hide-md">Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($myOrder as $orderVal)
                                        <tr>
                                            <td>{{ $orderVal->id }}</td>
                                            <td>{{ $orderVal->fullname }}</td>
                                            <td class="hide-md">{{ $orderVal->phone }}</td>
                                            <td class="hide-md">{{ $orderVal->address }}</td>
                                            <td class="hide-md">{{ $orderVal->transaction_id }}</td>
                                            <td><strong>{{ $orderVal->total_amount }} $</strong></td>
                                            <td>
                                                <span class="status-badge {{ orderStatusClass($orderVal->status) }}">
                                                    {{ $orderVal->status }}
                                                </span>
                                            </td>
                                            <td class="hide-md">{{ \Carbon\Carbon::parse($orderVal->created_at)->format('d M Y') }}</td>
                                            <td>
                                                <a href="/view-order/{{ $orderVal->id }}" class="btn-view">View</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- ── MOBILE CARDS (below md) ── --}}
                <div class="mobile-cards">
                    @foreach ($myOrder as $orderVal)
                        <div class="order-mobile-card">
                            <div class="om-row">
                                <span class="om-label">Order</span>
                                <span class="om-value">#{{ $orderVal->id }}</span>
                            </div>
                            <div class="om-row">
                                <span class="om-label">Name</span>
                                <span class="om-value">{{ $orderVal->fullname }}</span>
                            </div>
                            <div class="om-row">
                                <span class="om-label">Phone</span>
                                <span class="om-value">{{ $orderVal->phone }}</span>
                            </div>
                            <div class="om-row">
                                <span class="om-label">Address</span>
                                <span class="om-value">{{ $orderVal->address }}</span>
                            </div>
                            <div class="om-row">
                                <span class="om-label">Date</span>
                                <span class="om-value">{{ \Carbon\Carbon::parse($orderVal->created_at)->format('d M Y') }}</span>
                            </div>
                            <div class="om-footer">
                                <div>
                                    <span class="status-badge {{ orderStatusClass($orderVal->status) }}">{{ $orderVal->status }}</span>
                                    <strong style="margin-left:8px; font-size:0.9rem;">{{ $orderVal->total_amount }} $</strong>
                                </div>
                                <a href="/view-order/{{ $orderVal->id }}" class="btn-view">View</a>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="d-flex justify-content-center mt-4">
                        <ul class="order-pagination">

                            {{-- Previous button --}}
                            @if ($myOrder->onFirstPage())
                                <li class="disabled">
                                    <span class="page-btn">
                                        <i class="fa-solid fa-chevron-left"></i> Prev
                                    </span>
                                </li>
                            @else
                                <li>
                                    <a href="{{ $myOrder->previousPageUrl() }}" class="page-btn">
                                        <i class="fa-solid fa-chevron-left"></i> Prev
                                    </a>
                                </li>
                            @endif

                            {{-- Page numbers (show max 5 around current) --}}
                            @php
                                $start = max(1, $myOrder->currentPage() - 2);
                                $end   = min($myOrder->lastPage(), $myOrder->currentPage() + 2);
                            @endphp

                            @if ($start > 1)
                                <li><a href="{{ $myOrder->url(1) }}" class="page-btn">1</a></li>
                                @if ($start > 2)
                                    <li class="disabled"><span class="page-btn">…</span></li>
                                @endif
                            @endif

                            @for ($i = $start; $i <= $end; $i++)
                                <li class="{{ $myOrder->currentPage() == $i ? 'active' : '' }}">
                                    <a href="{{ $myOrder->url($i) }}" class="page-btn">{{ $i }}</a>
                                </li>
                            @endfor

                            @if ($end < $myOrder->lastPage())
                                @if ($end < $myOrder->lastPage() - 1)
                                    <li class="disabled"><span class="page-btn">…</span></li>
                                @endif
                                <li><a href="{{ $myOrder->url($myOrder->lastPage()) }}" class="page-btn">{{ $myOrder->lastPage() }}</a></li>
                            @endif

                            {{-- Next button --}}
                            @if ($myOrder->hasMorePages())
                                <li>
                                    <a href="{{ $myOrder->nextPageUrl() }}" class="page-btn">
                                        Next <i class="fa-solid fa-chevron-right"></i>
                                    </a>
                                </li>
                            @else
                                <li class="disabled">
                                    <span class="page-btn">
                                        Next <i class="fa-solid fa-chevron-right"></i>
                                    </span>
                                </li>
                            @endif

                        </ul>
                </div>

            @endif

        </div>
    </section>
</main>

@endsection