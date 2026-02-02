@extends('layouts_login.app')
@section('content')
<div class="landing-container">
    <!-- Full Screen Video Background -->
    <video autoplay muted loop playsinline class="landing-video-bg">
        <source src="{{asset('video/homepage_video.webm')}}" type="video/webm">
        <source src="{{asset('video/homepage_video.mp4')}}" type="video/mp4">
        Your browser does not support the video tag.
    </video>
    <div class="video-overlay"></div>

    <!-- Top Navigation -->
    <div class="top-nav">
        <div class="nav-logo">
            <img src="{{asset('images/l&tlogo.png')}}" alt="L&T Logo" class="nav-logo-img">
        </div>
        <div class="nav-links">
            <a href="#" class="nav-link">About Us</a>
            <button type="button" class="nav-login-btn" id="openLoginModal">Login</button>
        </div>
    </div>



    <!-- Login Modal (Hidden Initially) -->
    <div class="login-modal" id="loginModal">
        <div class="modal-content">
            <span class="close-btn" id="closeLoginModal">&times;</span>
            <div class="modal-logo text-center">
                <img src="{{asset('images/l&tlogo.png')}}" style="height:80px;">
            </div>
            <h2 class="modal-title text-center">Sign In</h2>

            <form class="login-form" id="login_form" method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}

                <!-- Employee Number Field -->
                <div class="form-group{{ $errors->has('employee_number') ? ' has-error' : '' }}">
                    <label for="employee_number" class="form-label">Employee Number</label>
                    <div class="input-with-icon">
                        <input id="employee_number" type="text" autocomplete='off' class="form-control"
                            name="employee_number" value="{{ old('employee_number') }}" required autofocus
                            placeholder="Enter your employee number">
                        <div class="input-icon">
                            <img src="{{ asset('images/doctor.png') }}" alt="Employee Icon">
                        </div>
                    </div>
                    @if ($errors->has('employee_number'))
                    <span class="error-message"><i class="error-icon">⚠</i>
                        {{ $errors->first('employee_number') }}</span>
                    @endif
                </div>

                <!-- Password Field -->
                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-with-icon">
                        <input id="password" type="password" autocomplete='off'
                            onfocus="this.removeAttribute('readonly');" class="form-control" name="password" required
                            placeholder="Enter your password">
                        <div class="input-icon">
                            <img src="{{ asset('images/key.png') }}" alt="Password Icon">
                        </div>
                        <button type="button" class="password-toggle" onclick="togglePassword()">👁</button>
                    </div>
                    @if ($errors->has('password'))
                    <span class="error-message"><i class="error-icon">⚠</i> {{ $errors->first('password') }}</span>
                    @endif
                </div>

                <!-- Company Selection Field -->
                <div class="form-group{{ $errors->has('company_id') ? ' has-error' : '' }}">
                    <label for="company_id" class="form-label">Company</label>
                    <div class="input-with-icon">
                        <select name='company_id' class='form-control company_id select2' required style="color:black;">
                            {!! config('global.CONT')->jCombologin('m_company_t','company_id','company_name',1)!!}
                        </select>
                        <div class="input-icon">
                            <i class="select-icon">▼</i>
                        </div>
                    </div>
                    @if ($errors->has('company_id'))
                    <span class="error-message"><i class="error-icon">⚠</i> {{ $errors->first('company_id') }}</span>
                    @endif
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="form-options">
                    <div class="remember-me">
                        <label class="checkbox-container">
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                            <span class="checkmark"></span>
                            <span class="checkbox-label">Remember Me</span>
                        </label>
                    </div>
                    <a class="forgot-password" href="{{ route('password.request') }}">Forgot Password?</a>
                </div>

                <!-- Login Button -->
                <div class="form-group">
                    <input type="button" value="Sign In" id="preauth" class="login-button">
                </div>
            </form>

            <!-- Modal Footer -->
            <div class="modal-footer text-center">
                <div class="powered-by">
                    <span>Powered By</span>
                    <span class="tech-name">iTechnology Pvt Ltd</span>
                    <img src="{{ asset('images/logo.png') }}" alt="iTech Logo" class="tech-logo">
                </div>
                <div class="copyright">© {{ date('Y') }} All rights reserved</div>
            </div>
        </div>
    </div>
</div>

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

html,
body {
    height: 100%;
    overflow: hidden;
    font-family: 'Segoe UI', sans-serif;
}

.landing-container {
    position: relative;
    height: 100vh;
    width: 100vw;
}

/* Video Background */
.landing-video-bg {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    z-index: -2;
}

.video-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.2);
    /* Very light for clarity */
    z-index: -1;
}

/* Top Navigation */
.top-nav {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    padding: 20px 40px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    z-index: 10;
}

.nav-logo-img {
    height: 60px;
}

.nav-links {
    display: flex;
    align-items: center;
    gap: 30px;
}

.nav-link {
    color: white;
    font-size: 1.1rem;
    font-weight: 500;
    text-decoration: none;
    transition: opacity 0.3s;
}

.nav-link:hover {
    opacity: 0.8;
}

