@extends('layouts_login.app')

@section('content')

<div class="login-container">
    <div class="login-wrapper">
        <!-- Left side with video/background -->
        <div class="login-left-section">
            <div class="video-overlay"></div>
            <video autoplay muted loop class="login-video-bg">
                <source src="{{asset('video/homepage_video.webm')}}" type="video/webm">
                <source src="{{asset('video/homepage_video.mp4')}}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            <div class="login-left-content">
                <div class="company-branding">
                    <div class="branding-wrapper">
                        <div class="brand-logo">
                            <img src="{{asset('images/l&tlogo.png')}}" alt="L&T Logo">
                        </div>
                        <h1>Larsen & Toubro</h1>
                        <h2>Healthcare Portal</h2>
                    </div>
                </div>
                <div class="welcome-section">
                    <div class="welcome-content">
                        <div class="welcome-text">Welcome Back</div>
                        <p class="welcome-subtitle">Access your account to continue to the healthcare management portal
                        </p>
                        <div class="feature-list">
                            <div class="feature-item">
                                <i class="feature-icon">✓</i>
                                <span>Secure & Encrypted</span>
                            </div>
                            <div class="feature-item">
                                <i class="feature-icon">✓</i>
                                <span>HIPAA Compliant</span>
                            </div>
                            <div class="feature-item">
                                <i class="feature-icon">✓</i>
                                <span>24/7 Support</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="security-badge">
                    <div class="badge-icon">🔒</div>
                    <div class="badge-text">Enterprise-Grade Security</div>
                </div>
            </div>
        </div>

        <!-- Right side with login form -->
        <div class="login-right-section">
            <div class="login-form-container">
                <!-- Animated background elements -->
                <div class="floating-shapes">
                    <div class="shape shape-1"></div>
                    <div class="shape shape-2"></div>
                    <div class="shape shape-3"></div>
                </div>

                <!-- Form Header -->
                <div class="form-header">
                    <div class="header-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path
                                d="M12 12C14.7614 12 17 9.76142 17 7C17 4.23858 14.7614 2 12 2C9.23858 2 7 4.23858 7 7C7 9.76142 9.23858 12 12 12Z"
                                fill="#3B82F6" />
                            <path d="M12 14C7.58172 14 4 17.5817 4 22H20C20 17.5817 16.4183 14 12 14Z" fill="#3B82F6" />
                        </svg>
                    </div>
                    <h2 class="form-title">Sign in to your account</h2>
                    <p class="form-subtitle">Enter your credentials to access the portal</p>
                </div>

                <!-- Login Form -->
                <form class="login-form" id="login_form" method="POST" action="{{ route('login') }}">
                    {{ csrf_field() }}

                    <!-- Employee Number Field -->
                    <div class="form-group{{ $errors->has('employee_number') ? ' has-error' : '' }}">
                        <label for="employee_number" class="form-label">
                            <span class="label-text">Employee Number</span>
                        </label>
                        <div class="input-with-icon">
                            <div class="input-prefix">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                                    <path d="M20 21V19C20 16.7909 18.2091 15 16 15H8C5.79086 15 4 16.7909 4 19V21"
                                        stroke="#64748B" stroke-width="2" stroke-linecap="round" />
                                    <circle cx="12" cy="7" r="4" stroke="#64748B" stroke-width="2"
                                        stroke-linecap="round" />
                                </svg>
                            </div>
                            <input id="employee_number" type="text" autocomplete='off' class="form-control"
                                name="employee_number" value="{{ old('employee_number') }}" required autofocus
                                placeholder="Enter your employee number">
                        </div>
                        @if ($errors->has('employee_number'))
                        <span class="error-message">
                            <i class="error-icon">⚠</i>
                            {{ $errors->first('employee_number') }}
                        </span>
                        @endif
                    </div>

                    <!-- Password Field -->
                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password" class="form-label">
                            <span class="label-text">Password</span>
                        </label>
                        <div class="input-with-icon">
                            <div class="input-prefix">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                                    <rect x="3" y="11" width="18" height="11" rx="2" stroke="#64748B"
                                        stroke-width="2" />
                                    <path d="M7 11V7C7 4.23858 9.23858 2 12 2C14.7614 2 17 4.23858 17 7V11"
                                        stroke="#64748B" stroke-width="2" stroke-linecap="round" />
                                </svg>
                            </div>
                            <input id="password" type="password" autocomplete='off'
                                onfocus="this.removeAttribute('readonly');" class="form-control" name="password"
                                required placeholder="Enter your password">
                            <button type="button" class="password-toggle" onclick="togglePassword()">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" class="eye-icon">
                                    <path d="M1 12C1 12 5 4 12 4C19 4 23 12 23 12C23 12 19 20 12 20C5 20 1 12 1 12Z"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                    <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" />
                                </svg>
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" class="eye-off-icon"
                                    style="display: none;">
                                    <path
                                        d="M17.94 17.94C16.2306 19.243 14.1491 19.9649 12 20C5 20 1 12 1 12C2.24389 9.68192 3.96914 7.65663 6.06 6.06M9.9 4.24C10.5883 4.07888 11.2931 3.99834 12 4C19 4 23 12 23 12C22.393 13.1356 21.6691 14.2048 20.84 15.19"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                    <path
                                        d="M15 12C15 13.6569 13.6569 15 12 15C10.3431 15 9 13.6569 9 12C9 10.3431 10.3431 9 12 9C13.6569 9 15 10.3431 15 12Z"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                    <path d="M1 1L23 23" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" />
                                </svg>
                            </button>
                        </div>
                        @if ($errors->has('password'))
                        <span class="error-message">
                            <i class="error-icon">⚠</i>
                            {{ $errors->first('password') }}
                        </span>
                        @endif
                    </div>

                    <!-- Company Selection Field -->
                    <div class="form-group{{ $errors->has('company_id') ? ' has-error' : '' }}">
                        <label for="company_id" class="form-label">
                            <span class="label-text">Company</span>
                        </label>
                        <div class="input-with-icon">
                            <div class="input-prefix">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                                    <path
                                        d="M19 21V5C19 3.89543 18.1046 3 17 3H7C5.89543 3 5 3.89543 5 5V21M19 21L21 21M19 21H14M5 21L3 21M5 21H10M9 7H15M9 11H15M12 21V17"
                                        stroke="#64748B" stroke-width="2" stroke-linecap="round" />
                                </svg>
                            </div>
                            <select name='company_id' class='form-control company_id select2' required
                                style="color:black;">
                                {!! config('global.CONT')->jCombologin('m_company_t','company_id','company_name',1)!!}
                            </select>
                        </div>
                        @if ($errors->has('company_id'))
                        <span class="error-message">
                            <i class="error-icon">⚠</i>
                            {{ $errors->first('company_id') }}
                        </span>
                        @endif
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="form-options">
                        <div class="remember-me">
                            <label class="checkbox-container">
                                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                <span class="checkmark">
                                    <svg width="12" height="9" viewBox="0 0 12 9" fill="none">
                                        <path d="M1 4.5L4.5 8L11 1" stroke="white" stroke-width="2"
                                            stroke-linecap="round" />
                                    </svg>
                                </span>
                                <span class="checkbox-label">Remember Me</span>
                            </label>
                        </div>
                        <a class="forgot-password" href="{{ route('password.request') }}">
                            Forgot Password?
                        </a>
                    </div>

                    <!-- Login Button -->
                    <div class="form-group">
                        <button type="button" id="preauth" class="login-button">
                            <span class="button-text">Sign In</span>
                            <div class="button-loader">
                                <div class="loader-spinner"></div>
                            </div>
                        </button>
                    </div>

                    <!-- Alternative Login -->
                    <div class="alternative-login">
                        <div class="divider">
                            <span>or continue with</span>
                        </div>
                        <div class="alt-login-buttons">
                            <button type="button" class="alt-login-btn">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                                    <path
                                        d="M22.56 12.25C22.56 11.47 22.49 10.72 22.36 10H12V14.26H17.92C17.66 15.63 16.88 16.79 15.71 17.57V20.34H19.28C21.36 18.42 22.56 15.6 22.56 12.25Z"
                                        fill="#4285F4" />
                                    <path
                                        d="M12 23C14.97 23 17.46 22.02 19.28 20.34L15.71 17.57C14.73 18.23 13.48 18.63 12 18.63C9.14 18.63 6.72 16.7 5.86 14.1H2.18V16.94C3.99 20.53 7.7 23 12 23Z"
                                        fill="#34A853" />
                                    <path
                                        d="M5.86 14.09C5.58 13.29 5.43 12.43 5.43 11.5C5.43 10.57 5.58 9.71 5.86 8.91V6.07H2.18C1.27 7.85 0.77 9.85 0.77 11.5C0.77 13.15 1.27 15.15 2.18 16.93L5.86 14.09Z"
                                        fill="#FBBC05" />
                                    <path
                                        d="M12 4.38C13.62 4.38 15.06 4.94 16.21 5.97L19.36 2.82C17.45 1.09 14.97 0 12 0C7.7 0 3.99 2.47 2.18 6.07L5.86 8.91C6.72 6.31 9.14 4.38 12 4.38Z"
                                        fill="#EA4335" />
                                </svg>
                                Google
                            </button>
                            <button type="button" class="alt-login-btn">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                                    <path
                                        d="M12 0C5.37 0 0 5.37 0 12C0 18.63 5.37 24 12 24C18.63 24 24 18.63 24 12C24 5.37 18.63 0 12 0ZM12 4.8C13.99 4.8 15.6 6.41 15.6 8.4C15.6 10.39 13.99 12 12 12C10.01 12 8.4 10.39 8.4 8.4C8.4 6.41 10.01 4.8 12 4.8ZM12 21.6C9.6 21.6 7.37 20.88 5.55 19.57C5.55 17.49 9.3 16.2 12 16.2C14.7 16.2 18.45 17.49 18.45 19.57C16.63 20.88 14.4 21.6 12 21.6Z"
                                        fill="#1877F2" />
                                </svg>
                                Microsoft
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Footer -->
                <div class="login-footer">
                    <div class="tech-partner">
                        <span class="partner-text">Technology Partner</span>
                        <div class="partner-logo">
                            <img src="{{ asset('images/logo.png') }}" alt="iTech Logo">
                        </div>
                        <span class="partner-name">iTechnology Pvt Ltd</span>
                    </div>
                    <div class="copyright">
                        © {{ date('Y') }} All rights reserved. <span class="version">v2.1.0</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Reset and Base Styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

