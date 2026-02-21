@extends('backend.master')

@section('content')
<div class="content-wrapper">
    @section('site-title')
        Admin | List Log
    @endsection
    @section('page-main-title')
        List Log
    @endsection

    <div class="container-xxl flex-grow-1 container-p-y">

        <style>
            /* ── Desktop table ── */
            .log-table-wrap { display: block; }
            .log-cards-wrap  { display: none; }

            @media (max-width: 991px) {
                .log-table-wrap { display: none; }
                .log-cards-wrap  { display: block; }
            }

            /* ── Mobile cards ── */
            .log-card {
                background: #fff;
                border-radius: 10px;
                box-shadow: 0 1px 8px rgba(0,0,0,0.07);
                padding: 1rem 1.1rem;
                margin-bottom: 1rem;
            }

            .log-card .card-top {
                display: flex;
                align-items: flex-start;
                justify-content: space-between;
                gap: 8px;
                margin-bottom: 0.5rem;
                flex-wrap: wrap;
            }

            .log-card .card-title {
                font-weight: 700;
                font-size: 0.9rem;
                color: #222;
                flex: 1;
                min-width: 0;
                word-break: break-word;
            }

            .log-card .card-row {
                font-size: 0.8rem;
                color: #666;
                margin-bottom: 4px;
            }

            .log-card .card-row span {
                font-weight: 600;
                color: #333;
            }

            .log-card .card-actions {
                margin-top: 0.6rem;
            }

            .log-card .card-actions a {
                display: inline-flex;
                align-items: center;
                gap: 4px;
                padding: 5px 14px;
                border-radius: 4px;
                font-size: 0.78rem;
                font-weight: 600;
                text-decoration: none;
                background: #e7f1ff;
                color: #0d6efd;
                transition: opacity 0.15s;
            }

            .log-card .card-actions a:hover { opacity: 0.82; }

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

        {{-- ── DESKTOP TABLE ── --}}
        <div class="card log-table-wrap">
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Post Type</th>
                            <th>Author</th>
                            <th>Action</th>
                            <th>Detail</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($log as $value)
                            <tr>
                                <td>
                                    <i class="fab fa-angular fa-lg text-danger me-2"></i>
                                    <strong>{{ $value->title }}</strong>
                                </td>
                                <td>{{ $value->post_type }}</td>
                                <td><span class="badge bg-label-primary">{{ $value->name }}</span></td>
                                <td><span class="badge bg-label-warning">{{ $value->action }}</span></td>
                                <td>
                                    <a href="/admin/log-detail/{{ $value->post_type }}/{{ $value->post_id }}/{{ $value->id }}">
                                        Detail
                                    </a>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($value->created_at)->format('d M Y, h:i A') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ── MOBILE / TABLET CARDS ── --}}
        <div class="log-cards-wrap">
            @foreach ($log as $value)
                <div class="log-card">
                    <div class="card-top">
                        <div class="card-title">
                            <i class="fab fa-angular fa-lg text-danger me-1"></i>
                            {{ $value->title }}
                        </div>
                        <span class="badge bg-label-warning">{{ $value->action }}</span>
                    </div>
                    <div class="card-row">Post Type: <span>{{ $value->post_type }}</span></div>
                    <div class="card-row">Author: <span>{{ $value->name }}</span></div>
                    <div class="card-row">Created: <span>{{ \Carbon\Carbon::parse($value->created_at)->format('d M Y, h:i A') }}</span></div>
                    <div class="card-actions">
                        <a href="/admin/log-detail/{{ $value->post_type }}/{{ $value->post_id }}/{{ $value->id }}">
                            <i class="bx bx-show"></i> Detail
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- ── PAGINATION ── --}}
        <div class="pagination_rounded">
            <ul>
                @if ($currentPage > 1)
                    <li>
                        <a href="/admin/log-activity?page={{ $currentPage - 1 }}">
                            <i class="fa fa-angle-left"></i> Prev
                        </a>
                    </li>
                @endif

                @for ($i = 0; $i < $totalPage; $i++)
                    <li>
                        <a href="/admin/log-activity?page={{ $i + 1 }}"
                           class="{{ $currentPage == $i + 1 ? 'active' : '' }}">
                            {{ $i + 1 }}
                        </a>
                    </li>
                @endfor

                @if ($currentPage < $totalPage)
                    <li>
                        <a href="/admin/log-activity?page={{ $currentPage + 1 }}">
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