@extends('frontend.layout')
@section('title')
    My Profile
@endsection
@section('content')

<style>
    .profile-section {
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

    .avatar-card {
        background: #fff;
        border-radius: 6px;
        box-shadow: 0 1px 6px rgba(0,0,0,0.07);
        padding: 2rem 1.5rem;
        text-align: center;
        margin-bottom: 1.25rem;
    }

    .avatar-wrap {
        position: relative;
        width: 100px;
        height: 100px;
        cursor: pointer;
        margin: 0 auto 1rem;
    }

    .avatar-wrap img,
    .avatar-wrap .avatar-placeholder {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #f0f0f0;
        display: block;
    }

    .avatar-wrap .avatar-placeholder {
        background: #222;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        color: #fff;
        font-weight: 700;
    }

    .avatar-overlay {
        position: absolute;
        inset: 0;
        border-radius: 50%;
        background: rgba(0,0,0,0.5);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.2s;
        color: #fff;
        font-size: 1.2rem;
        gap: 4px;
    }

    .avatar-wrap:hover .avatar-overlay { opacity: 1; }

    .avatar-overlay small { font-size: 0.55rem; letter-spacing: 0.05em; }

    .avatar-card .user-name {
        font-size: 1.05rem;
        font-weight: 800;
        color: #222;
        margin-bottom: 2px;
    }

    .avatar-card .user-email {
        font-size: 0.82rem;
        color: #aaa;
        margin-bottom: 0.5rem;
    }

    .avatar-card .user-since {
        font-size: 0.75rem;
        color: #bbb;
        text-transform: uppercase;
        letter-spacing: 0.06em;
    }

    .form-card {
        background: #fff;
        border-radius: 6px;
        box-shadow: 0 1px 6px rgba(0,0,0,0.07);
        overflow: hidden;
        margin-bottom: 1.25rem;
    }

    .form-card .card-head {
        padding: 0.9rem 1.5rem;
        background: #fafafa;
        border-bottom: 1px solid #f0f0f0;
        font-size: 0.75rem;
        font-weight: 800;
        letter-spacing: 0.09em;
        text-transform: uppercase;
        color: #888;
    }

    .form-card .card-body-inner { padding: 1.5rem; }

    .form-group-custom { margin-bottom: 1.1rem; }

    .form-group-custom label {
        display: block;
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: #888;
        margin-bottom: 6px;
    }

    .form-group-custom .form-control {
        width: 100%;
        border: 1.5px solid #e0e0e0;
        border-radius: 4px;
        padding: 0.65rem 0.9rem;
        font-size: 0.9rem;
        color: #333;
        transition: border-color 0.15s;
        background: #fff;
    }

    .form-group-custom .form-control:focus {
        outline: none;
        border-color: #222;
        box-shadow: none;
    }

    .form-group-custom .input-hint {
        font-size: 0.72rem;
        color: #bbb;
        margin-top: 4px;
    }

    .btn-save {
        display: inline-block;
        padding: 0.75rem 2rem;
        background: #222;
        color: #fff;
        font-weight: 700;
        font-size: 0.85rem;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background 0.2s;
    }

    .btn-save:hover { background: #e74c3c; }

    .alert-custom {
        padding: 0.75rem 1rem;
        border-radius: 4px;
        font-size: 0.85rem;
        font-weight: 600;
        margin-bottom: 1rem;
    }

    .alert-success-custom { background: #d1e7dd; color: #0a5c36; }
    .alert-error-custom   { background: #f8d7da; color: #842029; }

    @media (max-width: 767px) {
        .form-card .card-body-inner { padding: 1.1rem; }
    }
</style>

<main>
    <section class="profile-section">
        <div class="container">

            <h2 class="page-title">My Profile</h2>

            @if (Session::has('success'))
                <div class="alert-custom alert-success-custom">
                    <i class="fa-solid fa-circle-check me-1"></i> {{ Session::get('success') }}
                </div>
            @endif

            @if (Session::has('error'))
                <div class="alert-custom alert-error-custom">
                    <i class="fa-solid fa-circle-exclamation me-1"></i> {{ Session::get('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert-custom alert-error-custom">
                    @foreach ($errors->all() as $error)
                        <div><i class="fa-solid fa-circle-exclamation me-1"></i> {{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <div class="row g-4 align-items-start">

                {{-- ── Avatar ── --}}
                <div class="col-12 col-md-4 col-lg-3">
                    <div class="avatar-card">

                        <form action="/profile/update-photo" method="post" enctype="multipart/form-data" id="avatarForm">
                            @csrf
                            <div class="avatar-wrap mx-auto" onclick="document.getElementById('avatarInput').click()" title="Click to change photo">
                                @if ($user->profile && $user->profile != '')
                                    <img src="/uploads/{{ $user->profile }}" alt="Profile">
                                @else
                                    <div class="avatar-placeholder" id="avatarInitial">
                                        {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                                    </div>
                                @endif
                                <div class="avatar-overlay">
                                    <i class="fa-solid fa-camera"></i>
                                    <small>Change</small>
                                </div>
                            </div>
                            {{-- Hidden file input: auto-submits form on change --}}
                            <input type="file" id="avatarInput" name="avatar" accept="image/*" style="display:none;"
                                   onchange="document.getElementById('avatarForm').submit()">
                        </form>

                        <div class="user-name mt-2">{{ $user->name }}</div>
                        <div class="user-email">{{ $user->email }}</div>
                        @if ($user->created_at)
                            <div class="user-since">Member since {{ \Carbon\Carbon::parse($user->created_at)->format('M Y') }}</div>
                        @endif
                    </div>
                </div>

                {{-- ── Forms ── --}}
                <div class="col-12 col-md-8 col-lg-9">

                    {{-- Personal Info --}}
                    <div class="form-card">
                        <div class="card-head">Personal Information</div>
                        <div class="card-body-inner">
                            <form action="/profile/update" method="post">
                                @csrf
                                @method('PUT')
                                <div class="row g-3">
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group-custom">
                                            <label>Name</label>
                                            <input type="text" name="name" class="form-control"
                                                   value="{{ old('name', $user->name) }}"
                                                   placeholder="Your name" required>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group-custom">
                                            <label>Email Address</label>
                                            <input type="email" name="email" class="form-control"
                                                   value="{{ old('email', $user->email) }}"
                                                   placeholder="Your email" required>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn-save">
                                    <i class="fa-solid fa-floppy-disk me-1"></i> Save Changes
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- Change Password --}}
                    <div class="form-card">
                        <div class="card-head">Change Password</div>
                        <div class="card-body-inner">
                            <form action="/profile/change-password" method="post">
                                @csrf
                                @method('PUT')
                                <div class="row g-3">
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group-custom">
                                            <label>New Password</label>
                                            <input type="password" name="new_password" class="form-control"
                                                   placeholder="Min. 8 characters" required>
                                            <div class="input-hint">At least 8 characters</div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="form-group-custom">
                                            <label>Confirm New Password</label>
                                            <input type="password" name="new_password_confirmation" class="form-control"
                                                   placeholder="Repeat new password" required>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn-save">
                                    <i class="fa-solid fa-lock me-1"></i> Update Password
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
</main>

@endsection