.nav-login-btn {
    padding: 12px 28px;
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    color: white;
    border: 1px solid rgba(255, 255, 255, 0.3);
    border-radius: 50px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
}

.nav-login-btn:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: translateY(-2px);
}



.hero-title {
    font-size: 3.5rem;
    font-weight: 800;
    margin-bottom: 20px;
}

.hero-subtitle {
    font-size: 1.5rem;
    opacity: 0.9;
}

/* Login Modal */
.login-modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.6);
    backdrop-filter: blur(8px);
    align-items: center;
    justify-content: center;
    z-index: 20;
    opacity: 0;
    transition: opacity 0.4s ease;
}

.login-modal.open {
    display: flex;
    opacity: 1;
}

.modal-content {
    position: relative;
    width: 90%;
    max-width: 480px;
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(20px);
    border-radius: 24px;
    border: 1px solid rgba(255, 255, 255, 0.2);
    padding: 40px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
    color: white;
}

.close-btn {
    position: absolute;
    top: 15px;
    right: 20px;
    font-size: 1.8rem;
    cursor: pointer;
    opacity: 0.7;
}

.close-btn:hover {
    opacity: 1;
}

.modal-title {
    margin: 20px 0 30px;
    font-size: 2rem;
}

/* Form Styles (Same as previous premium look) */
.form-label {
    font-weight: 600;
    margin-bottom: 10px;
}

.input-with-icon {
    position: relative;
}

.form-control {
    width: 100%;
    padding: 16px 50px 16px 20px;
    background: rgba(255, 255, 255, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.3);
    border-radius: 14px;
    color: white;
    font-size: 1rem;
}

.form-control::placeholder {
    color: rgba(255, 255, 255, 0.7);
}

.form-control:focus {
    outline: none;
    background: rgba(255, 255, 255, 0.3);
    border-color: #60a5fa;
}

.input-icon img {
    width: 22px;
    height: 22px;
    opacity: 0.8;
}

.password-toggle {
    right: 50px;
    font-size: 1.3rem;
    color: rgba(255, 255, 255, 0.8);
}

.select2-container--default .select2-selection--single {
    height: 56px !important;
    background: rgba(255, 255, 255, 0.2) !important;
    border: 1px solid rgba(255, 255, 255, 0.3) !important;
    border-radius: 14px !important;
}

.login-button {
    width: 100%;
    padding: 18px;
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    border: none;
    border-radius: 14px;
    color: white;
    font-size: 1.15rem;
    font-weight: 700;
    cursor: pointer;
    box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
}

.login-button:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 35px rgba(59, 130, 246, 0.5);
}

.modal-footer {
    margin-top: 30px;
    font-size: 0.9rem;
    opacity: 0.9;
}

.tech-logo {
    width: 32px;
    height: 28px;
    margin-left: 8px;
}

/* Responsive */
@media (max-width: 768px) {
    .top-nav {
        padding: 15px 20px;
    }

    .hero-title {
        font-size: 2.5rem;
    }

    .modal-content {
        padding: 30px;
    }
}
</style>

<script>
/* Your original script + modal open/close */
(function() {
    $(".company_id").jCombologin(
        "{{ URL::to('jcomboform?table=m_company_t:company_id:company_name')}}&order_by=company_name asc", {
            selected_value: ""
        }
    );
});

$(document).ready(function() {
    // Modal Controls
    const modal = document.getElementById('loginModal');
    const openBtn = document.getElementById('openLoginModal');
    const closeBtn = document.getElementById('closeLoginModal');

    openBtn.onclick = () => modal.classList.add('open');
    closeBtn.onclick = () => modal.classList.remove('open');
    window.onclick = (e) => {
        if (e.target === modal) modal.classList.remove('open');
    };

    // Original Password Toggle
    window.togglePassword = function() {
        const passwordInput = document.getElementById('password');
        const toggleButton = document.querySelector('.password-toggle');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleButton.innerHTML = '👁‍🗨';
        } else {
            passwordInput.type = 'password';
            toggleButton.innerHTML = '👁';
        }
    };

    // Original Preauth
    $("#preauth").click(function() {
        const button = $(this);
        const originalText = button.val();
        button.addClass('loading').val('Authenticating...').prop('disabled', true);
        $.post("preauth1", {
                    password: $("#password").val()
                },
                function(data) {
                    $("#password").val(data);
                    setTimeout(() => $("form").submit(), 300);
                })
            .fail(function() {
                button.removeClass('loading').val(originalText).prop('disabled', false);
            });
    });

    // Original Enter Key Navigation
    $('.form-control').on('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            const nextInput = $(this).closest('.form-group').next().find('.form-control');
            if (nextInput.length) nextInput.focus();
            else $('#preauth').click();
        }
    });

    // Focus First Field
    if (!$('#employee_number').val()) $('#employee_number').focus();

    // Video Play
    const video = document.querySelector('.landing-video-bg');
    if (video) video.play().catch(() => console.log("Video autoplay prevented"));

    $('body').css('overflow', 'hidden');
});
</script>
@endsection