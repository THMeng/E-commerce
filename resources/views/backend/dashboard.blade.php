@extends('backend.master')
@section('site-title', 'Dashboard')
@section('page-main-title', 'Dashboard')

@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">

        <style>
            /* ── Stat cards ── */
            .stat-card {
                background: #fff;
                border-radius: 10px;
                padding: 1.25rem 1.5rem;
                box-shadow: 0 1px 8px rgba(0,0,0,0.06);
                display: flex;
                align-items: center;
                gap: 1rem;
                margin-bottom: 1.25rem;
                transition: box-shadow 0.2s;
            }

            .stat-card:hover { box-shadow: 0 4px 16px rgba(0,0,0,0.1); }

            .stat-icon {
                width: 52px;
                height: 52px;
                border-radius: 10px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.4rem;
                flex-shrink: 0;
            }

            .stat-icon.red    { background: #fff0ee; color: #e74c3c; }
            .stat-icon.blue   { background: #eef3ff; color: #3b82f6; }
            .stat-icon.green  { background: #edfaf4; color: #10b981; }
            .stat-icon.orange { background: #fff8ee; color: #f59e0b; }

            .stat-info { flex: 1; min-width: 0; }

            .stat-value {
                font-size: 1.6rem;
                font-weight: 800;
                color: #222;
                line-height: 1;
                margin-bottom: 4px;
            }

            .stat-label {
                font-size: 0.78rem;
                font-weight: 600;
                color: #aaa;
                text-transform: uppercase;
                letter-spacing: 0.07em;
            }

            .stat-change {
                font-size: 0.75rem;
                font-weight: 700;
                margin-top: 4px;
            }

            .stat-change.up   { color: #10b981; }
            .stat-change.down { color: #e74c3c; }

            /* ── Section title ── */
            .section-title {
                font-size: 0.88rem;
                font-weight: 800;
                letter-spacing: 0.07em;
                text-transform: uppercase;
                color: #222;
                margin-bottom: 1rem;
                padding-bottom: 0.5rem;
                border-bottom: 2px solid #f0f0f0;
            }

            /* ── Recent orders table ── */
            .dash-card {
                background: #fff;
                border-radius: 10px;
                box-shadow: 0 1px 8px rgba(0,0,0,0.06);
                overflow: hidden;
                margin-bottom: 1.25rem;
            }

            .dash-card-head {
                padding: 1rem 1.25rem;
                border-bottom: 1px solid #f0f0f0;
                display: flex;
                align-items: center;
                justify-content: space-between;
                flex-wrap: wrap;
                gap: 0.5rem;
            }

            .dash-card-head h6 {
                font-size: 0.88rem;
                font-weight: 800;
                color: #222;
                margin: 0;
                text-transform: uppercase;
                letter-spacing: 0.06em;
            }

            .btn-view-all {
                font-size: 0.75rem;
                font-weight: 700;
                color: #e74c3c;
                text-decoration: none;
                letter-spacing: 0.04em;
                text-transform: uppercase;
                transition: color 0.15s;
            }

            .btn-view-all:hover { color: #c0392b; }

            /* ── Table ── */
            .dash-table {
                width: 100%;
                border-collapse: collapse;
                font-size: 0.85rem;
            }

            .dash-table thead th {
                padding: 0.65rem 1rem;
                font-size: 0.7rem;
                font-weight: 700;
                letter-spacing: 0.08em;
                color: #aaa;
                text-transform: uppercase;
                background: #fafafa;
                border-bottom: 1px solid #f0f0f0;
                white-space: nowrap;
            }

            .dash-table tbody tr {
                border-bottom: 1px solid #f8f8f8;
                transition: background 0.12s;
            }

            .dash-table tbody tr:hover { background: #fafafa; }
            .dash-table tbody tr:last-child { border-bottom: none; }

            .dash-table td {
                padding: 0.75rem 1rem;
                vertical-align: middle;
                color: #444;
                font-weight: 500;
            }

            .dash-table td img {
                width: 40px;
                height: 40px;
                object-fit: contain;
                border-radius: 6px;
                background: #f5f5f5;
            }

            /* ── Status badges ── */
            .badge-status {
                display: inline-block;
                padding: 3px 10px;
                border-radius: 20px;
                font-size: 0.7rem;
                font-weight: 700;
                text-transform: capitalize;
                letter-spacing: 0.03em;
            }

            .badge-pending   { background: #fff3cd; color: #856404; }
            .badge-confirmed { background: #d1e7dd; color: #0a5c36; }
            .badge-delivered { background: #cfe2ff; color: #084298; }
            .badge-cancel    { background: #f8d7da; color: #842029; }

            /* ── Recent products ── */
            .product-row {
                display: flex;
                align-items: center;
                gap: 0.85rem;
                padding: 0.75rem 1.25rem;
                border-bottom: 1px solid #f8f8f8;
                transition: background 0.12s;
            }

            .product-row:hover { background: #fafafa; }
            .product-row:last-child { border-bottom: none; }

            .product-row img {
                width: 44px;
                height: 44px;
                object-fit: contain;
                border-radius: 6px;
                background: #f5f5f5;
                flex-shrink: 0;
            }

            .product-row .product-info { flex: 1; min-width: 0; }

            .product-row .product-name {
                font-size: 0.85rem;
                font-weight: 700;
                color: #222;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .product-row .product-cat {
                font-size: 0.73rem;
                color: #aaa;
                margin-top: 2px;
            }

            .product-row .product-price {
                font-size: 0.85rem;
                font-weight: 700;
                color: #e74c3c;
                white-space: nowrap;
                flex-shrink: 0;
            }

            /* ── Responsive ── */
            @media (max-width: 767px) {
                .stat-value { font-size: 1.3rem; }
                .stat-icon  { width: 44px; height: 44px; font-size: 1.2rem; }
                .dash-table thead { display: none; }
                .dash-table tbody tr {
                    display: block;
                    padding: 0.75rem 1rem;
                    border-bottom: 1px solid #f0f0f0;
                }
                .dash-table td {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    padding: 0.25rem 0;
                    font-size: 0.82rem;
                    border: none;
                }
                .dash-table td::before {
                    content: attr(data-label);
                    font-size: 0.7rem;
                    font-weight: 700;
                    color: #aaa;
                    text-transform: uppercase;
                    letter-spacing: 0.05em;
                    flex-shrink: 0;
                    margin-right: 1rem;
                }
            }

            @media (max-width: 575px) {
                .container-p-y { padding: 0.75rem !important; }
            }
        </style>

        {{-- ── STAT CARDS ── --}}
        <div class="row g-3 mb-2">
            <div class="col-6 col-md-3">
                <div class="stat-card">
                    <div class="stat-icon red">
                        <i class="bx bx-receipt"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-value">{{ $totalOrders ?? 0 }}</div>
                        <div class="stat-label">Total Orders</div>
                        <div class="stat-change up"><i class="bx bx-up-arrow-alt"></i> All time</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-card">
                    <div class="stat-icon blue">
                        <i class="bx bx-shopping-bag"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-value">{{ $totalProducts ?? 0 }}</div>
                        <div class="stat-label">Products</div>
                        <div class="stat-change up"><i class="bx bx-up-arrow-alt"></i> Active</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-card">
                    <div class="stat-icon green">
                        <i class="bx bx-dollar-circle"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-value">{{ number_format($totalRevenue ?? 0, 0) }}</div>
                        <div class="stat-label">Revenue ($)</div>
                        <div class="stat-change up"><i class="bx bx-up-arrow-alt"></i> Total</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="stat-card">
                    <div class="stat-icon orange">
                        <i class="bx bx-time-five"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-value">{{ $pendingOrders ?? 0 }}</div>
                        <div class="stat-label">Pending</div>
                        <div class="stat-change down"><i class="bx bx-right-arrow-alt"></i> Awaiting</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── MAIN CONTENT ROW ── --}}
        <div class="row g-3">

            {{-- Recent Orders --}}
            <div class="col-12 col-lg-8">
                <div class="dash-card">
                    <div class="dash-card-head">
                        <h6><i class="bx bx-receipt me-2" style="color:#e74c3c;"></i>Recent Orders</h6>
                        <a href="/admin/view-order" class="btn-view-all">View All →</a>
                    </div>
                    <div class="table-responsive">
                        <table class="dash-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Customer</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($recentOrders ?? [] as $order)
                                    <tr>
                                        <td data-label="#">#{{ $order->id }}</td>
                                        <td data-label="Customer">{{ $order->name }}</td>
                                        <td data-label="Amount">${{ $order->total_amount }}</td>
                                        <td data-label="Status">
                                            @php
                                                $badgeClass = match(strtolower($order->status ?? '')) {
                                                    'pending'   => 'badge-pending',
                                                    'confirmed' => 'badge-confirmed',
                                                    'delivered' => 'badge-delivered',
                                                    'cancel'    => 'badge-cancel',
                                                    default     => 'badge-pending',
                                                };
                                            @endphp
                                            <span class="badge-status {{ $badgeClass }}">{{ $order->status }}</span>
                                        </td>
                                        <td data-label="Date">{{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" style="text-align:center;padding:2rem;color:#ccc;">
                                            <i class="bx bx-receipt" style="font-size:2rem;display:block;margin-bottom:0.5rem;"></i>
                                            No orders yet
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Recent Products --}}
            <div class="col-12 col-lg-4">
                <div class="dash-card">
                    <div class="dash-card-head">
                        <h6><i class="bx bx-shopping-bag me-2" style="color:#3b82f6;"></i>Recent Products</h6>
                        <a href="/admin/list-product/" class="btn-view-all">View All →</a>
                    </div>
                    @forelse ($recentProducts ?? [] as $product)
                        <div class="product-row">
                            <img src="/uploads/{{ $product->thumbnail }}" alt="{{ $product->name }}">
                            <div class="product-info">
                                <div class="product-name">{{ $product->name }}</div>
                                <div class="product-cat">{{ $product->category_name ?? 'Uncategorized' }}</div>
                            </div>
                            <div class="product-price">
                                @if ($product->sale_price > 0)
                                    ${{ $product->sale_price }}
                                @else
                                    ${{ $product->regular_price }}
                                @endif
                            </div>
                        </div>
                    @empty
                        <div style="text-align:center;padding:2rem;color:#ccc;">
                            <i class="bx bx-shopping-bag" style="font-size:2rem;display:block;margin-bottom:0.5rem;"></i>
                            No products yet
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
        {{-- / Main content row --}}

    </div>
</div>

<div class="content-backdrop fade"></div>
@endsection