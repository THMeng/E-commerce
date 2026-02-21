@extends('backend.master-login-register')
@section('title')
    Login
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

    /* ── Brand ── */
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

    /* ── Alerts ── */
    .auth-alert {
        padding: 0.7rem 1rem;
        border-radius: 6px;
        font-size: 0.85rem;
        font-weight: 600;
        margin-bottom: 1.25rem;
        text-align: center;
    }

    .auth-alert.success { background: #d1e7dd; color: #0a5c36; }
    .auth-alert.danger  { background: #f8d7da; color: #842029; }
    .auth-alert.warning { background: #fff3cd; color: #856404; }

    /* ── Form fields ── */
    .form-group {
        margin-bottom: 1.1rem;
    }

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

    /* ── Remember + error row ── */
    .form-check-label {
        font-size: 0.85rem;
        color: #555;
        cursor: pointer;
    }

    .form-check-input {
        width: 16px;
        height: 16px;
        cursor: pointer;
        accent-color: #222;
    }

    .error-text {
        font-size: 0.78rem;
        color: #e74c3c;
        margin-top: 4px;
        display: block;
    }

    /* ── Submit button ── */
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

    /* ── Footer link ── */
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
            <p>Sign in to your account</p>
        </div>

        {{-- Alerts --}}
        @if (Session::has('message'))
            <div class="auth-alert success">{{ Session::get('message') }}</div>
        @endif

        @if (Session::has('message_fail'))
            <div class="auth-alert danger">{{ Session::get('message_fail') }}</div>
        @endif

        @if (Session::has('message_logout'))
            <div class="auth-alert warning">{{ Session::get('message_logout') }}</div>
        @endif

        @if (Session::has('status'))
            <div class="auth-alert danger">Invalid username or password.</div>
        @endif

        {{-- Form --}}
        <form action="/signin-submit" method="POST">
            @csrf

            <div class="form-group">
                <label for="email">Email or Username</label>
                <div class="input-wrap">
                    <input type="text" id="email" name="name_email"
                           placeholder="Enter your email or username" autofocus>
                    <i class="fa-solid fa-user input-icon"></i>
                </div>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-wrap">
                    <input type="password" id="password" name="password"
                           placeholder="Enter your password">
                    <i class="fa-solid fa-eye input-icon" id="togglePassword"></i>
                </div>
            </div>

            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="d-flex align-items-center gap-2">
                    <input class="form-check-input" type="checkbox" id="remember-me" name="remember" value="true">
                    <label class="form-check-label" for="remember-me">Remember me</label>
                </div>
            </div>

            <button type="submit" class="btn-auth">
                <i class="fa-solid fa-right-to-bracket me-2"></i> Sign In
            </button>
        </form>

        <div class="auth-footer">
            New here? <a href="/signup">Create an account</a>
        </div>

    </div>
</div>

<script>
    document.getElementById('togglePassword').addEventListener('click', function () {
        var input = document.getElementById('password');
        var isHidden = input.type === 'password';
        input.type = isHidden ? 'text' : 'password';
        this.classList.toggle('fa-eye', !isHidden);
        this.classList.toggle('fa-eye-slash', isHidden);
    });
</script>

@endsection