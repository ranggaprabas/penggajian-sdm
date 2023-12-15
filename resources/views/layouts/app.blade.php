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
    <!-- Flaticon-->
    <link rel="stylesheet" href="{{ asset('flaticon/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('flaticon_1/flaticon_1.css') }}">

    <!-- Select Theme style -->
    <link rel="stylesheet" href="{{ asset('vendor/jquery-nice-select/css/nice-select.css') }}">

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <!-- Custom style -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    <!-- select  -->
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2-bootstrap4.min.css') }}">

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
    <!--*******************
    Preloader start
********************-->
    <div id="preloader">
        <div class="spinner">
            <!-- Menggunakan karakter Unicode untuk ikon reload -->
            &#8635;
        </div>
    </div>
    <!--*******************
    Preloader end
********************-->

    <div id="main-wrapper">
        <div class="wrapper">
            <!-- Main Sidebar Container -->
            <aside>
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

            <!-- Main Footer -->
            <div class="footer">
                <div class="copyright">
                    <p>{{ date('Y') }} &copy; PT. Taman Media Indonesia</p>
                </div>
            </div>
        </div>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- dibawah ini bikin error -->
    {{-- @vite('resources/js/app.js') --}}

    <!-- Boostrap App -->
    <script src="{{ asset('vendor/global/global.min.js') }}"></script>
    <!-- Select Theme script -->
    <script src="{{ asset('vendor/jquery-nice-select/js/jquery.nice-select.min.js') }}"></script>
    <!-- Custom Theme script -->
    <script src="{{ asset('js/custom.min.js') }}"></script>
    <!-- Navbar Theme script -->
    <script src="{{ asset('js/dlabnav-init.js') }}"></script>
    {{-- sweet alert file --}}
    <script src="{{ asset('js/sweetalert2@11.js') }}"></script>
    {{-- select --}}
    <script src="{{ asset('js/select2.full.min.js') }}"></script>
    <!-- Ckeditor -->
    <script src="{{ asset('vendor/ckeditor/ckeditor.js') }}"></script>



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
        ClassicEditor
            .create(document.querySelector('#ckeditor1'), {
                toolbar: {
                    items: [
                        'bold',
                        'italic',
                        '|',
                        'undo',
                        'redo'
                    ]
                },
                language: 'en',
                // ... konfigurasi lainnya
            })
            .catch(error => {
                console.error(error);
            });
    </script>
    {{-- select2 select all and clear --}}
    <script>
        function selectAllCategories() {
            $('#categories option').prop('selected', true);
            $('#categories').trigger('change.select2');
        }

        function clearSelectedCategories() {
            $('#categories option').prop('selected', false);
            $('#categories').trigger('change.select2');
        }
    </script>


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

    <!-- Inisialisasi Select2 -->
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap4'
            });
        });
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
                    Swal.fire({
                        title: 'Logout Berhasil!',
                        text: 'Anda akan diarahkan keluar dalam 3 detik.',
                        icon: 'success',
                        timer: 3000, // Set the timer to 3 seconds
                        showConfirmButton: false, // Hide the "OK" button
                    });
                    // Delay the redirection after 3 seconds
                    setTimeout(function() {
                        document.querySelector('form').submit();
                    }, 2000);
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
            // Pemeriksaan tambahan untuk select dengan ID 'divisi'
            const divisiSelect = document.getElementById('divisi');
            const selectedDivisi = divisiSelect.options[divisiSelect.selectedIndex];
            if (selectedDivisi.value === '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Pilih Divisi',
                    text: 'Anda harus memilih divisi!',
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
                    text: 'Email harus mengandung karakter "@" dan "." (titik)!',
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
                    text: 'Email harus mengandung karakter "@" dan "." (titik)!',
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
                    text: 'Email harus mengandung karakter "@" dan "." (titik)!',
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
                    text: 'Email harus mengandung karakter "@" dan "." (titik)!',
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

    {{-- sweet alert in divisi input required --}}

    <script>
        function validateFormDivisi() {
            const divisiInputField = document.getElementById('divisi-input');
            if (divisiInputField.value.trim() === '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Nama Divisi Wajib Diisi',
                    text: 'Nama Divisi tidak boleh kosong!',
                });
                return false; // Menghentikan pengiriman formulir jika tidak valid
            }
            return true; // Kirim formulir jika valid
        }
    </script>

    {{-- sweet alert in setting input required --}}

    <script>
        function validateFormSetting() {
            const settingInputField = document.getElementById('setting');
            if (settingInputField.value.trim() === '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Telegram Bot Token Wajib Diisi',
                    text: 'Telegram Bot Token tidak boleh kosong!',
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

    {{-- Hide Data Tables Action Export --}}

    <script>
        $(document).ready(function() {
            var table = new DataTable('#example', {
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'copy',
                        exportOptions: {
                            columns: ':not(.action-column)' // Exclude columns with the 'action-column' class
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
                language: {
                    paginate: {
                        next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
                        previous: '<i class="fa fa-angle-double-left" aria-hidden="true"></i>'
                    }
                }
            });
        });
    </script>



    {{-- Default Entries 100 in input gaji --}}

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new DataTable('#example1', {
                "pageLength": 100, // Mengatur jumlah default entri menjadi 100
                "lengthMenu": [10, 25, 50, 100], // Menampilkan opsi untuk mengubah jumlah entri
                "language": {
                    "paginate": {
                        "next": '<i class="fa fa-angle-double-right" aria-hidden="true"><i>',
                        "previous": '<i class="fa fa-angle-double-left" aria-hidden="true"><i>'
                    }
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new DataTable('#example2', {
                "language": {
                    "paginate": {
                        "next": '<i class="fa fa-angle-double-right" aria-hidden="true"><i>',
                        "previous": '<i class="fa fa-angle-double-left" aria-hidden="true"><i>'
                    }
                }
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

    <script>
        //button create divisi event
        $('body').on('click', '#btn-delete-divisi', function() {

            let item_id = $(this).data('id');
            let token = $("meta[name='csrf-token']").attr("content");

            Swal.fire({
                title: 'Apakah Kamu Yakin?',
                text: `Ingin menghapus data Divisi '${$(this).data('nama')}'! `,
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'TIDAK',
                cancelButtonColor: '#d33',
                confirmButtonText: 'YA, HAPUS!'
            }).then((result) => {
                if (result.isConfirmed) {
                    //fetch to delete data
                    $.ajax({
                        url: `/admin/divisi/${item_id}`,
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
                                    "{{ route('admin.divisi.index') }}";
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

        @if (isset($divisi_count))
            startCountingAnimation('divisiCount', {{ $jabatan_count }}, 5000); // Animasi lebih lambat
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


    <!-- Timer message alert -->
    <script>
        // Tunggu sampai dokumen selesai dimuat
        document.addEventListener('DOMContentLoaded', function() {
            // Cari elemen dengan ID 'info-message'
            var infoMessage = document.getElementById('info-message');

            // Periksa apakah elemen ditemukan sebelum mencoba mengakses properti 'style'
            if (infoMessage) {
                // Hapus pesan setelah 3 detik (5000 milidetik)
                setTimeout(function() {
                    infoMessage.style.display = 'none';
                }, 5000);
            }
        });
    </script>








    <!-- Page specific script -->



    @yield('scripts')
</body>

</html>