html,
body {
    height: 100%;
    overflow: hidden;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
}

/* Main Layout Styles */
.login-container {
    height: 100vh;
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #334155 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow: hidden;
}

.login-container::before {
    content: '';
    position: absolute;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle at 30% 30%, rgba(59, 130, 246, 0.1) 0%, transparent 50%),
        radial-gradient(circle at 70% 70%, rgba(139, 92, 246, 0.1) 0%, transparent 50%);
    animation: float 20s ease-in-out infinite;
}

@keyframes float {

    0%,
    100% {
        transform: translate(0, 0) rotate(0deg);
    }

    33% {
        transform: translate(-50px, 50px) rotate(120deg);
    }

    66% {
        transform: translate(50px, -50px) rotate(240deg);
    }
}

.login-wrapper {
    width: 95vw;
    height: 95vh;
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(10px);
    border-radius: 24px;
    display: flex;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3),
        inset 0 1px 0 rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

/* Left Section */
.login-left-section {
    flex: 1.2;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
}

.video-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(30, 58, 138, 0.9) 0%, rgba(30, 64, 175, 0.85) 100%);
    z-index: 1;
}

.login-video-bg {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    z-index: 0;
    opacity: 0.6;
    filter: brightness(0.8) contrast(1.2);
}

.login-left-content {
    position: relative;
    z-index: 2;
    color: white;
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 40px;
}

