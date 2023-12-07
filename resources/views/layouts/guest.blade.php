<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Penggajian SDM</title>

    <link rel="icon" href="{{ asset('images/tamanmedia.png') }}" type="image/png">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('css/fontawesome.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('css/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <!-- Custom style -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

</head>

<body class="vh-100">
    <div class="authincation h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <!-- /.login-logo -->
                                <div class="auth-form">
                                    <div class="text-center mb-3">
                                        <a href="/">
                                            <img src="{{ asset('images/tamanmediaindonesia.png') }}" alt=""
                                                width="200" height="60">
                                        </a>
                                    </div>
                                    @yield('content')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.login-box -->

    {{-- @vite('resources/js/app.js') --}}

    <!-- Boostrap App -->
    <script src="{{ asset('vendor/global/global.min.js') }}"></script>
    <!-- Custom Theme script -->
    <script src="{{ asset('js/custom.min.js') }}"></script>
    <!-- Navbar Theme script -->
    <script src="{{ asset('js/dlabnav-init.js') }}"></script>
    <!-- Bootstrap 4 -->
    {{-- <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script> --}}
    <!-- AdminLTE App -->
    {{-- <script src="{{ asset('js/adminlte.min.js') }}" defer></script> --}}

    <script>
        // Select the password and password_confirmation inputs, and the toggle icons
        const passwordInput = document.getElementById('password');
        const passwordConfirmationInput = document.getElementById('password_confirmation');
        const passwordToggle = document.getElementById('password-toggle');

        if (passwordInput && passwordToggle) {
            // Add a click event listener to the toggle icon for password
            passwordToggle.addEventListener('click', function() {
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    passwordToggle.classList.remove('fa-eye');
                    passwordToggle.classList.add('fa-eye-slash');
                } else {
                    passwordInput.type = 'password';
                    passwordToggle.classList.remove('fa-eye-slash');
                    passwordToggle.classList.add('fa-eye');
                }
            });
        }

        if (passwordConfirmationInput) {
            // Add a click event listener to the toggle icon for password_confirmation
            const passwordConfirmationToggle = document.getElementById('password-confirmation-toggle');
            if (passwordConfirmationToggle) {
                passwordConfirmationToggle.addEventListener('click', function() {
                    if (passwordConfirmationInput.type === 'password') {
                        passwordConfirmationInput.type = 'text';
                        passwordConfirmationToggle.classList.remove('fa-eye');
                        passwordConfirmationToggle.classList.add('fa-eye-slash');
                    } else {
                        passwordConfirmationInput.type = 'password';
                        passwordConfirmationToggle.classList.remove('fa-eye-slash');
                        passwordConfirmationToggle.classList.add('fa-eye');
                    }
                });
            }
        }
    </script>
</body>

</html>
