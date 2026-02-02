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

        <!-- Login Modal -->
        <div class="login-modal" id="loginModal">
            <div class="modal-content">
                <span class="close-btn" id="closeLoginModal">&times;</span>

                <!-- Centered Logo -->
                <div class="modal-logo text-center">
                    <img src="{{asset('images/l&tlogo.png')}}" style="height:70px; margin-bottom: 10px;">
                </div>

                <!-- <h2 class="modal-title text-center">Sign In</h2>
                            <br> -->


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
                            <select name='company_id' rows='5' class='form-control company_id select2'
                                data-show-subtext="true" data-live-search="true" required>
                                {!! config('global.CONT')->jCombologin(
        'm_company_t',
        'company_id',
        'company_name',
        1
    )!!}
                            </select>
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

                <!-- Centered Footer -->
                <div class="modal-footer">
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
            overflow: hidden;
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
            background: rgba(0, 0, 0, 0.25);
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
        }

        .nav-login-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
        }

        /* Login Modal - NO SCROLL, FIXED BOTTOM SPACING */
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
            padding: 40px 20px;
            /* Equal top and bottom padding */
            overflow: hidden;
            /* Prevent scroll */
        }

        .login-modal.open {
            display: flex;
            opacity: 1;
        }

        .modal-content {
            position: relative;
            width: 100%;
            max-width: 380px;
            max-height: 90vh;
            /* Limit height */
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 25px 25px 15px;
            /* Reduced bottom padding */
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
            color: white;
            margin: auto;
            overflow-y: auto;
            /* Allow scroll only inside modal if absolutely needed */
            overflow-x: hidden;
        }

        /* Hide scrollbar for Chrome, Safari and Opera */
        .modal-content::-webkit-scrollbar {
            display: none;
        }

        /* Hide scrollbar for IE, Edge and Firefox */
        .modal-content {
            -ms-overflow-style: none;
            /* IE and Edge */
            scrollbar-width: none;
            /* Firefox */
        }

        .close-btn {
            position: absolute;
            top: 12px;
            right: 18px;
            font-size: 1.8rem;
            cursor: pointer;
            opacity: 0.7;
        }

        .close-btn:hover {
            opacity: 1;
        }

        .modal-title {
            margin: 5px 0 20px;
            font-size: 1.6rem;
            font-weight: 700;
            text-align: center;
        }

        /* Form Styles */
        .form-label {
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 0.95rem;
            display: block;
        }

        .input-with-icon {
            position: relative;
            margin-bottom: 15px;
        }

        .form-control {
            width: 100%;
            /* padding: 14px 45px 14px 15px; */
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 10px;
            color: white;
            font-size: 0.95rem;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .form-control:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.3);
            border-color: #60a5fa;
        }

        /* Select2 Dropdown Styling - Global because Select2 appends to body */
        .select2-container--default .select2-selection--single {
            background: rgba(255, 255, 255, 0.2) !important;
            border: 1px solid rgba(255, 255, 255, 0.3) !important;
            border-radius: 10px !important;
            height: 48px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: white !important;
            line-height: 46px !important;
            padding-left: 15px !important;
            font-size: 0.95rem !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__placeholder {
            color: rgba(255, 255, 255, 0.7) !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 46px !important;
            right: 10px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow b {
            border-color: white transparent transparent transparent !important;
        }

        .select2-container--default.select2-container--open .select2-selection--single .select2-selection__arrow b {
            border-color: transparent transparent white transparent !important;
        }

        /* Select2 dropdown list styling */
        .select2-dropdown {
            background-color: #2d3748 !important;
            border: 1px solid rgba(255, 255, 255, 0.3) !important;
            border-radius: 10px !important;
        }

        .select2-container--default .select2-results__option {
            color: white !important;
            padding: 10px 15px !important;
        }

        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #3b82f6 !important;
            color: white !important;
        }

        .select2-container--default .select2-results__option[aria-selected=true] {
            background-color: #1e40af !important;
        }

        .select2-search--dropdown .select2-search__field {
            background: rgba(255, 255, 255, 0.1) !important;
            border: 1px solid rgba(255, 255, 255, 0.3) !important;
            color: white !important;
            border-radius: 5px !important;
        }

        .input-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            display: flex;
            align-items: center;
            justify-content: center;
            width: 22px;
            height: 22px;
        }

        .input-icon img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            opacity: 0.8;
        }

        .select-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
            opacity: 0.8;
            font-size: 0.9rem;
        }

        .password-toggle {
            position: absolute;
            right: 45px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            font-size: 1.2rem;
            color: rgba(255, 255, 255, 0.8);
            cursor: pointer;
            z-index: 2;
        }


        /* Form Options */
        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 15px 0;
            font-size: 0.9rem;
        }

        .remember-me {
            display: flex;
            align-items: center;
        }

        .checkbox-container {
            display: flex;
            align-items: center;
            cursor: pointer;
            position: relative;
            padding-left: 30px;
            user-select: none;
        }

        .checkbox-container input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
            height: 0;
            width: 0;
        }

        .checkmark {
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            height: 20px;
            width: 20px;
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 4px;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .checkbox-container:hover input~.checkmark {
            background-color: rgba(255, 255, 255, 0.3);
        }

        .checkbox-container input:checked~.checkmark {
            background-color: #3b82f6;
        }

        .checkmark:after {
            content: "";
            position: absolute;
            display: none;
        }

        .checkbox-container input:checked~.checkmark:after {
            display: block;
        }

        .checkbox-container .checkmark:after {
            left: 6px;
            top: 2px;
            width: 6px;
            height: 10px;
            border: solid white;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }

        .checkbox-label {
            margin-left: 35px;
            color: white;
        }

        .forgot-password {
            color: #a5b4fc;
            font-weight: 500;
            text-decoration: none;
        }

        .forgot-password:hover {
            color: white;
            text-decoration: underline;
        }

        /* Login Button */
        .login-button {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            border: none;
            border-radius: 10px;
            color: white;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
            margin-top: 10px;
            transition: all 0.3s ease;
        }

        .login-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(59, 130, 246, 0.5);
        }

        .login-button:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }

        /* Form Group */
        .form-group {
            /* margin-bottom: 5px; */
        }

        .error-message {
            font-size: 0.85rem;
            margin-top: 5px;
            display: block;
            color: #ff6b6b;
        }

        .error-icon {
            margin-right: 5px;
        }

        /* Centered Footer */
        .modal-footer {
            margin-top: 15px;
            text-align: center;
            font-size: 0.85rem;
            opacity: 0.9;
            padding-bottom: 5px;
            width: 100%;
        }

        .powered-by {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 5px;
            width: 100%;
        }

        .tech-name {
            font-weight: 600;
            white-space: nowrap;
        }

        .tech-logo {
            width: 32px;
            height: 28px;
            flex-shrink: 0;
        }

        .copyright {
            font-size: 0.75rem;
            opacity: 0.8;
        }

        /* Responsive - NO SCROLL */
        @media (max-width: 768px) {
            .login-modal {
                padding: 30px 15px;
                /* Less padding on mobile but still space */
            }

            .modal-content {
                max-height: 85vh;
                /* Smaller max-height on mobile */
                padding: 20px 20px 15px;
                max-width: 90%;
            }

            .modal-logo img {
                height: 60px !important;
            }

            .modal-title {
                font-size: 1.4rem;
                margin: 5px 0 15px;
            }

            .input-with-icon {
                margin-bottom: 12px;
            }

            .form-options {
                margin: 12px 0;
            }

            .top-nav {
                padding: 15px 20px;
            }

            .nav-logo-img {
                height: 50px;
            }

            .nav-links {
                gap: 15px;
            }

            .nav-link {
                font-size: 1rem;
            }

            .nav-login-btn {
                padding: 10px 20px;
                font-size: 0.9rem;
            }
        }

        @media (max-width: 480px) {
            .login-modal {
                padding: 25px 12px;
                /* Minimal padding */
            }

            .modal-content {
                max-height: 82vh;
                padding: 18px 18px 12px;
            }

            .form-control {
                padding: 12px 40px 12px 12px;
                font-size: 0.9rem;
            }

            .input-icon {
                right: 12px;
            }

            .password-toggle {
                right: 40px;
            }


            .modal-footer {
                margin-top: 10px;
                font-size: 0.8rem;
            }

            .modal-title {
                font-size: 1.3rem;
                margin: 3px 0 12px;
            }
        }

        /* For very small screens */
        @media (max-height: 600px) {
            .login-modal {
                padding: 15px 10px;
                /* Very small padding */
            }

            .modal-content {
                max-height: 95vh;
                /* Use more of the available height */
                padding: 15px 15px 10px;
            }

            .modal-logo img {
                height: 50px !important;
                margin-bottom: 5px !important;
            }

            .modal-title {
                font-size: 1.2rem;
                margin: 0 0 10px;
            }

            .input-with-icon {
                margin-bottom: 8px;
            }

            .form-options {
                margin: 8px 0;
                font-size: 0.8rem;
            }

            .login-button {
                padding: 12px;
                font-size: 0.9rem;
                margin-top: 5px;
            }

            .modal-footer {
                margin-top: 8px;
                font-size: 0.75rem;
            }
        }
    </style>

    <script>
        $(document).ready(function () {
            const modal = document.getElementById('loginModal');
            const openBtn = document.getElementById('openLoginModal');
            const closeBtn = document.getElementById('closeLoginModal');

            // Open modal - PREVENT BODY SCROLL
            openBtn.onclick = () => {
                modal.classList.add('open');
                // Prevent body scroll
                document.body.style.overflow = 'hidden';
                document.documentElement.style.overflow = 'hidden';
                // Focus on employee number field when modal opens
                setTimeout(() => {
                    $('#employee_number').focus();
                }, 300);
            };

            // Close modal - RESTORE BODY SCROLL
            closeBtn.onclick = () => {
                modal.classList.remove('open');
                // Restore body scroll
                document.body.style.overflow = '';
                document.documentElement.style.overflow = '';
            };

            // Close modal when clicking outside
            window.onclick = (e) => {
                if (e.target === modal) {
                    modal.classList.remove('open');
                    // Restore body scroll
                    document.body.style.overflow = '';
                    document.documentElement.style.overflow = '';
                }
            };

            // Toggle password visibility
            window.togglePassword = function () {
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



            // Pre-auth functionality
            $("#preauth").click(function () {
                const button = $(this);
                const originalText = button.val();
                button.addClass('loading').val('Authenticating...').prop('disabled', true);

                $.post("preauth1", {
                    password: $("#password").val()
                }, function (data) {
                    $("#password").val(data);
                    setTimeout(() => {
                        $("form").submit();
                    }, 300);
                })
                    .fail(function () {
                        button.removeClass('loading').val(originalText).prop('disabled', false);
                        alert('Authentication failed. Please try again.');
                    });
            });

            // Enter key navigation
            $('.form-control').on('keydown', function (e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    const nextInput = $(this).closest('.form-group').next().find('.form-control');
                    if (nextInput.length) {
                        nextInput.focus();
                    } else {
                        $('#preauth').click();
                    }
                }
            });

            // Focus on employee number if empty
            if (!$('#employee_number').val()) {
                $('#employee_number').focus();
            }

            // Auto-play video with fallback
            const video = document.querySelector('.landing-video-bg');
            if (video) {
                const playPromise = video.play();
                if (playPromise !== undefined) {
                    playPromise.catch(() => {
                        console.log("Video autoplay prevented");
                    });
                }
            }

            // Prevent body scroll initially
            document.body.style.overflow = 'hidden';
            document.documentElement.style.overflow = 'hidden';
        });
    </script>
@endsection