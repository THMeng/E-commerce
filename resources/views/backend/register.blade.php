@extends('backend.master-login-register')
@section('title')
    Register
@endsection
@section('content')

<style>
    * { box-sizing: border-box; }

    body {
        background: #f5f5f5;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Segoe UI', sans-serif;
    }

    .auth-wrapper {
        width: 100%;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 1rem;
        background: #f5f5f5;
    }

    .auth-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 24px rgba(0,0,0,0.08);
        padding: 2.5rem 2rem;
        width: 100%;
        max-width: 420px;
    }

    .auth-brand {
        text-align: center;
        margin-bottom: 2rem;
    }

    .auth-logo {
        height: 50px;
        width: auto;
        object-fit: contain;
        display: block;
        margin: 0 auto 0.5rem;
    }

    .auth-brand .brand-logo {
        font-size: 2rem;
        font-weight: 900;
        letter-spacing: -0.03em;
        color: #222;
        text-decoration: none;
        display: inline-block;
        margin-bottom: 0.5rem;
    }

    .auth-brand p {
        font-size: 0.88rem;
        color: #aaa;
        margin: 0;
    }

    .auth-alert {
        padding: 0.7rem 1rem;
        border-radius: 6px;
        font-size: 0.85rem;
        font-weight: 600;
        margin-bottom: 1.25rem;
        text-align: center;
    }

    .auth-alert.danger  { background: #f8d7da; color: #842029; }
    .auth-alert.warning { background: #fff3cd; color: #856404; }

    .form-group { margin-bottom: 1.1rem; }

    .form-group label {
        display: block;
        font-size: 0.78rem;
        font-weight: 700;
        letter-spacing: 0.07em;
        text-transform: uppercase;
        color: #666;
        margin-bottom: 6px;
    }

    .form-group .input-wrap {
        position: relative;
        display: flex;
        align-items: center;
    }

    .form-group input {
        width: 100%;
        height: 44px;
        border: 1.5px solid #e0e0e0;
        border-radius: 6px;
        padding: 0 42px 0 14px;
        font-size: 0.9rem;
        color: #333;
        background: #fff;
        transition: border-color 0.15s, box-shadow 0.15s;
        outline: none;
    }

    .form-group input[type="file"] {
        padding: 10px 14px;
        height: auto;
        cursor: pointer;
    }

    .form-group input:focus {
        border-color: #222;
        box-shadow: 0 0 0 3px rgba(34,34,34,0.08);
    }

    .form-group input::placeholder { color: #ccc; }

    .input-icon {
        position: absolute;
        right: 13px;
        color: #bbb;
        font-size: 1rem;
        cursor: pointer;
        user-select: none;
        transition: color 0.15s;
    }

    .input-icon:hover { color: #555; }

    /* Profile upload area */
    .upload-label {
        display: flex;
        align-items: center;
        gap: 10px;
        border: 1.5px dashed #ddd;
        border-radius: 6px;
        padding: 0.85rem 1rem;
        cursor: pointer;
        transition: border-color 0.15s, background 0.15s;
        background: #fafafa;
    }

    .upload-label:hover {
        border-color: #222;
        background: #f5f5f5;
    }

    .upload-label i {
        font-size: 1.3rem;
        color: #aaa;
    }

    .upload-label .upload-text {
        font-size: 0.85rem;
        color: #888;
        flex: 1;
    }

    .upload-label .upload-text strong {
        display: block;
        color: #444;
        font-size: 0.82rem;
    }

    #profileInput { display: none; }

    .btn-auth {
        width: 100%;
        height: 46px;
        background: #222;
        color: #fff;
        font-weight: 700;
        font-size: 0.9rem;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        transition: background 0.2s;
        margin-top: 0.5rem;
    }

    .btn-auth:hover { background: #e74c3c; }

    .auth-footer {
        text-align: center;
        margin-top: 1.5rem;
        font-size: 0.85rem;
        color: #888;
    }

    .auth-footer a {
        color: #222;
        font-weight: 700;
        text-decoration: none;
        transition: color 0.15s;
    }

    .auth-footer a:hover { color: #e74c3c; }

    @media (max-width: 480px) {
        .auth-card { padding: 2rem 1.25rem; }
    }
</style>

<div class="auth-wrapper">
    <div class="auth-card">

        {{-- Brand --}}
        <div class="auth-brand">
            @php $logo = DB::table('logo')->first(); @endphp
            <a href="/">
                <img src="/uploads/{{ $logo->thumbnail ?? '' }}" alt="Logo" class="auth-logo">
            </a>
            <p>Create your account</p>
        </div>

        {{-- Alerts --}}
        @if (Session::has('message'))
            <div class="auth-alert danger">{{ Session::get('message') }}</div>
        @endif

        @if (Session::has('message_exist_user'))
            <div class="auth-alert warning">{{ Session::get('message_exist_user') }}</div>
        @endif

        {{-- Form --}}
        <form action="/signup-submit" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="username">Username</label>
                <div class="input-wrap">
                    <input type="text" id="username" name="name"
                           placeholder="Enter your username" required>
                    <i class="fa-solid fa-user input-icon"></i>
                </div>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <div class="input-wrap">
                    <input type="email" id="email" name="email"
                           placeholder="Enter your email" required>
                    <i class="fa-solid fa-envelope input-icon"></i>
                </div>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-wrap">
                    <input type="password" id="password" name="password"
                           placeholder="Enter your password" required>
                    <i class="fa-solid fa-eye input-icon" id="togglePassword"></i>
                </div>
            </div>

            <div class="form-group">
                <label>Profile Photo</label>
                <label class="upload-label" for="profileInput" id="uploadLabel">
                    <i class="fa-solid fa-cloud-arrow-up"></i>
                    <div class="upload-text">
                        <strong id="uploadFileName">Click to upload photo</strong>
                        JPG, PNG or WEBP — max 2MB
                    </div>
                </label>
                <input type="file" id="profileInput" name="profile"
                       accept="image/*" required>
            </div>

            <button type="submit" class="btn-auth">
                <i class="fa-solid fa-user-plus me-2"></i> Create Account
            </button>
        </form>

        <div class="auth-footer">
            Already have an account? <a href="/signin">Sign in</a>
        </div>

    </div>
</div>

<script>
    // Toggle password visibility
    document.getElementById('togglePassword').addEventListener('click', function () {
        var input = document.getElementById('password');
        var isHidden = input.type === 'password';
        input.type = isHidden ? 'text' : 'password';
        this.classList.toggle('fa-eye', !isHidden);
        this.classList.toggle('fa-eye-slash', isHidden);
    });

    // Show selected filename in upload area
    document.getElementById('profileInput').addEventListener('change', function () {
        var label = document.getElementById('uploadFileName');
        if (this.files && this.files[0]) {
            label.textContent = this.files[0].name;
            document.getElementById('uploadLabel').style.borderColor = '#222';
            document.getElementById('uploadLabel').querySelector('i').style.color = '#222';
        }
    });
</script>

@endsection