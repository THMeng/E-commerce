@extends('backend.master')

@section('content')
<div class="content-wrapper">
    @section('site-title')
        Admin | List Product
    @endsection
    @section('page-main-title')
        List Product
    @endsection

    <div class="container-xxl flex-grow-1 container-p-y">

        <style>
            /* ── Desktop table ── */
            .product-table-wrap { display: block; }
            .product-cards-wrap  { display: none; }

            /* ── Mobile / Tablet cards ── */
            @media (max-width: 991px) {
                .product-table-wrap { display: none; }
                .product-cards-wrap  { display: block; }
            }

            /* Card style */
            .product-card {
                background: #fff;
                border-radius: 10px;
                box-shadow: 0 1px 8px rgba(0,0,0,0.07);
                padding: 1rem;
                margin-bottom: 1rem;
                display: flex;
                gap: 0.85rem;
                align-items: flex-start;
            }

            .product-card img {
                width: 72px;
                height: 72px;
                object-fit: contain;
                border-radius: 6px;
                background: #f8f8f8;
                flex-shrink: 0;
                border: 1px solid #eee;
            }

            .product-card .card-body {
                flex: 1;
                min-width: 0;
            }

            .product-card .card-name {
                font-weight: 700;
                font-size: 0.92rem;
                color: #222;
                margin-bottom: 0.35rem;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .product-card .card-meta {
                display: flex;
                flex-wrap: wrap;
                gap: 5px;
                margin-bottom: 0.5rem;
            }

            .product-card .card-row {
                font-size: 0.78rem;
                color: #666;
                margin-bottom: 3px;
            }

            .product-card .card-row span {
                font-weight: 600;
                color: #333;
            }

            .product-card .card-actions {
                display: flex;
                gap: 6px;
                margin-top: 0.6rem;
                flex-wrap: wrap;
            }

            .product-card .card-actions a {
                display: inline-flex;
                align-items: center;
                gap: 4px;
                padding: 5px 12px;
                border-radius: 4px;
                font-size: 0.75rem;
                font-weight: 600;
                text-decoration: none;
                transition: opacity 0.15s;
            }

            .product-card .card-actions a:hover { opacity: 0.82; }
            .product-card .card-actions .btn-edit   { background: #e7f1ff; color: #0d6efd; }
            .product-card .card-actions .btn-detail { background: #e8f5e9; color: #198754; }
            .product-card .card-actions .btn-delete { background: #fdecea; color: #dc3545; }

            /* Pagination */
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
        <div class="card product-table-wrap">
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Thumbnail</th>
                            <th>Stock</th>
                            <th>Regular Price</th>
                            <th>Sale Price</th>
                            <th>Size</th>
                            <th>Color</th>
                            <th>Category</th>
                            <th>Viewer</th>
                            <th>Author</th>
                            <th>Create Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($product as $proVal)
                            <tr>
                                <td><span class="badge bg-label-primary me-1">{{ $proVal->name }}</span></td>
                                <td><img src="/uploads/{{ $proVal->thumbnail }}" width="70px"></td>
                                <td>
                                    @if ($proVal->quantity == 0)
                                        <span class="badge bg-label-danger me-1">out of stock</span>
                                    @else
                                        {{ $proVal->quantity }}
                                    @endif
                                </td>
                                <td>{{ $proVal->regular_price }} $</td>
                                <td>{{ $proVal->sale_price }} $</td>
                                <td><span class="badge bg-label-warning me-1">{{ $proVal->attribute_size }}</span></td>
                                <td><span class="badge bg-label-danger me-1">{{ $proVal->attribute_color }}</span></td>
                                <td><span class="badge bg-label-warning me-1">{{ $proVal->cateName }}</span></td>
                                <td><i>{{ $proVal->viewer }}</i></td>
                                <td><span class="badge bg-label-primary me-1">{{ $proVal->authorname }}</span></td>
                                <td><i>{{ $proVal->created_at }}</i></td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="/admin/update-product/{{ $proVal->id }}">
                                                <i class="bx bx-edit-alt me-1"></i> Edit
                                            </a>
                                            <a class="dropdown-item" href="/admin/detail-product/{{ $proVal->id }}">
                                                <i class="bx bx-show me-1"></i> Detail
                                            </a>
                                            <a class="dropdown-item remove-post-key"
                                               data-value="{{ $proVal->id }}"
                                               data-bs-toggle="modal"
                                               data-bs-target="#basicModal"
                                               href="javascript:void(0);">
                                                <i class="bx bx-trash me-1"></i> Delete
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ── MOBILE / TABLET CARDS ── --}}
        <div class="product-cards-wrap">
            @foreach ($product as $proVal)
                <div class="product-card">
                    <img src="/uploads/{{ $proVal->thumbnail }}" alt="{{ $proVal->name }}">
                    <div class="card-body">
                        <div class="card-name">{{ $proVal->name }}</div>

                        <div class="card-meta">
                            @if ($proVal->quantity == 0)
                                <span class="badge bg-label-danger">Out of Stock</span>
                            @else
                                <span class="badge bg-label-success">Stock: {{ $proVal->quantity }}</span>
                            @endif
                            @if ($proVal->sale_price > 0)
                                <span class="badge bg-label-warning">Sale</span>
                            @endif
                        </div>

                        <div class="card-row">Price: <span>${{ $proVal->regular_price }}</span>
                            @if ($proVal->sale_price > 0)
                                → <span style="color:#e74c3c">${{ $proVal->sale_price }}</span>
                            @endif
                        </div>
                        <div class="card-row">Category: <span>{{ $proVal->cateName }}</span></div>
                        <div class="card-row">Size: <span>{{ $proVal->attribute_size }}</span> &nbsp; Color: <span>{{ $proVal->attribute_color }}</span></div>
                        <div class="card-row">Author: <span>{{ $proVal->authorname }}</span> &nbsp; Views: <span>{{ $proVal->viewer }}</span></div>
                        <div class="card-row">Date: <span>{{ \Carbon\Carbon::parse($proVal->created_at)->format('d M Y') }}</span></div>

                        <div class="card-actions">
                            <a href="/admin/update-product/{{ $proVal->id }}" class="btn-edit">
                                <i class="bx bx-edit-alt"></i> Edit
                            </a>
                            <a href="/admin/detail-product/{{ $proVal->id }}" class="btn-detail">
                                <i class="bx bx-show"></i> Detail
                            </a>
                            <a href="javascript:void(0);"
                               class="btn-delete remove-post-key"
                               data-value="{{ $proVal->id }}"
                               data-bs-toggle="modal"
                               data-bs-target="#basicModal">
                                <i class="bx bx-trash"></i> Delete
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- ── PAGINATION ── --}}
        <div class="pagination_rounded">
            <ul>
                @if ($currentPage > 1)
                    <li>
                        <a href="/admin/list-product?page={{ $currentPage - 1 }}" class="prev">
                            <i class="fa fa-angle-left"></i> Prev
                        </a>
                    </li>
                @endif

                @for ($i = 0; $i < $totalPage; $i++)
                    <li>
                        <a href="/admin/list-product?page={{ $i + 1 }}"
                           class="{{ $currentPage == $i + 1 ? 'active' : '' }}">
                            {{ $i + 1 }}
                        </a>
                    </li>
                @endfor

                @if ($currentPage < $totalPage)
                    <li>
                        <a href="/admin/list-product?page={{ $currentPage + 1 }}" class="next">
                            Next <i class="fa fa-angle-right"></i>
                        </a>
                    </li>
                @endif
            </ul>
        </div>

        {{-- ── DELETE MODAL ── --}}
        <form action="/admin/remove-product-submit" method="post">
            @csrf
            <div class="modal fade" id="basicModal" tabindex="-1" style="display: none;" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Are you sure you want to delete this product?</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" id="remove-val" name="remove_id">
                            <button type="submit" class="btn btn-danger">Confirm Delete</button>
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <hr class="my-5">
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.remove-post-key').forEach(function (btn) {
        btn.addEventListener('click', function () {
            document.getElementById('remove-val').value = this.getAttribute('data-value');
        });
    });
});
</script>

@endsection