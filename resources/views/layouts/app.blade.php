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
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">

    <!-- Custom style -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    <!-- select  -->
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2-bootstrap4.min.css') }}">

    {{-- Auto Complete --}}

    <!-- Sertakan jQuery -->
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    <script src="{{ asset('js/jquery.min.js') }}"></script>


    <!-- Sertakan jQuery UI -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>



    <!-- Data Tables -->
    <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css" rel="stylesheet" />



    {{-- sweet alert --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">



    {{-- Data tables --}}
    {{-- <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/buttons.bootstrap4.min.css') }}"> --}}



    @yield('styles')
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-dark navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
            </ul>
            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link">
                        <div class="dark-mode-toggle" class="dropdown-item">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="customSwitch1">
                                <span class="toggle-icon toggle-icon-left"><i class="fa fa-sun"></i></span>
                                <label class="custom-control-label" for="customSwitch1"></label>
                                <span class="toggle-icon toggle-icon-center"><i class="fa fa-moon"></i></span>
                            </div>
                        </div>
                    </a>
                </li>



                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
                        {{ Auth::user()->nama }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" style="left: inherit; right: 0px;">
                        <a href="{{ route('admin.profile.show') }}" class="dropdown-item">
                            <i class="mr-2 fas fa-file"></i>
                            {{ __('My profile') }}
                        </a>
                        <div class="dropdown-divider"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}" class="dropdown-item"
                                onclick="event.preventDefault(); confirmLogout();">
                                <i class="mr-2 fas fa-sign-out-alt"></i>
                                {{ __('Log Out') }}
                            </a>
                        </form>
                        <div class="dropdown-divider"></div>

                    </div>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="/" class="brand-link">
                <span class="brand-text font-weight-bold text-center d-block">Penggajian SDM</span>
            </a>

            @include('layouts.navigation')
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper mt-2">
            @if (session()->has('message'))
                <div class="container-header">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="alert alert-{{ session()->get('alert-info') }}">
                                    {{ session()->get('message') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if ($errors->any())
                <div class="container-header">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <ul class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                        <div>{{ $error }}</div>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @yield('content')
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
            <div class="p-3">
                <h5>Title</h5>
                <p>Sidebar content</p>
            </div>
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <!-- To the right -->
            <div class="float-start">
                <p>{{ date('Y') }} &copy; PT. Taman Media Indonesia</p>
            </div>
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- dibawah ini bikin error -->
    {{-- @vite('resources/js/app.js') --}}

    <!-- AdminLTE App -->
    <script src="{{ asset('js/adminlte.min.js') }}" defer></script>

    {{-- sweet alert file --}}
    <script src="{{ asset('js/sweetalert2@11.js') }}"></script>

    {{-- select --}}
    <script src="{{ asset('js/select2.full.min.js') }}"></script>



    <!-- Data Tables -->
    {{-- <script src="https://code.jquery.com/jquery-3.7.0.js"></script> --}}
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

    {{-- Donuts Chart --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>




    {{-- sweet alert --}}
    {{-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}

    <script>
        // Select the password and password_confirmation inputs, and the toggle icons
        const passwordInput = document.getElementById('password');
        const passwordConfirmationInput = document.getElementById('password_confirmation');
        const passwordToggle = document.getElementById('password-toggle');

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

        // Add a click event listener to the toggle icon for password_confirmation
        const passwordConfirmationToggle = document.getElementById('password-confirmation-toggle');
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
    </script>

    <!-- Inisialisasi Select2 -->
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap4'
            });
        });
    </script>


    {{-- sweet alert confirm Logout --}}

    <script>
        function confirmLogout() {
            Swal.fire({
                title: 'Konfirmasi Logout',
                text: 'Anda yakin ingin keluar?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Logout',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika pengguna menekan "Ya, Logout", maka formulir akan di-submit
                    document.querySelector('form').submit();
                }
            });
        }
    </script>

    {{-- sweet alert in users input required --}}

    <script>
        function validateForm() {
            // Implementasikan validasi JavaScript sesuai kebutuhan Anda
            // Contoh: Periksa semua bidang yang diperlukan
            // Pemeriksaan tambahan untuk nama dengan ID tertentu
            const namaField = document.getElementById('nama');
            if (namaField.value.trim() === '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Nama Wajib Diisi',
                    text: 'Nama tidak boleh kosong!',
                });
                return false; // Menghentikan pengiriman formulir jika tidak valid
            }
            // Pemeriksaan tambahan untuk select dengan ID 'entitas'
            const entitasSelect = document.getElementById('entitas');
            const selectedOption = entitasSelect.options[entitasSelect.selectedIndex];
            if (selectedOption.value === '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Pilih Entitas',
                    text: 'Anda harus memilih entitas!',
                });
                return false; // Menghentikan pengiriman formulir jika tidak valid
            }
            // Pemeriksaan tambahan untuk select dengan ID 'jabatan'
            const jabatanSelect = document.getElementById('jabatan');
            const selectedJabatan = jabatanSelect.options[jabatanSelect.selectedIndex];
            if (selectedJabatan.value === '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Pilih Jabatan',
                    text: 'Anda harus memilih jabatan!',
                });
                return false; // Menghentikan pengiriman formulir jika tidak valid
            }
            // Pemeriksaan tambahan untuk email dengan ID 'email'
            const emailField = document.getElementById('email');
            const emailValue = emailField.value.trim();
            if (emailValue === '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Email Wajib Diisi',
                    text: 'Email tidak boleh kosong!',
                });
                return false; // Menghentikan pengiriman formulir jika email kosong
            } else if (!isValidEmail(emailValue)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Format Email Tidak Valid',
                    text: 'Masukkan email yang valid!',
                });
                return false; // Menghentikan pengiriman formulir jika email tidak valid
            }
            const nikField = document.getElementById('nik');
            if (nikField.value.trim() === '') {
                Swal.fire({
                    icon: 'error',
                    title: 'NIK Wajib Diisi',
                    text: 'NIK tidak boleh kosong!',
                });
                return false; // Menghentikan pengiriman formulir jika tidak valid
            }
            const requiredFields = document.querySelectorAll('[required]');
            for (const field of requiredFields) {
                if (field.value.trim() === '') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Semua Inputan Wajib Diisi',
                        text: 'Harap isi semua inputan yang diperlukan.',
                    });
                    return false; // Menghentikan pengiriman formulir jika tidak valid
                }
            }
            return true; // Kirim formulir jika valid
        }

        function isValidEmail(email) {
            // Implementasikan pemeriksaan format email sesuai kebutuhan Anda
            // Contoh sederhana: menggunakan ekspresi reguler
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }
    </script>

    <script>
        function validateFormAdmin() {
            // Implementasikan validasi JavaScript sesuai kebutuhan Anda
            // Contoh: Periksa semua bidang yang diperlukan
            // Pemeriksaan tambahan untuk nama dengan ID tertentu
            const namaField = document.getElementById('nama');
            if (namaField.value.trim() === '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Nama Wajib Diisi',
                    text: 'Nama tidak boleh kosong!',
                });
                return false; // Menghentikan pengiriman formulir jika tidak valid
            }
            // Pemeriksaan tambahan untuk email dengan ID 'email'
            const emailField = document.getElementById('email');
            const emailValue = emailField.value.trim();
            if (emailValue === '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Email Wajib Diisi',
                    text: 'Email tidak boleh kosong!',
                });
                return false; // Menghentikan pengiriman formulir jika email kosong
            } else if (!isValidEmail(emailValue)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Format Email Tidak Valid',
                    text: 'Masukkan email yang valid!',
                });
                return false; // Menghentikan pengiriman formulir jika email tidak valid
            }
            // Pemeriksaan tambahan untuk password dengan ID tertentu
            const passwordField = document.getElementById('password');
            if (passwordField.value.trim() === '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Password Wajib Diisi',
                    text: 'Password tidak boleh kosong!',
                });
                return false; // Menghentikan pengiriman formulir jika tidak valid
            }
            // Pemeriksaan tambahan untuk konfirmasi password dengan ID tertentu
            const passwordConfirmationField = document.getElementById('password_confirmation');
            if (passwordConfirmationField.value.trim() === '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Konfirmasi Password Wajib Diisi',
                    text: 'Konfirmasi Password tidak boleh kosong!',
                });
                return false; // Menghentikan pengiriman formulir jika tidak valid
            }
            // Pemeriksaan apakah password dan konfirmasi password sama
            if (passwordField.value !== passwordConfirmationField.value) {
                Swal.fire({
                    icon: 'error',
                    title: 'Password Tidak Sama',
                    text: 'Password dan Konfirmasi Password harus cocok!',
                });
                return false; // Menghentikan pengiriman formulir jika tidak valid
            }
            return true; // Kirim formulir jika valid
        }

        function isValidEmail(email) {
            // Implementasikan pemeriksaan format email sesuai kebutuhan Anda
            // Contoh sederhana: menggunakan ekspresi reguler
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }
    </script>

    <script>
        function validateFormAdminEdit() {
            // Implementasikan validasi JavaScript sesuai kebutuhan Anda
            // Contoh: Periksa semua bidang yang diperlukan
            // Pemeriksaan tambahan untuk nama dengan ID tertentu
            const namaField = document.getElementById('nama');
            if (namaField.value.trim() === '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Nama Wajib Diisi',
                    text: 'Nama tidak boleh kosong!',
                });
                return false; // Menghentikan pengiriman formulir jika tidak valid
            }
            // Pemeriksaan tambahan untuk email dengan ID 'email'
            const emailField = document.getElementById('email');
            const emailValue = emailField.value.trim();
            if (emailValue === '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Email Wajib Diisi',
                    text: 'Email tidak boleh kosong!',
                });
                return false; // Menghentikan pengiriman formulir jika email kosong
            } else if (!isValidEmail(emailValue)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Format Email Tidak Valid',
                    text: 'Masukkan email yang valid!',
                });
                return false; // Menghentikan pengiriman formulir jika email tidak valid
            }
            // Pemeriksaan untuk password dan konfirmasi password hanya jika password diisi
            const passwordField = document.getElementById('password');
            const passwordConfirmationField = document.getElementById('password_confirmation');

            if (passwordField.value.trim() !== '' || passwordConfirmationField.value.trim() !== '') {
                if (passwordField.value !== passwordConfirmationField.value) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Password Tidak Sama',
                        text: 'Password Baru dan Konfirmasi Password Baru harus cocok!',
                    });
                    return false; // Menghentikan pengiriman formulir jika tidak valid
                }
            }
            return true; // Kirim formulir jika valid
        }

        function isValidEmail(email) {
            // Implementasikan pemeriksaan format email sesuai kebutuhan Anda
            // Contoh sederhana: menggunakan ekspresi reguler
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }
    </script>

    <script>
        function validateFormAdminProfile() {
            // Implementasikan validasi JavaScript sesuai kebutuhan Anda
            // Contoh: Periksa semua bidang yang diperlukan
            // Pemeriksaan tambahan untuk nama dengan ID tertentu
            const namaField = document.getElementById('nama');
            if (namaField.value.trim() === '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Nama Wajib Diisi',
                    text: 'Nama tidak boleh kosong!',
                });
                return false; // Menghentikan pengiriman formulir jika tidak valid
            }
            // Pemeriksaan tambahan untuk email dengan ID 'email'
            const emailField = document.getElementById('email');
            const emailValue = emailField.value.trim();
            if (emailValue === '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Email Wajib Diisi',
                    text: 'Email tidak boleh kosong!',
                });
                return false; // Menghentikan pengiriman formulir jika email kosong
            } else if (!isValidEmail(emailValue)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Format Email Tidak Valid',
                    text: 'Masukkan email yang valid!',
                });
                return false; // Menghentikan pengiriman formulir jika email tidak valid
            }
            // Pemeriksaan untuk password dan konfirmasi password hanya jika password diisi
            const passwordField = document.getElementById('password');
            const passwordConfirmationField = document.getElementById('password_confirmation');

            if (passwordField.value.trim() !== '' || passwordConfirmationField.value.trim() !== '') {
                if (passwordField.value !== passwordConfirmationField.value) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Password Tidak Sama',
                        text: 'Password Baru dan Konfirmasi Password Baru harus cocok!',
                    });
                    return false; // Menghentikan pengiriman formulir jika tidak valid
                }
            }
            return true; // Kirim formulir jika valid
        }

        function isValidEmail(email) {
            // Implementasikan pemeriksaan format email sesuai kebutuhan Anda
            // Contoh sederhana: menggunakan ekspresi reguler
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }
    </script>

    {{-- sweet alert in entitas input required --}}

    <script>
        function validateFormEntitas() {
            const entitasInputField = document.getElementById('entitas-input');
            if (entitasInputField.value.trim() === '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Nama Entitas Wajib Diisi',
                    text: 'Nama Entitas tidak boleh kosong!',
                });
                return false; // Menghentikan pengiriman formulir jika tidak valid
            }
            return true; // Kirim formulir jika valid
        }
    </script>

    {{-- sweet alert in jabatan input required --}}

    <script>
        function validateFormJabatan() {
            const jabatanInputField = document.getElementById('nama-jabatan');
            if (jabatanInputField.value.trim() === '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Nama Jabatan Wajib Diisi',
                    text: 'Nama Jabatan tidak boleh kosong!',
                });
                return false; // Menghentikan pengiriman formulir jika tidak valid
            }
            const jabatanNilaiField = document.getElementById('nilai-jabatan');
            if (jabatanNilaiField.value.trim() === '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Tunjangan Jabatan Wajib Diisi',
                    text: 'Tunjangan Jabatan tidak boleh kosong!',
                });
                return false; // Menghentikan pengiriman formulir jika tidak valid
            }
            return true; // Kirim formulir jika valid
        }
    </script>




    <!-- Script JavaScript untuk mengaktifkan dropdown , but komen vite js-->
    <script>
        $(document).ready(function() {
            $('.nav-item.dropdown').on('click', function() {
                $(this).find('.dropdown-menu').toggleClass('show');
            });

            // Menutup dropdown saat mengklik di luar dropdown
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.nav-item.dropdown').length) {
                    $('.dropdown-menu').removeClass('show');
                }
            });
        });
    </script>


    {{-- Komponen Add Tunjangan --}}

    <script>
        $(document).ready(function() {
            var counter = 0;

            function addTunjanganInput() {
                var newTunjangan = `
                    <div class="tunjangan">
                        <div class="form-group">
                            <label for="nama_tunjangan${counter}">Nama Tunjangan</label>
                            <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Tj.</div>
                                    </div>
                                <input class="form-control autocomplete_txt_tunjangan" type="text" name="nama_tunjangan[]" data-type='namatunjangan' required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nilai_tunjangan${counter}">Nilai Tunjangan</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Rp.</div>
                                </div>
                                <input class="form-control nilai-tunjangan" type="text" name="nilai_tunjangan[]" oninput="addCommas2(this)" required>
                            </div>
                        </div>
                        <button type="button" class="btn btn-outline-danger removeTunjanganAdd mb-3"> <i class="fa fa-trash"></i>  Hapus Tunjangan</button>
                    </div>
                `;
                $("#tunjanganContainer").append(newTunjangan);
                counter++;
            }

            $("#addTunjangan").click(function() {
                addTunjanganInput();
            });

            function calculateTotalTunjangan() {
                var total = 0;
                $(".nilai-tunjangan").each(function() {
                    var nilai = parseFloat($(this).val().replace(/\D/g, ''));
                    if (!isNaN(nilai)) {
                        total += nilai;
                    }
                });

                // Menggunakan metode toLocaleString() untuk memisahkan ribuan dengan titik
                var formattedTotal = total.toLocaleString('id-ID', {
                    style: 'currency',
                    currency: 'IDR'
                });

                $("#totalTunjangan").text("Total Tunjangan: " + formattedTotal);
            }



            $(document).on("input", ".nilai-tunjangan", function() {
                calculateTotalTunjangan();
            });

            $(document).on("click", ".removeTunjanganAdd", function() {
                $(this).closest('.tunjangan')
                    .remove(); // Menghapus elemen yang mengandung elemen yang akan dihapus
                calculateTotalTunjangan(); // Rekalkulasi total
            });
        });
    </script>

    {{-- Komponen Add Potongan --}}

    <script>
        $(document).ready(function() {
            var counter = 0;

            function addPotonganInput() {
                var newPotongan = `
                    <div class="potongan">
                        <div class="form-group">
                            <label for="nama_potongan${counter}">Nama Potongan</label>
                                <input class="form-control autocomplete_txt_potongan" type="text" name="nama_potongan[]" data-type='namapotongan' required>
                        </div>
                        <div class="form-group">
                            <label for="nilai_potongan${counter}">Nilai Potongan</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Rp.</div>
                                </div>
                                <input class="form-control nilai-potongan" type="text" name="nilai_potongan[]" oninput="addCommas2(this)" required>
                            </div>
                        </div>
                        <button type="button" class="btn btn-outline-danger removePotonganAdd mb-3"> <i class="fa fa-trash"></i>  Hapus Potongan</button>
                    </div>
                `;
                $("#potonganContainer").append(newPotongan);
                counter++;
            }

            $("#addPotongan").click(function() {
                addPotonganInput();
            });

            function calculateTotalPotongan() {
                var total = 0;
                $(".nilai-potongan").each(function() {
                    var nilai = parseFloat($(this).val().replace(/\D/g, ''));
                    if (!isNaN(nilai)) {
                        total += nilai;
                    }
                });

                // Menggunakan metode toLocaleString() untuk memisahkan ribuan dengan titik
                var formattedTotal = total.toLocaleString('id-ID', {
                    style: 'currency',
                    currency: 'IDR'
                });

                $("#totalPotongan").text("Total Potongan: " + formattedTotal);
            }



            $(document).on("input", ".nilai-potongan", function() {
                calculateTotalPotongan();
            });

            $(document).on("click", ".removePotonganAdd", function() {
                $(this).closest('.potongan')
                    .remove(); // Menghapus elemen yang mengandung elemen yang akan dihapus
                calculateTotalPotongan(); // Rekalkulasi total
            });
        });
    </script>


    {{-- Komponen Edit Tunjangan --}}

    <script>
        $(document).ready(function() {
            var counter =
                {{ isset($sdm) ? $sdm->komponenGaji->count() : 0 }}; // Hitung jumlah tunjangan yang ada

            function addTunjanganInput() {
                var newTunjangan = `
                <div class="tunjangan">
                        <div class="form-group">
                            <label for="nama_tunjangan">Nama Tunjangan</label>
                            <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Tj.</div>
                                    </div>
                                <input class="form-control autocomplete_txt_tunjangan" type="text" name="nama_tunjangan[]" data-type="namatunjangan" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nilai_tunjangan">Nilai Tunjangan</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Rp.</div>
                                </div>
                                <input class="form-control nilai-tunjangan" type="text" name="nilai_tunjangan[]" oninput="addCommas2(this)" required>
                            </div>
                        </div>
                        <button type="button" class="btn btn-outline-danger removeTunjangan mb-3"> <i class="fa fa-trash"></i>  Hapus Tunjangan</button>
                    </div>
            `;
                $("#tunjanganContainer").append(newTunjangan);
                counter++;
            }

            $("#addTunjanganEdit").click(function() {
                addTunjanganInput();
            });

            $(document).on("click", ".removeTunjangan", function() {
                var tunjanganElement = $(this).closest('.tunjangan');
                var tunjanganId = tunjanganElement.data('id'); // Dapatkan ID tunjangan
                tunjanganElement.remove(); // Hapus elemen secara visual

                // Hapus ID tunjangan dari daftar tunjangan_ids
                var tunjanganIds = $("#tunjangan_ids").val().split(',').filter(function(id) {
                    return id !== tunjanganId.toString();
                });
                $("#tunjangan_ids").val(tunjanganIds.join(','));
            });
        });
    </script>


    {{-- Komponen Edit Potongan --}}

    <script>
        $(document).ready(function() {
            var counter =
                {{ isset($sdm) ? $sdm->komponenGaji->count() : 0 }}; // Hitung jumlah potongan yang ada

            function addPotonganInput() {
                var newPotongan = `
                <div class="potongan">
                        <div class="form-group">
                            <label for="nama_potongan">Nama Potongan</label>
                                <input class="form-control autocomplete_txt_potongan" type="text" name="nama_potongan[]" data-type="namapotongan" required>
                        </div>
                        <div class="form-group">
                            <label for="nilai_potongan">Nilai Potongan</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Rp.</div>
                                </div>
                                <input class="form-control nilai-potongan" type="text" name="nilai_potongan[]" oninput="addCommas2(this)" required>
                            </div>
                        </div>
                        <button type="button" class="btn btn-outline-danger removePotongan mb-3"> <i class="fa fa-trash"></i>  Hapus Potongan</button>
                    </div>
            `;
                $("#potonganContainer").append(newPotongan);
                counter++;
            }

            $("#addPotonganEdit").click(function() {
                addPotonganInput();
            });

            $(document).on("click", ".removePotongan", function() {
                var potonganElement = $(this).closest('.potongan');
                var potonganId = potonganElement.data('id'); // Dapatkan ID potongan
                potonganElement.remove(); // Hapus elemen secara visual

                // Hapus ID potongan dari daftar potongan_ids
                var potonganIds = $("#potongan_ids").val().split(',').filter(function(id) {
                    return id !== potonganId.toString();
                });
                $("#potongan_ids").val(potonganIds.join(','));
            });
        });
    </script>


    {{-- Auto Complete Tunjangan --}}

    <script type="text/javascript">
        // Autocomplete script
        $(document).on('focus', '.autocomplete_txt_tunjangan', function() {
            type = $(this).data('type');

            if (type == 'namatunjangan') autoType = 'nama_tunjangan';

            $(this).autocomplete({
                minLength: 1, // Set to 1 to display options after typing one character
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('searchajax') }}",
                        dataType: "json",
                        data: {
                            term: request.term,
                            type: type,
                        },
                        success: function(data) {
                            var array = $.map(data, function(item) {
                                return {
                                    label: item[autoType],
                                    value: item[autoType],
                                    data: item
                                }
                            });
                            // Batasi hasil hanya ke 1 item pertama
                            var limitedResults = array.slice(0, 1);
                            response(limitedResults);
                        }
                    });
                },
                select: function(event, ui) {
                    var data = ui.item.data;

                    // Do something with the selected data
                }
            });
        });
    </script>


    {{-- Auto Complete Potongan --}}

    <script type="text/javascript">
        // Autocomplete script
        $(document).on('focus', '.autocomplete_txt_potongan', function() {
            type = $(this).data('type');

            if (type == 'namapotongan') autoType = 'nama_potongan';

            $(this).autocomplete({
                minLength: 1, // Set to 1 to display options after typing one character
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('searchajax-potongan') }}",
                        dataType: "json",
                        data: {
                            term: request.term,
                            type: type,
                        },
                        success: function(data) {
                            var array = $.map(data, function(item) {
                                return {
                                    label: item[autoType],
                                    value: item[autoType],
                                    data: item
                                }
                            });
                            // Batasi hasil hanya ke 1 item pertama
                            var limitedResults = array.slice(0, 1);
                            response(limitedResults);
                        }
                    });
                },
                select: function(event, ui) {
                    var data = ui.item.data;

                    // Do something with the selected data
                }
            });
        });
    </script>





    {{-- Hide Data Tables Action Export --}}

    <script>
        $(document).ready(function() {
            var table = new DataTable('#example', {
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'copy',
                        exportOptions: {
                            columns: ':not(.action-column)' // Mengexklusikan kolom dengan class 'action-column'
                        }
                    },
                    {
                        extend: 'csv',
                        exportOptions: {
                            columns: ':not(.action-column)'
                        }
                    },
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: ':not(.action-column)'
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: ':not(.action-column)'
                        }
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: ':not(.action-column)'
                        }
                    }
                ],
            });
        });
    </script>


    {{-- Default Entries 100 in input gaji --}}

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new DataTable('#example1', {
                "pageLength": 100, // Mengatur jumlah default entri menjadi 100
                "lengthMenu": [10, 25, 50, 100] // Menampilkan opsi untuk mengubah jumlah entri
            });
        });
    </script>


    {{-- Delete swall entitas --}}

    <script>
        //button create post event
        $('body').on('click', '#btn-delete-post', function() {

            let item_id = $(this).data('id');
            let token = $("meta[name='csrf-token']").attr("content");

            Swal.fire({
                title: 'Apakah Kamu Yakin?',
                text: `Ingin menghapus data Entitas '${$(this).data('nama')}'! `,
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'TIDAK',
                cancelButtonColor: '#d33',
                confirmButtonText: 'YA, HAPUS!'
            }).then((result) => {
                if (result.isConfirmed) {
                    //fetch to delete data
                    $.ajax({
                        url: `/admin/entitas/${item_id}`,
                        type: "DELETE",
                        cache: false,
                        data: {
                            "_token": token
                        },
                        success: function(response) {
                            //show success message
                            Swal.fire({
                                type: 'success',
                                icon: 'success',
                                title: `${response.message}`,
                                showConfirmButton: false,
                                timer: 3000
                            });
                            //remove post on table
                            $(`#index_${item_id}`).remove();
                            // Kembali ke halaman sebelumnya
                            setTimeout(function() {
                                window.location.href =
                                    "{{ route('admin.entitas.index') }}";
                            }, 2000);
                        }
                    });
                }
            });
        });
    </script>

    {{-- Delete swall jabatan --}}

    <script>
        //button create post event
        $('body').on('click', '#btn-delete-jabatan', function() {

            let item_id = $(this).data('id');
            let token = $("meta[name='csrf-token']").attr("content");

            Swal.fire({
                title: 'Apakah Kamu Yakin?',
                text: `Ingin menghapus data Jabatan '${$(this).data('nama')}'! `,
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'TIDAK',
                cancelButtonColor: '#d33',
                confirmButtonText: 'YA, HAPUS!'
            }).then((result) => {
                if (result.isConfirmed) {

                    console.log('test');

                    //fetch to delete data
                    $.ajax({

                        url: `/admin/jabatan/${item_id}`,
                        type: "DELETE",
                        cache: false,
                        data: {
                            "_token": token
                        },
                        success: function(response) {

                            //show success message
                            Swal.fire({
                                type: 'success',
                                icon: 'success',
                                title: `${response.message}`,
                                showConfirmButton: false,
                                timer: 3000
                            });

                            //remove post on table
                            $(`#index_${item_id}`).remove();

                            // Kembali ke halaman sebelumnya
                            setTimeout(function() {
                                window.location.href =
                                    "{{ route('admin.jabatan.index') }}";
                            }, 2000);
                        }
                    });
                }
            })

        });
    </script>

    {{-- Delete swall SDM --}}

    <script>
        //button create post event
        $('body').on('click', '#btn-delete-users', function() {

            let sdm_id = $(this).data('id');
            let token = $("meta[name='csrf-token']").attr("content");

            Swal.fire({
                title: 'Apakah Kamu Yakin?',
                text: `Ingin Nonaktifkan data SDM '${$(this).data('nama')}'! `,
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'TIDAK',
                cancelButtonColor: '#d33',
                confirmButtonText: 'YA, BENAR!'
            }).then((result) => {
                if (result.isConfirmed) {

                    console.log('test');

                    //fetch to delete data
                    $.ajax({

                        url: `/admin/sdm/${sdm_id}`,
                        type: "DELETE",
                        cache: false,
                        data: {
                            "_token": token
                        },
                        success: function(response) {

                            //show success message
                            Swal.fire({
                                type: 'success',
                                icon: 'success',
                                title: `${response.message}`,
                                showConfirmButton: false,
                                timer: 3000
                            });

                            //remove post on table
                            $(`#index_${sdm_id}`).remove();

                            // Kembali ke halaman sebelumnya
                            setTimeout(function() {
                                window.location.href =
                                    "{{ route('admin.sdm.index') }}";
                            }, 2000);
                        }
                    });
                }
            })

        });
    </script>

    {{-- Delete swall Admin --}}

    <script>
        //button create post event
        $('body').on('click', '#btn-delete-admin', function() {

            let admin_id = $(this).data('id');
            let token = $("meta[name='csrf-token']").attr("content");

            Swal.fire({
                title: 'Apakah Kamu Yakin?',
                text: `Ingin menghapus data Admin '${$(this).data('nama')}'! `,
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'TIDAK',
                cancelButtonColor: '#FF5733',
                confirmButtonText: 'YA, HAPUS!'
            }).then((result) => {
                if (result.isConfirmed) {

                    console.log('test');

                    //fetch to delete data
                    $.ajax({

                        url: `/admin/users/${admin_id}`,
                        type: "DELETE",
                        cache: false,
                        data: {
                            "_token": token
                        },
                        success: function(response) {

                            //show success message
                            Swal.fire({
                                type: 'success',
                                icon: 'success',
                                title: `${response.message}`,
                                showConfirmButton: false,
                                timer: 3000
                            });

                            //remove post on table
                            $(`#index_${admin_id}`).remove();

                            // Kembali ke halaman sebelumnya
                            setTimeout(function() {
                                window.location.href =
                                    "{{ route('admin.users.index') }}";
                            }, 2000);
                        }
                    });


                }
            })

        });
    </script>


    {{-- Restore swall SDM --}}

    <script>
        //button create post event
        $('body').on('click', '#btn-restore-users', function() {

            let sdm_id = $(this).data('id');
            let token = $("meta[name='csrf-token']").attr("content");

            Swal.fire({
                title: 'Apakah Kamu Yakin?',
                text: `Ingin aktifkan data SDM '${$(this).data('nama')}'! `,
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'TIDAK',
                cancelButtonColor: '#d33',
                confirmButtonText: 'YA, BENAR!'
            }).then((result) => {
                if (result.isConfirmed) {

                    console.log('test');

                    //fetch to delete data
                    $.ajax({

                        url: `/admin/sdm/restore/${sdm_id}`,
                        type: "DELETE",
                        cache: false,
                        data: {
                            "_token": token
                        },
                        success: function(response) {

                            //show success message
                            Swal.fire({
                                type: 'success',
                                icon: 'success',
                                title: `${response.message}`,
                                showConfirmButton: false,
                                timer: 3000
                            });

                            //remove post on table
                            $(`#index_${sdm_id}`).remove();

                            // Kembali ke halaman sebelumnya
                            setTimeout(function() {
                                window.location.href =
                                    "{{ route('admin.sdm.index.deleted') }}";
                            }, 2000);
                        }
                    });
                }
            })

        });
    </script>

    {{-- Undo swall gaji --}}

    <script>
        //button create post event
        $('body').on('click', '#btn-delete-gaji', function() {

            let item_id = $(this).data('id');
            let token = $("meta[name='csrf-token']").attr("content");

            Swal.fire({
                title: 'Apakah Kamu Yakin?',
                text: `Ingin undo data SDM '${$(this).data('nama')}'! `,
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'TIDAK',
                cancelButtonColor: '#d33',
                confirmButtonText: 'YA, UNDO!'
            }).then((result) => {
                if (result.isConfirmed) {

                    console.log('test');

                    //fetch to delete data
                    $.ajax({

                        url: `/admin/gaji/${item_id}`,
                        type: "DELETE",
                        cache: false,
                        data: {
                            "_token": token
                        },
                        success: function(response) {

                            //show success message
                            Swal.fire({
                                type: 'success',
                                icon: 'success',
                                title: `${response.message}`,
                                showConfirmButton: false,
                                timer: 3000
                            });

                            //remove post on table
                            $(`#index_${item_id}`).remove();

                            // Kembali ke halaman sebelumnya
                            setTimeout(function() {
                                window.location.href =
                                    "{{ route('admin.gaji.index') }}";
                            }, 2000);
                        }
                    });
                }
            })

        });
    </script>

    {{-- Donut chart --}}

    <script>
        @if (isset($maleCount) && isset($femaleCount))
            // Mendapatkan elemen canvas
            var donutChartCanvas = $("#donutChart").get(0).getContext("2d");

            // Membuat donut chart
            var donutChart = new Chart(donutChartCanvas, {
                type: "doughnut",
                data: {
                    labels: ["Laki-laki", "Perempuan"],
                    datasets: [{
                        data: [{{ $maleCount }}, {{ $femaleCount }}],
                        backgroundColor: ["#00c0ef", "#ec49a6"],
                    }],
                },
                options: {
                    maintainAspectRatio: false,
                    responsive: true,
                },
            });
        @endif
    </script>


    {{-- Pie Chart --}}

    <script>
        @if (isset($maleCount) && isset($femaleCount))
            // Mendapatkan elemen canvas
            var pieChartCanvas = $("#pieChart").get(0).getContext("2d");

            // Membuat pie chart
            var pieChart = new Chart(pieChartCanvas, {
                type: "pie",
                data: {
                    labels: ["Crocodic", "Eventy", "Reprime", "Ta'aruf"],
                    datasets: [{
                        data: [{{ $crocodicCount }}, {{ $eventyCount }}, {{ $reprimeCount }},
                            {{ $taarufCount }}
                        ],
                        backgroundColor: ["#3c8dbc", "#f39c12", "#1F3775", "#EF4043"],
                    }],
                },
                options: {
                    maintainAspectRatio: false,
                    responsive: true,
                },
            });
        @endif
    </script>

    {{-- Dark Mode --}}

    <script>
        // Temukan tombol mode gelap dan checkbox-nya
        const darkModeToggle = document.querySelector('.dark-mode-toggle');
        const darkModeCheckbox = document.getElementById('customSwitch1');

        // Fungsi untuk mengaktifkan mode gelap
        function enableDarkMode() {
            document.body.classList.add('dark-mode');
            // Simpan status mode gelap di penyimpanan lokal
            localStorage.setItem('darkMode', 'enabled');
        }

        // Fungsi untuk menonaktifkan mode gelap
        function disableDarkMode() {
            document.body.classList.remove('dark-mode');
            // Simpan status mode gelap di penyimpanan lokal
            localStorage.setItem('darkMode', 'disabled');
        }

        // Periksa status mode gelap saat halaman dimuat
        window.addEventListener('load', () => {
            const darkModeStatus = localStorage.getItem('darkMode');
            if (darkModeStatus === 'enabled') {
                enableDarkMode();
                darkModeCheckbox.checked = true;
            }
        });

        // Tambahkan event listener untuk mengubah mode saat tombol dinyalakan atau dimatikan
        darkModeToggle.addEventListener('change', () => {
            if (darkModeCheckbox.checked) {
                enableDarkMode();
            } else {
                disableDarkMode();
            }
        });
    </script>


    <!-- Untuk menambahkan titik pemisah rupiah Jabatan -->
    <script>
        // Fungsi untuk menambahkan pemisah titik saat mengisi input number
        function addCommas(input) {
            var value = input.value.replace(/\D/g, ''); // Menghapus semua titik
            input.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, "."); // Menambahkan titik pada angka
        }

        // Fungsi untuk menghapus pemisah titik sebelum mengirimkan formulir
        function removeCommas() {
            var tunjanganJabatanInput = document.getElementsByName('tunjangan_jabatan')[0];

            tunjanganJabatanInput.value = tunjanganJabatanInput.value.replace(/\./g, ''); // Menghapus semua titik
        }
    </script>


    <!-- Untuk menambahkan titik pemisah rupiah dan remove ditunjangan dinamis saat dikirim ke server  -->

    <script>
        // Fungsi untuk menambahkan pemisah titik saat mengisi input number atau teks
        function addCommas2(input) {
            var value = input.value.replace(/\D/g, ''); // Menghapus semua titik
            input.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, "."); // Menambahkan titik pada angka
        }

        // Fungsi untuk menghapus pemisah titik sebelum mengirimkan formulir
        function removeCommas2() {
            var inputsTunjangan = document.getElementsByName('nilai_tunjangan[]');
            var inputsPotongan = document.getElementsByName('nilai_potongan[]');

            for (var i = 0; i < inputsTunjangan.length; i++) {
                var value = inputsTunjangan[i].value;
                value = value.replace(/\./g, ''); // Menghapus semua titik
                inputsTunjangan[i].value = value;
            }
            for (var i = 0; i < inputsPotongan.length; i++) {
                var value = inputsPotongan[i].value;
                value = value.replace(/\./g, ''); // Menghapus semua titik
                inputsPotongan[i].value = value;
            }
        }
    </script>




    <!-- Number Counting Animation -->
    <script>
        @if (isset($employee_count))
            startCountingAnimation('employeeCount', {{ $employee_count }}, 5000); // Animasi lebih lambat
        @endif

        @if (isset($entita_count))
            startCountingAnimation('entitaCount', {{ $entita_count }}, 5000); // Animasi lebih lambat
        @endif

        @if (isset($jabatan_count))
            startCountingAnimation('jabatanCount', {{ $jabatan_count }}, 5000); // Animasi lebih lambat
        @endif

        function startCountingAnimation(targetId, endValue, duration) {
            const element = document.getElementById(targetId);
            const startValue = parseInt(element.textContent, 10);
            const increment = Math.ceil(endValue / (duration / 100));
            let currentValue = startValue;

            const intervalId = setInterval(() => {
                if (currentValue < endValue) {
                    currentValue += increment;
                    if (currentValue > endValue) {
                        currentValue = endValue; // Pastikan tidak melebihi nilai akhir
                    }
                    element.textContent = currentValue;
                } else {
                    clearInterval(intervalId);
                }
            }, 100); // Tingkatkan angka ini untuk memperlambat animasi
        }
    </script>


    <!-- Timer message -->
    <script>
        // Tunggu sampai dokumen selesai dimuat
        document.addEventListener('DOMContentLoaded', function() {
            // Cari elemen dengan ID 'info-message'
            var infoMessage = document.getElementById('info-message');

            // Periksa apakah elemen ditemukan sebelum mencoba mengakses properti 'style'
            if (infoMessage) {
                // Hapus pesan setelah 3 detik (3000 milidetik)
                setTimeout(function() {
                    infoMessage.style.display = 'none';
                }, 3000);
            }
        });
    </script>








    <!-- Page specific script -->



    @yield('scripts')
</body>

</html>
