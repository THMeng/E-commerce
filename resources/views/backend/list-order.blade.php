@extends('backend.master')

@section('content')
<div class="content-wrapper">
    @section('site-title')
        Admin | List Order
    @endsection
    @section('page-main-title')
        List Order
    @endsection

    <div class="container-xxl flex-grow-1 container-p-y">

        <style>
            /* ── Desktop table ── */
            .order-table-wrap { display: block; }
            .order-cards-wrap  { display: none; }

            @media (max-width: 991px) {
                .order-table-wrap { display: none; }
                .order-cards-wrap  { display: block; }
            }

            /* ── Mobile cards ── */
            .order-card {
                background: #fff;
                border-radius: 10px;
                box-shadow: 0 1px 8px rgba(0,0,0,0.07);
                padding: 1rem 1.1rem;
                margin-bottom: 1rem;
            }

            .order-card .card-top {
                display: flex;
                align-items: center;
                justify-content: space-between;
                margin-bottom: 0.6rem;
                flex-wrap: wrap;
                gap: 6px;
            }

            .order-card .card-id {
                font-weight: 800;
                font-size: 0.9rem;
                color: #222;
            }

            .order-card .card-row {
                font-size: 0.8rem;
                color: #666;
                margin-bottom: 4px;
                word-break: break-word;
            }

            .order-card .card-row span {
                font-weight: 600;
                color: #333;
            }

            .order-card .card-row .txn {
                font-size: 0.72rem;
                color: #888;
                font-family: monospace;
            }

            /* Status badge colours */
            .status-pending   { background: #fff3cd; color: #856404; }
            .status-confirmed { background: #d1e7dd; color: #0a5c36; }
            .status-delivered { background: #cfe2ff; color: #084298; }
            .status-cancel    { background: #f8d7da; color: #842029; }
            .status-default   { background: #e2e3e5; color: #41464b; }

            .status-pill {
                display: inline-block;
                padding: 3px 10px;
                border-radius: 20px;
                font-size: 0.72rem;
                font-weight: 700;
                text-transform: capitalize;
            }

            /* ── Pagination ── */
            .pagination_rounded ul {
                list-style: none;
                display: flex;
                flex-wrap: wrap;
                gap: 6px;
                padding: 0;
                margin: 1.25rem 0 0;
            }

            .pagination_rounded ul li a {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                min-width: 36px;
                height: 36px;
                padding: 0 10px;
                border: 1.5px solid #ddd;
                border-radius: 6px;
                font-size: 0.82rem;
                font-weight: 600;
                color: #444;
                text-decoration: none;
                background: #fff;
                transition: all 0.15s;
                white-space: nowrap;
            }

            .pagination_rounded ul li a:hover,
            .pagination_rounded ul li a.active {
                background: #696cff;
                color: #fff;
                border-color: #696cff;
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

        {{-- ── DESKTOP TABLE ── --}}
        <div class="card order-table-wrap">
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Transaction ID</th>
                            <th>Full Name</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Updated</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($order as $value)
                            <tr>
                                <td><span class="badge bg-label-primary">{{ $value->id }}</span></td>
                                <td><span class="badge bg-label-warning">{{ $value->transaction_id }}</span></td>
                                <td><span class="badge bg-label-danger">{{ $value->fullname }}</span></td>
                                <td><span class="badge bg-label-warning">{{ $value->phone }}</span></td>
                                <td><span class="badge bg-label-primary">{{ $value->address }}</span></td>
                                <td><span class="badge bg-label-warning">{{ $value->total_amount }} $</span></td>
                                <td>
                                    <span class="status-pill {{ orderStatusClass($value->status) }}">
                                        {{ $value->status }}
                                    </span>
                                </td>
                                <td><span class="badge bg-label-warning">{{ \Carbon\Carbon::parse($value->created_at)->format('d M Y, h:i A') }}</span></td>
                                <td><span class="badge bg-label-warning">{{ \Carbon\Carbon::parse($value->updated_at)->format('d M Y, h:i A') }}</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ── MOBILE / TABLET CARDS ── --}}
        <div class="order-cards-wrap">
            @foreach ($order as $value)
                <div class="order-card">
                    <div class="card-top">
                        <div class="card-id"># {{ $value->id }} — {{ $value->fullname }}</div>
                        <span class="status-pill {{ orderStatusClass($value->status) }}">{{ $value->status }}</span>
                    </div>
                    <div class="card-row">Transaction: <span class="txn">{{ $value->transaction_id }}</span></div>
                    <div class="card-row">Phone: <span>{{ $value->phone }}</span></div>
                    <div class="card-row">Address: <span>{{ $value->address }}</span></div>
                    <div class="card-row">Total: <span>${{ $value->total_amount }}</span></div>
                    <div class="card-row">Created: <span>{{ \Carbon\Carbon::parse($value->created_at)->format('d M Y, h:i A') }}</span></div>
                    <div class="card-row">Updated: <span>{{ \Carbon\Carbon::parse($value->updated_at)->format('d M Y, h:i A') }}</span></div>
                </div>
            @endforeach
        </div>

        {{-- ── PAGINATION ── --}}
        <div class="pagination_rounded">
            <ul>
                @if ($currentPage > 1)
                    <li>
                        <a href="/admin/list-order?page={{ $currentPage - 1 }}">
                            <i class="fa fa-angle-left"></i> Prev
                        </a>
                    </li>
                @endif

                @for ($i = 0; $i < $totalPage; $i++)
                    <li>
                        <a href="/admin/list-order?page={{ $i + 1 }}"
                           class="{{ $currentPage == $i + 1 ? 'active' : '' }}">
                            {{ $i + 1 }}
                        </a>
                    </li>
                @endfor

                @if ($currentPage < $totalPage)
                    <li>
                        <a href="/admin/list-order?page={{ $currentPage + 1 }}">
                            Next <i class="fa fa-angle-right"></i>
                        </a>
                    </li>
                @endif
            </ul>
        </div>

        <hr class="my-5">
    </div>
</div>

@endsection