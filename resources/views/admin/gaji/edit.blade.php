@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="header">
        <div class="header-content">
            <nav class="navbar navbar-expand">
                <div class="collapse navbar-collapse justify-content-between">
                    <div class="header-left">
                        <div class="dashboard_bar">
                            Payroll
                        </div>
                    </div>
                    <!-- Right navbar links -->
                    <ul class="navbar-nav header-right">
                        <li class="nav-item dropdown notification_dropdown">
                            <a class="btn btn-primary d-sm-inline-block position-relative" data-toggle="dropdown"
                                aria-expanded="false" style="padding-bottom: 26px;">
                                {{ Auth::user()->nama }} <i class="fa fa-user ms-3 scale-5"></i>
                                @if (Auth::check())
                                    <div class="position-absolute start-50 translate-middle-x text-center">
                                        @if (Auth::user()->status)
                                            superadmin
                                        @else
                                            admin
                                        @endif
                                    </div>
                                @endif
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <div id="dlab_W_Notification1" class="widget-media dlab-scroll p-3" style="height:230px;">
                                    <ul class="timeline">
                                        <li>
                                            <div class="timeline-panel">
                                                <div class="media me-2 media-info">
                                                    <i class="fa fa-user"></i>
                                                </div>
                                                <div class="media-body">
                                                    <a href="{{ route('admin.profile.show') }}" class="dropdown-item">
                                                        <h6 class="mb-1">{{ __('My profile') }}</h6>
                                                    </a>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="timeline-panel">
                                                <div class="media me-2 media-danger">
                                                    <i class="fa fa-cog"></i>
                                                </div>
                                                <div class="media-body">
                                                    <a href="{{ route('admin.settings.show') }}" class="dropdown-item">
                                                        <h6 class="mb-1">{{ __('Setting') }}</h6>
                                                    </a>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="timeline-panel">
                                                <div class="media me-2 media-success">
                                                    <i class="fas fa-sign-out-alt"></i>
                                                </div>
                                                <div class="media-body">
                                                    <form method="POST" action="{{ route('logout') }}">
                                                        @csrf
                                                        <a href="{{ route('logout') }}" class="dropdown-item"
                                                            onclick="event.preventDefault(); confirmLogout();">
                                                            <h6 class="mb-1"> {{ __('Log Out') }}</h6>
                                                        </a>
                                                    </form>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div> <!-- /.navbar -->

    <!-- Main content -->
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="{{ route('admin.gaji.index') }}">Payroll</a>
                    </li>
                    <li class="breadcrumb-item">Edit Payroll</li>
                </ol>
            </div>
            <div class="col-lg-12">
                <form novalidate action="{{ route('admin.gaji.update', $gaji->id) }}" method="POST"
                    onsubmit="return validateFormEditGaji() && removeCommas2();">
                    @csrf
                    @method('PUT')
                    @if ($errors->any())
                        <div class="alert alert-danger solid alert-dismissible fade show" id="info-message">
                            <svg viewbox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"
                                fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
                                <polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2">
                                </polygon>
                                <line x1="15" y1="9" x2="9" y2="15"></line>
                                <line x1="9" y1="9" x2="15" y2="15"></line>
                            </svg>
                            <strong>Error!</strong>
                            @foreach ($errors->all() as $error)
                                {{ $error }}<br>
                            @endforeach
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="btn-close"></button>
                        </div>
                    @endif
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Profile SDM</h4>
                        </div>
                        <div class="card-body">
                            <div class="basic-form">
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <div class="form-group">
                                            <label for="nama">Nama</label>
                                            <input class="form-control gray-border" type="text" id="nama"
                                                name="nama" value="{{ old('nama', $gaji->nama) }}">
                                        </div>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <div class="form-group">
                                            <label for="nik">Nik</label>
                                            <input class="form-control gray-border" type="number" id="nik"
                                                name="nik" value="{{ old('nik', $gaji->nik) }}">
                                        </div>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <div class="form-group">
                                            <label for="nik">Telegram Id</label>
                                            <input class="form-control gray-border" type="number" name="chat_id"
                                                value="{{ old('chat_id', $gaji->chat_id) }}">
                                        </div>
                                    </div>
                                    <!-- Form input untuk tunjangan -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h4 class="card-title">Tunjangan</h4>
                                </div>
                                <div class="card-body p-3">
                                    <div id="tunjanganContainer">
                                        @foreach ($tunjangans as $tunjangan)
                                            <div class="tunjangan">
                                                <div class="form-group mb-3">
                                                    <label for="nama_tunjangan">Nama Tunjangan</label>
                                                    <select class="form-control select2" name="nama_tunjangan[]" required>
                                                        <option value="__create__">Lainnya</option>
                                                        <option value="" disabled>-- Pilih Tunjangan --</option>
                                                        <!-- Tambahkan opsi tunjangan dari data yang tersedia -->
                                                        @foreach ($opsiTunjangan as $absensiId => $opsi)
                                                            @foreach ($opsi as $namaTunjangan)
                                                                <option value="{{ $namaTunjangan }}"
                                                                    {{ $namaTunjangan === $tunjangan['nama_tunjangan'] ? 'selected' : '' }}>
                                                                    {{ $namaTunjangan }}
                                                                </option>
                                                            @endforeach
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <script>
                                                    $(document).ready(function() {
                                                        // Inisialisasi Select2
                                                        $('select[name="nama_tunjangan[]"]').select2();

                                                        // Menangani perubahan nilai pada elemen select
                                                        $('select[name="nama_tunjangan[]"]').on('change', async function() {
                                                            // Mendapatkan nilai terpilih
                                                            var selectedValue = $(this).val();

                                                            // Cek apakah opsi "Lainnya" dipilih
                                                            if (selectedValue === '__create__') {
                                                                // Tampilkan modal SweetAlert2 untuk memasukkan nama Tunjangan baru
                                                                const {
                                                                    value: newTunjanganName
                                                                } = await Swal.fire({
                                                                    input: 'text',
                                                                    inputLabel: 'Nama Tunjangan Baru',
                                                                    inputPlaceholder: 'Masukkan Nama Tunjangan Baru',
                                                                    showCancelButton: true,
                                                                    inputValidator: (value) => {
                                                                        if (!value) {
                                                                            return 'Nama Tunjangan tidak boleh kosong!';
                                                                        }
                                                                    }
                                                                });

                                                                // Cek jika pengguna memasukkan nilai baru
                                                                if (newTunjanganName) {
                                                                    // Tambahkan nilai baru ke dalam select
                                                                    var newOption = new Option(newTunjanganName, newTunjanganName, true, true);
                                                                    $(this).append(newOption).val(newTunjanganName).trigger('change');
                                                                } else {
                                                                    // Batal jika pengguna membatalkan operasi
                                                                    $(this).val('').trigger('change');
                                                                }
                                                            }
                                                        });
                                                    });
                                                </script>
                                                <div class="form-group mb-3">
                                                    <label for="nilai_tunjangan">Nilai Tunjangan</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">Rp.</span>
                                                        <input type="text" class="form-control gray-border"
                                                            name="nilai_tunjangan[]"
                                                            value="{{ old('nilai_tunjangan', number_format($tunjangan['nilai_tunjangan'], 0, ',', '.')) }}"
                                                            required oninput="addCommas2(this)">
                                                    </div>
                                                </div>
                                                <button type="button"
                                                    class="btn btn-outline-danger removeTunjangan mb-3">
                                                    <i class="fa fa-trash"></i> Hapus Tunjangan
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                    <button type="button" id="addTunjanganEdit" class="btn btn-outline-success">
                                        <i class="fa fa-plus"></i> Tambah Tunjangan</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h4 class="card-title">Potongan</h4>
                                </div>
                                <div class="card-body p-3">
                                    <div id="potonganContainer">
                                        @foreach ($potongans as $potongan)
                                            <div class="potongan">
                                                <div class="form-group mb-3">
                                                    <label for="nama_potongan">Nama Potongan</label>
                                                    <select class="form-control select2" name="nama_potongan[]" required>
                                                        <option value="__create__">Lainnya</option>
                                                        <option value="" disabled>-- Pilih Potongan --</option>
                                                        <!-- Tambahkan opsi potongan dari data yang tersedia -->
                                                        @foreach ($opsiPotongan as $absensiId => $opsi)
                                                            @foreach ($opsi as $namaPotongan)
                                                                <option value="{{ $namaPotongan }}"
                                                                    {{ $namaPotongan === $potongan['nama_potongan'] ? 'selected' : '' }}>
                                                                    {{ $namaPotongan }}
                                                                </option>
                                                            @endforeach
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <script>
                                                    $(document).ready(function() {
                                                        // Inisialisasi Select2
                                                        $('select[name="nama_potongan[]"]').select2();

                                                        // Menangani perubahan nilai pada elemen select
                                                        $('select[name="nama_potongan[]"]').on('change', async function() {
                                                            // Mendapatkan nilai terpilih
                                                            var selectedValue = $(this).val();

                                                            // Cek apakah opsi "Lainnya" dipilih
                                                            if (selectedValue === '__create__') {
                                                                // Tampilkan modal SweetAlert2 untuk memasukkan nama Potongan baru
                                                                const {
                                                                    value: newPotonganName
                                                                } = await Swal.fire({
                                                                    input: 'text',
                                                                    inputLabel: 'Nama Potongan Baru',
                                                                    inputPlaceholder: 'Masukkan Nama Potongan Baru',
                                                                    showCancelButton: true,
                                                                    inputValidator: (value) => {
                                                                        if (!value) {
                                                                            return 'Nama Potongan tidak boleh kosong!';
                                                                        }
                                                                    }
                                                                });

                                                                // Cek jika pengguna memasukkan nilai baru
                                                                if (newPotonganName) {
                                                                    // Tambahkan nilai baru ke dalam select
                                                                    var newOption = new Option(newPotonganName, newPotonganName, true, true);
                                                                    $(this).append(newOption).val(newPotonganName).trigger('change');
                                                                } else {
                                                                    // Batal jika pengguna membatalkan operasi
                                                                    $(this).val('').trigger('change');
                                                                }
                                                            }
                                                        });
                                                    });
                                                </script>
                                                <div class="form-group mb-3">
                                                    <label for="nilai_potongan">Nilai Potongan</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text">Rp.</span>
                                                        <input type="text" class="form-control gray-border"
                                                            name="nilai_potongan[]"
                                                            value="{{ old('nilai_potongan', number_format($potongan['nilai_potongan'], 0, ',', '.')) }}"
                                                            required oninput="addCommas2(this)">
                                                    </div>
                                                </div>
                                                <button type="button" class="btn btn-outline-danger removePotongan mb-3">
                                                    <i class="fa fa-trash"></i> Hapus Potongan
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                    <button type="button" id="addPotonganEdit" class="btn btn-outline-success">
                                        <i class="fa fa-plus"></i> Tambah Potongan</button>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <button class="btn btn-primary" type="submit">Simpan</button>
            </form>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
    <!-- /.content -->
    <div class="footer">
        <div class="copyright">
        </div>
    </div>

    <!-- Script untuk menangani penambahan dan penghapusan input tunjangan -->
    <script>
        $(document).ready(function() {
            var counter = {{ count($tunjangans) }};

            function addTunjanganInput() {
                var newTunjangan = `
                    <div class="tunjangan">
                        <div class="form-group mb-3">
                            <label for="nama_tunjangan${counter}">Nama Tunjangan</label>
                            <select class="form-control select2" name="nama_tunjangan[]" required>
                                <option value="__create__">Lainnya</option>
                                <option value="" disabled selected>-- Pilih Tunjangan --</option>
                                <!-- Tambahkan opsi tunjangan dari data yang tersedia -->
                                @foreach ($opsiTunjangan as $absensiId => $opsi)
                                    @foreach ($opsi as $namaTunjangan)
                                        <option value="{{ $namaTunjangan }}">{{ $namaTunjangan }}</option>
                                    @endforeach
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="nilai_tunjangan${counter}">Nilai Tunjangan</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp.</span>
                                <input type="text" class="form-control gray-border" name="nilai_tunjangan[]" oninput="addCommas(this)" required>
                            </div>
                        </div>
                        <button type="button" class="btn btn-outline-danger removeTunjangan mb-3"><i class="fa fa-trash"></i> Hapus Tunjangan</button>
                    </div>
                `;
                $("#tunjanganContainer").append(newTunjangan);
                counter++;

                // Inisialisasi Select2 pada elemen yang baru ditambahkan
                $('.select2').select2({
                    theme: 'bootstrap4'
                });
            }

            $("#addTunjanganEdit").click(function() {
                addTunjanganInput();
            });

            $(document).on("click", ".removeTunjangan", function() {
                var tunjanganElement = $(this).closest('.tunjangan');
                tunjanganElement.remove();
            });

            // Menangani perubahan nilai pada elemen select
            $(document).on('change', '[name^="nama_tunjangan"]', async function() {
                // Mendapatkan nilai terpilih
                var selectedValue = $(this).val();

                // Cek apakah opsi "Lainnya" dipilih
                if (selectedValue === '__create__') {
                    // Tampilkan modal SweetAlert2 untuk memasukkan nama Tunjangan baru
                    const {
                        value: newTunjanganName
                    } = await Swal.fire({
                        input: 'text',
                        inputLabel: 'Nama Tunjangan Baru',
                        inputPlaceholder: 'Masukkan Nama Tunjangan Baru',
                        showCancelButton: true,
                        inputValidator: (value) => {
                            if (!value) {
                                return 'Nama Tunjangan tidak boleh kosong!';
                            }
                        }
                    });

                    // Cek jika pengguna memasukkan nilai baru
                    if (newTunjanganName) {
                        // Tambahkan nilai baru ke dalam select
                        var newOption = new Option(newTunjanganName, newTunjanganName, true, true);
                        $(this).append(newOption).val(newTunjanganName).trigger('change');
                    } else {
                        // Batal jika pengguna membatalkan operasi
                        $(this).val('').trigger('change');
                    }
                }
            });
        });
    </script>

    <!-- Script untuk menangani penambahan dan penghapusan input potongan -->
    <script>
        $(document).ready(function() {
            var counter = {{ count($potongans) }};

            function addPotonganInput() {
                var newPotongan = `
                    <div class="potongan">
                        <div class="form-group mb-3">
                            <label for="nama_potongan${counter}">Nama Potongan</label>
                            <select class="form-control select2" name="nama_potongan[]" required>
                                <option value="__create__">Lainnya</option>
                                <option value="" disabled selected>-- Pilih Potongan --</option>
                                <!-- Tambahkan opsi potongan dari data yang tersedia -->
                                @foreach ($opsiPotongan as $absensiId => $opsi)
                                    @foreach ($opsi as $namaPotongan)
                                        <option value="{{ $namaPotongan }}">{{ $namaPotongan }}</option>
                                    @endforeach
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="nilai_potongan${counter}">Nilai Potongan</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp.</span>
                                <input type="text" class="form-control gray-border" name="nilai_potongan[]" oninput="addCommas(this)" required>
                            </div>
                        </div>
                        <button type="button" class="btn btn-outline-danger removePotongan mb-3"><i class="fa fa-trash"></i> Hapus Potongan</button>
                    </div>
                `;
                $("#potonganContainer").append(newPotongan);
                counter++;

                // Inisialisasi Select2 pada elemen yang baru ditambahkan
                $('.select2').select2({
                    theme: 'bootstrap4'
                });
            }

            $("#addPotonganEdit").click(function() {
                addPotonganInput();
            });

            $(document).on("click", ".removePotongan", function() {
                var potonganElement = $(this).closest('.potongan');
                potonganElement.remove();
            });

            // Menangani perubahan nilai pada elemen select
            $(document).on('change', '[name^="nama_potongan"]', async function() {
                // Mendapatkan nilai terpilih
                var selectedValue = $(this).val();

                // Cek apakah opsi "Lainnya" dipilih
                if (selectedValue === '__create__') {
                    // Tampilkan modal SweetAlert2 untuk memasukkan nama Potongan baru
                    const {
                        value: newPotonganName
                    } = await Swal.fire({
                        input: 'text',
                        inputLabel: 'Nama Potongan Baru',
                        inputPlaceholder: 'Masukkan Nama Potongan Baru',
                        showCancelButton: true,
                        inputValidator: (value) => {
                            if (!value) {
                                return 'Nama Potongan tidak boleh kosong!';
                            }
                        }
                    });

                    // Cek jika pengguna memasukkan nilai baru
                    if (newPotonganName) {
                        // Tambahkan nilai baru ke dalam select
                        var newOption = new Option(newPotonganName, newPotonganName, true, true);
                        $(this).append(newOption).val(newPotonganName).trigger('change');
                    } else {
                        // Batal jika pengguna membatalkan operasi
                        $(this).val('').trigger('change');
                    }
                }
            });
        });
    </script>

@endsection