.company-branding {
    animation: slideInDown 0.8s ease-out;
}

.branding-wrapper {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 12px;
}

.brand-logo {
    width: 80px;
    height: 80px;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 12px;
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.brand-logo img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}

.company-branding h1 {
    font-size: 2rem;
    font-weight: 700;
    background: linear-gradient(45deg, #ffffff, #93c5fd);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    text-shadow: 0 2px 20px rgba(147, 197, 253, 0.3);
}

.company-branding h2 {
    font-size: 1.1rem;
    font-weight: 400;
    opacity: 0.9;
    color: #dbeafe;
    letter-spacing: 1px;
}

.welcome-section {
    animation: slideInUp 0.8s ease-out 0.2s both;
}

.welcome-content {
    text-align: center;
}

.welcome-text {
    font-size: 3.5rem;
    font-weight: 800;
    margin-bottom: 16px;
    background: linear-gradient(45deg, #ffffff, #60a5fa);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    text-shadow: 0 4px 30px rgba(96, 165, 250, 0.4);
    line-height: 1.1;
    position: relative;
    display: inline-block;
}

.welcome-text::after {
    content: '';
    position: absolute;
    bottom: -8px;
    left: 25%;
    width: 50%;
    height: 3px;
    background: linear-gradient(90deg, transparent, #60a5fa, transparent);
    border-radius: 2px;
}

.welcome-subtitle {
    font-size: 1.1rem;
    opacity: 0.9;
    margin-bottom: 32px;
    line-height: 1.6;
    max-width: 400px;
    color: #dbeafe;
    font-weight: 300;
}

.feature-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
    max-width: 300px;
    margin: 0 auto;
}

.feature-item {
    display: flex;
    align-items: center;
    font-size: 1rem;
    background: rgba(255, 255, 255, 0.1);
    padding: 14px 20px;
    border-radius: 12px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    transition: all 0.3s ease;
    animation: fadeIn 0.5s ease-out forwards;
    opacity: 0;
}

.feature-item:nth-child(1) {
    animation-delay: 0.3s;
}

.feature-item:nth-child(2) {
    animation-delay: 0.4s;
}

.feature-item:nth-child(3) {
    animation-delay: 0.5s;
}

.feature-item:hover {
    background: rgba(255, 255, 255, 0.15);
    transform: translateX(5px);
    border-color: rgba(255, 255, 255, 0.2);
}

.feature-icon {
    width: 24px;
    height: 24px;
    background: linear-gradient(135deg, #60a5fa, #3b82f6);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 12px;
    font-weight: bold;
    font-size: 0.9rem;
    color: white;
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
}

.security-badge {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    padding: 16px;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 16px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    animation: slideInUp 0.8s ease-out 0.4s both;
}

.badge-icon {
    font-size: 1.5rem;
    animation: pulse 2s infinite;
}

.badge-text {
    font-size: 0.9rem;
    font-weight: 500;
    color: #dbeafe;
}

/* Right Section */
.login-right-section {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #ffffff;
    position: relative;
    overflow: hidden;
}

.floating-shapes {
    position: absolute;
    width: 100%;
    height: 100%;
    pointer-events: none;
}

.shape {
    position: absolute;
    border-radius: 50%;
    background: linear-gradient(135deg, #3b82f6, #8b5cf6);
    opacity: 0.1;
    animation: floatShape 20s infinite linear;
}

.shape-1 {
    width: 300px;
    height: 300px;
    top: -150px;
    right: -150px;
    animation-delay: 0s;
}

.shape-2 {
    width: 200px;
    height: 200px;
    bottom: -100px;
    left: -100px;
    animation-delay: -5s;
    background: linear-gradient(135deg, #10b981, #3b82f6);
}

.shape-3 {
    width: 150px;
    height: 150px;
    top: 50%;
    right: 30%;
    animation-delay: -10s;
    background: linear-gradient(135deg, #f59e0b, #ef4444);
}

@keyframes floatShape {

    0%,
    100% {
        transform: translate(0, 0) rotate(0deg);
    }

    33% {
        transform: translate(30px, 50px) rotate(120deg);
    }

    66% {
        transform: translate(-20px, -30px) rotate(240deg);
    }
}

.login-form-container {
    width: 100%;
    max-width: 420px;
    padding: 40px;
    position: relative;
    z-index: 1;
}

.form-header {
    text-align: center;
    margin-bottom: 40px;
    animation: fadeIn 0.6s ease-out;
}

.header-icon {
    width: 56px;
    height: 56px;
    background: linear-gradient(135deg, #3b82f6, #1d4ed8);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    box-shadow: 0 8px 24px rgba(59, 130, 246, 0.3);
}

.form-title {
    font-size: 1.8rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 8px;
}

.form-subtitle {
    font-size: 0.95rem;
    color: #64748b;
    font-weight: 400;
}

/* Form Styles */
.login-form {
    animation: slideInUp 0.6s ease-out 0.2s both;
}

.form-group {
    margin-bottom: 24px;
}

.form-label {
    display: block;
    margin-bottom: 8px;
}

.label-text {
    font-size: 0.9rem;
    font-weight: 600;
    color: #475569;
    display: flex;
    align-items: center;
    gap: 6px;
}

.input-with-icon {
    position: relative;
    transition: all 0.3s ease;
}

.input-with-icon:focus-within {
    transform: translateY(-2px);
}

.input-prefix {
    position: absolute;
    left: 16px;
    top: 50%;
    transform: translateY(-50%);
    color: #64748b;
    pointer-events: none;
    z-index: 1;
}

.form-control {
    width: 100%;
    padding: 16px 16px 16px 48px;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    font-size: 0.95rem;
    color: #1e293b;
    background: white;
    transition: all 0.3s ease;
    font-weight: 500;
}

.form-control:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
    background: #f8fafc;
}

.form-control::placeholder {
    color: #94a3b8;
    font-weight: 400;
}

.password-toggle {
    position: absolute;
    right: 16px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    cursor: pointer;
    color: #64748b;
    padding: 8px;
    border-radius: 8px;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.password-toggle:hover {
    background: #f1f5f9;
    color: #3b82f6;
}

.eye-icon,
.eye-off-icon {
    width: 20px;
    height: 20px;
}

/* Select2 Customization */
.select2-container--default .select2-selection--single {
    height: 52px !important;
    border: 2px solid #e2e8f0 !important;
    border-radius: 12px !important;
    background: white !important;
    transition: all 0.3s ease !important;
}

.select2-container--default .select2-selection--single:focus-within {
    border-color: #3b82f6 !important;
    box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1) !important;
}

.select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #1e293b !important;
    line-height: 52px !important;
    padding-left: 48px !important;
    font-weight: 500 !important;
}

.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 52px !important;
    right: 16px !important;
}

.select2-container--default .select2-selection--single .select2-selection__arrow b {
    border-color: #64748b transparent transparent transparent !important;
}

.select2-dropdown {
    border: 2px solid #e2e8f0 !important;
    border-radius: 12px !important;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1) !important;
    margin-top: 4px !important;
}

.select2-results__option {
    padding: 12px 16px !important;
    color: #1e293b !important;
    font-weight: 500 !important;
    transition: all 0.2s ease !important;
}

.select2-container--default .select2-results__option--highlighted[aria-selected] {
    background: linear-gradient(135deg, #3b82f6, #1d4ed8) !important;
    color: white !important;
}

.select2-container--default .select2-results__option[aria-selected=true] {
    background: #f1f5f9 !important;
    color: #1e293b !important;
}

/* Form Options */
.form-options {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 32px;
}

.checkbox-container {
    display: flex;
    align-items: center;
    cursor: pointer;
    user-select: none;
    position: relative;
}

.checkbox-container input {
    display: none;
}

.checkmark {
    width: 20px;
    height: 20px;
    border: 2px solid #cbd5e1;
    border-radius: 6px;
    margin-right: 10px;
    position: relative;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.checkbox-container input:checked+.checkmark {
    background: linear-gradient(135deg, #3b82f6, #1d4ed8);
    border-color: transparent;
}

.checkbox-container input:checked+.checkmark svg {
    opacity: 1;
}

.checkbox-label {
    color: #475569;
    font-size: 0.9rem;
    font-weight: 500;
}

.forgot-password {
    color: #3b82f6;
    text-decoration: none;
    font-size: 0.9rem;
    font-weight: 600;
    transition: all 0.3s ease;
    position: relative;
    padding: 4px 8px;
    border-radius: 6px;
}

.forgot-password:hover {
    color: #1d4ed8;
    background: #f1f5f9;
    text-decoration: none;
}

.forgot-password::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 8px;
    right: 8px;
    height: 2px;
    background: linear-gradient(90deg, #3b82f6, transparent);
    transform: scaleX(0);
    transition: transform 0.3s ease;
}

.forgot-password:hover::after {
    transform: scaleX(1);
}

/* Login Button */
.login-button {
    width: 100%;
    padding: 18px;
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    color: white;
    border: none;
    border-radius: 12px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    box-shadow: 0 8px 24px rgba(59, 130, 246, 0.3);
}

.login-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 32px rgba(59, 130, 246, 0.4);
    background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
}

.login-button:active {
    transform: translateY(0);
}

.login-button::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: 0.5s;
}

.login-button:hover::before {
    left: 100%;
}

.button-loader {
    display: none;
}

.loader-spinner {
    width: 20px;
    height: 20px;
    border: 3px solid rgba(255, 255, 255, 0.3);
    border-top-color: white;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

.login-button.loading .button-text {
    opacity: 0;
}

.login-button.loading .button-loader {
    display: block;
}

/* Alternative Login */
.alternative-login {
    margin-top: 32px;
    animation: fadeIn 0.6s ease-out 0.4s both;
}

.divider {
    display: flex;
    align-items: center;
    text-align: center;
    margin: 24px 0;
    color: #64748b;
    font-size: 0.85rem;
    font-weight: 500;
}

.divider::before,
.divider::after {
    content: '';
    flex: 1;
    border-bottom: 1px solid #e2e8f0;
}

.divider span {
    padding: 0 16px;
}

.alt-login-buttons {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
}

.alt-login-btn {
    padding: 14px;
    background: white;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    font-size: 0.9rem;
    font-weight: 600;
    color: #475569;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}

.alt-login-btn:hover {
    background: #f8fafc;
    border-color: #cbd5e1;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
}

/* Footer */
.login-footer {
    margin-top: 40px;
    text-align: center;
    animation: fadeIn 0.6s ease-out 0.6s both;
}

.tech-partner {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    margin-bottom: 16px;
    padding: 16px;
    background: #f8fafc;
    border-radius: 16px;
}

.partner-text {
    font-size: 0.85rem;
    color: #64748b;
    font-weight: 500;
}

.partner-logo {
    width: 32px;
    height: 32px;
    background: white;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 6px;
    border: 1px solid #e2e8f0;
}

.partner-logo img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}

.partner-name {
    font-size: 0.9rem;
    font-weight: 600;
    color: #475569;
}

.copyright {
    font-size: 0.8rem;
    color: #94a3b8;
    font-weight: 400;
}

.version {
    background: #f1f5f9;
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 0.75rem;
    color: #64748b;
    margin-left: 8px;
}

/* Error Message */
.error-message {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #dc2626;
    font-size: 0.85rem;
    margin-top: 8px;
    padding: 12px;
    background: #fef2f2;
    border-radius: 8px;
    border: 1px solid #fecaca;
    animation: shake 0.5s ease;
}

.error-icon {
    font-size: 1rem;
}

/* Animations */
@keyframes fadeIn {
    from {
        opacity: 0;
    }

    to {
        opacity: 1;
    }
}

@keyframes slideInDown {
    from {
        opacity: 0;
        transform: translateY(-30px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes pulse {

    0%,
    100% {
        opacity: 1;
    }

    50% {
        opacity: 0.7;
    }
}

@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}

@keyframes shake {

    0%,
    100% {
        transform: translateX(0);
    }

    25% {
        transform: translateX(-5px);
    }

    75% {
        transform: translateX(5px);
    }
}

/* Responsive Design */
@media (max-width: 1024px) {
    .login-wrapper {
        flex-direction: column;
        width: 100vw;
        height: 100vh;
        border-radius: 0;
    }

    .login-left-section {
        flex: 0.6;
        padding: 20px;
    }

    .login-right-section {
        flex: 0.4;
        min-height: 400px;
    }

    .welcome-text {
        font-size: 2.5rem;
    }

    .login-form-container {
        padding: 30px;
        max-width: 90%;
    }
}

@media (max-width: 768px) {
    .login-left-content {
        padding: 24px;
    }

    .welcome-text {
        font-size: 2rem;
    }

    .company-branding h1 {
        font-size: 1.6rem;
    }

    .feature-list {
        gap: 8px;
    }

    .feature-item {
        padding: 12px 16px;
        font-size: 0.9rem;
    }

    .login-form-container {
        padding: 24px;
    }

    .form-header {
        margin-bottom: 30px;
    }

    .form-title {
        font-size: 1.5rem;
    }

    .alt-login-buttons {
        grid-template-columns: 1fr;
    }

    .tech-partner {
        flex-direction: column;
        gap: 8px;
        padding: 12px;
    }
}

/* Dark Mode Support */
@media (prefers-color-scheme: dark) {
    .login-right-section {
        background: #0f172a;
    }

    .form-title {
        color: #f1f5f9;
    }

    .form-subtitle {
        color: #94a3b8;
    }

    .form-control {
        background: #1e293b;
        border-color: #334155;
        color: #f1f5f9;
    }

    .form-control:focus {
        background: #1e293b;
        border-color: #3b82f6;
    }

    .form-control::placeholder {
        color: #64748b;
    }

    .checkbox-label {
        color: #cbd5e1;
    }

    .forgot-password:hover {
        background: #1e293b;
    }

    .alt-login-btn {
        background: #1e293b;
        border-color: #334155;
        color: #cbd5e1;
    }

    .alt-login-btn:hover {
        background: #334155;
        border-color: #475569;
    }

    .tech-partner {
        background: #1e293b;
    }

    .partner-name {
        color: #cbd5e1;
    }

    .copyright {
        color: #64748b;
    }

    .version {
        background: #334155;
        color: #94a3b8;
    }
}
</style>

<script>
(function() {
    // Initialize company dropdown
    $(".company_id").jCombologin(
        "{{ URL::to('jcomboform?table=m_company_t:company_id:company_name')}}&order_by=company_name asc", {
            selected_value: ""
        }
    );
});

$(document).ready(function() {
    // Enhanced password toggle with SVG icons
    window.togglePassword = function() {
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.querySelector('.eye-icon');
        const eyeOffIcon = document.querySelector('.eye-off-icon');
        const toggleButton = document.querySelector('.password-toggle');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.style.display = 'none';
            eyeOffIcon.style.display = 'block';
            toggleButton.style.color = '#3b82f6';
        } else {
            passwordInput.type = 'password';
            eyeIcon.style.display = 'block';
            eyeOffIcon.style.display = 'none';
            toggleButton.style.color = '#64748b';
        }
    };

    // Enhanced preauth functionality with better UX
    $("#preauth").click(function() {
        const button = $(this);
        const originalText = button.find('.button-text').text();

        // Add loading state
        button.addClass('loading').prop('disabled', true);

        // Add ripple effect
        const ripple = document.createElement('span');
        ripple.classList.add('ripple');
        button.append(ripple);

        // Remove ripple after animation
        setTimeout(() => ripple.remove(), 600);

        $.post("preauth1", {
                password: $("#password").val()
            }, function(data) {
                $("#password").val(data);

                // Add success animation
                button.css({
                    'background': 'linear-gradient(135deg, #10b981 0%, #059669 100%)',
                    'box-shadow': '0 12px 32px rgba(16, 185, 129, 0.4)'
                });

                // Submit form after success animation
                setTimeout(function() {
                    $("form").submit();
                }, 500);
            })
            .fail(function(xhr) {
                // Reset button state
                button.removeClass('loading').prop('disabled', false);

                // Add error animation
                button.css({
                    'background': 'linear-gradient(135deg, #ef4444 0%, #dc2626 100%)',
                    'box-shadow': '0 12px 32px rgba(239, 68, 68, 0.4)'
                });

                // Reset to original style after delay
                setTimeout(() => {
                    button.css({
                        'background': 'linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%)',
                        'box-shadow': '0 8px 24px rgba(59, 130, 246, 0.3)'
                    });
                }, 1500);
            });
    });

    // Enhanced form field animations
    $('.form-control').on('focus', function() {
        $(this).closest('.form-group').find('.input-with-icon').css({
            'transform': 'translateY(-2px)',
            'box-shadow': '0 8px 24px rgba(0, 0, 0, 0.1)'
        });
    }).on('blur', function() {
        $(this).closest('.form-group').find('.input-with-icon').css({
            'transform': 'translateY(0)',
            'box-shadow': 'none'
        });
    });

    // Enter key navigation
    $('.form-control').on('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            const formGroups = $('.form-group');
            const currentIndex = formGroups.index($(this).closest('.form-group'));

            if (currentIndex < formGroups.length - 1) {
                formGroups.eq(currentIndex + 1).find('.form-control').focus();
            } else {
                $('#preauth').click();
            }
        }
    });

    // Initialize with animation
    setTimeout(() => {
        if (!$('#employee_number').val()) {
            $('#employee_number').focus();
        }
    }, 800);

    // Fix video autoplay
    const video = document.querySelector('.login-video-bg');
    if (video) {
        video.play().catch(e => {
            // Fallback for autoplay restrictions
            video.muted = true;
            video.play();
        });
    }

    // Add hover effects for form groups
    $('.form-group').hover(
        function() {
            $(this).find('.form-label .label-text').css('color', '#3b82f6');
        },
        function() {
            $(this).find('.form-label .label-text').css('color', '#475569');
        }
    );

    // Prevent scroll on body
    $('body').css('overflow', 'hidden');

    // Add some interactive elements
    $('.feature-item').each(function(index) {
        $(this).css('animation-delay', (index * 0.1) + 's');
    });

    // Smooth animations on load
    $('.login-form-container').addClass('loaded');
});

// Add CSS for ripple effect
const style = document.createElement('style');
style.textContent = `
    .ripple {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.4);
        transform: scale(0);
        animation: ripple 0.6s linear;
    }
    
    @keyframes ripple {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }
    
    .login-form-container.loaded * {
        animation-play-state: running !important;
    }
`;
document.head.appendChild(style);
</script>
@endsection