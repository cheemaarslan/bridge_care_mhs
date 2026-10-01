<!DOCTYPE html>
<html dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="CCM RPM Login Portal">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/favicon.png') }}">
    <title>MHS RPM - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800;900&family=Playfair+Display:wght@700&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --primary: #1d6c9d;
            --primary-dark: #145680;
            --primary-light: #2889c4;
            --secondary: #499654;
            --secondary-dark: #367040;
            --secondary-light: #5cb566;
            --bg-body: #eef6f0;
            --card-bg: #ffffff;
            --text-dark: #0d2e1a;
            --text-muted: #4d7560;
            --border: #c6dfc9;
            --input-bg: #f4fbf5;
            --shadow-blue: rgba(29, 108, 157, 0.18);
            --shadow-green: rgba(73, 150, 84, 0.20);
            --shadow-strong: rgba(13, 46, 26, 0.22);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Nunito', sans-serif;
            background: var(--bg-body);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            /* allow page scrolling on small screens */
            overflow: auto;
        }

        /* ── Animated background ── */
        .bg-layer {
            position: fixed;
            inset: 0;
            z-index: 0;
            background:
                radial-gradient(ellipse 80% 60% at 10% 20%, rgba(29, 108, 157, 0.13) 0%, transparent 70%),
                radial-gradient(ellipse 60% 50% at 90% 80%, rgba(73, 150, 84, 0.13) 0%, transparent 65%),
                radial-gradient(ellipse 50% 40% at 50% 50%, rgba(73, 150, 84, 0.07) 0%, transparent 70%),
                #eef6f0;
        }

        .bg-circles {
            position: fixed;
            inset: 0;
            z-index: 0;
            overflow: hidden;
        }

        .bg-circles span {
            position: absolute;
            border-radius: 50%;
            opacity: 0.07;
            animation: drift 18s ease-in-out infinite;
        }

        .bg-circles span:nth-child(1) {
            width: 420px;
            height: 420px;
            top: -80px;
            left: -100px;
            background: var(--primary);
            animation-duration: 20s;
        }

        .bg-circles span:nth-child(2) {
            width: 280px;
            height: 280px;
            bottom: -60px;
            right: -80px;
            background: var(--secondary);
            animation-duration: 15s;
            animation-delay: -5s;
        }

        .bg-circles span:nth-child(3) {
            width: 180px;
            height: 180px;
            top: 40%;
            left: 55%;
            background: var(--secondary-light);
            animation-duration: 12s;
            animation-delay: -8s;
        }

        @keyframes drift {

            0%,
            100% {
                transform: translate(0, 0) scale(1);
            }

            50% {
                transform: translate(20px, -25px) scale(1.08);
            }
        }

        /* ── ECG line decoration ── */
        .ecg-strip {
            position: fixed;
            bottom: 60px;
            left: 0;
            right: 0;
            z-index: 0;
            opacity: 0.06;
            pointer-events: none;
        }

        /* ── Wrapper ── */
        .login-wrapper {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            min-height: 100vh;
            padding: 24px;
        }

        /* ── Two-column container ── */
        .login-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0;
            max-width: 980px;
            width: 100%;
            border-radius: 24px;
            overflow: hidden;
            box-shadow:
                0 30px 80px var(--shadow-strong),
                0 0 0 1px rgba(29, 108, 157, 0.08);
            animation: rise 0.75s cubic-bezier(.22, .68, 0, 1.2) both;
        }

        @keyframes rise {
            from {
                opacity: 0;
                transform: translateY(40px) scale(0.97);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* ── Left panel ── */
        .login-image {
            background: linear-gradient(160deg, var(--primary) 0%, var(--primary-dark) 45%, var(--secondary-dark) 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 48px 36px;
            position: relative;
            overflow: hidden;
            min-height: 560px;

        }

        .login-image::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse 120% 80% at 80% 110%, rgba(73, 150, 84, 0.30) 0%, transparent 60%),
                radial-gradient(ellipse 80% 60% at -10% -10%, rgba(255, 255, 255, 0.06) 0%, transparent 50%);
        }

        /* Subtle dot grid */
        .login-image::after {
            content: '';
            position: absolute;
            inset: 0;
            background-image: radial-gradient(circle, rgba(255, 255, 255, 0.12) 1px, transparent 1px);
            background-size: 28px 28px;
            opacity: 0.4;
        }

        .img-logo-wrap {
            position: relative;
            z-index: 1;
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 28px;
        }

        .img-logo-wrap img {
            width: 106%;
            height: auto;
            object-fit: contain;
            filter: drop-shadow(0 12px 32px rgba(0, 0, 0, 0.35));
            animation: floatLogo 4s ease-in-out infinite;
        }

        @keyframes floatLogo {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .img-tagline {
            color: rgba(255, 255, 255, 0.75);
            font-size: 13.5px;
            font-weight: 600;
            letter-spacing: 2.5px;
            text-transform: uppercase;
            position: relative;
            z-index: 1;
        }

        .img-stats {
            display: flex;
            gap: 24px;
            position: relative;
            z-index: 1;
            margin-top: 8px;
        }

        .stat-pill {
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.18);
            border-radius: 50px;
            padding: 8px 10px;
            text-align: center;
            backdrop-filter: blur(8px);
        }

        .stat-pill .num {
            display: block;
            color: #fff;
            font-size: 16px;
            font-weight: 800;
            line-height: 1.2;
        }

        .stat-pill .lbl {
            display: block;
            color: rgba(255, 255, 255, 0.65);
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        /* ── Right panel (form card) ── */
        .login-card {
            background: var(--card-bg);
            display: flex;
            flex-direction: column;
        }

        /* Header strip */
        .login-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            padding: 40px 36px 36px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .login-header::before {
            content: '';
            position: absolute;
            top: -60px;
            right: -60px;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.07);
        }

        .login-header::after {
            content: '';
            position: absolute;
            bottom: -40px;
            left: -40px;
            width: 140px;
            height: 140px;
            border-radius: 50%;
            background: rgba(73, 150, 84, 0.20);
        }

        .pulse-icon {
            width: 72px;
            height: 72px;
            background: rgba(255, 255, 255, 0.15);
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 18px;
            font-size: 28px;
            color: #fff;
            position: relative;
            z-index: 1;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.18);
        }

        .pulse-icon::before {
            content: '';
            position: absolute;
            inset: -6px;
            border-radius: 50%;
            border: 2px solid rgba(255, 255, 255, 0.15);
            animation: pulse-ring 2s ease-out infinite;
        }

        @keyframes pulse-ring {
            0% {
                transform: scale(0.9);
                opacity: 0.8;
            }

            100% {
                transform: scale(1.4);
                opacity: 0;
            }
        }

        .login-header h1 {
            font-family: 'Playfair Display', serif;
            font-size: 30px;
            font-weight: 700;
            color: #fff;
            letter-spacing: 0.5px;
            position: relative;
            z-index: 1;
            margin-bottom: 6px;
        }

        .login-header p {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.8);
            font-weight: 400;
            letter-spacing: 0.3px;
            position: relative;
            z-index: 1;
        }

        /* Green accent bar */
        .accent-bar {
            height: 4px;
            background: linear-gradient(90deg, var(--secondary), var(--secondary-light), var(--primary-light));
        }

        /* Body */
        .login-body {
            padding: 36px 36px 32px;
            flex: 1;
        }

        .section-label {
            font-size: 11px;
            font-weight: 800;
            color: var(--text-muted);
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-label::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 700;
            color: var(--text-dark);
            font-size: 13.5px;
            letter-spacing: 0.2px;
        }

        .input-wrap {
            position: relative;
        }

        .input-wrap .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary);
            font-size: 14px;
            opacity: 0.7;
            transition: opacity 0.2s;
        }

        .form-control {
            width: 100%;
            padding: 13px 16px 13px 40px;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            font-size: 14px;
            font-family: 'Nunito', sans-serif;
            font-weight: 600;
            background: var(--input-bg);
            color: var(--text-dark);
            transition: all 0.25s ease;
        }

        .form-control::placeholder {
            color: #9ab5c7;
            font-weight: 400;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            background: #fff;
            box-shadow: 0 0 0 3.5px rgba(29, 108, 157, 0.12);
        }

        .form-control:focus+.input-icon,
        .input-wrap:focus-within .input-icon {
            opacity: 1;
        }

        .form-control.is-invalid {
            border-color: #dc3545;
            background: #fff5f5;
        }

        .error-message {
            color: #dc3545;
            font-size: 12px;
            margin-top: 6px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        /* Remember me */
        .form-check {
            display: flex;
            align-items: center;
            margin-bottom: 22px;
            gap: 10px;
        }

        .form-check-input {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: var(--primary);
            border-radius: 5px;
            flex-shrink: 0;
        }

        .form-check-label {
            font-size: 13.5px;
            color: var(--text-muted);
            font-weight: 600;
            cursor: pointer;
            margin: 0;
        }

        /* Sign in button */
        .btn-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 800;
            font-family: 'Nunito', sans-serif;
            cursor: pointer;
            letter-spacing: 0.6px;
            transition: all 0.25s ease;
            box-shadow: 0 8px 24px var(--shadow-blue);
            position: relative;
            overflow: hidden;
            margin-bottom: 4px;
        }

        .btn-login::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, var(--secondary-dark) 0%, var(--secondary) 100%);
            opacity: 0;
            transition: opacity 0.3s;
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 14px 36px var(--shadow-green);
            color: #fff;
        }

        .btn-login:hover::after {
            opacity: 1;
        }

        .btn-login span {
            position: relative;
            z-index: 1;
        }

        .btn-login:active {
            transform: translateY(0);
        }

        /* Divider */
        .divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 18px 0 14px;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        .divider span {
            font-size: 11px;
            color: var(--text-muted);
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }

        /* Forgot */
        .forgot-password {
            text-align: center;
        }

        .forgot-password a {
            color: var(--primary);
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 700;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .forgot-password a:hover {
            color: var(--secondary);
            gap: 9px;
        }

        /* Footer note */
        .secure-note {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            margin-top: 24px;
            padding-top: 18px;
            border-top: 1px solid var(--border);
            color: var(--text-muted);
            font-size: 11.5px;
            font-weight: 600;
        }

        .secure-note i {
            color: var(--secondary);
            font-size: 12px;
        }

        /* Preloader */
        .preloader {
            display: none;
        }

        .preloader.show {
            display: flex;
            position: fixed;
            inset: 0;
            background: rgba(13, 46, 66, 0.55);
            align-items: center;
            justify-content: center;
            z-index: 10000;
            backdrop-filter: blur(4px);
        }

        .spinner {
            width: 52px;
            height: 52px;
            border: 4px solid rgba(255, 255, 255, 0.25);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* ── Responsive ── */
        @media (max-width: 780px) {
            .login-container {
                grid-template-columns: 1fr;
                border-radius: 20px;
            }

            .login-image {
                display: none;
            }

            .login-body {
                padding: 28px 24px 24px;
            }

            .login-header {
                padding: 32px 24px 28px;
            }
        }

        @media (max-width: 1200px) and (min-width: 781px) {
            .login-wrapper {
                padding: 16px;
            }

            .login-container {
                max-width: 900px;
            }

            .login-image {
                min-height: 500px;
                padding: 36px 28px;
            }

            .login-body {
                padding: 28px 28px 24px;
            }

            .login-header {
                padding: 32px 28px 28px;
            }

            .img-logo-wrap img {
                width: 96%;
            }
        }

        @media (max-height: 820px) and (min-width: 781px) {
            body {
                align-items: flex-start;
            }

            .login-wrapper {
                min-height: auto;
                padding: 18px 24px;
                align-items: flex-start;
            }

            .login-container {
                max-width: 920px;
            }

            .login-image {
                min-height: 460px;
                padding: 34px 28px;
            }

            .login-body {
                padding: 26px 28px 22px;
            }

            .login-header {
                padding: 30px 28px 26px;
            }

            .section-label,
            .form-group,
            .divider,
            .secure-note {
                margin-bottom: 16px;
            }

            .secure-note {
                margin-top: 18px;
                padding-top: 14px;
            }
        }
    </style>
</head>

<body>
    <div class="bg-layer"></div>
    <div class="bg-circles">
        <span></span><span></span><span></span>
    </div>

    <!-- ECG SVG decoration -->
    <svg class="ecg-strip" viewBox="0 0 1440 60" fill="none" xmlns="http://www.w3.org/2000/svg"
        preserveAspectRatio="none">
        <polyline points="0,30 180,30 220,30 240,5 260,55 280,10 300,50 320,30 1440,30" stroke="#499654"
            stroke-width="2.5" fill="none" />
    </svg>

    <div class="preloader" id="preloader">
        <div class="spinner"></div>
    </div>

    <div class="login-wrapper">
        <div class="login-container">

            <!-- LEFT: Logo Panel -->
            <div class="login-image">
                <div class="img-logo-wrap">
                    <img src="{{ asset('assets/images/mhs-logo.webp') }}" alt="Miracle Healthcare Solution"
                        style="border-radius: 24px;"
                        onerror="this.onerror=null;this.src='{{ asset('assets/images/mhs-logo.webp') }}';">
                    <span class="img-tagline">Trusted Clinical Care</span>
                    <div class="img-stats">
                        <div class="stat-pill">
                            <span class="num">CCM</span>
                            <span class="lbl">Chronic Care Management</span>
                        </div>
                        <div class="stat-pill">
                            <span class="num">RPM</span>
                            <span class="lbl">Remote Patient Monitoring</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT: Form Panel -->
            <div class="login-card">
                <div class="login-header">
                    <div class="pulse-icon">
                        <i class="fas fa-heartbeat"></i>
                    </div>
                    <h1>CCM RPM</h1>
                    <p>Clinical Care Management Portal</p>
                </div>

                <div class="accent-bar"></div>

                <div class="login-body">
                    <div class="section-label">Secure Sign In</div>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email -->
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <div class="input-wrap">
                                <input id="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" required autocomplete="email" autofocus
                                    placeholder="you@example.com">
                                <i class="fas fa-envelope input-icon"></i>
                            </div>
                            @error('email')
                                <div class="error-message"><i class="fas fa-circle-exclamation"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="form-group">
                            <label for="password">Password</label>
                            <div class="input-wrap">
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    required autocomplete="current-password" placeholder="••••••••••">
                                <i class="fas fa-lock input-icon"></i>
                            </div>
                            @error('password')
                                <div class="error-message"><i class="fas fa-circle-exclamation"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Remember Me -->
                        <div class="form-check">
                            <input id="remember" type="checkbox" class="form-check-input" name="remember"
                                {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">Keep me signed in</label>
                        </div>

                        <!-- Sign In -->
                        <button type="submit" class="btn-login">
                            <span><i class="fas fa-arrow-right-to-bracket"></i> &nbsp;Sign In to Portal</span>
                        </button>

                        <!-- Forgot -->
                        @if (Route::has('password.request'))
                            <div class="divider"><span>or</span></div>
                            <div class="forgot-password">
                                <a href="{{ route('password.request') }}">
                                    <i class="fas fa-key"></i> Reset your password
                                </a>
                            </div>
                        @endif

                    </form>

                    <div class="secure-note">
                        <i class="fas fa-shield-halved"></i>
                        &copy; {{ date('Y') }} Miracle Healthcare Solution. All rights reserved.
                    </div>
                    <div class="secure-note" style="margin-top: 8px; border-top: none; padding-top: 0;">
                        <i class="fas fa-code"></i>
                        Developed by <a href="https://bitlogicx.com/" target="_blank"
                            style="color: var(--primary); font-weight: 800; text-decoration: none; transition: color 0.2s;"
                            onmouseover="this.style.color='var(--secondary)'"
                            onmouseout="this.style.color='var(--primary)'">BitLogicx</a>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('preloader')?.classList.remove('show');
        });
        document.querySelector('form')?.addEventListener('submit', function() {
            document.getElementById('preloader')?.classList.add('show');
        });
    </script>
</body>

</html>
