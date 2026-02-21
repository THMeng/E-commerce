@extends('backend.master')

@section('content')
<div class="content-wrapper">
    @section('site-title')
        Admin | Log Detail
    @endsection
    @section('page-main-title')
        Log Detail
    @endsection

    <div class="container-xxl flex-grow-1 container-p-y">

        <style>
            .log-detail-card {
                background: #fff;
                border-radius: 10px;
                box-shadow: 0 1px 8px rgba(0,0,0,0.07);
                padding: 1.5rem;
                margin-bottom: 1.25rem;
            }

            .log-detail-card .card-header-bar {
                display: flex;
                align-items: center;
                justify-content: space-between;
                flex-wrap: wrap;
                gap: 8px;
                padding-bottom: 1rem;
                margin-bottom: 1rem;
                border-bottom: 2px solid #f0f0f0;
            }

            .log-detail-card .card-header-bar .log-title {
                font-size: 1rem;
                font-weight: 800;
                color: #222;
                display: flex;
                align-items: center;
                gap: 8px;
                word-break: break-word;
            }

            .log-detail-card .field-grid {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 1rem;
            }

            @media (max-width: 575px) {
                .log-detail-card .field-grid {
                    grid-template-columns: 1fr;
                }
            }

            .log-detail-card .field-item .field-label {
                font-size: 0.7rem;
                font-weight: 700;
                letter-spacing: 0.08em;
                text-transform: uppercase;
                color: #aaa;
                margin-bottom: 4px;
            }

            .log-detail-card .field-item .field-value {
                font-size: 0.88rem;
                font-weight: 600;
                color: #333;
                word-break: break-word;
            }

            .log-detail-card .field-item.full-width {
                grid-column: 1 / -1;
            }

            /* Action badge colours */
            .action-badge {
                display: inline-block;
                padding: 3px 12px;
                border-radius: 20px;
                font-size: 0.72rem;
                font-weight: 700;
                text-transform: capitalize;
                background: #fff3cd;
                color: #856404;
            }

            .back-btn {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                padding: 0.55rem 1.25rem;
                background: #222;
                color: #fff;
                font-size: 0.82rem;
                font-weight: 700;
                letter-spacing: 0.05em;
                text-transform: uppercase;
                border-radius: 6px;
                text-decoration: none;
                transition: background 0.15s;
                margin-bottom: 1.25rem;
                display: inline-flex;
            }

            .back-btn:hover { background: #696cff; color: #fff; }
        </style>

        <a href="javascript:history.back()" class="back-btn">
            <i class="fa fa-angle-left"></i> Back
        </a>

        @foreach ($log as $value)
            <div class="log-detail-card">
                <div class="card-header-bar">
                    <div class="log-title">
                        <i class="fab fa-angular fa-lg text-danger"></i>
                        {{ $value->title }}
                    </div>
                    <span class="action-badge">{{ $value->action }}</span>
                </div>

                <div class="field-grid">
                    <div class="field-item">
                        <div class="field-label">Log ID</div>
                        <div class="field-value"># {{ $value->id }}</div>
                    </div>

                    <div class="field-item">
                        <div class="field-label">Post ID</div>
                        <div class="field-value"># {{ $value->post_id }}</div>
                    </div>

                    <div class="field-item">
                        <div class="field-label">Post Type</div>
                        <div class="field-value">
                            <span class="badge bg-label-primary">{{ $value->post_type }}</span>
                        </div>
                    </div>

                    <div class="field-item">
                        <div class="field-label">Author</div>
                        <div class="field-value">
                            <span class="badge bg-label-primary">{{ $value->name }}</span>
                        </div>
                    </div>

                    <div class="field-item">
                        <div class="field-label">Created At</div>
                        <div class="field-value">{{ \Carbon\Carbon::parse($value->created_at)->format('d M Y, h:i A') }}</div>
                    </div>

                    <div class="field-item">
                        <div class="field-label">Updated At</div>
                        <div class="field-value">{{ \Carbon\Carbon::parse($value->updated_at)->format('d M Y, h:i A') }}</div>
                    </div>
                </div>
            </div>
        @endforeach

        <hr class="my-5">
    </div>
</div>

@endsection