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
                                onclick="event.preventDefault(); this.closest('form').submit();">
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

    @vite('resources/js/app.js')
    <!-- AdminLTE App -->
    <script src="{{ asset('js/adminlte.min.js') }}" defer></script>


    <!-- Data Tables -->
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
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
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Jquery Auto Complete -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>


    <!-- Jquery Auto Complete -->
    <script type="text/javascript">
        var route = "{{ route('autocomplete.search') }}"; // Menggunakan user_nama rute
        $('#search').typeahead({
            source: function(query, process) {
                return $.get(route, {
                    query: query
                }, function(data) {
                    // Menggunakan map untuk mengubah format data menjadi teks yang sesuai
                    var formattedData = $.map(data, function(item) {
                        return item.user_nama + ' - ' + item
                            .tunjangan_makan; // Menampilkan user_nama dan tunjangan_makan
                    });
                    return process(formattedData);
                });
            },
            updater: function(item) {
                var namaTunjangan = item.split(' - ');
                var tunjanganMakan = namaTunjangan[1].trim();
                var formattedValue = tunjanganMakan.replace(/\./g, ''); // Menghapus semua titik
                formattedValue = formattedValue.replace(/\B(?=(\d{3})+(?!\d))/g,
                    "."); // Menambahkan titik pada angka
                $('#search').val(formattedValue); // Menyimpan nilai dengan pemisah titik ke dalam input
                return formattedValue;
            }
        });

        $('#search2').typeahead({
            source: function(query, process) {
                return $.get(route, {
                    query: query
                }, function(data) {
                    // Menggunakan map untuk mengubah format data menjadi teks yang sesuai
                    var formattedData = $.map(data, function(item) {
                        return item.user_nama + ' - ' + item
                            .tunjangan_transportasi; // Menampilkan user_nama dan tunjangan_transportasi
                    });
                    return process(formattedData);
                });
            },
            updater: function(item) {
                var namaTunjangan = item.split(' - ');
                var tunjanganTransportasi = namaTunjangan[1].trim();
                var formattedValue = tunjanganTransportasi.replace(/\./g, ''); // Menghapus semua titik
                formattedValue = formattedValue.replace(/\B(?=(\d{3})+(?!\d))/g,
                    "."); // Menambahkan titik pada angka
                $('#search2').val(formattedValue); // Menyimpan nilai dengan pemisah titik ke dalam input
                return formattedValue;
            }
        });

        $('#search3').typeahead({
            source: function(query, process) {
                return $.get(route, {
                    query: query
                }, function(data) {
                    // Menggunakan map untuk mengubah format data menjadi teks yang sesuai
                    var formattedData = $.map(data, function(item) {
                        return item.user_nama + ' - ' + item
                            .potongan_pinjaman; // Menampilkan user_nama dan potongan_pinjaman
                    });
                    return process(formattedData);
                });
            },
            updater: function(item) {
                var namaPotongan = item.split(' - ');
                var potonganPinjaman = namaPotongan[1].trim();
                var formattedValue = potonganPinjaman.replace(/\./g, ''); // Menghapus semua titik
                formattedValue = formattedValue.replace(/\B(?=(\d{3})+(?!\d))/g,
                    "."); // Menambahkan titik pada angka
                $('#search3').val(formattedValue); // Menyimpan nilai dengan pemisah titik ke dalam input
                return formattedValue;
            }
        });
    </script>







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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new DataTable('#example1', {
                "pageLength": 100, // Mengatur jumlah default entri menjadi 100
                "lengthMenu": [10, 25, 50, 100] // Menampilkan opsi untuk mengubah jumlah entri
            });
        });
    </script>


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

    <script>
        //button create post event
        $('body').on('click', '#btn-delete-users', function() {

            let user_id = $(this).data('id');
            let token = $("meta[name='csrf-token']").attr("content");

            Swal.fire({
                title: 'Apakah Kamu Yakin?',
                text: `Ingin menghapus data SDM '${$(this).data('nama')}'! `,
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

                        url: `/admin/users/${user_id}`,
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
                            $(`#index_${user_id}`).remove();

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



    <script>
        //button create post event
        $('body').on('click', '#btn-restore-users', function() {

            let user_id = $(this).data('id');
            let token = $("meta[name='csrf-token']").attr("content");

            Swal.fire({
                title: 'Apakah Kamu Yakin?',
                text: `Ingin mengembalikan data SDM '${$(this).data('nama')}'! `,
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

                        url: `/admin/users/restore/${user_id}`,
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
                            $(`#index_${user_id}`).remove();

                            // Kembali ke halaman sebelumnya
                            setTimeout(function() {
                                window.location.href =
                                    "{{ route('admin.users.index.deleted') }}";
                            }, 2000);
                        }
                    });
                }
            })

        });
    </script>

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


    <!-- Untuk menambahkan koma di jabatan -->
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



    <script>
        // Fungsi untuk menambahkan pemisah titik saat mengisi input number atau teks
        function addCommas2(input) {
            var value = input.value.replace(/\./g, ''); // Menghapus semua titik
            input.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, "."); // Menambahkan titik pada angka
        }

        // Fungsi untuk menghapus pemisah titik sebelum mengirimkan formulir
        function removeCommas2() {
            var tunjanganMakanInput = document.getElementsByName('tunjangan_makan')[0];
            var tunjanganTransportasiInput = document.getElementsByName('tunjangan_transportasi')[0];
            var potonganPinjamanInput = document.getElementsByName('potongan_pinjaman')[0];

            tunjanganMakanInput.value = tunjanganMakanInput.value.replace(/\./g, ''); // Menghapus semua titik
            tunjanganTransportasiInput.value = tunjanganTransportasiInput.value.replace(/\./g, ''); // Menghapus semua titik
            potonganPinjamanInput.value = potonganPinjamanInput.value.replace(/\./g, ''); // Menghapus semua titik
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






    <!-- Page specific script -->



    @yield('scripts')
</body>

</html>
